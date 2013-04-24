<?php
/**
 * This file is part of BcMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Mq;

use React\EventLoop\Factory as EventLoopFactory;
use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\Server as SocketServer;
use React\Socket\ServerInterface;

use Bc\BackgroundProcess\Factory as BackgroundProcessFactory;

/**
 * Message Queue Server
 *
 * Uses ReactPHP to run a non-blocking server that accepts messages via a
 * socket and executes them in a background process.
 *
 * Usage:
 *
 *     $loop = React\EventLoop\Factory::create();
 *     $server = new Bc\Mq\Server(
 *         new Bc\BackgroundProcess\Factory('Bc\BackgroundProcess\BackgroundProcess'),
 *         $loop,
 *         new React\Socket\Server($loop)
 *     );
 *
 *     $server->run(sprintf('`which php` %s/consumer.php', __DIR__), 4000);
 *
 * See `examples/server.php` for a full example.
 *
 * @package   BcMq
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class Server
{
    /** @var BackgroundProcessFactory */
    private $processFactory;

    /** @var LoopInterface */
    private $loop;

    /** @var ServerInterface */
    private $socket;

    /**
     * Constructor.
     *
     * @param BackgroundProcessFactory $processFactory Factory to create background procceses
     * @param LoopInterface            $loop           The loop
     * @param ServerInterface          $socket         The socket
     */
    public function __construct(BackgroundProcessFactory $processFactory, LoopInterface $loop, ServerInterface $socket)
    {
        $this->processFactory   = $processFactory;
        $this->loop             = $loop;
        $this->socket           = $socket;
    }

    /**
     * Runs the message server on the given port.
     *
     * @param string  $consumer Command to execute when a message arrives
     * @param integer $port     Port to run the server on
     *
     * @return void
     */
    public function run($consumer, $port)
    {
        // @codeCoverageIgnoreStart
        $this->socket->on('connection', function (ConnectionInterface $conn) use ($consumer) {
            $conn->on('data', function ($data) use ($conn, $consumer) {
                $this->handleData(trim($data), $consumer, $conn);
            });
        });
        // @codeCoverageIgnoreEnd

        $this->socket->listen($port);
        $this->loop->run();
    }

    /**
     * Handles the given data.
     *
     * @param string              $data       Consumed data
     * @param string              $consumer   Command to execute
     * @param ConnectionInterface $connection The connection to the producer
     *
     * @return void
     */
    public function handleData($data, $consumer, ConnectionInterface $connection)
    {
        $command = sprintf('%s "%s"', $consumer, addslashes($data));
        $this->processFactory->newProcess($command)->run();

        $connection->close();
    }
}
