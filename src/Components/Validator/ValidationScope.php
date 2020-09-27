<?php

namespace Shop\Components\Validator;

final class ValidationScope
{
    /**
     * @var array
     */
    private $validationRules;

    private function __construct(array $validationRules)
    {
        $this->validationRules = $validationRules;
    }

    public static function fromArray(array $validationRules)
    {
        return new self($validationRules);
    }

    public static function fromObject(UnderValidation  $underValidation)
    {
        return new self($underValidation->getRules());
    }

    public function toArray()
    {
        return $this->validationRules;
    }
}