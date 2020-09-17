<?php

namespace Shop\Components\Router;

use Psr\Http\Message\ServerRequestInterface;
use Shop\Components\Router\Exception\RequestNotMatchedException;
use Shop\Components\Router\Exception\RouteNotFoundException;

final class Router
{
    private $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }
        throw new RequestNotMatchedException($request);
    }

    public function generate($name, array $params = []): string
    {
        foreach ($this->routes->getRoutes() as $route) {
            if (null !== $url = $route->generate($name, array_filter($params))){
                return $url;
            }
        }

        throw new RouteNotFoundException($name, $params);
    }

}