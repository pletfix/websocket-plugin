<?php

namespace Pletfix\WebSocket\Handler;

use Exception;
use Ratchet\ConnectionInterface;
use Pletfix\WebSocket\Handler\Contracts\WebSocketHandler as WebSocketHandlerContract;
use SplObjectStorage;

/**
 * Class which handles the web socket events.
 *
 * @see http://socketo.me/docs/hello-world Ratchet Tutorial
 */
class WebSocketHandler implements WebSocketHandlerContract
{
    /**
     * List of all client connections.
     *
     * @var SplObjectStorage
     */
    protected $connections;

    /**
     * Create a new web socket handler.
     */
    public function __construct()
    {
        $this->connections = new SplObjectStorage;
    }

    /**
     * @inheritdoc
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections->attach($conn);
        $this->trace($conn, 'Connection open');
    }

    /**
     * @inheritdoc
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->connections->detach($conn);
        $this->trace($conn, 'Connection closed');
    }

    /**
     * @inheritdoc
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $this->trace($from, $msg);
        $this->broadcastExclude($msg, [$from]);
    }

    /**
     * @inheritdoc
     */
    public function onPush($msg)
    {
        $this->trace(null, $msg);
        $this->broadcast($msg);
    }

    /**
     * @inheritdoc
     */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $this->trace($conn, 'Error: ' . $e->getMessage());
        $conn->close();
    }

    /**
     * Send a message to a client.
     *
     * @param ConnectionInterface $to The connection which receive the message.
     * @param string $msg The message to send.
     */
    protected function send(ConnectionInterface $to, $msg)
    {
        $to->send($msg);
    }

    /**
     * Send a message to all clients.
     *
     * @param string $msg The message to send.
     */
    protected function broadcast($msg)
    {
        foreach ($this->connections as $conn) {
            $conn->send($msg);
        }
    }

    /**
     * Send a message to all clients except the clients listed in the blacklist.
     *
     * @param string $msg The message to send.
     * @param array $exclude Blacklist
     */
    protected function broadcastExclude($msg, array $exclude)
    {
        $exclude = array_map(function($conn) {
            return $conn->resourceId;
        }, $exclude);

        foreach ($this->connections as $conn) {
            if (!in_array($conn->resourceId, $exclude)) {
                $conn->send($msg);
            }
        }
    }

    /**
     * Print the text to stdout.
     *
     * @param ConnectionInterface $conn|null
     * @param string $text
     */
    protected function trace($conn, $text)
    {
        /** @noinspection PhpUndefinedFieldInspection */
        echo ($conn !== null ? 'Client #' . $conn->resourceId : 'Server') . ': ' . $text . PHP_EOL;
    }
}