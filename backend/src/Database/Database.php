<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private static $pdo;

    public static function getIntance()
    {
        if (!isset(self::$pdo)){

            try {
                $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
                $dotenv->load();

                $dsn = sprintf(
                    'pgsql:host=%s;port=%s;dbname=%s',
                    getenv('DB_HOST'),
                    getenv('DB_PORT'),
                    getenv('DB_NAME')
                );

                $conexao = 'pgsql:host=localhost;port=5432;dbname=mercado_expert;user=expert;password=openPsql20';

                $host = getenv('DB_HOST');
                $user = getenv('DB_USER');
                $password = getenv('DB_PASSWORD');
                $port = getenv('DB_PORT');

//                var_dump($user, $password, $port);
//                $pdo = new PDO($dsn, $user, $password, $port);
                $pdo = new PDO($conexao);

            } catch (PDOException $exception){
                echo $exception->getMessage();
            }
            return $pdo;
        }
        return self::$pdo;
    }
}