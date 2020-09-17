<?php

namespace Shop\Components\DI;

use Psr\Container\ContainerInterface;

final class Container implements ContainerInterface
{
    private $bindings = [];
    private $cacheDependencies = [];

    // $serviceId - полное имя класса
    public function get($serviceId)
    {
        if (isset($this->cacheDependencies[$serviceId])) {
            return $this->cacheDependencies[$serviceId];
        }

        if (isset($this->bindings[$serviceId])) {
            $binding = $this->bindings[$serviceId];

            if ($binding instanceof \Closure) {
                $this->cacheDependencies[$serviceId] = $binding($this);
            } else {
                $this->cacheDependencies[$serviceId] = $binding;
            }

            return $this->cacheDependencies[$serviceId];
        }

        if (!class_exists($serviceId)) {
            throw new \RuntimeException(sprintf('Unable to resolve service "%s"', $serviceId));
        }

        $reflectionClass = new \ReflectionClass($serviceId);

        $arguments = [];

        if ($constructor = $reflectionClass->getConstructor()) {
            $arguments = $this->readConstructor($constructor);
        }

        $this->cacheDependencies[$serviceId] = $service = $reflectionClass->newInstanceArgs($arguments);

        return $service;
    }

    public function bind($serviceId, $definition)
    {
        if ($this->has($serviceId)) {
            unset($this->cacheDependencies[$serviceId]);
            unset($this->bindings[$serviceId]);
        }

        $this->bindings[$serviceId] = $definition;
    }

    public function has($serviceId)
    {
        return array_key_exists($serviceId, $this->cacheDependencies) || array_key_exists($serviceId, $this->bindings);
    }

    private function readConstructor(\ReflectionMethod $constructor)
    {
        $arguments = [];

        foreach ($constructor->getParameters() as $parameter) {
            if ($class = $parameter->getClass()) {
                $arguments[] = $this->get($class->getName());
            } elseif ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
            } elseif ($this->has($parameter->getName())){
                $arguments[] = $this->get($parameter->getName());
            } else {
                throw new \RuntimeException();
            }
        }

        return $arguments;
    }


}