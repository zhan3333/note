<?php

// 给定一个非空整数数组，除了某个元素只出现一次以外，其余每个元素均出现两次。找出那个只出现了一次的元素。
//
//说明：
//
//你的算法应该具有线性时间复杂度。 你可以不使用额外空间来实现吗？
//
//示例 1:
//
//输入: [2,2,1]
//输出: 1
//示例 2:
//
//输入: [4,1,2,1,2]
//输出: 4
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/single-number
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 不使用额外空间(数字异或操作)
     * 时间复杂度: O(n)
     * 空间复杂度: O(1)
     */
    function singleNumber($nums)
    {
        $len = count($nums);
        $num = $nums[0];
        for ($i = 1; $i < $len; $i++) {
            $num ^= $nums[$i];
        }
        return $num;
    }

    /**
     * 使用额外空间
     * 时间复杂度: O(n)
     * 空间复杂度: O(n)
     * @param Integer[] $nums
     * @return Integer
     */
    function singleNumber1($nums)
    {
        $len = count($nums);
        $arr = [];
        for ($i = 0; $i < $len; $i++) {
            if (isset($arr[$nums[$i]])) {
                unset($arr[$nums[$i]]);
            } else {
                $arr[$nums[$i]] = 1;
            }
        }
        return array_key_first($arr);
    }
}

$s = new Solution();

var_dump($s->singleNumber([2, 2, 1])); // 1
var_dump($s->singleNumber([4, 1, 2, 1, 2])); // 4