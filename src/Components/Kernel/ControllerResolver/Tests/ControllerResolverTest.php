<?php

namespace Shop\Components\Kernel\ControllerResolver\Tests;

use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Shop\Components\DI\Container;
use Shop\Components\Kernel\ControllerResolver\ControllerResolver;

final class ControllerResolverTest extends TestCase
{
    public function testResolver()
    {
        $request = ServerRequestFactory::fromGlobals();
        $request = $request->withAttribute('name', 'John');

        $container = new Container();
        $container->bind('dsn', 'localhost://127.0.1');
        $container->bind(A::class, function (Container $container) {
            return new A('Value of Property', $container->get('dsn'));
        });

        $controllerResolver = new ControllerResolver($container);

        $b = $controllerResolver->resolve($request,[IndexController::class, 'viewB']);

        self::assertEquals($controllerResolver->resolve($request, IndexController::class), 'John');
        self::assertEquals($b->a->property, 'Value of Property');
        self::assertEquals($b->a->dsn, 'localhost://127.0.1');
    }
}

class IndexController
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

class A
{
    /**
     * @var string
     */
    public $property;
    /**
     * @var string
     */
    public $dsn;

    public function __construct (string $property, string $dsn)
    {
        $this->property = $property;
        $this->dsn = $dsn;
    }
}

class B
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

