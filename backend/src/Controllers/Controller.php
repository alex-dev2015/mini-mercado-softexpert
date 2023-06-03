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

    public function success(array $data, string $verb): string
    {
        $this->response->setSuccess(true);
        if ($verb == 'GET') {
            $this->response->setResponseContent($data)
                ->setHttpStatusCode(200);
        }

        if ($verb == 'POST') {
            $this->response->setResponseContent($data)
                ->setHttpStatusCode(201)
                ->setReturnMessage('Cadastro Realizado com Sucesso!');
        }

        return json_encode($this->response->getResponse());
    }

    public function responseFailure(string $verb): string
    {
        $this->response->setSuccess(false);
        $this->response->setHttpStatusCode(400);
        if ($verb == 'GET') {
            $this->response->setReturnMessage('Falha ao retornar os dados');
        }
        if ($verb == 'POST') {
            $this->response->setReturnMessage('Falha ao inserir os dados');
        }

        if ($verb == 'PUT') {
            $this->response->setReturnMessage('Falha ao atualizar os dados');
        }

        if ($verb == 'DELETE') {
            $this->response->setReturnMessage('Falha ao deletar os dados');
        }

        return json_encode($this->response->getResponse());
    }

    public function emptyData(string $verb): string
    {
        $this->response->setSuccess(false);
        $this->response->setHttpStatusCode(400);
        if ($verb == 'GET') {
            $this->response ->setReturnMessage('Dados não encontrado');
        }
        if ($verb == 'POST') {
            $this->response ->setReturnMessage('Dados da Requisição Vazia');
        }

        return json_encode($this->response->getResponse());
    }

}
