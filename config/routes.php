<?php

use Shop\App\Http\Controllers\EnterController;
use Shop\App\Http\Controllers\Product\ShowController;
use Shop\Components\Router\RouteCollection;
use Shop\App\Http\Controllers\Product\IndexController;

return function (RouteCollection $routes) {
    $routes->get('home', '/', EnterController::class);
    $routes->get('products', '/products', IndexController::class);
    $routes->get('product_show','/product/{id}', ShowController::class, ['id' => '\d+']);

    return $routes;
};