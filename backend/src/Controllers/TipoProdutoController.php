<?php

namespace App\Controllers;

use App\Models\TipoProdutoModel;

class TipoProdutoController extends Controller
{
    private $tipoProdutoModel;
    public function __construct()
    {
        parent::__construct();
        $tipoProdutoModel = new TipoProdutoModel();
        $this->tipoProdutoModel = $tipoProdutoModel;
    }

    public function index()
    {
        $tipoProdutos = $this->tipoProdutoModel->listarTodosOsTiposDeProdutos();
        if (is_array($tipoProdutos)){
            $resposta = [];
            (empty($tipoProdutos))
                ? $resposta = $this->semDados('GET')
                : $resposta = $this->sucesso($tipoProdutos, 'GET');
            echo $resposta;

        }else{
            echo $this->falha('GET');
        }
    }

    public function listarImpostos()
    {
        $novoArray = [];
        $produtos = $this->tipoProdutoModel->listarProdutosComImpostos();

        if (!empty($produtos)) {
            foreach ($produtos as $produto) {
                $tipo = $produto["produto"];
                if (!array_key_exists($tipo, $novoArray)) {
                    $novoArray[$tipo] = array(
                        "tributos" => array()
                    );
                }
                $tributo = array(
                    "nome" => $produto["nome"],
                    "aliquota" => $produto["aliquota"]
                );
                array_push($novoArray[$tipo]["tributos"], $tributo);
            }
            echo $this->sucesso($novoArray, 'GET');
        }else{
            echo $this->semDados('GET');
        }
    }

    public function show($id)
    {
        $tipoProduto = $this->tipoProdutoModel->pesquisarTipoDeProduto($id);
        if (is_array($tipoProduto)){
            $resposta = [];
            (empty($tipoProduto))
                ? $resposta = $this->semDados('GET')
                : $resposta = $this->sucesso($tipoProduto, 'GET');
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
            $inserir = $this->tipoProdutoModel->inserirTipoDeProduto($data);
            if ($inserir > 0 ){
                echo $this->sucesso($data, 'POST');
            }else{
                echo $this->falha('POST');
            }
        }
    }
}