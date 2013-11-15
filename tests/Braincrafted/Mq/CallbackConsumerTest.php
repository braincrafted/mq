<?php
/**
 * This file is part of BraincraftedMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Mq;

/**
 * ConsumerTest
 *
 * @group unit
 */
class CallbackConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the <code>consume()</code> message.
     *
     * @covers Braincrafted\Mq\CallbackConsumer::__construct()
     * @covers Braincrafted\Mq\CallbackConsumer::consume()
     */
    public function testConsume()
    {
        $consumer = new CallbackConsumer(
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
     * @covers Braincrafted\Mq\CallbackConsumer::consume()
     */
    public function testConsume_Escaped()
    {
        $consumer = new CallbackConsumer(
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
     * @covers Braincrafted\Mq\CallbackConsumer::consume()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testConsume_MissingType()
    {
        $consumer = new CallbackConsumer();

        $consumer->consume('{\"message\":\"foobar\"}');
    }

    /**
     * Tests the <code>consume()</code> message and the message misses the message.
     *
     * @covers Braincrafted\Mq\CallbackConsumer::consume()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testConsume_MissingMessage()
    {
        $consumer = new CallbackConsumer();

        $consumer->consume('{\"type\":\"default\"}');
    }
}
