<?php

require __DIR__ . '/vendor/autoload.php';

$data = [
    'name' => 'dsвыаываfsdfdsf',
    'age' => 25
];
$toValidate = [
    'name' => [
        function ($value) {
            $error = new \Shop\Components\Validator\Error();
            if (mb_strlen($value) > 10) {
                return $error->addError('Имя слишком длинное');
            }
            return $error;
        },
        function ($value) {
            $error = new \Shop\Components\Validator\Error();
            if (empty($value)) {
                return $error->addError('поле пустое');
            }
            return $error;
        }
    ],
    'age' => [
        function ($value) {
            $error = new \Shop\Components\Validator\Error();
            if ($value <= 0) {
                return $error->addError('Введите положительное ненулевое число');
            }
            return $error;
        }
    ]
];
$validator = new \Shop\Components\Validator\Validator();
$errorCollection = $validator->validate($data, $toValidate);

var_dump($errorCollection);