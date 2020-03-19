<?php

class Solution
{
    /**
     * 冒泡排序
     * 时间复杂度: O(n**2)
     * 空间复杂度: O(1)
     * 稳定排序
     * @param $nums
     * @return mixed
     */
    function popSort($nums)
    {
        $len = count($nums);
        $lastExchangeIndex = 0;
        $unOrderBorder = $len - 1;
        for ($i = 0; $i < $len - 1; $i++) {
            $isOrdered = true;
            for ($j = 0; $j < $unOrderBorder; $j++) {
                if ($nums[$j] > $nums[$j + 1]) {
                    $tmp = $nums[$j];
                    $nums[$j] = $nums[$j + 1];
                    $nums[$j + 1] = $tmp;
                    $isOrdered = false;
                    $lastExchangeIndex = $j;
                }
            }
            $unOrderBorder = $lastExchangeIndex;
            if ($isOrdered) {
                break;
            }
        }
        return $nums;
    }
}

$s = new Solution();

var_dump($s->popSort([2, 5, 3, 0, 1, 4])); // 0, 1, 2, 3, 4, 5