<?php

use FastRoute\RouteCollector;

$dispatcher = FastRoute\simpleDispatcher(
    function (RouteCollector $r) {
        /**
         * Auth Routes
         */
        $r->addRoute('POST', '/login', 'App\Controllers\AuthController@login');
        $r->addRoute('GET', '/authenticate', 'App\Controllers\AuthController@auth');

        /**
         * Products Routes
         */
        $r->addRoute('GET', '/products', 'App\Controllers\ProductController@index');
        $r->addRoute('GET', '/products/{id:\d+}', 'App\Controllers\ProductController@show');
        $r->addRoute('POST', '/products', 'App\Controllers\ProductController@create');

        /**
         * Product Types Routes
         */
        $r->addRoute('GET', '/product_type', 'App\Controllers\ProductTypeController@index');
        $r->addRoute('GET', '/product_type/{id:\d+}', 'App\Controllers\ProductTypeController@show');
        $r->addRoute('POST', '/product_type', 'App\Controllers\ProductTypeController@create');

        /**
         * Sales Routes
         */
        $r->addRoute('GET', '/sales', 'App\Controllers\SaleController@index');
        $r->addRoute('POST', '/execute_sale', 'App\Controllers\SaleController@executeSale');

    }
);

return $dispatcher;

