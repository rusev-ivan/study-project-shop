<?php


namespace Shop\Http\Router\Route;


use Psr\Http\Message\ServerRequestInterface;
use Shop\Http\Router\Result;

interface Route
{
    public function match(ServerRequestInterface $request): ?Result;

    public function generate($name, array $params = []): ?string;
}