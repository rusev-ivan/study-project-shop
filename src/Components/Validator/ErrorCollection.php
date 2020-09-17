<?php

namespace Shop\Components\Validator;

final class ErrorCollection
{
        private $errors;

        public function addError(Error $error)
        {
            $this->errors[] = $error;
        }

        public function getErrors()
        {
            return $this->errors;
        }
}