<?php

// 给定一个包含 m x n 个元素的矩阵（m 行, n 列），请按照顺时针螺旋顺序，返回矩阵中的所有元素。
//
//示例 1:
//
//输入:
//[
// [ 1, 2, 3 ],
// [ 4, 5, 6 ],
// [ 7, 8, 9 ]
//]
//输出: [1,2,3,6,9,8,7,4,5]
//示例 2:
//
//输入:
//[
//  [1, 2, 3, 4],
//  [5, 6, 7, 8],
//  [9,10,11,12]
//]
//输出: [1,2,3,4,8,12,11,10,9,5,6,7]

class Solution
{

    /**
     * @param Integer[][] $matrix
     * @return Integer[]
     */
    function spiralOrder($matrix)
    {
        $h = count($matrix);
        $w = count($matrix[0]);
        $top = 0;
        $bottom = $h - 1;
        $left = 0;
        $right = $w - 1;
        $action = 0;
        $ans = [];
        while ($top <= $bottom && $left <= $right) {
            if ($action === 0) {
                // 从左到右
                for ($i = $left; $i <= $right; $i++) {
                    $ans[] = $matrix[$top][$i];
                }
                $top++;
            } elseif ($action === 1) {
                // 从上到下
                for ($i = $top; $i <= $bottom; $i++) {
                    $ans[] = $matrix[$i][$right];
                }
                $right--;
            } elseif ($action === 2) {
                // 从右到左
                for ($i = $right; $i >= $left; $i--) {
                    $ans[] = $matrix[$bottom][$i];
                }
                $bottom--;
            } elseif ($action === 3) {
                // 从下到上
                for ($i = $bottom; $i >= $top; $i--) {
                    $ans[] = $matrix[$i][$left];
                }
                $left++;
            }
            $action++;
            $action %= 4;
        }
        return $ans;
    }
}