<?php

namespace Shop\Components\EventDispatcher;

final class SimpleEventDispatcher implements EventDispatcherInterface
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