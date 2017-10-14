<?php

$di = \Core\Services\DI::getInstance();

$di->set('websocket', \Pletfix\WebSocket\Services\WebSocket::class, true);
$di->set('websocket-handler', \Pletfix\WebSocket\Handler\WebSocketHandler::class, true);
