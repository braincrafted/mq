<?php

require_once __DIR__.'/../vendor/autoload.php';

// This script expects the message (a JSON object) the first argument
// when calling the script from the command line.
//
// For example:
// $ php consumer.php '{"type":"default", "message": "Hello Consumer!"}'

if (!isset($_SERVER['argv'][1])) {
    echo "Usage: php consumer.php MESSAGE\n";
    exit(1);
}

// First we need to initalize the Consumer
// We need to add one or more consumers.
// In this case we use callbacks to consume the message.
// BcMq also contains a consumer that can use services

$consumer = new Bc\Mq\CallbackConsumer(array(
    // The key is the type of the consumer, the value must be a callback
    'default'   => function ($message) {
        // This consumer simply takes the message and appends it to a file called default.log
        file_put_contents(__DIR__.'/default.log', $message."\n", FILE_APPEND);
    }
));

// Consume the first argument
$consumer->consume($_SERVER['argv'][1]);
