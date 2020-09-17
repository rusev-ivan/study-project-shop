<?php

namespace Shop\Components\Kernel\ControllerResolver;

use Psr\Http\Message\ServerRequestInterface;
use Shop\Components\DI\Container;
use Shop\Components\Kernel\ControllerResolver\ArgumentResolvers\ArgumentResolver;


final class ControllerResolver
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var iterable
     */
    private $argumentResolvers;

    public function __construct(Container $container, iterable $argumentResolvers = [])
    {

        $this->container = $container;
        $this->argumentResolvers = new ArgumentResolver($container, $argumentResolvers);
    }

    public function resolve(ServerRequestInterface $request, $controller)
    {
        //function()
        if ((is_callable($controller) || $controller instanceof \Closure) && ! is_array($controller)) {
            $reflectionFunction = new \ReflectionFunction($controller);

            return $controller(...$this->argumentResolvers->getArguments(
                $request,
                $reflectionFunction->getParameters())
            );
        }

        //(string) Class
        if (is_string($controller) && class_exists($controller)) {
            $reflectionClass = new \ReflectionClass($controller);

            if (! $reflectionClass->hasMethod('__invoke')) {
                throw new \RuntimeException();
            }

            $constructorArguments = $reflectionClass->hasMethod('__construct')
                ? $this->argumentResolvers->getArguments($request, $reflectionClass->getConstructor()->getParameters())
                : [];

            $invoker = new $controller(...$constructorArguments);

            return $invoker(...$this->argumentResolvers->getArguments(
                $request,
                $reflectionClass->getMethod('__invoke')->getParameters()
            ));
        }

        //[Controller, method]
        if (is_array($controller)) {
            [$controllerClass, $controllerMethod] = $controller;

            $reflectionClass = new \ReflectionClass($controllerClass);

            $constructorArguments = $reflectionClass->hasMethod('__construct')
                ? $this->argumentResolvers->getArguments($request, $reflectionClass->getConstructor()->getParameters())
                : [];

            $controllerObject = new $controllerClass(...$constructorArguments);

            return $controllerObject->$controllerMethod(
                ...$this->argumentResolvers->getArguments(
                    $request,
                    $reflectionClass->getMethod($controllerMethod)->getParameters()
                )
            );
        }
        throw new \RuntimeException();
    }
}