<?php


function Fibonacci($n)
{
    if ($n < 1) {
        return 0;
    }
    $dp = [1, 1];
    $i = 2;
    while ($i < $n) {
        $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
        $i++;
    }
    return $dp[$n - 1];
}

var_dump(Fibonacci(1)); // 1
var_dump(Fibonacci(2)); // 1
var_dump(Fibonacci(3)); // 2
var_dump(Fibonacci(4)); // 3
var_dump(Fibonacci(5)); // 5
var_dump(Fibonacci(6)); // 8