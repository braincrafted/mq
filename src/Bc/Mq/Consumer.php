<?php
/**
 * This file is part of BcMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Mq;

use Bc\Json\Json;

class Consumer
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
     * Consumes the given message.
     *
     * @param string $data The message must be encoded as JSON and quotes can be escaped.
     *
     * @return void
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
