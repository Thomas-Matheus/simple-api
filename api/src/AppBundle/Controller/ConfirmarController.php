<?php

namespace AppBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\Usuario;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class ConfirmarController extends FOSRestController
{


    /**
     * @Rest\Get("api/confirm/{email}")
     * @ApiDoc(
     *  statusCodes={
     *      200="OK.",
     *      202="Email enviado com sucesso.",
     *      400="Email inválido.",
     *      500="Erro interno.",
     *  },
     *  description="Envia um email de confirmação",
     *  requirements={
     *      {
     *          "name"="email",
     *          "dataType"="string",
     *          "description"="Email de recebimento."
     *      }
     *  }
     * )
     */
    public function confirmarAction($email)
    {

        $user = (new Usuario())
            ->setId(1)
            ->setNome('José da Silva')
            ->setCpf('42334528897');

        if (empty($email)) {
            return new View('O email não pode ser vazio', Response::HTTP_BAD_REQUEST);
        }

        try {
            $htmlEmail = $this->renderView('@App/email/email-confirmacao.html.twig', [
                'usuario' => $user,
                'msg' => $this->get('servico.activemq.receber.mensagem')->receiver()
            ]);

            $this->get('servico.email.confirmacao')->sendMail($email, $htmlEmail);

            return new View('Email enviado com sucesso para ' . $email, Response::HTTP_ACCEPTED);
        } catch (\Throwable $throwable) {
            return new View('Não possível se conectar ao ActiveMQ, Erro.: ' . $throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}