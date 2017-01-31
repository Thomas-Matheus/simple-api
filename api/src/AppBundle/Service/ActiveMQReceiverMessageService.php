<?php

namespace AppBundle\Service;

use FuseSource\Stomp\Stomp;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ActiveMQReceiverMessageService
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

    /**
     * @return string
     * @throws \Exception
     */
    public function receiver(): string
    {
        $activeMQ = new Stomp('tcp://' . $this->activeMQHost);
        $activeMQ->connect();
        $activeMQ->subscribe('/queue/message');

        $message = $activeMQ->readFrame();

        if (empty($message)) {
            throw new \Exception('Falha ao receber a mensagem');
        }

        $activeMQ->ack($message);
        $body = $message->body;
        $activeMQ->disconnect();
        return $body ? $body : '';
    }

}