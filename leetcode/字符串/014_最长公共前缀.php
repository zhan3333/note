<?php

// 编写一个函数来查找字符串数组中的最长公共前缀。
//
//如果不存在公共前缀，返回空字符串 ""。
//
//示例 1:
//
//输入: ["flower","flow","flight"]
//输出: "fl"
//示例 2:
//
//输入: ["dog","racecar","car"]
//输出: ""
//解释: 输入不存在公共前缀。
//说明:
//
//所有输入只包含小写字母 a-z 。
//
//通过次数198,361提交次数545
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/longest-common-prefix
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 用一个下标来取所有字符串的字符, 不相同则停止, 取不到字符停止, 返回下标前的字符串

class Solution
{

    /**
     * 暴力法
     * 时间复杂度 O(S) S为所有字符串的长度和
     * @param String[] $strs
     * @return String
     */
    function longestCommonPrefix($strs)
    {
        $len = count($strs);
        if ($len === 0) return '';
        for ($i = 0, $firstStrLen = strlen($strs[0]); $i < $firstStrLen; $i++) {
            $curChar = $strs[0][$i];
            for ($j = 0; $j < $len; $j++) {
                if (!isset($strs[$j][$i]) || $strs[$j][$i] !== $curChar) {
                    return substr($strs[0], 0, $i);
                }
            }
        }
        return $strs[0];
    }
}

$s = new Solution();
var_dump($s->longestCommonPrefix(["flower", "flow", "flight"])); // fl
var_dump($s->longestCommonPrefix(["dog", "racecar", "car"])); // ''