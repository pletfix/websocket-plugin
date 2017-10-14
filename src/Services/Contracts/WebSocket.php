<?php

namespace Pletfix\WebSocket\Services\Contracts;

interface WebSocket
{
    /**
     * Push a message to the web socket server.
     *
     * @param string $msg The message to send.
     */
    public function push($msg);
}
