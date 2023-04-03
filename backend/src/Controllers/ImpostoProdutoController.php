<?php

namespace App\Controllers;

use App\Models\ImpostoProdutoModel;

class ImpostoProdutoController extends Controller
{
    private $impostoProdutoModel;
    public function __construct()
    {
        parent::__construct();
        $impostoProdutoModel = new ImpostoProdutoModel();
        $this->impostoProdutoModel = $impostoProdutoModel;
    }

    public function index()
    {
        $impostos = $this->impostoProdutoModel->listarTodosOsImpostosDosProdutos();
        if (is_array($impostos)){
            $resposta = [];
            (empty($impostos))
                ? $resposta = $this->semDados('GET')
                : $resposta = $this->sucesso($impostos, 'GET');
            echo $resposta;

        }else{
            echo $this->falha('GET');
        }
    }

    public function show($id)
    {
        $imposto = $this->impostoProdutoModel->pesquisarImpostoDeProduto($id);
        if (is_array($imposto)){
            $resposta = [];
            (empty($imposto))
                ? $resposta = $this->semDados('GET')
                : $resposta = $this->sucesso($imposto, 'GET');
            echo $resposta;
        }else{
            echo $this->falha('GET');
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data))
        {
            echo $this->semDados('POST');
        }else{
            $inserir = $this->impostoProdutoModel->inserirImpostoEmProduto($data);
            if ($inserir > 0 ){
                echo $this->sucesso($data, 'POST');
            }else{
                echo $this->falha('POST');
            }
        }
    }
}