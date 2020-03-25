<?php


class Solution
{
    function longestCommonPrefix($strs)
    {
        $index = 0;
        $len = count($strs);
        while (isset($strs[0][$index])) {
            for ($i = 1; $i < $len; $i++) {
                if (!isset($strs[$i][$index]) || $strs[$i][$index] !== $strs[0][$index]) {
                    return substr($strs[0], 0, $index);
                }
            }
            $index++;
        }
        return substr($strs[0], 0, $index);
    }
}

$s = new Solution();
var_dump($s->longestCommonPrefix(["flower", "flow", "flight"])); // fl
var_dump($s->longestCommonPrefix(["dog", "racecar", "car"])); //
