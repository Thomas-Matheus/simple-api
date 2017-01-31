<?php

namespace AppBundle\Entity;

class Usuario
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Usuario
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Usuario
     */
    public function setNome(string $nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return Usuario
     */
    public function setCpf(string $cpf)
    {
        $cpfClear = preg_replace("/[^0-9,.]/", '', $cpf);

        if (11 !== strlen($cpfClear)) {
            throw new \InvalidArgumentException('O CPF informado é inválido!');
        }

        $this->cpf = $cpfClear;
        return $this;
    }


}