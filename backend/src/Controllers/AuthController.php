<?php

namespace App\Controllers;

use Exception;
use Firebase\JWT\JWT;
use App\Models\AuthModel;
use App\Utils\UsefulFunctions;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    private AuthModel $authModel;
    private UsefulFunctions $usefulFunctions;
    public function __construct()
    {
        parent::__construct();
        $authModel = new AuthModel();
        $usefulFunctions = new UsefulFunctions();
        $this->authModel = $authModel;
        $this->usefulFunctions = $usefulFunctions;

    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);


        $username = $data['username'];
        $password = $data['password'];

        $user = $this->authModel->searchUser($username);

        if (!$user){
            echo $this->emptyData('POST');
            exit(0);
        }

        if(!password_verify($password, $user[0]['password'])){
            echo $this->responseFailure('POST');
            exit(0);
        }

        $payload = [
            "exp" => time() + 20,
            "iat" => time(),
            "email" => $username
        ];

        $encode = JWT::encode($payload, $_ENV['TOKEN_KEY'], 'HS256');
        echo $this->success([$encode], 'GET');
    }

    public function auth(){
        if (!empty($_SERVER["HTTP_AUTHORIZATION"])){
            $authorization = $_SERVER["HTTP_AUTHORIZATION"];
            $token = str_replace('Bearer ', '', $authorization);
            $key = $_ENV['TOKEN_KEY'];

            try {
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
                echo json_encode($decoded);
                exit(0);
            }catch (Exception $e){
                if ($e->getMessage() === 'Expired token'){
                    $this->responseFailure('GET');
                    die('EXPIRED');
                }
            }
        }
        echo $this->responseFailure('GET');
    }

}