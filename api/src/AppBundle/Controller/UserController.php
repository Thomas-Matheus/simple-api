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

class UserController extends FOSRestController
{

    /**
     * @Rest\Get("api/user")
     * @ApiDoc(
     *  statusCodes={
     *      200="OK.",
     *      202="Sucesso.",
     *      400="Não existem usuários cadastrados.",
     *  },
     *  resource=true,
     *  description="Retorna todos os usuários cadastrados.",
     * )
     */
    public function getUsersAcion()
    {
        $collection = new ArrayCollection();
        $user1 = (new Usuario())
            ->setId(1)
            ->setNome('José da Silva')
            ->setCpf('42334528897');
        $collection->add($user1);

        $user2 = (new Usuario())
            ->setId(2)
            ->setNome('Carlos Antônio')
            ->setCpf('58510866457');
        $collection->add($user2);


        if (empty($collection) || null === $collection) {
            return new View('Não existem usuários cadastrados', Response::HTTP_BAD_REQUEST);
        }

        return new View($collection, Response::HTTP_ACCEPTED);
    }

    /**
     * @Rest\Get("api/user/{id}")
     * @ApiDoc(
     *  statusCodes={
     *      200="OK.",
     *      202="Sucesso.",
     *      404="Usuário não encontrado.",
     *  },
     *  description="Retorna apenas um usuário, pesquisando pelo id.",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Id do usuário."
     *      }
     *  }
     * )
     */
    public function getUserAction($id)
    {
        $user = (new Usuario())
            ->setId(1)
            ->setNome('José da Silva')
            ->setCpf('42334528897');

        if (empty($user) || null === $user || 1 !== (int)$id) {
            return new View('Usuário não encontrado', Response::HTTP_NOT_FOUND);
        }

        return new View($user, Response::HTTP_ACCEPTED);
    }


    /**
     * @Rest\Post("api/user/")
     * @ApiDoc(
     *  statusCodes={
     *      200="OK.",
     *      201="Usuário criado com sucesso.",
     *      400="CPF inválido.",
     *      406="Campos nulos não permitidos (nome e cpf).",
     *  },
     *  description="Cria um usuário.",
     *  requirements={
     *      {
     *          "name"="nome",
     *          "dataType"="string",
     *          "description"="Nome do usuário."
     *      },
     *     {
     *          "name"="cpf",
     *          "dataType"="string",
     *          "description"="CPF do usuário."
     *      }
     *  },
     *  output="AppBundle\Entity\Usuario"
     * )
     */
    public function postUserAction(Request $request)
    {
        $nome = $request->get('nome');
        $cpf = preg_replace("/[^0-9,.]/", '', $request->get('cpf'));

        if (11 !== strlen($cpf)) {
            return new View('CPF Inválido!!', Response::HTTP_BAD_REQUEST);
        }

        if (empty($nome) || empty($cpf)) {
            return new View('Não são permitidos valores nulos', Response::HTTP_NOT_ACCEPTABLE);
        }

        $user = (new Usuario())
            ->setId(1)
            ->setNome($nome)
            ->setCpf($cpf)
        ;

        //@todo: Aqui deveria conter o código para salvar o usuário x.x

        return new View($user, Response::HTTP_CREATED);
    }

}
