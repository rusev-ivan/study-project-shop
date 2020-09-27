<?php

namespace Shop\Components\Validator\Rules;

use Shop\Components\Validator\Result;
use Shop\Components\Validator\Rule;

final class NotIn implements Rule
{
    /**
     * @var array
     */
    private $inArray;

    public function __construct(...$inArray)
    {
        $this->inArray = $inArray;
    }

    public function __invoke(array $data, string $field): Result
    {
        return new Result(
            !in_array($data[$field],$this->inArray),
            sprintf('Знвчение "%s" есть в списке недоступных', $data[$field])
        );
    }
}