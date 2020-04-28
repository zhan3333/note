<?php

/*
 * @lc app=leetcode.cn id=74 lang=php
 *
 * [74] 搜索二维矩阵
 */

// 编写一个高效的算法来判断 m x n 矩阵中，是否存在一个目标值。该矩阵具有如下特性：
//
//每行中的整数从左到右按升序排列。
//每行的第一个整数大于前一行的最后一个整数。
//示例 1:
//
//输入:
//matrix = [
//  [1,   3,  5,  7],
//  [10, 11, 16, 20],
//  [23, 30, 34, 50]
//]
//target = 3
//输出: true
//示例 2:
//
//输入:
//matrix = [
//  [1,   3,  5,  7],
//  [10, 11, 16, 20],
//  [23, 30, 34, 50]
//]
//target = 13
//输出: false

// @lc code=start
class Solution {

    /**
     * 二分搜索
     * 时间复杂度: O(log(m*n))
     */
    function searchMatrix($matrix, $target) {
        $h = count($matrix);
        $w = count($matrix[0]);
        $len = $h * $w;
        $left = 0;
        $right = $len - 1;
        while($left <= $right) {
            $mid = ($right + $left) >> 1;
            $i = (int)($mid / $w);
            $j = $mid % $w;
            if ($matrix[$i][$j] === $target) {
                return true;
            } elseif ($matrix[$i][$j] > $target) {
                $right = $mid - 1;
            } else {
                $left = $mid + 1;
            }
        }
        return false;
    }

    /**
     * 利用有序矩阵特性, 每次可以排除掉一行
     * 时间复杂度: O(m + n)
     * @param Integer[][] $matrix
     * @param Integer $target
     * @return Boolean
     */
    function searchMatrix1($matrix, $target) {
        $h = count($matrix);
        $w = count($matrix[0]);
        $i = 0; $j = $w - 1;
        while($i < $h && $j >= 0) {
            if ($target === $matrix[$i][$j]) {
                return true;
            } elseif ($matrix[$i][$j] > $target) {
                $j--;
            } elseif ($matrix[$i][$j] < $target) {
                $j++;
            }
        }
        return false;
    }
}
// @lc code=end

