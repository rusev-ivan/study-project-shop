<?php

interface EventListener
{
    // ['eventName' => 'method']
    public function subscribedEvents(): array;
}

interface EventDispatcher
{
    public function addListener(EventListener $listener): void;
    public function dispatch(object $event): void;
}

final class SimpleEventDispatcher implements EventDispatcher
{
    /**
     * @var EventListener[]
     */
    private $listeners = [];
    private $sortedListeners = [];

    public function addListener(EventListener $listener): void
    {
        $this->listeners[] = $listener;
    }

    public function dispatch(object $event): void
    {
        $this->sortListeners();

        $eventName = get_class($event);

        if (!isset($this->sortedListeners[$eventName])) {
            return;
        }

        $listeners = $this->sortedListeners[$eventName];

        foreach ($listeners as $listener) {
            call_user_func($listener, $event);
        }
    }

    private function sortListeners(): void
    {
        foreach ($this->listeners as $listener) {
            foreach ($listener->subscribedEvents() as $event => $method) {
                $this->sortedListeners[$event][] = [$listener, $method];
            }
        }
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

$dispatcher = new SimpleEventDispatcher();
$dispatcher->addListener(new SomeEventListener());

$event = new SomeEvent();

$dispatcher->dispatch($event);

var_dump($event);