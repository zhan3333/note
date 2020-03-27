<?php

// 输入一个矩阵，按照从外向里以顺时针的顺序依次打印出每一个数字，
//例如，如果输入如下4 X 4矩阵： 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16
// 则依次打印出数字1,2,3,4,8,12,16,15,14,13,9,5,6,7,11,10.


function printMatrix($matrix)
{
    if (empty($matrix) || empty($matrix[0])) {
        return [];
    }
    $l = 0;
    $r = count($matrix[0]) - 1;
    $t = 0;
    $b = count($matrix) - 1;
    $ans = [];
    while ($l <= $r && $t <= $b) {
        if ($l < $r) {
            for ($i = $l; $i <= $r; $i++) {
                $ans[] = $matrix[$t][$i];
            }
            $t++;
            if ($t > $b) {
                break;
            }
        }
        if ($t < $b) {
            for ($i = $t; $i <= $b; $i++) {
                $ans[] = $matrix[$i][$r];
            }
            $r--;
            if ($l > $r) {
                break;
            }
        }
        if ($l < $r) {
            for ($i = $r; $i >= $l; $i--) {
                $ans[] = $matrix[$b][$i];
            }
            $b--;
            if ($t > $b) {
                break;
            }
        }
        if ($t < $b) {
            for ($i = $b; $i >= $t; $i--) {
                $ans[] = $matrix[$i][$l];
            }
            $l++;
            if ($l > $r) {
                break;
            }
        }
    }
    return $ans;
}

$arr = [
    [1, 2, 3, 4],
    [5, 6, 7, 8],
    [9, 10, 11, 12],
    [13, 14, 15, 16],
];

var_dump(printMatrix($arr)); // 1,2,3,4,8,12,16,15,14,13,9,5,6,7,11,10
var_dump(printMatrix([])); // []
var_dump(printMatrix([[1], [2], [3], [4]])); // 1, 2, 3, 4
var_dump(printMatrix([[1, 2, 3, 4]])); // 1, 2, 3, 4
var_dump(printMatrix([[1, 2, 3, 4], [5, 6, 7, 8]])); // 1, 2, 3, 4