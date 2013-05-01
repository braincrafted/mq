<?php

namespace Bc\Mq;

use \Mockery as m;

/**
 * ServiceConsumerTest
 *
 * @group unit
 */
class ServiceConsumerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerInterface */
    private $container;

    public function setUp()
    {
        $this->container = m::mock('Symfony\Component\DependencyInjection\ContainerInterface');

        $service = m::mock('\stdClass');
        $service
            ->shouldReceive('consume')
            ->with('foobar')
            ->once();

        $this->container
            ->shouldReceive('get')
            ->with('consumer.bar')
            ->once()
            ->andReturn($service);
    }
    /**
     * Tests the <code>consume()</code> message.
     *
     * @covers Bc\Mq\ServiceConsumer::__construct()
     * @covers Bc\Mq\ServiceConsumer::consume()
     * @covers Bc\Mq\ServiceConsumer::setContainer()
     */
    public function testConsume()
    {
        $consumer = new ServiceConsumer(array('default' => 'consumer.bar'));
        $consumer->setContainer($this->container);

        $consumer->consume('{"type":"default","message":"foobar"}');
    }

    /**
     * Tests the <code>consume()</code> message.
     *
     * @covers Bc\Mq\ServiceConsumer::consume()
     */
    public function testConsume_Escaped()
    {
        $consumer = new ServiceConsumer(array('default' => 'consumer.bar'));
        $consumer->setContainer($this->container);

        $consumer->consume('{\"type\":\"default\",\"message\":\"foobar\"}');
    }

    /**
     * Tests the <code>consume()</code> message and the message misses the type.
     *
     * @covers Bc\Mq\ServiceConsumer::consume()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testConsume_MissingType()
    {
        $consumer = new ServiceConsumer();

        $consumer->consume('{\"message\":\"foobar\"}');
    }

    /**
     * Tests the <code>consume()</code> message and the message misses the message.
     *
     * @covers Bc\Mq\ServiceConsumer::consume()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testConsume_MissingMessage()
    {
        $consumer = new ServiceConsumer();

        $consumer->consume('{\"type\":\"default\"}');
    }
}
