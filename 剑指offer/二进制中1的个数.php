<?php

// 输入一个整数，输出该数二进制表示中1的个数。其中负数用补码表示。


function NumberOf1($n)
{
    $count = 0;
    if ($n < 0) {
        $n &= 0x7FFFFFFF;
    }
    while ($n > 0) {
        if ($n % 2 === 1) {
            $count++;
        }
        $n >>= 1;
    }
    return $count;
}

var_dump(NumberOf1(2)); // 1
var_dump(NumberOf1(-2)); // 1
var_dump(NumberOf1(-2147483648)); // 1