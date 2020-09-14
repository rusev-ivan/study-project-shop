<?php

namespace Shop\Components\Middleware;

final class MiddlewareProcessor
{
    /**
     * @var \SplQueue
     */
    private $middlewareQueue;
    private $action;

    public function __construct()
    {
        $this->middlewareQueue = new \SplQueue();
    }

    public function addMiddleware(MiddlewareHandler $middleware)
    {
        $this->middlewareQueue->enqueue($middleware);
    }

    public function process(object $command, object $action)
    {
        $this->action = $action;

        return $this->reduce($command);
    }

    private function reduce(object $command)
    {
        if ($this->middlewareQueue->isEmpty()) {

            $decorator = new class($this->action) implements MiddlewareHandler {

                /**
                 * @var object
                 */
                private $delegate;

                public function __construct(object $action)
                {
                    $this->delegate = $action;
                }

                public function __invoke(object $command, \Closure $next)
                {
                    return ($this->delegate)($command);
                }
            };

            return $decorator($command, function ($command) {
                return $command;
            });
        }

        return call_user_func($this->middlewareQueue->dequeue(), $command, function (object $command) {
            return $this->reduce($command);
        });
    }
}