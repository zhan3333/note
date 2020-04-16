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
     * 排序比较结果
     * 时间复杂度: O(NlogN)
     * 空间复杂度: O(n)  复制了一个数组排储存排序结果
     * @param $nums
     * @return int
     */
    function findUnsortedSubarray($nums)
    {
        $sort = $nums;
        sort($sort);
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            if ($sort[$i] !== $nums[$i]) {
                break;
            }
        }
        for ($j = $len - 1; $j >= 0; $j--) {
            if ($sort[$j] !== $nums[$j]) {
                break;
            }
        }
        return $j - $i < 0 ? 0 : $j - $i + 1;
    }

    /**
     * 两次遍历兼容相等的数
     * 从左到右找到第一个下降的数
     * 从右到左找到第一个上升的数
     * @param Integer[] $nums
     * @return Integer
     */
    function findUnsortedSubarray1($nums)
    {
        $min = PHP_INT_MAX;
        $max = PHP_INT_MIN;
        $flag = false;
        $len = count($nums);
        for ($i = 1; $i < $len; $i++) {
            if ($nums[$i] < $nums[$i - 1]) {
                $flag = true;
            }
            if ($flag) {
                $min = min($min, $nums[$i]);
            }
        }
        $flag = false;
        for ($i = $len - 2; $i >= 0; $i--) {
            if ($nums[$i] > $nums[$i + 1]) {
                $flag = true;
            }
            if ($flag) {
                $max = max($nums[$i], $max);
            }
        }
        for ($l = 0; $l < $len; $l++) {
            if ($min < $nums[$l]) {
                break;
            }
        }
        for ($r = $len - 1; $r >= 0; $r--) {
            if ($max > $nums[$r]) {
                break;
            }
        }
        return $r - $l < 0 ? 0 : $r - $l + 1;
    }
}

// [2, 6, 4, 8, 10, 9, 15]