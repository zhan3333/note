<?php

// 给定一个整数数组和一个整数 k，判断数组中是否存在两个不同的索引 i 和 j，使得 nums [i] = nums [j]，并且 i 和 j 的差的 绝对值 至多为 k。
//
// 
//
//示例 1:
//
//输入: nums = [1,2,3,1], k = 3
//输出: true
//示例 2:
//
//输入: nums = [1,0,1,1], k = 1
//输出: true
//示例 3:
//
//输入: nums = [1,2,3,1,2,3], k = 2
//输出: false
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/contains-duplicate-ii
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * Hash
     * @param $nums
     * @param $k
     */
    function containsNearbyDuplicate($nums, $k)
    {
        $len = count($nums);
        $map = [];
        for ($i = 0; $i < $len; $i++) {
            if (isset($map[$nums[$i]])) {
                if (abs($i - $map[$nums[$i]]) <= $k) {
                    return true;
                }
            }
            $map[$nums[$i]] = $i;
        }
        return false;
    }

    /**
     * 暴力解法
     * @param Integer[] $nums
     * @param Integer $k
     * @return Boolean
     */
    function containsNearbyDuplicate1($nums, $k)
    {
        $j = 1;
        $len = count($nums);
        while ($j < $len) {
            $i = $j - $k;
            if ($i < 0) {
                $i = 0;
            }
            while ($i < $j) {
                if ($nums[$i] === $nums[$j]) {
                    return true;
                }
                $i++;
            }
            $j++;
        }
        return false;
    }
}

$s = new Solution();

var_dump($s->containsNearbyDuplicate([1, 2, 3, 1], 3)); // true
var_dump($s->containsNearbyDuplicate([1, 0, 1, 1], 1)); // true
var_dump($s->containsNearbyDuplicate([1, 2, 3, 1, 2, 3], 2)); // false
var_dump($s->containsNearbyDuplicate([1, 5, 3, 4, 5], 10)); // true