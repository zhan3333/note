<?php

// 给定一个double类型的浮点数base和int类型的整数exponent。
// 求base的exponent次方。
//
// 保证base和exponent不同时为0


function Power($base, $exponent)
{
    $n = $exponent;
    if ($exponent === 0) {
        return 1;
    } elseif ($exponent < 0) {
        if ($base === 0) {
            return 0;
        }
        $n = -$exponent;
    }
    $res = PowerSoft($base, $n);
    return $exponent < 0 ? 1 / $res : $res;
}

function PowerSoft($base, $n)
{
    if ($n === 0) {
        return 1;
    }
    if ($n === 1) {
        return $base;
    }
    $div = $n >> 1;
    if ($n % 2 === 0) {
        return PowerSoft($base, $div) * PowerSoft($base, $div);
    } else {
        return PowerSoft($base, $div) * PowerSoft($base, $div) * $base;
    }
}

var_dump(Power(1.1, 2)); // 1.21
var_dump(Power(2, 3)); // 1.21