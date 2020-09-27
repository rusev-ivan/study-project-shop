<?php

namespace Shop\Components\Validator;

interface GreedyRule extends Rule
{
    /**
     * @return bool
     */
    public function isGreedy(): bool;
}
