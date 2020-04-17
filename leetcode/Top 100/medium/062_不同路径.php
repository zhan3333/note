<?php

// 一个机器人位于一个 m x n 网格的左上角 （起始点在下图中标记为“Start” ）。
//
//机器人每次只能向下或者向右移动一步。机器人试图达到网格的右下角（在下图中标记为“Finish”）。
//
//问总共有多少条不同的路径？
//
//
//
//例如，上图是一个7 x 3 的网格。有多少可能的路径？
//
// 
//
//示例 1:
//
//输入: m = 3, n = 2
//输出: 3
//解释:
//从左上角开始，总共有 3 条路径可以到达右下角。
//1. 向右 -> 向右 -> 向下
//2. 向右 -> 向下 -> 向右
//3. 向下 -> 向右 -> 向右
//示例 2:
//
//输入: m = 7, n = 3
//输出: 28
// 
//
//提示：
//
//1 <= m, n <= 100
//题目数据保证答案小于等于 2 * 10 ^ 9
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/unique-paths
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    private $ans = 0;

    /**
     * 动态规划算法
     * 很关键一点, 只能往下和往右, 所以每一个点可以到达的方法 = 上边点的方法数 + 左边点的方法数
     * dp([i, j]) = dp([i - 1, j]) + dp([i, j - 1])
     * @param $m
     * @param $n
     * @return mixed
     */
    function uniquePaths($m, $n)
    {
        $map = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $m; $j++) {
                if ($i === 0 && $j === 0) {
                    $map[0][0] = 1;
                } else {
                    $top = $map[$i - 1][$j] ?? 0;
                    $left = $map[$i][$j - 1] ?? 0;
                    $map[$i][$j] = $left + $top;
                }
            }
        }
        return $map[$n - 1][$m - 1];
    }


    /**
     * 暴力回溯法, 会有很多不必要的移动
     * 执行超时...
     * 时间复杂度
     * @param Integer $m
     * @param Integer $n
     * @return Integer
     */
    function uniquePaths1($m, $n)
    {
        $map = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $m; $j++) {
                $map[$i][$j] = 0;
            }
        }
        $this->backtrack($map, 0, 0, $m, $n);
        return $this->ans;
    }

    function backtrack($map, $i, $j, $m, $n)
    {
        if ($i === $m - 1 && $j === $n - 1) {
            $this->ans++;
            return;
        }
        if ($i < $m - 1 && $map[$j][$i + 1] !== 1) {
            // 可以向右走
            $map[$j][$i + 1] = 1;
            $this->backtrack($map, $i + 1, $j, $m, $n);
            $map[$j][$i + 1] = 0;
        }
        if ($j < $n - 1 && $map[$j + 1][$i] !== 1) {
            // 可以向下走
            $map[$j + 1][$i] = 1;
            $this->backtrack($map, $i, $j + 1, $m, $n);
            $map[$j + 1][$i] = 0;
        }
    }
}

$s = new Solution();

var_dump($s->uniquePaths(10, 10));