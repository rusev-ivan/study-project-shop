<?php


namespace Shop\Components\Middleware;


interface MiddlewareHandler
{
    public function __invoke(object $message, \Closure $next);
}