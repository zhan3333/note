<?php

// 给定一个整数数组 nums ，找到一个具有最大和的连续子数组（子数组最少包含一个元素），返回其最大和。
//
//示例:
//
//输入: [-2,1,-3,4,-1,2,1,-5,4],
//输出: 6
//解释: 连续子数组 [4,-1,2,1] 的和最大，为 6。
//进阶:
//
//如果你已经实现复杂度为 O(n) 的解法，尝试使用更为精妙的分治法求解。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/maximum-subarray
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 1. 题目要求返回最大值, 而不需要返回最大值对应的下标
// 可以使用动态规划来做
// 1. 值: 当前坐标下的最大值
// 2. 公式: P(i) = P(i-1)>0 ? P(i-1) + P(i) : P(i)
// 如何理解这个公式呢? 当前面的数大于0才有累加的意义, 否则就抛弃

class Solution
{

    /**
     * 分治法
     * @todo
     * @param $nums
     */
    function maxSubArray($nums) {

    }

    /**
     * 空间复杂度为O(1)的动态规划
     *
     * @param $nums
     */
    function maxSubArray2($nums)
    {
        $len = count($nums);
        $max = $nums[0];
        for ($i = 1; $i < $len; $i++) {
            if ($nums[$i - 1] > 0) $nums[$i] = $nums[$i - 1] + $nums[$i];
            $max = max($max, $nums[$i]);
        }
        return $max;
    }

    /**
     * 动态规划方案
     * 时间复杂度: O(n)
     * 空间复杂度: O(n^2)
     * @param Integer[] $nums
     * @return Integer
     */
    function maxSubArray1($nums)
    {
        $dp = [];
        $len = count($nums);
        $max = $nums[0];
        for ($i = 0; $i < $len; $i++) {
            $dp[$i][$i] = $nums[$i];
            for ($j = $i; $j >= 0; $j--) {
                if (isset($dp[$i - 1][$j])) {
                    $dp[$i][$j] = $dp[$i - 1][$j] + $dp[$i][$i];
                }
                $max = max($dp[$i][$j], $max);
            }
        }
        return $max;
    }
}

$s = new Solution();

var_dump($s->maxSubArray([-2, 1, -3, 4, -1, 2, 1, -5, 4]));  // 6