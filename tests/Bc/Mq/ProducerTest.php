<?php
/**
 * This file is part of BcMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Mq;

/**
 * ProducerTest
 *
 * @group unit
 */
class ProducerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the <code>produce()</code> method with a connection error.
     *
     * @expectedException \RuntimeException
     */
    public function testProduce_NoConnection()
    {
        $producer = new Producer('invalid', 4444);
        $producer->produce('default', 'foobar');
    }
}
