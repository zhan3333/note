<?php

// 给定两个字符串 s 和 t，它们只包含小写字母。
//
//字符串 t 由字符串 s 随机重排，然后在随机位置添加一个字母。
//
//请找出在 t 中被添加的字母。
//
// 
//
//示例:
//
//输入：
//s = "abcd"
//t = "abcde"
//
//输出：
//e
//
//解释：
//'e' 是那个被添加的字母。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/find-the-difference
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 转成数字来操作
     * @param $s
     * @param $t
     * @return string
     */
    function findTheDifference($s, $t)
    {
        $len1 = strlen($s);
        $len2 = strlen($t);
        if ($len2 - $len1 !== 1) {
            return '';
        }
        $ret = ord($t[$len2 - 1]);
        for ($i = 0; $i < $len1; $i++) {
            $ret ^= ord($s[$i]);
            $ret ^= ord($t[$i]);
        }
        return chr($ret);
    }

    /**
     * @param String $s
     * @param String $t
     * @return String
     */
    function findTheDifference1($s, $t)
    {
        $hash = [];
        $len = strlen($s);
        for ($i = 0; $i < $len; $i++) {
            if (!isset($hash[$s[$i]])) {
                $hash[$s[$i]] = 0;
            }
            $hash[$s[$i]]++;
        }
        for ($i = 0; $i <= $len; $i++) {
            if (!isset($hash[$t[$i]])) {
                return $t[$i];
            }
            $hash[$t[$i]]--;
            if ($hash[$t[$i]] < 0) {
                return $t[$i];
            }
        }
        return array_keys(array_filter($hash, function ($key, $value) {
                return $value === 1;
            }))[0] ?? '';
    }
}

$s = new Solution();

var_dump($s->findTheDifference('abcd', 'abcde')); // e