<?php

namespace App\Controllers;

use App\Models\VendaModel;

class VendaController extends Controller
{
    private $vendaModel;
    public function __construct()
    {
        parent::__construct();
        $vendaModel = new VendaModel();
        $this->vendaModel = $vendaModel;
    }

    public function index()
    {
        $vendas = $this->vendaModel->listarVendas();
        if (is_array($vendas)){
            $resposta = [];
            (empty($vendas))
                ? $resposta = $this->semDados('GET')
                : $resposta = $this->sucesso($vendas, 'GET');
            echo $resposta;
        }else{
            echo $this->falha('GET');
        }
    }

    public function show($id)
    {
        //
    }

    public function iniciar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (empty($dados))
        {
            echo $this->semDados('POST');
        }else{
            $dados["data"] = date('Y-m-d');
            $inserir = $this->vendaModel->iniciarVenda($dados);
            if ($inserir > 0 ){
                echo json_encode(['id' => $inserir]);
            }else{
                echo $this->falha('POST');
            }
        }
    }

    public function create()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (empty($dados['vendas']))
        {
            echo $this->semDados('POST');
        }else{
            $dados["data"] = date('Y-m-d');
            $inserir = $this->vendaModel->realizarVenda($dados['vendas']);
            if ($inserir > 0 ){
                echo $this->sucesso($dados, 'POST');
            }else{
                echo $this->falha('POST');
            }
        }
    }

}