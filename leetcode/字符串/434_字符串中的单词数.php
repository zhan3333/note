<?php

// 统计字符串中的单词个数，这里的单词指的是连续的不是空格的字符。
//
//请注意，你可以假定字符串里不包括任何不可打印的字符。
//
//示例:
//
//输入: "Hello, my name is John"
//输出: 5
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/number-of-segments-in-a-string
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class Solution
{

    /**
     * 在字符串的最末尾加上一个空格, 可以将几种情况归为一种考虑
     * 我们称之为: 不一样的创造条件让它们一样
     * 时间复杂度: O(n) 只遍历了一次字符串
     * @param $s
     * @return int
     */
    function countSegments($s)
    {
        $s .= ' ';
        $len = strlen($s);
        $count = 0;
        for ($i = 0; $i < $len - 1; $i++) {
            if ($s[$i] !== ' ' && $s[$i + 1] === ' ') {
                $count++;
            }
        }
        return $count;
    }


    function countSegments2($s)
    {
        $right = strlen($s) - 1;
        $left = 0;
        $count = 0;
        while ($right >= 0 && $s[$right] === ' ') {
            $right--;
        }
        while ($left <= $right && $s[$left] === ' ') {
            $left++;
        }
        while ($left <= $right) {
            if ($s[$left] !== ' ' && ($left === $right || $s[$left + 1] === ' ')) {
                $count++;
            }
            $left++;
        }
        return $count;
    }

    /**
     * @param String $s
     * @return Integer
     */
    function countSegments1($s)
    {
        if ($s === '') {
            return 0;
        }
        return count(array_filter(explode(' ', $s), function ($item) {
            return $item !== '' && $item !== ' ';
        }));
    }
}

$s = new Solution();

var_dump($s->countSegments('')); //0
var_dump($s->countSegments(' ')); //0
var_dump($s->countSegments('Hello, my name is John')); //5