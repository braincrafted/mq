<?php
/**
 * This file is part of BraincraftedMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Mq;

use Braincrafted\Json\Json;

/**
 * Produces messages and sends them to the queue.
 *
 * This class is absolutley not required to write messages to the queue,
 * the following snippet would do the same thing:
 *
 *     $fp = stream_socket_client('tcp://localhost:4000');
 *     fwrite($fp, json_encode(array('type'=>'default','message'=>'bazbazbaz')));
 *     fclose($fp);
 *
 * However, Producer makes it a little bit easier:
 *
 *     $producer = new Braincrafted\Mq\Producer('localhost', 4000);
 *     $producer->produce('default', 'Hello World');
 *
 * See `examples/producer.php` for a full example.
 *
 * @package   BraincraftedMq
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class Producer
{
    /** @var string */
    private $hostname;

    /** @var integer */
    private $port;

    /**
     * Constructor.
     * @param string  $hostname The hostname
     * @param integer $port     The port
     */
    public function __construct($hostname, $port)
    {
        $this->hostname = $hostname;
        $this->port = $port;
    }

    /**
     * Produces a new message.
     *
     * @param string $type    The type of message
     * @param mixed  $message The message
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    public function produce($type, $message)
    {
        $fp = @stream_socket_client(sprintf('tcp://%s:%d', $this->hostname, $this->port), $errno, $errstr, 30);
        if (!$fp) {
            throw new \RuntimeException(sprintf('%s (%s)', $errstr, $errno));
        }

        fwrite($fp, Json::encode(array(
            'type'      => $type,
            'message'   => $message
        )));

        fclose($fp);
    }
}
