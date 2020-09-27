<?php

namespace Shop\Components\Validator;

interface Rule
{
    /**
     * @param array  $data
     * @param string $field
     *
     * @return Result
     */
    public function __invoke(array $data, string $field): Result;
}
