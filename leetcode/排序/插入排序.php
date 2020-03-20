<?php

class Solution
{
    /**
     * 插入排序, 始终让前半部分有序, 每一个元素都需要与前面的数对比
     * 时间复杂度: O(n^2)
     * 空间复杂度: O(1)
     * 稳定
     * @param $nums
     * @return mixed
     */
    function insertSort($nums)
    {
        $len = count($nums);
        for ($i = 1; $i < $len; $i++) {
            for ($j = $i; $j > 0; $j--) {
                if ($nums[$j] < $nums[$j - 1]) {
                    $tmp = $nums[$j];
                    $nums[$j] = $nums[$j - 1];
                    $nums[$j - 1] = $tmp;
                }
            }
        }
        return $nums;
    }
}

$s = new Solution();
var_dump($s->insertSort([3, 4, 1, 5, 0, 2]));  // 0, 1, 2, 3, 4, 5