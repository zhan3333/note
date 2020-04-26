<?php

/*
 * @lc app=leetcode.cn id=63 lang=php
 *
 * [63] 不同路径 II
 */

// @lc code=start
class Solution
{

    /**
     * 动态规划
     * 遇到障碍时值为0
     * @param Integer[][] $obstacleGrid
     * @return Integer
     */
    function uniquePathsWithObstacles($obstacleGrid)
    {
        $h = count($obstacleGrid);
        $w = count($obstacleGrid[0]);
        for ($i = 0; $i < $h; $i++) {
            for ($j = 0; $j < $w; $j++) {
                // dp[i][j] = dp[i-1][j] + dp[j-1][i]
                if ($obstacleGrid[$i][$j] === 1) {
                    $obstacleGrid[$i][$j] = 0;
                } else {
                    if ($i === 0 && $j === 0) {
                        $obstacleGrid[$i][$j] = 1;
                    } else {
                        $top = $i > 0 ? $obstacleGrid[$i - 1][$j] : 0;
                        $left = $j > 0 ? $obstacleGrid[$i][$j - 1] : 0;
                        $obstacleGrid[$i][$j] = $top + $left;
                    }
                }

            }
        }
        return $obstacleGrid[$h - 1][$w - 1];
    }
}
// @lc code=end

