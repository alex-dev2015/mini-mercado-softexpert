<?php

namespace App\Database;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database
{
    private static $pdo;

    public static function getIntance()
    {
        if (!isset(self::$pdo)) {

            try {
                $conexao = 'pgsql:host=localhost;port=5432;dbname=mercado_expert;user=expert;password=openPsql20';
                $pdo = new PDO($conexao);

            } catch (PDOException $exception){
                echo $exception->getMessage();
            }
            return $pdo;
        }
        return self::$pdo;
    }
}
