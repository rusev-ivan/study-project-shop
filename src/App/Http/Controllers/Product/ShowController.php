<?php

namespace Shop\App\Http\Controllers\Product;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

final class ShowController
{
    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');

        if ($id > 10) {
            return new HtmlResponse('Undefined page', 404);
        }

        return new HtmlResponse('Товар № ' . $id);
    }
}