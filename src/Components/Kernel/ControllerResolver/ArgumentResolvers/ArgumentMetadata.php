<?php

namespace Shop\Components\Kernel\ControllerResolver\ArgumentResolvers;

final class ArgumentMetadata
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $type;

    public function __construct(string $type, string $name)
    {

        $this->name = $name;
        $this->type = $type;
    }

    public function type()
    {
        return $this->type;
    }

    public function name()
    {
        return $this->name;
    }
}