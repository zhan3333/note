<?php

// 把一个数组最开始的若干个元素搬到数组的末尾，我们称之为数组的旋转。
//输入一个非递减排序的数组的一个旋转，输出旋转数组的最小元素。
//例如数组{3,4,5,1,2}为{1,2,3,4,5}的一个旋转，该数组的最小值为1。
//NOTE：给出的所有元素都大于0，若数组大小为0，请返回0。

function minNumberInRotateArray($rotateArray)
{
    $len = count($rotateArray);
    if ($len === 0) {
        return 0;
    }
    $left = 0;
    $right = $len - 1;
    while ($left < $right - 1) {
        $center = (int)(($right - $left) / 2) + $left;
        if ($rotateArray[$center] < $rotateArray[$left]) {
            $right = $center;
        }
        if ($rotateArray[$center] > $rotateArray[$right]) {
            $left = $center;
        }
    }
    return min($rotateArray[$left], $rotateArray[$right]);
}

var_dump(minNumberInRotateArray([7, 8, 9, 1, 2, 3, 4, 5, 6])); // 1