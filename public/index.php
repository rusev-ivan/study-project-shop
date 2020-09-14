<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Shop\App\Http\Controllers\EnterController;
use Shop\App\Http\Controllers\Product\IndexController;
use Shop\App\Http\Controllers\Product\ShowController;
use Shop\Http\ResponseSender;
use Shop\Components\Router\ControllerResolver;
use Shop\Components\Router\Exception\RequestNotMatchedException;
use Shop\Components\Router\RouteCollection;
use Shop\Components\Router\Router;

require __DIR__ . '/../vendor/autoload.php';

$routes = new RouteCollection();
$routes->get('home', '/', EnterController::class);
$routes->get('products', '/products', IndexController::class);
$routes->get('product_show','/product/{id}', ShowController::class, ['id' => '\d+']);
$router = new Router($routes);
$resolver = new ControllerResolver();

$request = ServerRequestFactory::fromGlobals();
try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $resolver->resolve($result->getHandler());
    $response = $action($request);
} catch (RequestNotMatchedException $e){
    $response = new HtmlResponse('Undefined page', 404);
}
$response = $response->withHeader('X-Developer', 'Rusev');

### Sending

$emitter = new ResponseSender();
$emitter->send($response);

