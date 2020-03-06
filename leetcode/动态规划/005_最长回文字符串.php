<?php

//给定一个字符串 s，找到 s 中最长的回文子串。你可以假设 s 的最大长度为 1000。
//
//示例 1：
//
//输入: "babad"
//输出: "bab"
//注意: "aba" 也是一个有效答案。
//示例 2：
//
//输入: "cbbd"
//输出: "bb"
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/longest-palindromic-substring
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 使用动态规划来做
// 找到动态规划方程: P(i, j) = P(i - 1, j + 1) && Si === Sj
// 还有一种马拉车算法

class Solution
{

    /**
     * 动态规划法
     * 时间复杂度: O(n^2)
     * 空间复杂度: O(n^2)
     * @param String $s
     * @return String
     */
    function longestPalindrome($s)
    {
        $len = strlen($s);
        if ($len < 2) return $s;
        $dp = [];
        $left = $right = 0;
        for ($i = 0; $i < $len; $i++) {
            $dp[$i][$i] = true;
            for ($j = $i - 1; $j >= 0; $j--) {
                $dp[$i][$j] = ($s[$i] === $s[$j]) && ($i - $j === 1 || $dp[$i - 1][$j + 1]);
                // 当子字符串为回文, 且长度大于历史最长长度, 则更新最新的左右坐标
                if ($dp[$i][$j] && ($i - $j > $right - $left)) {
                    $left = $j;
                    $right = $i;
                }
            }
        }
        return substr($s, $left, $right - $left + 1);
    }
}

$s = new Solution();

var_dump($s->longestPalindrome('babad')); // aba
var_dump($s->longestPalindrome('cbbd')); // bb
