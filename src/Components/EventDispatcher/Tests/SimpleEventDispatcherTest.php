<?php

namespace Shop\Components\EventDispatcher\Tests;

use PHPUnit\Framework\TestCase;
use Shop\Components\EventDispatcher\EventListener;
use Shop\Components\EventDispatcher\SimpleEventDispatcher;

final class SimpleEventDispatcherTest extends TestCase
{
    public function testDispatcher()
    {
        $dispatcher = new SimpleEventDispatcher();
        $dispatcher->addListener(new SomeEventListener());

        $event = new SomeEvent();
        $dispatcher->dispatch($event);

        self::assertEquals($event->name, 'Anton');
        self::assertEquals($event->surName, 'Petrov');
    }
}


final class SomeEvent
{
    public $name = '';
    public $surName = '';
}

final class SomeEventListener implements EventListener
{
    public function omCreated(SomeEvent $event)
    {
        $event->name = 'Anton';
        $event->surName = 'Petrov';
    }

    public function subscribedEvents(): array
    {
        return [
            SomeEvent::class => 'omCreated'
        ];
    }
}