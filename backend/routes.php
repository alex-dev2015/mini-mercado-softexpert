<?php

use FastRoute\RouteCollector;

$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    /**
     * Rotas de Produtos
     */
    $r->addRoute('GET', '/produtos', 'App\Controllers\ProdutoController@index');
    $r->addRoute('GET', '/produtos/{id:\d+}', 'App\Controllers\ProdutoController@show');
    $r->addRoute('POST', '/produtos', 'App\Controllers\ProdutoController@create');

    /**
     * Rotas do tipo de Produto
     */
    $r->addRoute('GET', '/tipo_produtos', 'App\Controllers\TipoProdutoController@index');
    $r->addRoute('GET', '/tipo_produtos_impostos', 'App\Controllers\TipoProdutoController@listarImpostos');
    $r->addRoute('GET', '/tipo_produtos/{id:\d+}', 'App\Controllers\TipoProdutoController@show');
    $r->addRoute('POST', '/tipo_produtos', 'App\Controllers\TipoProdutoController@create');

    /**
     * Rotas de impostos
     */
    $r->addRoute('GET', '/imposto_produtos', 'App\Controllers\ImpostoProdutoController@index');
    $r->addRoute('GET', '/imposto_produtos/{id:\d+}', 'App\Controllers\ImpostoProdutoController@show');
    $r->addRoute('POST', '/imposto_produtos', 'App\Controllers\ImpostoProdutoController@create');

    /**
     * Rotas de Vendas
     */
    $r->addRoute('GET', '/vendas', 'App\Controllers\VendaController@index');
    $r->addRoute('POST', '/iniciar_venda', 'App\Controllers\VendaController@iniciar');
    $r->addRoute('POST', '/realizar_venda', 'App\Controllers\VendaController@create');


});

return $dispatcher;

