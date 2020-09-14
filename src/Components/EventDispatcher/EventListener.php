<?php


namespace Shop\Components\EventDispatcher;


interface EventListener
{
    // ['eventName' => 'method']
    public function subscribedEvents(): array;
}