<?php

namespace Shop\Components\Validator;

final class Error
{
    public $message = [];

    public function addError(string $message)
    {
        $this->message[] = $message;
        return $this;
    }

    public function isEmpty()
    {
        if (empty($this->message)){
            return true;
        } else {
            return false;
        }
    }

    public  function getMessege()
    {
        return $this->message;
    }
}