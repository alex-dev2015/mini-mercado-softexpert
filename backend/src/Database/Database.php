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
                $dotEnv = Dotenv::createImmutable(dirname(__FILE__, 3));
                $dotEnv->load();
                $host = $_ENV['DATABASE_HOST'];
                $port = $_ENV['DATABASE_PORT'];
                $dbName = $_ENV['DATABASE_NAME'];
                $user = $_ENV['DATABASE_USER'];
                $password = $_ENV['DATABASE_PASSWORD'];

                $conexao =  'pgsql:host=' . $host .
                            ';port=' . $port .
                            ';dbname=' . $dbName .
                            ';user=' . $user .
                            ';password=' . $password
                ;
                $pdo = new PDO($conexao);

            } catch (PDOException $exception){
                echo $exception->getMessage();
            }
            return $pdo;
        }
        return self::$pdo;
    }
}
