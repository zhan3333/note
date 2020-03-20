<?php

class Solution
{
    /**
     * 选择排序, 每次选择最小的数访到指定位置
     * 时间复杂度: O(n^2)
     * 空间复杂度: O(1)
     * 不稳定, 相同两个数的顺序会变更
     *
     * @param $nums
     * @return mixed
     */
    function selectSort($nums)
    {
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            $minI = $i;
            for ($j = $i + 1; $j < $len; $j++) {
                if ($nums[$j] < $nums[$minI]) {
                    $minI = $j;
                }
            }
            if ($minI !== $i) {
                $tmp = $nums[$minI];
                $nums[$minI] = $nums[$i];
                $nums[$i] = $tmp;
            }
        }
        return $nums;
    }
}

$s = new Solution();

var_dump($s->selectSort([5, 4, 0, 1, 3, 2])); // 0, 1, 2, 3, 4, 5