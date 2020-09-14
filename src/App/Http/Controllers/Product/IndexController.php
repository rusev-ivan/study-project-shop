<?php

namespace Shop\App\Http\Controllers\Product;

use Laminas\Diactoros\Response\HtmlResponse;

final class IndexController
{
    public function __invoke()
    {
        return new HtmlResponse('Все товары');
    }
}
