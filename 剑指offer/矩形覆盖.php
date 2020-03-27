<?php

// 我们可以用2*1的小矩形横着或者竖着去覆盖更大的矩形。
// 请问用n个2*1的小矩形无重叠地覆盖一个2*n的大矩形，总共有多少种方法？
//
// 比如n=3时，2*3的矩形块有3种覆盖方法：
//
// f(1) = 1
// f(2) = 2
// f(3) = f(1) + f(2) = 3
// f(4) = f(2) + f(3) = 5

function rectCover($number)
{
    if ($number === 0) {
        return 0;
    }
    $dp = [1, 2];
    $i = 2;
    while ($i < $number) {
        $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
        $i++;
    }
    return $dp[$number - 1];
}

var_dump(rectCover(3)); // 3