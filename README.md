#### Sobre a aplicação
Foram criadas 3 simples APIs, `usuario`, `confirmar` e `reserva` para realizar troca de mensagens com o ActiveMQ utilizando as APIs `confirmar` e `reserva`.

#### APIs

* Usuário
  * `api/user`
    * Método HTTP **GET**
    * Retorna todos os usuários.

  * `api/user/1`
    * Método HTTP **GET**
    * Pesquisa por um usuário pelo `id´.

  * `api/user/`
    * Método HTTP **POST**
    * Cadastra um novo usário.
    * **Campos**.: `nome` e `cpf`

  * **OBS**.: Usuários estáticos.
  
* Reserva
  * `api/reserva/{mensagem}`
    * Envia uma mensagem a fila do `ActiveMQ`, o campo mensagem é opcional, caso não preenchido é adicionado a mensagem default `ActiveMQ Ativo Recebendo as Mensagens`

* Confirmar
  * `api/confirm/{email}`
    * Recebe a mensagem adicionada a fila do `ActiveMQ` e envia um email de confirmação para o email informado na api, campo **email** `obrigatório`

#### Tecnologias Utilizadas

* Composer
* Docker
* Docker Compose
* Symfony Framework 3.2
* ActiveMQ

#### Requisitos

  * Composer
  * Docker 1.12 ou supeior
  * Docker Compose 1.10
  * ActiveMQ

#### Configuração

* Ao realizar o clone do projeto, navegue até a pasta `simple-api/api` e execute o comando `composer install` em seu terminal, para realizar o download de todas as dependências do framework.
* Volte para a pasta `simple-api` e execute o compando `docker-compose up -d`, fazendo que seja realizado o download do container e realize as devidas configurações para o funcionamento da API.

#### Acesso a API

* Documentação da API
  * `http://localhost:8080/api/doc`

* API Usuário
  * `http://localhost:8080/api/user`

* API Confirmar
  * `http://localhost:8081/api/confirm`

* API Reserva
  * `http://localhost:8082/api/reserva`
  
**OBS**.:
Provavelmente o Google não irá permitir o envio do email devido a segurança, sendo necessário acessar o link `https://www.google.com/settings/security/lesssecureapps` e **ATIVAR** o método 'menos seguro' nas configurações do seu email que irá realizar o `envio do email` para o destinatário.

Ao rodar o **composer** no final do download das dependias, será solicitado para que seja adicionado o usuário e a senha do email de preferencia **gmail**, para que seja possível realizar o envio de email quando utilizar a **API Confirmar** e o IP de conexão do **ActiveMQ**

Caso não tenha adicionado os dados necessários durante o composer, procurar o arquivo `parameters.yml` no diretório `api/app/config/parameters.yml`.

Ficando da seguinte forma:
```yml
# Diretório -> api/app/config/parameters.yml

mailer_user: seuemail@gmail.com
mailer_password: suasenha@secreta
active_mq_host: localhost:61613
```
