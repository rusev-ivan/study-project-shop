<?php

namespace Shop\Components\Validator\Rules;

use Shop\Components\Validator\Result;
use Shop\Components\Validator\Rule;

final class LengthMin implements Rule
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
        return new Result(mb_strlen($data[$field]) > $this->value, sprintf('Число символов не должно быть меньше, чем %d', $this->value));
    }
}