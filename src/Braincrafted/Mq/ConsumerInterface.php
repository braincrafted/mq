<?php
/**
 * This file is part of BraincraftedMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Mq;

/**
 * Consumes messags from the message queue.
 *
 * @package   BraincraftedMq
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
interface ConsumerInterface
{
    /**
     * Consumes the given message.
     *
     * @param string $data The message must be encoded as JSON and quotes can be escaped.
     *
     * @return void
     */
    public function consume($data);
}
