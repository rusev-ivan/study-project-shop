<?php

use Shop\Components\Validator\Rules\Email;
use Shop\Components\Validator\Rules\Gt;
use Shop\Components\Validator\Rules\Gte;
use Shop\Components\Validator\Rules\In;
use Shop\Components\Validator\Rules\Max;
use Shop\Components\Validator\Rules\Min;
use Shop\Components\Validator\Rules\NotIn;
use Shop\Components\Validator\Rules\Required;
use Shop\Components\Validator\ValidationScope;

require __DIR__ . '/vendor/autoload.php';

$data = [
    'name' => 'dfsdddfs',
    'age' => null,
    'email' => 'joeexample.com',
    'gender'=> 'male'
];
$toValidate = [
    'name' => [
        new Min(5),
        new Max(10),
        new Required(),
    ],

    'email' => [
        new Email('ошибка Email')
    ],

    'age' => [
        new Gte(18),
    ],

    'gender' => [
        new In('male', 'female'),
        new NotIn('a', 'b', 'c')
    ]

//    'age' => [
//        function ($value) {
//            $error = new \Shop\Components\Validator\Error();
//            if ($value <= 0) {
//                return $error->addError('Введите положительное ненулевое число');
//            }
//            return $error;
//        }
//    ]
];
$validator = new \Shop\Components\Validator\Validator();
$errorCollection = $validator->validate($data, ValidationScope::fromArray($toValidate));

var_dump($errorCollection);