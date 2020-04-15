<?php

// 给定一个大小为 n 的数组，找到其中的多数元素。多数元素是指在数组中出现次数大于 ⌊ n/2 ⌋ 的元素。
//
//你可以假设数组是非空的，并且给定的数组总是存在多数元素。
//
// 
//
//示例 1:
//
//输入: [3,2,3]
//输出: 3
//示例 2:
//
//输入: [2,2,1,1,1,2,2]
//输出: 2
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/majority-element
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 混战方法: 超过半数的数每次都能消灭掉一个不相同的数, 最后剩下的肯定是超过半数的数了
     * 空间复杂度: O(1)
     * 时间复杂度: O(n)
     * @param $nums
     * @return mixed
     */
    function majorityElement($nums)
    {
        $count = 1;
        $maj = $nums[0];
        $len = count($nums);
        for ($i = 1; $i < $len; $i++) {
            if ($maj === $nums[$i]) {
                $count++;
            } else {
                $count--;
                if ($count === 0) {
                    $maj = $nums[$i + 1];
                }
            }
        }
        return $maj;
    }


    /**
     * 用哈希表的解法
     * 时间复杂度: O(n) 遍历一遍元素
     * 空间复杂度: O(n) 用了hash表来储存元素的计数
     * @param Integer[] $nums
     * @return Integer
     */
    function majorityElement1($nums)
    {
        $hash = [];
        $mid = count($nums) >> 1;
        foreach ($nums as $num) {
            if (!isset($hash[$num])) {
                $hash[$num] = 0;
            }
            $hash[$num]++;
            if ($hash[$num] > $mid) {
                return $num;
            }
        }
        return -1;
    }
}