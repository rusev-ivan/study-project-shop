<?php


namespace Shop\Components\Router\Route;


use Psr\Http\Message\ServerRequestInterface;
use Shop\Components\Router\Result;

interface Route
{
    public function match(ServerRequestInterface $request): ?Result;

    public function generate($name, array $params = []): ?string;
}