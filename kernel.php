<?php

use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;
use Shop\Components\DI\Container;
use Shop\Components\Kernel\ControllerResolver\ControllerResolver;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

$request = ServerRequestFactory::fromGlobals();
$request = $request->withAttribute('name', 'John');
$container->bind(A::class, function () {
    return new A('something');
});

$controllerResolver = new ControllerResolver($container);

final class IndexController
{
    /**
     * @var B
     */
    private $b;

    public function __construct(B $b)
    {
        $this->b = $b;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $request->getAttribute('name');
    }

    public function viewB()
    {
        return $this->b;
    }
}


final class A
{
    /**
     * @var string
     */
    public $dsn;


    public function __construct(string $dsn)
    {
        $this->dsn = $dsn;

    }
}

final class B
{
    /**
     * @var A
     */
    public $a;

    public function __construct(A $a)
    {
        $this->a = $a;
    }
}

dd(
    $controllerResolver->resolve($request, IndexController::class),
    '----------------------',
    $controllerResolver->resolve($request, [IndexController::class, 'viewB'])
);
