<?php

namespace Shop\Components\Validator\Rules;

use Shop\Components\Validator\Result;
use Shop\Components\Validator\Rule;

final class Gte implements Rule
{
    /**
     * @var int
     */
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function __invoke(array $data, string $field): Result
    {
        return new Result(
            $data[$field] >= $this->value,
            sprintf('Значение поля "%s" должно быть больше либо равно, чем %d', $field, $this->value)
        );
    }
}