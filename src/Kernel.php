<?php

namespace Shop;

use Psr\Http\Message\ServerRequestInterface;
use Shop\Components\DI\Container;
use Shop\Components\Kernel\ControllerResolver\ControllerResolver;
use Shop\Components\Router\Result;
use Shop\Components\Router\RouteCollection;
use Shop\Components\Router\Router;
use Shop\Http\ResponseSender;

final class Kernel

{
    /**
     * @var string
     */
    private $dependenciesPath;
    /**
     * @var string
     */
    private $routesPath;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var ControllerResolver
     */
    private $controllerResolver;

    public function __construct(string $dependenciesPath, string $routesPath)
    {
        $this->dependenciesPath = $dependenciesPath;
        $this->routesPath = $routesPath;
        $this->container = $this->bootContainer();
        $this->controllerResolver = new ControllerResolver($this->container);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @throws \Throwable
     */
    public function handle(ServerRequestInterface $request): void
    {
        try {
            $router = $this->bootRouter();
            /** @var Result $result */
            $result = $router->match($request);
            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }
            $response = $this->controllerResolver->resolve($request, $result->getHandler());


            $emitter = new ResponseSender();
            $emitter->send($response);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    private function bootRouter()
    {
        $routesConfig = require_once $this->routesPath;

        return new Router($routesConfig(new RouteCollection()));
    }

    public function bootContainer(): Container
    {
        $func = require_once $this->dependenciesPath;
        $container = new Container();
        $func($container);

        return $container;
    }

}