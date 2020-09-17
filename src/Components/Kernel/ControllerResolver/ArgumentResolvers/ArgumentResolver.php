<?php

namespace Shop\Components\Kernel\ControllerResolver\ArgumentResolvers;

use Psr\Http\Message\ServerRequestInterface;
use Shop\Components\DI\Container;

final class ArgumentResolver
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var array|iterable
     */
    private $argumentResolvers;

    public function __construct(Container $container, iterable $argumentResolvers = [])
    {

        $this->container         = $container;
        $this->argumentResolvers = array_merge($this->defaultArgumentResolver(), $argumentResolvers);
    }

    public function getArguments(ServerRequestInterface $request, array $parameters)
    {
        $arguments = [];

        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            /** @var ArgumentValueResolvers $argumentResolver */
            foreach ($this->argumentResolvers as $argumentResolver) {
                $argumentMetadata = $this->createArgumentMetadata(($parameter));

                if (! $argumentResolver->support($request, $argumentMetadata)) {
                    continue;
                }

                $resolvedArguments = $argumentResolver->resolve($request, $argumentMetadata);

                $hasOne = false;

                foreach ($resolvedArguments as $resolvedArgument) {
                    $hasOne = true;
                    $arguments[] = $resolvedArgument;
                }

                if (! $hasOne) {
                    throw new \InvalidArgumentException();
                }

                continue 2;
            }
        }

        return $arguments;
    }

    private function createArgumentMetadata(\ReflectionParameter $parameter)
    {
        $reflectionType = $parameter->getType();

        $type = $reflectionType instanceof \ReflectionNamedType ? $reflectionType->getName() : (string) $reflectionType;
        $name = null == $parameter->getClass() ? $parameter->getName() : $parameter->getClass()->getName();

        return new ArgumentMetadata($type, $name);
    }


    private function defaultArgumentResolver()
    {
        return [
            new RequestValueResolver,
            new ContainerArgumentValueResolver($this->container),
        ];
    }
}