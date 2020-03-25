<?php

// 在 N * N 的网格上，我们放置一些 1 * 1 * 1  的立方体。
//
//每个值 v = grid[i][j] 表示 v 个正方体叠放在对应单元格 (i, j) 上。
//
//请你返回最终形体的表面积。
//
// 
//
//示例 1：
//
//输入：[[2]]
//输出：10
//示例 2：
//
//输入：[[1,2],[3,4]]
//输出：34
//示例 3：
//
//输入：[[1,0],[0,2]]
//输出：16
//示例 4：
//
//输入：[[1,1,1],[1,0,1],[1,1,1]]
//输出：32
//示例 5：
//
//输入：[[2,2,2],[2,1,2],[2,2,2]]
//输出：46
// 
//
//提示：
//
//1 <= N <= 50
//0 <= grid[i][j] <= 50
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/surface-area-of-3d-shapes
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * @param Integer[][] $grid
     * @return Integer
     */
    function surfaceArea($grid)
    {
        $len = count($grid);
        $sum = 0;
        for ($i = 0; $i < $len; $i++) {
            $len2 = count($grid[$i]);
            for ($j = 0; $j < $len2; $j++) {
                $level = $grid[$i][$j];
                if ($level === 0) {
                    continue;
                }
                $sum += $level * 4 + 2;
                if (isset($grid[$i - 1][$j])) {
                    $sum -= min($grid[$i - 1][$j], $level);
                }
                if (isset($grid[$i + 1][$j])) {
                    $sum -= min($grid[$i + 1][$j], $level);
                }
                if (isset($grid[$i][$j - 1])) {
                    $sum -= min($grid[$i][$j - 1], $level);
                }
                if (isset($grid[$i][$j + 1])) {
                    $sum -= min($grid[$i][$j + 1], $level);
                }
            }
        }
        return $sum;
    }
}

$s = new Solution();
var_dump($s->surfaceArea([[2]])); // 10
var_dump($s->surfaceArea([[1, 2], [3, 4]])); //34