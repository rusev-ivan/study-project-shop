<?php

namespace Shop\Components\Validator\Rules;

use Shop\Components\Validator\Result;
use Shop\Components\Validator\Rule;

final class Email implements Rule
{
    /**
     * @var string
     */
    private $message;

    public function __construct(string $message = 'Email адрес указан неверно')
    {
        $this->message = $message;
    }

    public function __invoke(array $data, string $field): Result
    {
        return new Result(
            filter_var($data[$field], FILTER_VALIDATE_EMAIL),
            $this->message
        );
    }
}