<?php

namespace App\Controllers;

use App\Utils\JsonResponse;

class Controller
{
    private $response;
    public function __construct()
    {
        $response = new JsonResponse();
        $this->response = $response;
    }

    public function sucesso(array $dados, string $verbo)
    {
        $this->response->setSucesso(true);
        if ($verbo == 'GET'){
            $this->response->setConteudoResposta($dados)
                ->setHttpStatusCode(200);
        }

        if ($verbo == 'POST'){
            $this->response->setConteudoResposta($dados)
                ->setHttpStatusCode(201)
                ->setMensagemDeRetorno('Cadastro Realizado com Sucesso!');
        }

        return json_encode($this->response->getResponse());
    }

    public function falha(string $verbo)
    {
        $this->response->setSucesso(false);
        $this->response->setHttpStatusCode(400);
        if ($verbo == 'GET'){
            $this->response->setMensagemDeRetorno('Falha ao retornar os dados');
        }
        if ($verbo == 'POST'){
            $this->response->setMensagemDeRetorno('Falha ao inserir os dados');
        }

        if ($verbo == 'PUT'){
            $this->response->setMensagemDeRetorno('Falha ao atualizar os dados');
        }

        if ($verbo == 'DELETE'){
            $this->response->setMensagemDeRetorno('Falha ao deletar os dados');
        }

        return json_encode($this->response->getResponse());
    }

    public function semDados(string $verbo){
        $this->response->setSucesso(false);
        $this->response->setHttpStatusCode(400);
        if ($verbo == 'GET'){
            $this->response ->setMensagemDeRetorno('Dados não encontrado');
        }
        if ($verbo == 'POST'){
            $this->response ->setMensagemDeRetorno('Dados da Requisição Vazia');
        }

        return json_encode($this->response->getResponse());
    }

}