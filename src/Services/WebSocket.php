<?php

namespace Pletfix\WebSocket\Services;

use Pletfix\WebSocket\Services\Contracts\WebSocket as WebSocketContract;
use RuntimeException;
use ZMQ;
use ZMQContext;
use ZMQSocket;

/**
 * Object to push messages to the web socket.
 *
 * @see http://socketo.me/docs/push Push Integration by Ratchet
 */
class WebSocket implements WebSocketContract
{
    /**
     * ZMQSocket to send messages from the web server to the web socket.
     *
     * @var ZMQSocket
     */
    protected $pushSocket;

    /**
     * Create a new WebSocket instance.
     */
    public function __construct()
    {
        if (!class_exists('\React\ZMQ\Context')) {
            throw new RuntimeException('React/ZMQ is required to push messages!');
        }
        $context = new ZMQContext();
        $this->pushSocket = $context->getSocket(ZMQ::SOCKET_PUSH, config('websocket.zmq_push_id'));
        $this->pushSocket->connect('tcp://127.0.0.1:' . config('websocket.push_port'));
    }

    /**
     * @inheritdoc
     */
    public function push($message)
    {
        $this->pushSocket->send($message);
    }
}
