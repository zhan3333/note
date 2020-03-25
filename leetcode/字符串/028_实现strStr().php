<?php

// 实现 strStr() 函数。
//
//给定一个 haystack 字符串和一个 needle 字符串，在 haystack 字符串中找出 needle 字符串出现的第一个位置 (从0开始)。如果不存在，则返回  -1。
//
//示例 1:
//
//输入: haystack = "hello", needle = "ll"
//输出: 2
//示例 2:
//
//输入: haystack = "aaaaa", needle = "bba"
//输出: -1
//说明:
//
//当 needle 是空字符串时，我们应当返回什么值呢？这是一个在面试中很好的问题。
//
//对于本题而言，当 needle 是空字符串时我们应当返回 0 。这与C语言的 strstr() 以及 Java的 indexOf() 定义相符。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/implement-strstr
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * todo KMP 方式
     * @param $haystack
     * @param $needle
     * @return int
     */
    function strStr($tString, $pString)
    {
        $lenT = strlen($tString);
        $lenP = strlen($pString);
        $i = 0;  // S 的下标
        $j = 0;  // P 的下标
        $next = $this->makeNext($pString);
        while ($i < $lenT && $j < $lenP) {
            if ($j === -1 || $tString[$i] === $pString[$j]) {
                $i++;
                $j++;
            } else {
                $j = $next[$j];
            }
        }
        return $j === $lenP ? $i - $lenP : -1;

    }

    function makeNext($str)
    {
        $next[0] = -1;
        $i = 0;
        $j = -1;
        while ($i < strlen($str)) {
            if ($j === -1 || $str[$i] === $str[$j]) {
                $j++;
                $i++;
                $next[$i] = $j;
            } else {
                $j = $next[$j];
            }
        }
        return $next;
    }

    /**
     * 调用系统api
     * @param String $haystack
     * @param String $needle
     * @return Integer
     */
    function strStr1($haystack, $needle)
    {
        if (empty($needle)) {
            return 0;
        }
        $res = strpos($haystack, $needle);
        if ($res === false) {
            return -1;
        }
        return $res;
    }
}

$s = new Solution();
//var_dump($s->strStr('aabcabcc', 'abcabc')); // 2
//var_dump($s->strStr('hello', 'll')); // 2
//var_dump($s->strStr('aaaaa', 'bba')); // -1
//var_dump($s->strStr('aaaaa', '')); // 0
var_dump($s->strStr("mississippi", 'issipi')); // -1