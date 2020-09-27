<?php

namespace Shop\Components\Validator\Rules;

use Shop\Components\Validator\GreedyRule;
use Shop\Components\Validator\Result;

final class Required implements GreedyRule
{
    public function isGreedy(): bool
    {
        return true;
    }

    public function __invoke(array $data, string $field): Result
    {
        return new Result(isset($data[$field]), 'No value passed for field');
    }
}
