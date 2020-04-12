<?php

// 给定一个非空数组，返回此数组中第三大的数。如果不存在，则返回数组中最大的数。要求算法时间复杂度必须是O(n)。
//
//示例 1:
//
//输入: [3, 2, 1]
//
//输出: 1
//
//解释: 第三大的数是 1.
//示例 2:
//
//输入: [1, 2]
//
//输出: 2
//
//解释: 第三大的数不存在, 所以返回最大的数 2 .
//示例 3:
//
//输入: [2, 2, 3, 1]
//
//输出: 1
//
//解释: 注意，要求返回第三大的数，是指第三大且唯一出现的数。
//存在两个值为2的数，它们都排第二。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/third-maximum-number
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 三次循环找出三大数
     * 时间复杂度 O(n)
     * @param $nums
     * @return int|mixed
     */
    function thirdMax($nums)
    {
        $max1 = $max2 = $max3 = PHP_INT_MIN;
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            if ($nums[$i] > $max1) {
                $max1 = $nums[$i];
            }
        }
        for ($i = 0; $i < $len; $i++) {
            if ($nums[$i] > $max2 && $nums[$i] !== $max1) {
                $max2 = $nums[$i];
            }
        }
        for ($i = 0; $i < $len; $i++) {
            if ($nums[$i] > $max3 && $nums[$i] !== $max2 && $nums[$i] !== $max1) {
                $max3 = $nums[$i];
            }
        }
        if ($max1 !== PHP_INT_MIN && $max2 !== PHP_INT_MIN && $max3 !== PHP_INT_MIN) {
            return $max3;
        }
        return $max1;
    }
}

$s = new Solution();
var_dump($s->thirdMax([3, 2, 1])); // 1
var_dump($s->thirdMax([1, 2])); // 2
var_dump($s->thirdMax([2, 2, 3, 1])); // 1