@extends('app')

@section('title', 'Web Socket Example')

@section('metas')
    <meta name="websocket-address" content="{{ 'ws://' . $_SERVER['SERVER_NAME'] . ':' . config('websocket.port') }}" />
@endsection

@section('scripts')
    <script src="{{asset('js/websocket.js')}}"></script>
    <script>
        $(document).ready(function() {
            websocket.on('open', function() {
                trace('Socket open.');
            });

            websocket.on('close', function(code, reason) {
                trace('Socket closed: ' + reason + ' (' + code + ')');
            });

            websocket.on('message', function(message) {
                var data = JSON.parse(message);
                trace('Received: ' + data.text);
            });

            websocket.on('error', function() {
                trace('Socket error!');
            });

            $('#openBtn').click(function() {
                websocket.open();
            });

            $('#closeBtn').click(function() {
                websocket.close();
            });

            $('#message').keypress(function(event) {
                if (event.keyCode == '13') {
                    send();
                }
            });

            $('#sendBtn').click(function() {
                send();
            });

            websocket.open();
        });

        function send() {
            if (!websocket.isReady()) {
                trace('Socket is not ready!');
                return;
            }

            var input = $('#message');
            var value = input.val();
            if (value === '') {
                trace('Please enter a message');
                return;
            }
            var data = {
                text: value
            };

            websocket.send(JSON.stringify(data));

            trace('Sent: ' + value);
            input.val('');
        }

        function trace(message) {
            var div = $('#chat-log');
            div.append(message + '<br/>');
            div.scrollTop(div.prop('scrollHeight'));
        }
    </script>
@endsection

@section('styles')
    <style>
        #chat-log {
            height: 400px;
            border: 1px solid silver;
            overflow: scroll;
            padding: 5px;
            margin-top: 5px;
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Web Socket Example
                    </div>
                    <div class="panel-body">
                        <button id="openBtn" class="btn btn-default" >Open</button>
                        <button id="closeBtn" class="btn btn-default" >Close</button><br/>
                        <div id="chat-log">
                        </div>
                        <div class="input-group">
                            <input type="text" id="message" class="form-control" placeholder="Type a message..."/>
                            <span class="input-group-btn">
                                <button id="sendBtn" class="btn btn-secondary" type="button">Send!</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
