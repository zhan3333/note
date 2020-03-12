<?php

// 给定一个大小为 n 的数组，找到其中的多数元素。多数元素是指在数组中出现次数大于 ⌊ n/2 ⌋ 的元素。
//
//你可以假设数组是非空的，并且给定的数组总是存在多数元素。
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
     * 哈希表
     * 时间复杂度: O(n)
     * 空间复杂度: O(n)
     * @param Integer[] $nums
     * @return Integer
     */
    function majorityElement($nums)
    {
        $map = [];
        $len = count($nums);
        $a = (int)($len / 2);
        for ($i = 0; $i < $len; $i++) {
            // 计数
            if (isset($map[$nums[$i]])) {
                $map[$nums[$i]]++;
            } else {
                $map[$nums[$i]] = 1;
            }
            // 判断
            if ($map[$nums[$i]] > $a) {
                return $nums[$i];
            }
        }
        return -1;
    }
}

$s = new Solution();

var_dump($s->majorityElement([3, 2, 3])); // 3
var_dump($s->majorityElement([2, 2, 1, 1, 1, 2, 2])); // 2