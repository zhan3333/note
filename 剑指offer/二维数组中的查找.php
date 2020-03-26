<?php

// 在一个二维数组中（每个一维数组的长度相同），每一行都按照从左到右递增的顺序排序，
// 每一列都按照从上到下递增的顺序排序。请完成一个函数，输入这样的一个二维数组和一个整数，判断数组中是否含有该整数。
//
// 这道题可用从右上角往左下角排查

function Find($target, $array)
{
    $maxI = count($array);
    if ($maxI === 0) {
        return false;
    }
    $maxJ = count($array[0]);
    $i = $maxI - 1;
    $j = 0;
    while ($i >= 0 && $j < $maxJ) {
        if ($array[$i][$j] < $target) {
            $j++;
        } elseif ($array[$i][$j] > $target) {
            $i--;
        } else {
            return true;
        }
    }
    return false;
}

$target = 10;
$array = [
    [1, 2, 3, 4],
    [5, 6, 7, 8],
    [9, 10, 11, 12],
    [13, 14, 15, 16],
];

var_dump(Find($target, $array));
var_dump(Find(99, $array));
var_dump(Find(-1, $array));