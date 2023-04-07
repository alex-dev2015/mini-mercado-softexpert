<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Database\Database;

class ModelBase implements Padrao
{
    private $conexao;

    public function __construct()
    {
        $conexao = Database::getIntance();
        $this->setConexao($conexao);
    }

    public function readAll($table): array
    {
        // TODO: Implement readAll() method.
        $sql = $this->conexao->prepare("select * from $table");

        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql->execute();
            $lista = [];
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $lista[] = $row;
            }
            return $lista;
        }

        return [];
    }

    public function update($table, array $columns, array $data, $where, $id)
    {
        // TODO: Implement update() method.
        $sql = "UPDATE {$table} SET " ;

        $arr = array_map(null, $columns, $data);

        foreach ( $arr as $item) {
            $sql .= " {$item[0]}={$item[1]} ,";
        }

        //retira a última vírgula
        $rest = substr($sql, 0, -1);

        $query = $rest;

        $query .= " WHERE {$where}=$id";

        $sq =$this->conexao->prepare($query);

        $sq->execute();
        return $sq->rowCount();
    }

    public function delete($table, $id)
    {
        // TODO: Implement delete() method.
    }

    public function insert($table, $columns, $data)
    {
        // TODO: Implement insert() method.
        try {
            $parametros = $columns;
            $coluna = str_replace(":", "", $columns);
            $stmt = $this->conexao->prepare("INSERT INTO $table ($coluna) VALUES ($parametros)");
            $stmt->execute($data);
            $lastId = $this->conexao->lastInsertId();
            return $lastId;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function findBy(string $table, string $column, int $id)
    {
        // TODO: Implement findBy() method.
        try {
            $sql = $this->conexao->prepare("select * from $table where $column = :id ");
            $sql->bindValue(":id", $id);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * @param PDO $conexao
     */
    public function setConexao(PDO $conexao): void
    {
        $this->conexao = $conexao;
    }

    /**
     * @return mixed
     */
    public function getConexao()
    {
        return $this->conexao;
    }
}
