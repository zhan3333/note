<?php

// todo 未完成
class Solution
{
    function buildHeap(&$nums)
    {
        $len = count($nums);
        $nonLeaf = (int)($len / 2) - 1;
        for ($i = $nonLeaf; $i >= 0; $i--) {
            $this->heapify($nums, $i, $len);
        }
    }

    function heapify(&$nums, $i, $heapSize)
    {
        $smallest = $i;
        $left = 2 * $i + 1;
        $right = 2 * $i + 2;
        if ($left < $heapSize) {
            if ($nums[$i] > $nums[$left]) {
                $smallest = $left;
            }
        }
        if ($right < $heapSize) {
            if ($nums[$smallest] > $nums[$left]) {
                $smallest = $right;
            }
        }
        if ($smallest !== $i) {
            $tmp = $nums[$i];
            $nums[$i] = $nums[$smallest];
            $nums[$smallest] = $tmp;
            $this->heapify($nums, $smallest, $heapSize);
        }
    }

    /**
     * 堆排序
     * 时间复杂度: O(nLogN)
     * 空间复杂度: O(n) 堆大小
     * 不稳定
     * @param $nums
     * @return mixed
     */
    function heapSort($nums)
    {
        $len = count($nums);
        $heapSize = $len;
        $this->buildHeap($nums);
        for ($i = 0; $i < $len - 1; $i++) {
            $tmp = $nums[0];
            $nums[0] = $nums[$len - 1];
            $nums[$len - 1] = $tmp;
            $heapSize--;
            $this->heapify($nums, 0, $heapSize);
        }
        return $nums;
    }
}

$s = new Solution();

var_dump($s->heapSort([4, 5, 3, 0, 1, 2])); // 0, 1, 2, 3, 4, 5