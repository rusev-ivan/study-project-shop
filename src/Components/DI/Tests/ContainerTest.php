<?php

namespace Shop\Components\DI\Tests;

use PHPUnit\Framework\TestCase;
use Shop\Components\DI\Container;

final class ContainerTest extends TestCase
{
    public function testContainer()
    {
        $container = new Container;
        $container->bind('dsn', 'localhost://127.0.1');
        $container->bind(A::class, function (Container $container) {
            return new A('Value of Property', $container->get('dsn'));
        });
        $b = $container->get(B::class);

        self::assertEquals($b->a->property, 'Value of Property');
        self::assertEquals($b->a->dsn, 'localhost://127.0.1');
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


