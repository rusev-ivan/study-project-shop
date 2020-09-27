<?php

function sum (...$arg) {
    return array_sum($arg);
}

echo sum(1,2,4);