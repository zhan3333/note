<?php


class Solution
{
    // 快速排序 非递归
    function quickSort($nums)
    {
        $this->partition($nums, 0, count($nums) - 1);
        return $nums;
    }

    function partition(&$nums, $left, $right)
    {
        if ($left >= $right) {
            return;
        }
        $i = $left;
        $j = $right;
        $p = $nums[$left];
        while ($i < $j) {
            while ($i < $j && $nums[$j] > $p) {
                $j--;
            }
            while ($i < $j && $nums[$i] <= $p) {
                $i++;
            }
            if ($i < $j) {
                $tmp = $nums[$i];
                $nums[$i] = $nums[$j];
                $nums[$j] = $tmp;
            }
        }
        $tmp = $nums[$i];
        $nums[$i] = $nums[$left];
        $nums[$left] = $tmp;
        $this->partition($nums, $left, $i - 1);
        $this->partition($nums, $i + 1, $right);
    }


    /**
     * 快速排序 递归
     * 时间复杂度: 最好: O(nLogN) 最差数组已经有序: O(n**2)
     * 空间复杂度: O(n ** 2)
     * 不稳定
     *
     * @param $nums
     * @return array
     */
    function quickSort1($nums)
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
        return array_merge($this->quickSort1($left), [$p], $this->quickSort1($right));
    }

}

$s = new Solution();

var_dump($s->quickSort([2, 5, 4, 0, 3, 1])); // 0, 1, 2, 3, 4, 5