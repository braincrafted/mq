<?php
/**
 * This file is part of BraincraftedMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Mq;

use Braincrafted\Json\Json;

/**
 * Consumes messags from the message queue and calls a callback.
 *
 * Allows to handle different types of messages with different callbacks.
 *
 * Usage:
 *
 *     $consumer = new Braincrafted\Mq\Consumer(array(
 *         'default'   => function ($message) {
 *             file_put_contents(__DIR__.'/default.log', $message."\n", FILE_APPEND);
 *         }
 *     ));
 *     $consumer->consume($_SERVER['argv'][1]);
 *
 * See `examples/consumer.php` for a full example.
 *
 * @package   BraincraftedMq
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class CallbackConsumer implements ConsumerInterface
{
    /** @var array */
    private $consumers;

    /**
     * Constructor.
     *
     * @param array $consumers Mesage consumers, associative array where the key is the type and the value
     *                         is a callback
     */
    public function __construct(array $consumers = array())
    {
        $this->consumers = $consumers;
    }

    /**
     * {@inheritDoc}
     */
    public function consume($data)
    {
        $data = Json::decode(stripslashes($data), true);

        if (!isset($data['type'])) {
            throw new \InvalidArgumentException('Message can\'t be consumed because the type information is missing.');
        }

        if (!isset($data['message'])) {
            throw new \InvalidArgumentException('Message can\'t be consumed because the message is missing.');
        }

        if (isset($this->consumers[$data['type']])) {
            call_user_func($this->consumers[$data['type']], $data['message']);
        }
    }
}
