<?php

// 给定一个包含非负整数的 m x n 网格，请找出一条从左上角到右下角的路径，使得路径上的数字总和为最小。
//
//说明：每次只能向下或者向右移动一步。
//
//示例:
//
//输入:
//[
//  [1,3,1],
//  [1,5,1],
//  [4,2,1]
//]
//输出: 7
//解释: 因为路径 1→3→1→1→1 的总和最小。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/minimum-path-sum
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * medium
     * 动态规划
     * 时间复杂度: O(n)
     * 空间复杂度: O(1)
     * dp([i, j]) = dp([i, j]) + min(dp(i - 1, j), dp(i, j - 1))
     * @param Integer[][] $grid
     * @return Integer
     */
    function minPathSum($grid)
    {
        $height = count($grid);
        $width = count($grid[0]);
        for ($i = 0; $i < $height; $i++) {
            for ($j = 0; $j < $width; $j++) {
                $top = $grid[$i - 1][$j] ?? PHP_INT_MAX;
                $left = $grid[$i][$j - 1] ?? PHP_INT_MAX;
                if ($i !== 0 || $j !== 0) {
                    $grid[$i][$j] += min($top, $left);
                }
            }
        }
        return $grid[$height - 1][$width - 1];
    }
}