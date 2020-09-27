<?php

namespace Shop\Components\Validator\Tests;

use PHPUnit\Framework\TestCase;
use Shop\Components\Validator\Rules\Min;
use Shop\Components\Validator\Rules\Required;
use Shop\Components\Validator\ValidationScope;
use Shop\Components\Validator\Validator;

class RequiredTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator();
    }

    public function testThatRequiredRuleWorkAsExcepted(): void
    {
        $data = [
            'age' => 25
        ];
        $toValidate = [
            'name' => [
                new Required(),
                new Min(20),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('No value passed for field' , $errorCollection->getErrors()['name']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'age' => 25
        ];
        $toValidate = [
            'name' => [
                new Min(20),
                new Required(),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('No value passed for field' , $errorCollection->getErrors()['name']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'age' => 25,
            'name' => 'Jhon'
        ];
        $toValidate = [
            'name' => [
                new Min(2),
                new Required(),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }


}
