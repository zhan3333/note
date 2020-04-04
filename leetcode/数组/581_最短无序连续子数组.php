<?php

// 给定一个整数数组，你需要寻找一个连续的子数组，如果对这个子数组进行升序排序，那么整个数组都会变为升序排序。
//
//你找到的子数组应是最短的，请输出它的长度。
//
//示例 1:
//
//输入: [2, 6, 4, 8, 10, 9, 15]
//输出: 5
//解释: 你只需要对 [6, 4, 8, 10, 9] 进行升序排序，那么整个表都会变为升序排序。
//说明 :
//
//输入的数组长度范围在 [1, 10,000]。
//输入的数组可能包含重复元素 ，所以升序的意思是<=。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/shortest-unsorted-continuous-subarray
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 时间复杂度: O(nLogN), 进行了一次排序
     * 空间复杂度: O(n) 复制了一个数组
     * @param Integer[] $nums
     * @return Integer
     */
    function findUnsortedSubarray($nums)
    {
        $len = count($nums);
        $oldNums = $nums;
        sort($nums);
        $left = 0;
        $right = 0;
        for ($i = 0; $i < $len; $i++) {
            if ($nums[$i] !== $oldNums[$i]) {
                $left = $i;
                break;
            }
        }
        for ($i = $len - 1; $i >= 0; $i--) {
            if ($nums[$i] !== $oldNums[$i]) {
                $right = $i;
                break;
            }
        }
        return $right > $left ? $right - $left + 1 : 0;
    }
}

$s = new Solution();

//var_dump($s->findUnsortedSubarray([2, 6, 4, 8, 10, 9, 15])); // 5
//var_dump($s->findUnsortedSubarray([3, 3, 3, 2, 1, 1, 1])); // 7
//var_dump($s->findUnsortedSubarray([1, 2, 3, 4])); // 0
var_dump($s->findUnsortedSubarray([1, 3, 2, 4, 5])); // 2
var_dump($s->findUnsortedSubarray([1, 2, 3, 3, 3])); // 0
var_dump($s->findUnsortedSubarray([1, 1])); // 0