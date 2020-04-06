<?php

// 给定两个字符串 s 和 t ，编写一个函数来判断 t 是否是 s 的字母异位词。
//
//示例 1:
//
//输入: s = "anagram", t = "nagaram"
//输出: true
//示例 2:
//
//输入: s = "rat", t = "car"
//输出: false
//说明:
//你可以假设字符串只包含小写字母。
//
//进阶:
//如果输入字符串包含 unicode 字符怎么办？你能否调整你的解法来应对这种情况？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/valid-anagram
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 时间复杂度: O(n)
     * 孔家你复杂度: O(n)
     * @param String $s
     * @param String $t
     * @return Boolean
     */
    function isAnagram($s, $t)
    {
        $len = strlen($s);
        if ($len !== strlen($t)) {
            return false;
        }
        $map = [];
        for ($i = 0; $i < $len; $i++) {
            if (!isset($map[$s[$i]])) {
                $map[$s[$i]] = 0;
            }
            if (!isset($map[$t[$i]])) {
                $map[$t[$i]] = 0;
            }
            $map[$s[$i]]++;
            $map[$t[$i]]--;
        }
        foreach ($map as $item) {
            if ($item !== 0) {
                return false;
            }
        }
        return true;
    }
}

$s = new Solution();

var_dump($s->isAnagram('anagram', 'nagaram')); // true
var_dump($s->isAnagram('rat', 'car')); // false