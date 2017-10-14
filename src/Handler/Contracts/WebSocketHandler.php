<?php

namespace Pletfix\WebSocket\Handler\Contracts;

use Ratchet\MessageComponentInterface;

interface WebSocketHandler extends MessageComponentInterface
{
    /**
     * Received a message from the web server (via ZMQSocket).
     *
     * @param string $msg
     */
    public function onPush($msg);
}
