<?php

namespace Pletfix\WebSocket\Controllers;

use App\Controllers\Controller;
use Core\Services\Contracts\Response;

class WebSocketController extends Controller
{
    /**
     * Open a chat window.
     *
     * @return Response
     */
    public function chat()
    {
        return view('websocket.chat');
    }

    /**
     * Push a message.
     *
     * @return Response
     */
    public function push()
    {
        websocket()->push(json_encode([
            'text' => datetime()->toDateTimeString()
        ]));
    }
}
