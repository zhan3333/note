<?php

// 给定一个非负整数数组，你最初位于数组的第一个位置。
//
//数组中的每个元素代表你在该位置可以跳跃的最大长度。
//
//判断你是否能够到达最后一个位置。
//
//示例 1:
//
//输入: [2,3,1,1,4]
//输出: true
//解释: 我们可以先跳 1 步，从位置 0 到达 位置 1, 然后再从位置 1 跳 3 步到达最后一个位置。
//示例 2:
//
//输入: [3,2,1,0,4]
//输出: false
//解释: 无论怎样，你总会到达索引为 3 的位置。但该位置的最大跳跃长度是 0 ， 所以你永远不可能到达最后一个位置。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/jump-game
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    private $ans = false;

    /**
     * 从后往前判断的思路
     * 时间复杂度: O(n)
     *  空间复杂度: O(1)
     * @param $nums
     * @return bool
     */
    function canJump($nums)
    {
        $n = 1;
        $len = count($nums);
        for ($i = $len - 2; $i >= 0; $i--) {
            // 判断这个数的大小是否能够支撑跳到下一个可以到达末尾的点
            if ($nums[$i] >= $n) {
                // 能跳到, 那么只需要前一个点能跳1步即可
                $n = 1;
            } else {
                // 不能跳到, 那么跳到下一个可以到达终点的点的任务就交给前一个点了, 而且跳跃超度+1
                $n++;
            }
            // 当遍历到第一个点了都, 还是不能跳跃到下一个可以到达终点的点, 这样就失败了
            if ($i === 0 && $nums[0] < $n) {
                return false;
            }
        }
        return true;
    }

    /**
     * 回溯算法走一个
     * @param Integer[] $nums
     * @return Boolean
     */
    function canJump1($nums)
    {
        $this->backtrack($nums, 0);
        return $this->ans;
    }

    function backtrack($nums, $now)
    {
        if ($this->ans) {
            return;
        }
        $len = count($nums);
        if ($now === $len - 1) {
            $this->ans = true;
            return;
        }
        for ($i = 1; $i <= $nums[$now]; $i++) {
            if ($now + $i >= $len - 1) {
                $this->ans = true;
                return;
            }
            if ($nums[$now + $i] === 0) {
                continue;
            }
            $this->backtrack($nums, $now + $i);
        }
    }
}