<?php

namespace AppBundle\Service;

use FuseSource\Stomp\Stomp;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ActiveMQSenderMessageService
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string
     */
    private $activeMQHost;

    /**
     * ActiveMQMessageService constructor.
     * @param ContainerInterface $container
     * @param string $activeMQHost
     */
    public function __construct(ContainerInterface $container, string $activeMQHost)
    {
        $this->container = $container;
        $this->activeMQHost = $activeMQHost;
    }

    public function sender(string $msg)
    {
        $activeMQ = new Stomp('tcp://' . $this->activeMQHost);
        $activeMQ->connect();
        $activeMQ->send('/queue/message', $msg);
        $activeMQ->disconnect();
    }


}