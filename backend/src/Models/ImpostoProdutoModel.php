<?php

namespace App\Models;

use PDOException;

class ImpostoProdutoModel extends ModelBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listarTodosOsImpostosDosProdutos()
    {
        try {
            $produtos = $this->readAll(
                'tributos'
            );
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
        return $produtos;
    }

    public function inserirImpostoEmProduto(array $dados)
    {
        return $this->insert(
            'tributos',
            ":nome, :aliquota, :tipo_id",
            $dados
        );
    }

    public function pesquisarImpostoDeProduto($id)
    {

        return $this->findBy(
            'tributos',
            'id',
            $id
        );
    }
}