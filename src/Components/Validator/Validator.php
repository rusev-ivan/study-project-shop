<?php

namespace Shop\Components\Validator;

use Shop\Components\Validator\Rules\Required;

final class Validator
{
    /**
     * @param array           $data
     * @param ValidationScope $scope
     *
     * @return ErrorCollection
     */
    public function validate(array $data, ValidationScope $scope): ErrorCollection
    {
        $fieldRules = $scope->toArray();

        $errors = [];

        /**
         * @var string $field
         * @var Rule[] $rules
         */
        foreach ($fieldRules as $field => $rules) {
            list($rules, $isRequired) = $this->sortRules($rules);

            if (!$isRequired && !isset($data[$field])) {
                continue;
            }

            foreach ($rules as $rule) {
                $result = $rule($data, $field);

                if ($result->isErr()) {
                    $errors[$field] = $result->message();

                    continue 2;
                }
            }
        }

        return new ErrorCollection($errors);
    }

    /**
     * @param array $rules
     *
     * @return array
     */
    private function sortRules(array $rules): array
    {
        $greedyRules    = [];
        $nonGreedyRules = [];
        $isRequired     = false;

        while ($rule = array_shift($rules)) {
            if ($rule instanceof Required) {
                $isRequired = true;
            }

            if ($rule instanceof GreedyRule && $rule->isGreedy()) {
                $greedyRules[] = $rule;
            } else {
                $nonGreedyRules[] = $rule;
            }
        }

       return [array_merge($greedyRules, $nonGreedyRules), $isRequired];
    }
}
