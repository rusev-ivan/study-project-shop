<?php

namespace Shop\Components\Validator\Tests;

use PHPUnit\Framework\TestCase;
use Shop\Components\Validator\Rules\Gt;
use Shop\Components\Validator\Rules\Gte;
use Shop\Components\Validator\Rules\Lt;
use Shop\Components\Validator\Rules\Lte;
use Shop\Components\Validator\ValidationScope;
use Shop\Components\Validator\Validator;

final class ComparsionTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator();
    }

    public function testGreaterThan()
    {
        $data = [
            'age' => 16
        ];
        $toValidate = [
            'age' => [
                new Gt(18),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Значение поля "age" должно быть больше, чем 18' , $errorCollection->getErrors()['age']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'age' => 20
        ];
        $toValidate = [
            'age' => [
                new Gt(18),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }

    public function testGreaterThanOrEqual()
    {
        $data = [
            'age' => 16
        ];
        $toValidate = [
            'age' => [
                new Gte(18),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Значение поля "age" должно быть больше либо равно, чем 18' , $errorCollection->getErrors()['age']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'age' => 18
        ];
        $toValidate = [
            'age' => [
                new Gte(18),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }

    public function testLessThan()
    {
        $data = [
            'age' => 66
        ];
        $toValidate = [
            'age' => [
                new Lt(65),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Значение поля "age" должно быть меньше, чем 65' , $errorCollection->getErrors()['age']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'age' => 20
        ];
        $toValidate = [
            'age' => [
                new Lt(65),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }

    public function testLessThanOrEqual()
    {
        $data = [
            'age' => 66
        ];
        $toValidate = [
            'age' => [
                new Lte(65),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Значение поля "age" должно быть меньше либо равно, чем 65' , $errorCollection->getErrors()['age']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'age' => 65
        ];
        $toValidate = [
            'age' => [
                new Lte(65),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }


}