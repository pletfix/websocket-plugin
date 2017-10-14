<?php

namespace Pletfix\WebSocket\Commands;

use Core\Services\Command;
use Core\Services\DI;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\ZMQ\Context;

/**
 * Command to start the web socket server.
 *
 * @see http://socketo.me/docs/hello-world Ratchet Tutorial
 * @see http://socketo.me/docs/push Push Integration by Ratchet
 */
class WebSocketCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'websocket:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a web socket server.';

    /**
     * Possible options of the command.
     *
     * @var array
     */
    protected $options = [
        'port' => ['type' => 'int', 'short' => 'p', 'default' => null, 'description' => 'The Port on which we listen for new connections.'],
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $config  = config('websocket');
        $port    = $this->input('port') ?: $config['port'];
        $loop    = Factory::create();
        $handler = DI::getInstance()->get('websocket-handler');

        // Listen for the web server message to redirect to the web socket

        $context = new Context($loop);
        /** @var \React\ZMQ\SocketWrapper $pull */
        /** @noinspection PhpUndefinedMethodInspection */
        $pull = $context->getSocket(\ZMQ::SOCKET_PULL, $config['zmq_pull_id']);
        /** @noinspection PhpUndefinedMethodInspection */
        $pull->bind('tcp://127.0.0.1:'.$config['push_port']);
        $pull->on('message', [$handler, 'onPush']);

        // Set up our web socket server for clients wanting real-time updates

        $webSock = new Server('0.0.0.0:' . $port, $loop); // Binding to 0.0.0.0 means remotes can connect
        new IoServer(
            new HttpServer(
                new WsServer(
                    $handler
                )
            ), $webSock
        );

        $this->info('Listening on port ' . $port);
        $loop->run();
    }
}
