<?php

// 一只青蛙一次可以跳上1级台阶，也可以跳上2级……它也可以跳上n级。
// 求该青蛙跳上一个n级的台阶总共有多少种跳法。
//
// 递推公式
// f(0) = 0
// f(1) = 1
// f(2) = f(2-1) + f(2-2) = 2
// f(3) = f(3-1) + f(3-2) + f(3-3) = 2
// f(n-1) = f(n - 1 - 1) + ... f(0)
// f(n) = f(n-1) + f(n-2) + ... f(0)
// = 2 (f(n-1))

function jumpFloorII($number)
{
    return 1 << ($number - 1);
}

var_dump(jumpFloorII(3)); // 4
var_dump(jumpFloorII(4)); //