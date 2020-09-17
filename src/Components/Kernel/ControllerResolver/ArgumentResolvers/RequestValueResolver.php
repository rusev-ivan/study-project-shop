<?php

namespace Shop\Components\Kernel\ControllerResolver\ArgumentResolvers;

use Psr\Http\Message\ServerRequestInterface;

final class RequestValueResolver implements ArgumentValueResolvers
{

    /**
     * @param ServerRequestInterface $request
     * @param ArgumentMetadata $argumentMetadata
     * @return iterable
     */
    public function resolve(ServerRequestInterface $request, ArgumentMetadata $argumentMetadata): iterable
    {
        yield $request;
    }

    public function support(ServerRequestInterface $request, ArgumentMetadata $argumentMetadata): bool
    {
        return ServerRequestInterface::class === $argumentMetadata->type()
            || is_subclass_of($argumentMetadata->type(), ServerRequestInterface::class);
    }
}