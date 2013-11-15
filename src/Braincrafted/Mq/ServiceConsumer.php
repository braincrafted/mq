<?php
/**
 * This file is part of BraincraftedMq.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Mq;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Braincrafted\Json\Json;

/**
 * Consumes messags from the message queue and sends them to a service.
 *
 * @package   BraincraftedMq
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class ServiceConsumer implements ContainerAwareInterface, ConsumerInterface
{
    /** @var array */
    private $consumers;

    /** @var ContainerInterface */
    private $container;

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
     * Sets the service container.
     *
     * @param ContainerInterface $container The service container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
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
            $service = $this->container->get($this->consumers[$data['type']]);
            call_user_func(array($service, 'consume'), $data['message']);
        }
    }}
