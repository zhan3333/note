<?php

class Solution
{

    /**
     * @param Integer[] $nums
     * @param Integer $val
     * @return Integer
     */
    function removeElement(&$nums, $val)
    {
        $len = count($nums);
        $saveI = 0;
        for ($i = 0; $i < $len; $i++) {
            if ($nums[$i] !== $val) {
                if ($i !== $saveI) {
                    $nums[$saveI] = $nums[$i];
                }
                $saveI++;
            }
        }
        $nums = array_slice($nums, 0, $saveI);
        return $saveI;
    }
}

$s = new Solution();

$nums1 = [3, 2, 2, 3];
var_dump($s->removeElement($nums1, 3)); // 2
var_dump($nums1); // 2, 2