<?php

// 给出一个区间的集合，请合并所有重叠的区间。
//
//示例 1:
//
//输入: [[1,3],[2,6],[8,10],[15,18]]
//输出: [[1,6],[8,10],[15,18]]
//解释: 区间 [1,3] 和 [2,6] 重叠, 将它们合并为 [1,6].
//示例 2:
//
//输入: [[1,4],[4,5]]
//输出: [[1,5]]
//解释: 区间 [1,4] 和 [4,5] 可被视为重叠区间。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/merge-intervals
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 先排序, 后合并
     * 时间复杂度: O(nLogN) 取决于排序的算法
     * 空间复杂度: 使用了栈来储存过程, 最大 O(n)
     * 合并条件 [a1, a2], [b1, b2] 其中 a1 <= b1 <= $a2 <= b2
     * @param Integer[][] $intervals
     * @return Integer[][]
     */
    function merge($intervals)
    {
        usort($intervals, function ($a, $b) {
            return $a[0] - $b[0];
        });

        $stack = [$intervals[0]];
        $len = count($intervals);
        for ($i = 1; $i < $len; $i++) {
            $pop = array_pop($stack);
            if ($pop[1] >= $intervals[$i][0]) {
                $stack[] = [$pop[0], max($pop[1], $intervals[$i][1])];
            } else {
                $stack[] = $pop;
                $stack[] = $intervals[$i];
            }
        }
        return $stack;
    }
}