<?php

/*
 * @lc app=leetcode.cn id=59 lang=php
 *
 * [59] 螺旋矩阵 II
 */

// @lc code=start
class Solution
{

    /**
     * @param Integer $n
     * @return Integer[][]
     */
    function generateMatrix($n)
    {
        $top = 0;
        $bottom = $n - 1;
        $left = 0;
        $right = $n - 1;
        $ans = [];
        // PHP 中数组如果先赋值后边的数, 就变成了 key 数组, 而不是 index 数组了, 输出的内容会反过来了
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $ans[$i][$j] = null;
            }
        }
        $action = 0;
        $count = 1;
        while ($left <= $right && $top <= $bottom) {
            if ($action === 0) {
                // 左往右
                for ($i = $left; $i <= $right; $i++) {
                    $ans[$top][$i] = $count++;
                }
                $top++;
            } elseif ($action === 1) {
                // 上往下
                for ($i = $top; $i <= $bottom; $i++) {
                    $ans[$i][$right] = $count++;
                }
                $right--;
            } elseif ($action === 2) {
                // 右往左
                for ($i = $right; $i >= $left; $i--) {
                    $ans[$bottom][$i] = $count++;
                }
                $bottom--;
            } elseif ($action === 3) {
                // 下往上
                for ($i = $bottom; $i >= $top; $i--) {
                    $ans[$i][$left] = $count++;
                }
                $left++;
            }
            $action++;
            $action %= 4;
        }
        return $ans;
    }
}
// @lc code=end