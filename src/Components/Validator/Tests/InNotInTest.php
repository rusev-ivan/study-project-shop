<?php

namespace Shop\Components\Validator\Tests;

use PHPUnit\Framework\TestCase;
use Shop\Components\Validator\Rules\In;
use Shop\Components\Validator\Rules\NotIn;
use Shop\Components\Validator\ValidationScope;
use Shop\Components\Validator\Validator;

final class InNotInTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator();
    }

    public function testIn()
    {
        $data = [
            'gender' => 'dsfsd'
        ];
        $toValidate = [
            'gender' => [
                new In('male', 'female'),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Знвчение "dsfsd" отсутствует в списке допустимых' , $errorCollection->getErrors()['gender']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'gender' => 'male'
        ];
        $toValidate = [
            'gender' => [
                new In('male', 'female'),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }

    public function testNotIn()
    {
        $data = [
            'name' => 'Karl'
        ];
        $toValidate = [
            'name' => [
                new NotIn('Karl', 'Jhon'),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Знвчение "Karl" есть в списке недоступных' , $errorCollection->getErrors()['name']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'name' => 'Vasya'
        ];
        $toValidate = [
            'name' => [
                new NotIn('Karl', 'Jhon'),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }
}