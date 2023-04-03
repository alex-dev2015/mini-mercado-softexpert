<?php

namespace App\Models;

use PDO;
use PDOException;

class TipoProdutoModel extends ModelBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listarTodosOsTiposDeProdutos()
    {
        try {
            $produtos = $this->readAll(
                'tipo_produtos'
            );
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
        return $produtos;
    }

    public function listarProdutosComImpostos()
    {
        $conexao = parent::getConexao();
        $sql = $conexao->prepare("select tp.id,
                                         tp.nome AS produto,
                                          t.nome,
                                          t.aliquota
                                    from tipo_produtos AS tp
                              left join tributos AS t on t.tipo_id = tp.id
                              group by tp.id, tp.nome, t.nome, t.aliquota"
         );
        try{
            $sql->execute();
            return $sql->fetchAll( PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            return null;
        }
    }

    public function inserirTipoDeProduto(array $dados)
    {
        return $this->insert(
            'tipo_produtos',
            ":nome",
            $dados
        );
    }

    public function pesquisarTipoDeProduto($id)
    {
        return $this->findBy(
            'tipo_produtos',
            'id',
            $id
        );
    }
}