<?php

// 给定一个包含 0, 1, 2, ..., n 中 n 个数的序列，找出 0 .. n 中没有出现在序列中的那个数。
//
//示例 1:
//
//输入: [3,0,1]
//输出: 2
//示例 2:
//
//输入: [9,6,4,2,3,5,7,0,1]
//输出: 8
//说明:
//你的算法应具有线性时间复杂度。你能否仅使用额外常数空间来实现?
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/missing-number
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class Solution
{
    /**
     * 考虑是两个数列, 那么使用异或来求解
     * @param $nums
     */
    function missingNumber($nums)
    {
        $len = count($nums);
        $ret = $len;
        for ($i = 0; $i < $len; $i++) {
            $ret = $ret ^ $nums[$i] ^ $i;
        }
        return $ret;
    }


    /**
     * 等差数列求和
     * @param Integer[] $nums
     * @return Integer
     */
    function missingNumber1($nums)
    {
        $len = count($nums);
        return ((1 + $len) * $len) / 2 - array_sum($nums);
    }
}

$s = new Solution();

var_dump($s->missingNumber([9, 6, 4, 2, 3, 5, 7, 0, 1])); // 8