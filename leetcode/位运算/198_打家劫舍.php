<?php

// 你是一个专业的小偷，计划偷窃沿街的房屋。每间房内都藏有一定的现金，影响你偷窃的唯一制约因素就是相邻的房屋装有相互连通的防盗系统，如果两间相邻的房屋在同一晚上被小偷闯入，系统会自动报警。
//
//给定一个代表每个房屋存放金额的非负整数数组，计算你在不触动警报装置的情况下，能够偷窃到的最高金额。
//
//示例 1:
//
//输入: [1,2,3,1]
//输出: 4
//解释: 偷窃 1 号房屋 (金额 = 1) ，然后偷窃 3 号房屋 (金额 = 3)。
//     偷窃到的最高金额 = 1 + 3 = 4 。
//示例 2:
//
//输入: [2,7,9,3,1]
//输出: 12
//解释: 偷窃 1 号房屋 (金额 = 2), 偷窃 3 号房屋 (金额 = 9)，接着偷窃 5 号房屋 (金额 = 1)。
//     偷窃到的最高金额 = 2 + 9 + 1 = 12 。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/house-robber
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 使用动态规划来做
// dp[i最高金额] = dp[i-2] + value(i)

class Solution
{

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function rob($nums)
    {
        $dp = [];
        $len = count($nums);
        $max = 0;
        for ($i = 0; $i < $len; $i++) {
            if ($i === 0) {
                $dp[$i] = $nums[$i];
            } elseif ($i === 1) {
                $dp[$i] = max($nums[$i - 1], $nums[$i]);
            } else {
                $dp[$i] = max($dp[$i - 2] + $nums[$i], $dp[$i - 1]);
            }
            $max = max($dp[$i], $max);
        }
        return $max;
    }
}

$s = new Solution();

var_dump($s->rob([1, 2, 3, 1])); // 4
var_dump($s->rob([2, 7, 9, 3, 1])); // 12
var_dump($s->rob([])); // 0
var_dump($s->rob([9, 1, 2, 9])); // 18