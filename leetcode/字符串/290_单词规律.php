<?php

// 给定一种规律 pattern 和一个字符串 str ，判断 str 是否遵循相同的规律。
//
//这里的 遵循 指完全匹配，例如， pattern 里的每个字母和字符串 str 中的每个非空单词之间存在着双向连接的对应规律。
//
//示例1:
//
//输入: pattern = "abba", str = "dog cat cat dog"
//输出: true
//示例 2:
//
//输入:pattern = "abba", str = "dog cat cat fish"
//输出: false
//示例 3:
//
//输入: pattern = "aaaa", str = "dog cat cat dog"
//输出: false
//示例 4:
//
//输入: pattern = "abba", str = "dog dog dog dog"
//输出: false
//说明:
//你可以假设 pattern 只包含小写字母， str 包含了由单个空格分隔的小写字母。    
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/word-pattern
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 时间复杂度: O(n)
     * 空间复杂度: O(m + n)
     * @param String $pattern
     * @param String $str
     * @return Boolean
     */
    function wordPattern($pattern, $str)
    {
        $arr = explode(' ', $str);
        $lenM = strlen($pattern);
        $lenN = count($arr);
        if ($lenM !== $lenN) {
            return false;
        }
        $map = [];
        $reverseMap = [];
        for ($i = 0; $i < $lenM; $i++) {
            $p = $pattern[$i];
            $s = $arr[$i];
            if (!isset($map[$p])) {
                if (isset($reverseMap[$s])) {
                    return false;
                }
                $map[$p] = $s;
                $reverseMap[$s] = $p;
            } elseif ($map[$p] !== $s) {
                return false;
            }
        }
        return true;
    }
}

$s = new Solution();

var_dump($s->wordPattern('abba', 'dog cat cat dog'));
var_dump($s->wordPattern('abba', 'dog cat cat cat'));