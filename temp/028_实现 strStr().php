<?php

class Solution
{

    /**
     * @param String $haystack
     * @param String $needle
     * @return Integer
     */
    function strStr($haystack, $needle)
    {
        $len1 = strlen($haystack);
        $len2 = strlen($needle);
        if ($len1 < $len2) {
            return -1;
        }
        if ($needle === '') {
            return 0;
        }
        for ($i = 0; $i < $len1 - $len2 + 1; $i++) {
            for ($j = 0; $j < $len2; $j++) {
                if ($haystack[$i + $j] !== $needle[$j]) {
                    break;
                }
                if ($j === $len2 - 1) {
                    return $i;
                }
            }
        }
        return -1;
    }
}

$s = new Solution();
var_dump($s->strStr('hello', 'll')); // 2