<?php

date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/vendor/autoload.php';

$dispatcher = require __DIR__ . '/routes.php';

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);




switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $response = new \App\Utils\JsonResponse();
        $response->setSucesso(false);
        $response->setHttpStatusCode(404)
            ->setMensagemDeErro('Rota Não Encontrada');
        echo json_encode($response->getResponse());
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response = new \App\Utils\JsonResponse();
        $response->setSucesso(false);
        $response->setHttpStatusCode(405)
            ->setMensagemDeErro('Método Desconhecido');
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