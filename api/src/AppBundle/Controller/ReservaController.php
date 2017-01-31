<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\Usuario;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class ReservaController extends FOSRestController
{

    /**
     * @Rest\Get("api/reserva/{mensagem}")
     * @ApiDoc(
     *  statusCodes={
     *      200="OK.",
     *      202="Mensagem enviada com sucesso.",
     *  },
     *  description="Envia uma nova mensagem",
     *  requirements={
     *      {
     *          "name"="mensagem",
     *          "dataType"="string",
     *          "description"="Mensagem a ser enviada."
     *      }
     *  }
     * )
     */
    public function reservaAction($mensagem)
    {
        $msg = empty($mensagem)
            ? $mensagem
            : 'ActiveMQ Ativo Recebendo as Mensagens'
        ;

        $this->get('servico.activemq.enviar.mensagem')->sender($msg);
        return new View('Mensagem enviada.', Response::HTTP_ACCEPTED);
    }
    
}
