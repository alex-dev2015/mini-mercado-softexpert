<?php

namespace App\Models;

interface Padrao
{
    public function read(array $colunas , $tabela , array  $filtrarColuna = null, array $parametros = null, array $value = null);
    public function findBy(string $tabela, string $coluna, int $id);
    public function readAll(string $tabela);
    public function update(string $tabela, array  $colunas, array $dados, $where , $id);
    public function delete(string $tabela, int $id);
    public function insert(string$tabela, array $colunas , array $dados);
}