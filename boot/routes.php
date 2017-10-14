<?php

$router = Core\Application::router();

$router->get('websocket/chat', 'WebSocketController@chat');
$router->get('websocket/push', 'WebSocketController@push');
