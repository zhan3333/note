<?php

// 一只青蛙一次可以跳上1级台阶，也可以跳上2级。
//求该青蛙跳上一个n级的台阶总共有多少种跳法（先后次序不同算不同的结果）。
//
// 递推公式
// n > 2: f(n) = f(n - 1) + f(n - 2)
// n = 2: f(n) = 2
// n = 1: f(n) = 1

function jumpFloor($number)
{
    $dp = [1, 2];
    $i = 2;
    while ($i < $number) {
        $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
        $i++;
    }
    return $dp[$number - 1];
}

var_dump(jumpFloor(2)); // 1
var_dump(jumpFloor(3)); // 2