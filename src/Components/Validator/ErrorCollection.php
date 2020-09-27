<?php

namespace Shop\Components\Validator;

final class ErrorCollection
{
    private $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }

    public function isEmpty()
    {
        return 0 >= count($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}