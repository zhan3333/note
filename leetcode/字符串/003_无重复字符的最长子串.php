<?php

// 给定一个字符串，请你找出其中不含有重复字符的 最长子串 的长度。
//
//示例 1:
//
//输入: "abcabcbb"
//输出: 3
//解释: 因为无重复字符的最长子串是 "abc"，所以其长度为 3。
//示例 2:
//
//输入: "bbbbb"
//输出: 1
//解释: 因为无重复字符的最长子串是 "b"，所以其长度为 1。
//示例 3:
//
//输入: "pwwkew"
//输出: 3
//解释: 因为无重复字符的最长子串是 "wke"，所以其长度为 3。
//     请注意，你的答案必须是 子串 的长度，"pwke" 是一个子序列，不是子串。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/longest-substring-without-repeating-characters
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


// 思路
// 这题使用滑动窗口的思路最省力, 逐个读取字符, 并将字符与下标加入hash表中, 当读取到有重复字符时, 将i移动到hash表中重复字符的下标位置
// 每次读取字符, 都要取历史最长长度作为结果保存下来

class Solution
{

    /**
     * 时间复杂度 O(2n) = O(n)
     * @param String $s
     * @return Integer
     */
    function lengthOfLongestSubstring1($s)
    {
        $set = [];
        $len = strlen($s);
        $i = $j = $ans = 0;
        while ($i < $len && $j < $len) {
            if (!isset($set[$s[$j]])) {
                $set[$s[$j++]] = 0;
                $ans = max($ans, $j - $i);
            } else {
                unset($set[$s[$i++]]);
            }
        }
        return $ans;
    }

    /**
     * 时间复杂度 O(n)
     * 空间复杂度 O(min(m, n)), 字符串n, 字符集m
     * @param String $s
     * @return Integer
     */
    function lengthOfLongestSubstring($s)
    {
        // key: 字符, value: 字符所在的下标+1
        $hash = [];
        $len = strlen($s);
        $ans = 0;
        // 遍历字符
        for ($j = 0, $i = 0; $j < $len; $j++) {
            if (isset($hash[$s[$j]])) {
                // 如果字符集中存在的这个字符, 则直接将i移到这个位置上
                $i = max($hash[$s[$j]], $i);
            }
            // 计算历史最长长度
            $ans = max($ans, $j - $i + 1);
            // 储存当前读取到的字符和下标到hash中
            $hash[$s[$j]] = $j + 1;
        }
        return $ans;
    }
}

$s = new Solution();

var_dump($s->lengthOfLongestSubstring('abcabcbb'));  // 3
var_dump($s->lengthOfLongestSubstring('bbbbb'));  // 1
var_dump($s->lengthOfLongestSubstring('pwwkew'));  // 3

