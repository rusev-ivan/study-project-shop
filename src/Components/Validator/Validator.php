<?php

namespace Shop\Components\Validator;

final class Validator
{
    public function validate(array $data, $toValidate): ErrorCollection
    {
        $errorCollection = new ErrorCollection();
        foreach ($data as $name => $value) {
            if ($toValidate instanceof UnderValidation){
                $toValidate = $toValidate->getRules();
            }
            foreach ($toValidate as $validateParametr => $rules) {
                if ($validateParametr !== $name){
                    continue;
                }
                foreach ($rules as $rule) {
                    /** @var Error $error */
                    $error = call_user_func($rule, $value);
                    if (!$error->isEmpty()){
                        $errorCollection->addError($error);
                    }
                }
            }
        }
        return $errorCollection;
    }
}