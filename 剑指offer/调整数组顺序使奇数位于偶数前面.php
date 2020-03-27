<?php

// 输入一个整数数组，实现一个函数来调整该数组中数字的顺序，
// 使得所有的奇数位于数组的前半部分，所有的偶数位于数组的后半部分，
// 并保证奇数和奇数，偶数和偶数之间的相对位置不变。

function reOrderArray($array)
{
    // 冒泡
    $len = count($array);
    if ($len < 2) {
        return $array;
    }
    $lastSwapIndex = $len - 2;
    $maxJ = $len - 2;
    for ($i = 0; $i < $len; $i++) {
        $sorted = true;
        for ($j = 0; $j <= $maxJ; $j++) {
            if ($array[$j] % 2 === 0 && $array[$j + 1] % 2 === 1) {
                $tmp = $array[$j];
                $array[$j] = $array[$j + 1];
                $array[$j + 1] = $tmp;
                $sorted = false;
                $lastSwapIndex = $j;
            }
        }
        $maxJ = $lastSwapIndex - 1;
        if ($sorted) {
            break;
        }
    }
    return $array;
}

var_dump(reOrderArray([1, 2, 3, 4, 5])); // 1, 3, 5, 2, 4