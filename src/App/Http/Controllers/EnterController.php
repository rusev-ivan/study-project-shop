<?php

namespace Shop\App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Shop\Http\Response;

final class EnterController
{
    public function __invoke(ServerRequestInterface $request)
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new Response('Hello, ' . $name . '!');
    }
}