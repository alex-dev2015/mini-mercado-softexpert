<?php

use App\Utils\JsonResponse;
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dispatcher = include __DIR__ . '/routes.php';

date_default_timezone_set('America/Sao_Paulo');

$dotEnv = Dotenv::createImmutable(dirname(__FILE__, 1));
$dotEnv->load();

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($httpMethod === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
    exit(0);
}

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
case FastRoute\Dispatcher::NOT_FOUND:
    $response = new JsonResponse();
    $response->setSuccess(false);
    $response->setHttpStatusCode(404)
        ->setErrorMessage('Rota Não Encontrada');
    echo json_encode($response->getResponse());
    break;
case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $response = new JsonResponse();
    $response->setSuccess(false);
    $response->setHttpStatusCode(405)
        ->setErrorMessage('Método Desconhecido');
    echo json_encode($response->getResponse());
    break;
case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $vars = $routeInfo[2];
    [$controllerName, $method] = explode('@', $handler);
    $controller = new $controllerName();
    call_user_func_array([$controller, $method], $vars);
    break;
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
