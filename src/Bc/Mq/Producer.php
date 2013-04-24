<?php
/**
 * This file is part of BcMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Mq;

use Bc\Json\Json;

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
