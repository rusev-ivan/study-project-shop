<?php

namespace Shop\Components\Kernel\ControllerResolver\ArgumentResolvers;

use Psr\Http\Message\ServerRequestInterface;
use Shop\Components\DI\Container;

final class ContainerArgumentValueResolver implements ArgumentValueResolvers
{

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function resolve(ServerRequestInterface $request, ArgumentMetadata $argumentMetadata): iterable
    {
        yield $this->container->get($argumentMetadata->name());
    }

    public function support(ServerRequestInterface $request, ArgumentMetadata $argumentMetadata): bool
    {
        return $this->container->has($argumentMetadata->name()) || class_exists($argumentMetadata->name());
    }
}