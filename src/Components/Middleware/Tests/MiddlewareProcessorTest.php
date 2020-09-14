<?php

namespace Shop\Components\Tests;

use PHPUnit\Framework\TestCase;
use Shop\Components\Middleware\MiddlewareHandler;
use Shop\Components\Middleware\MiddlewareProcessor;

final class MiddlewareProcessorTest extends TestCase
{
    public function testProcessor(): void
    {
        $processor = new MiddlewareProcessor();

        $processor->addMiddleware(new FirstMiddlewareHandler());
        $processor->addMiddleware(new SecondMiddlewareHandler());

        /** @var Message $result */
        $result = $processor->process(new Message(), new Action());
        self::assertEquals($result->name,'First action work Second ' );


    }
}

final class FirstMiddlewareHandler implements MiddlewareHandler
{
    public function __invoke(object $message, \Closure $next)
    {
        $message->name .= 'First ';

        return $next($message);
    }
}

final class SecondMiddlewareHandler implements MiddlewareHandler
{
    public function __invoke(object $message, \Closure $next)
    {
        $message = $next($message);

        $message->name .= 'Second ';

        return $message;
    }
}

final class Action
{
    public function __invoke(Message $message)
    {
        $message->name .= 'action work ';

        return $message;
    }
}

final class Message
{
    public $name;
}