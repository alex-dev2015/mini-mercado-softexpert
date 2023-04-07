<?php

namespace App\Models;

interface Padrao
{
    public function findBy(string $table, string $column, int $id);
    public function readAll(string $table);
    public function update(string $table, array $columns, array $data, $where , $id);
    public function delete(string $table, int $id);
    public function insert(string $table, array $columns , array $data);
}
