<?php
/**
 * This file is part of BcMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Mq;

/**
 * ConsumerTest
 *
 * @group unit
 */
class ConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the <code>consume()</code> message.
     *
     * @covers Bc\Mq\Consumer::__construct()
     * @covers Bc\Mq\Consumer::consume()
     */
    public function testConsume()
    {
        $consumer = new Consumer(
            array(
                'default'   => function($message) {
                    $this->assertEquals('foobar', $message);
                }
            )
        );

        $consumer->consume('{"type":"default","message":"foobar"}');
    }

    /**
     * Tests the <code>consume()</code> message.
     *
     * @covers Bc\Mq\Consumer::consume()
     */
    public function testConsume_Escaped()
    {
        $consumer = new Consumer(
            array(
                'default'   => function($message) {
                    $this->assertEquals('foobar', $message);
                }
            )
        );

        $consumer->consume('{\"type\":\"default\",\"message\":\"foobar\"}');
    }

    /**
     * Tests the <code>consume()</code> message and the message misses the type.
     *
     * @covers Bc\Mq\Consumer::consume()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testConsume_MissingType()
    {
        $consumer = new Consumer();

        $consumer->consume('{\"message\":\"foobar\"}');
    }

    /**
     * Tests the <code>consume()</code> message and the message misses the message.
     *
     * @covers Bc\Mq\Consumer::consume()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testConsume_MissingMessage()
    {
        $consumer = new Consumer();

        $consumer->consume('{\"type\":\"default\"}');
    }
}
