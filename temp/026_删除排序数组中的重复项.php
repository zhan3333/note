<?php

class Solution
{

    /**
     * @param Integer[] $nums
     * @return Integer 返回修改后数组的长度
     */
    function removeDuplicates(&$nums)
    {
        $fast = 1;
        $slow = 1;
        $len = count($nums);
        while ($fast < $len) {
            if ($nums[$fast] !== $nums[$fast - 1]) {
                $nums[$slow] = $nums[$fast];
                $slow++;
            }
            $fast++;
        }
        $nums = array_slice($nums, 0, $slow);
        return $slow;
    }
}

$s = new Solution();

$nums1 = [1, 1, 2];
var_dump($s->removeDuplicates($nums1)); // 2
var_dump($nums1); // 1, 2