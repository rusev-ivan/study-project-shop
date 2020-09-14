<?php


namespace Shop\Components\EventDispatcher;


interface EventDispatcherInterface
{
    public function addListener(EventListener $listener): void;
    public function dispatch(object $event): void;
}