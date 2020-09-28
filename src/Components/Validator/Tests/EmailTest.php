<?php

namespace Shop\Components\Validator\Tests;

use PHPUnit\Framework\TestCase;
use Shop\Components\Validator\Rules\Email;
use Shop\Components\Validator\ValidationScope;
use Shop\Components\Validator\Validator;

final class EmailTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator();
    }

    public function testEmailValidation()
    {
        $data = [
            'email' => 'v_rusevmail.ru'
        ];
        $toValidate = [
            'email' => [
                new Email(),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Email адрес указан неверно' , $errorCollection->getErrors()['email']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'email' => 'v_rusevmail.ru'
        ];
        $toValidate = [
            'email' => [
                new Email('Ошибка Email'),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertEquals('Ошибка Email' , $errorCollection->getErrors()['email']);
        self::assertFalse($errorCollection->isEmpty());

        $data = [
            'email' => 'v_rusev@mail.ru'
        ];
        $toValidate = [
            'email' => [
                new Email(),
            ]
        ];
        $errorCollection = $this->validator->validate($data, ValidationScope::fromArray($toValidate));

        self::assertTrue($errorCollection->isEmpty());
        self::assertEmpty($errorCollection->getErrors());
    }
}