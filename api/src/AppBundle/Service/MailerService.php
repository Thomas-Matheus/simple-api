<?php

namespace AppBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;

class MailerService
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * MailerService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param string $mailPara
     * @param $mensagem
     */
    public function sendMail(string $mailPara, $mensagem)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Confirmação')
            ->setFrom('thomas.nnteam@gmail.com')
            ->setTo($mailPara)
            ->setBody($mensagem)
            ->setContentType('text/html')
        ;

        $this->container->get('mailer')->send($message);
    }
    
}