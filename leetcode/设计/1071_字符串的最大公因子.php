<?php

// 对于字符串 S 和 T，只有在 S = T + ... + T（T 与自身连接 1 次或多次）时，我们才认定 “T 能除尽 S”。
//
//返回最长字符串 X，要求满足 X 能除尽 str1 且 X 能除尽 str2。
//
// 
//
//示例 1：
//
//输入：str1 = "ABCABC", str2 = "ABC"
//输出："ABC"
//示例 2：
//
//输入：str1 = "ABABAB", str2 = "ABAB"
//输出："AB"
//示例 3：
//
//输入：str1 = "LEET", str2 = "CODE"
//输出：""
// 
//
//提示：
//
//1 <= str1.length <= 1000
//1 <= str2.length <= 1000
//str1[i] 和 str2[i] 为大写英文字母
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/greatest-common-divisor-of-strings
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * @param String $str1
     * @param String $str2
     * @return String
     */
    function gcdOfStrings($str1, $str2)
    {
        if ($str1 . $str2 !== $str2 . $str1) {
            return '';
        }
        $ans = substr($str1, 0, $this->gcd(strlen($str1), strlen($str2)));
        if ($ans === false) {
            return '';
        }
        return $ans;
    }

    function gcd($a, $b)
    {
        return $b === 0 ? $a : $this->gcd($b, $a % $b);
    }
}

$s = new Solution();
var_dump($s->gcdOfStrings('ABCABC', 'ABC')); // ABC
var_dump($s->gcdOfStrings('ABABAB', 'ABAB')); // ABAB
var_dump($s->gcdOfStrings('LEET', 'CODE')); // ''