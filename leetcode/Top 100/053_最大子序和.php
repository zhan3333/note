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


class Solution
{

    /**
     * 使用简单版的动态规划
     * dp(n) = max(n, n + dp(n-1))
     * 时间复杂度: O(n) 遍历一遍数组
     * 空间复杂度: O(1)
     *
     * @param Integer[] $nums
     * @return Integer
     */
    function maxSubArray($nums)
    {
        $len = count($nums);
        $max = $nums[0];
        for ($i = 1; $i < $len; $i++) {
            $nums[$i] = max($nums[$i], $nums[$i] + $nums[$i - 1]);
            $max = max($nums[$i], $max);
        }
        return $max;
    }
}