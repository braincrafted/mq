<?php

require_once __DIR__.'/../vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

// The server requires an event loop from React, a socket and a factory to create
// background processes
$server = new Bc\Mq\Server(
    new Bc\BackgroundProcess\Factory('Bc\BackgroundProcess\BackgroundProcess'),
    $loop,
    new React\Socket\Server($loop)
);

// We run the message queue server on port 4000 and use consumer.php to consume messages
$server->run(sprintf('`which php` %s/consumer.php', __DIR__), 4000);
