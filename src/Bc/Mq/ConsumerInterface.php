<?php
/**
 * This file is part of BcMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Mq;

/**
 * Consumes messags from the message queue.
 *
 * @package   BcMq
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
