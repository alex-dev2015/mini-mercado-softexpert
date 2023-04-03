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

    public function read(array $colunas, $tabela, array $filtrarColuna = null, array $parametros = null, array $value = null)
    {
        // TODO: Implement read() method.
        $query = "select ";

        foreach ($colunas as $field) {
            $query .= " {$field},";
        }

        //retira a última vírgula
        $rest = substr($query, 0, -1);

        $query = $rest;

        $query .= " from {$tabela} WHERE  ";


        if ($filtrarColuna <> null) {
            $arr = array_map(null, $filtrarColuna, $parametros, $value);
            foreach ($arr as $item) {

                $sql = " {$item[0]} {$item[1]} ";

                if (is_string($item[2])) {
                    $sql .= " '{$item[2]}' and";
                } elseif (is_numeric($item[2])) {
                    $sql .= " {$item[2]} and";
                }
                $query .= $sql;
            }

            $rest2 = substr($query, 0, -3);

            $query = $rest2;
        }


        try {
            $sql = $this->conexao->prepare("$query");
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function readAll($tabela): array
    {
        // TODO: Implement readAll() method.
        $sql = $this->conexao->prepare("select * from $tabela");

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

    public function update($tabela, array $colunas, array $dados, $where, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($tabela, $id)
    {
        // TODO: Implement delete() method.
    }

    public function insert($tabela, $colunas, $dados)
    {
        // TODO: Implement insert() method.
        try {
            $parametros = $colunas;
            $coluna = str_replace(":", "", $colunas);
            $stmt = $this->conexao->prepare("INSERT INTO $tabela ($coluna) VALUES ($parametros)");
            $stmt->execute($dados);
            $lastId = $this->conexao->lastInsertId();
            return $lastId;
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * @param mixed $conexao
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

    public function findBy(string $tabela, string $coluna, int $id)
    {
        // TODO: Implement findBy() method.
        try {
             $sql = $this->conexao->prepare("select * from $tabela where $coluna = :id ");
             $sql->bindValue(":id", $id);
             $sql->execute();
             return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}