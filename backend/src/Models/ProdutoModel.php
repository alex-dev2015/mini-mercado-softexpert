<?php

namespace App\Models;

use PDOException;

class ProdutoModel extends ModelBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listarTodosOsProdutos()
    {
        try {
            $produtos = $this->readAll(
                'produtos'
            );
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
        return $produtos;
    }

    public function inserirProduto(array $dados)
    {
        return $this->insert(
            'produtos',
            ":nome, :preco, :tipo_id",
            $dados
        );
    }

    public function pesquisarProduto($id)
    {
        return $this->findBy(
            'produtos',
            'id',
            $id
        );
    }
}