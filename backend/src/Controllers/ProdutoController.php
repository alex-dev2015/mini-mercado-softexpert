<?php

namespace App\Controllers;

use App\Models\ProdutoModel;

class ProdutoController extends Controller
{
    private $produtoModel;
    public function __construct()
    {
        parent::__construct();
        $produtoModel = new ProdutoModel();
        $this->produtoModel = $produtoModel;
    }

    public function index()
    {
        $produtos = $this->produtoModel->listarTodosOsProdutos();
        if (is_array($produtos)){
            $resposta = [];
            (empty($produtos))
                ? $resposta = $this->semDados('GET')
                : $resposta = $this->sucesso($produtos, 'GET');
            echo $resposta;
        }else{
            echo $this->falha('GET');
        }
    }

    public function show($id)
    {
        $produto = $this->produtoModel->pesquisarProduto($id);
        if (is_array($produto)){
            $resposta = [];
            (empty($produto))
                ? $resposta = $this->semDados('GET')
                : $resposta = $this->sucesso($produto, 'GET');
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
            $inserir = $this->produtoModel->inserirProduto($data);
            if ($inserir > 0 ){
                echo $this->sucesso($data, 'POST');
            }else{
                echo $this->falha('POST');
            }
        }
    }
}