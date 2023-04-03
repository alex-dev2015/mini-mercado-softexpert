<?php

namespace App;

class App
{
    private $routes = [];

    public function addRoute($method, $uri, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
        ];

    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] == $method && $route['uri'] == $uri) {
                $action = $route['action'];
                $parts = explode('@', $action);
                $controllerName = $parts[0];
                $method = $parts[1];
                $controller = new $controllerName;
                $controller->$method();
                return;
            }
        }

        http_response_code(404);
        echo "Endpoint não encontrado";
    }
}
