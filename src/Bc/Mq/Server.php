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

class Server
{
    /** @var BackgroundProcessFactory */
    private $processFactory;

    /** @var LoopInterface */
    private $loop;

    /** @var ServerInterface */
    private $socket;

    public function __construct(BackgroundProcessFactory $processFactory, LoopInterface $loop, ServerInterface $socket)
    {
        $this->processFactory   = $processFactory;
        $this->loop             = $loop;
        $this->socket           = $socket;
    }

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

    public function handleData($data, $consumer, ConnectionInterface $connection)
    {
        $command = sprintf('%s "%s"', $consumer, addslashes($data));
        $this->processFactory->newProcess($command)->run();

        $connection->close();
    }
}
