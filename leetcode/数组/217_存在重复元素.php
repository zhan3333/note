<?php

// 给定一个整数数组，判断是否存在重复元素。
//
//如果任何值在数组中出现至少两次，函数返回 true。如果数组中每个元素都不相同，则返回 false。
//
//示例 1:
//
//输入: [1,2,3,1]
//输出: true
//示例 2:
//
//输入: [1,2,3,4]
//输出: false
//示例 3:
//
//输入: [1,1,1,3,3,4,3,2,4,2]
//输出: true
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/contains-duplicate
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class Solution
{

    /**
     * 时间复杂度: O(n)
     * 空间复杂度: O(n)
     * @param Integer[] $nums
     * @return Boolean
     */
    function containsDuplicate($nums)
    {
        $hash = [];
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            if (isset($hash[$nums[$i]])) {
                return true;
            } else {
                $hash[$nums[$i]] = 1;
            }
        }
        return false;
    }
}

$s = new Solution();

var_dump($s->containsDuplicate([1, 2, 3, 1])); // true