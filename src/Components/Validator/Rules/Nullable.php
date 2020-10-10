<?php

namespace Shop\Components\Validator\Rules;

use Shop\Components\Validator\Result;
use Shop\Components\Validator\Rule;

final class Nullable implements Rule
{
    public function __invoke(array $data, string $field): Result
    {
        return new Result(
            null === $data[$field],
            sprintf('поле "%s" не пустое', $data[$field])
        );
    }
}