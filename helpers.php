<?php

use Core\Services\DI;

if (!function_exists('websocket')) {
    /**
     * Get the WebSocket to push messages.
     *
     * @return \Pletfix\WebSocket\Services\Contracts\WebSocket
     */
    function websocket()
    {
        return DI::getInstance()->get('websocket');
    }
}
