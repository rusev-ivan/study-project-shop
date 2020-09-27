<?php

namespace Shop\Components\Validator;

final class Result
{
    /**
     * @var bool
     */
    private $isOk;

    /**
     * @var string
     */
    private $message;

    public function __construct(bool $isOk, string $message = null)
    {
        $this->isOk = $isOk;
        $this->message = $message;
    }

    public function isErr()
    {
        return !$this->isOk;
    }

    public function message(): ?string
    {
        return $this->message;
    }
}
