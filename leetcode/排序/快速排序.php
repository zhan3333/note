<?php


class Solution
{
    /**
     * 快速排序
     * 时间复杂度: 最好: O(nLogN) 最差数组已经有序: O(n**2)
     * 空间复杂度: O(logN)
     * 不稳定
     *
     * @param $nums
     * @return array
     */
    function quickSort($nums)
    {
        $len = count($nums);
        if ($len < 2) {
            return $nums;
        }
        $p = $nums[0];
        $left = [];
        $right = [];
        for ($i = 1; $i < $len; $i++) {
            if ($nums[$i] > $p) {
                $right[] = $nums[$i];
            } else {
                $left[] = $nums[$i];
            }
        }
        return array_merge($this->quickSort($left), [$p], $this->quickSort($right));
    }

}

$s = new Solution();

var_dump($s->quickSort([2, 5, 4, 0, 3, 1])); // 0, 1, 2, 3, 4, 5