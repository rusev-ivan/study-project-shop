<?php

namespace Shop\Components\Kernel\ControllerResolver\ArgumentResolvers;

use Psr\Http\Message\ServerRequestInterface;

interface ArgumentValueResolvers
{
    public function resolve(ServerRequestInterface $request, ArgumentMetadata $argumentMetadata): iterable;
    public function support(ServerRequestInterface $request, ArgumentMetadata $argumentMetadata): bool;
}