<?php

namespace Shop\Http\Router;

final class ControllerResolver
{
    public function resolve($handler)
    {
        return \is_string($handler) ? new $handler() : $handler;
    }

}