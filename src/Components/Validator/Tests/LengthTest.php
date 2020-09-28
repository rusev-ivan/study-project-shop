<?php

namespace Shop\Components\Validator\Tests;

use PHPUnit\Framework\TestCase;
use Shop\Components\Validator\Rules\LengthMax;
use Shop\Components\Validator\Rules\LengthMin;
use Shop\Components\Validator\ValidationScope;
use Shop\Components\Validator\Validator;

final class LengthTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator();
    }

    public function testLengthMin()
    {
        $data = [
            'name' => 'John'
        ];
        $toValidate = [
            'name' => [
                new LengthMin(5),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Число символов не должно быть меньше, чем 5' , $errorCollection->getErrors()['name']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'name' => 'Selvestr'
        ];
        $toValidate = [
            'name' => [
                new LengthMin(5),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }

    public function testLengthMax()
    {
        $data = [
            'name' => 'Selvestr'
        ];
        $toValidate = [
            'name' => [
                new LengthMax(5),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Число символов не должно быть больше, чем 5' , $errorCollection->getErrors()['name']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'name' => 'John'
        ];
        $toValidate = [
            'name' => [
                new LengthMax(5),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }
}