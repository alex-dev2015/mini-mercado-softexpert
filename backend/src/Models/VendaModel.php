<?php

namespace App\Models;

use PDOException;

class VendaModel extends ModelBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listarVendas()
    {
        try {
            $vendas = $this->readAll(
                'vendas_produtos'
            );
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
        return $vendas;
    }

    public function iniciarVenda(array $dados)
    {
        return $this->insert(
            'vendas',
            ":valor_total, :valor_tributo, :data",
            $dados
        );
    }

    public function realizarVenda(array $dados)
    {
        $lastInsert = 0;

        try {
            foreach ($dados as $dado){
                $inserir = $this->insert('vendas_produtos',
                    ":venda_id, :produto_id, :valor_total, :quantidade, :tributo",
                    $dado
                );

                if ($inserir > 0) {
                    $lastInsert += $inserir;
                }
            }
            return $lastInsert;

        }catch (\Exception $e){
            return 0;
        }

    }
}