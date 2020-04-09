<?php

// 给定一个赎金信 (ransom) 字符串和一个杂志(magazine)字符串，判断第一个字符串 ransom 能不能由第二个字符串 magazines 里面的字符构成。如果可以构成，返回 true ；否则返回 false。
//
//(题目说明：为了不暴露赎金信字迹，要从杂志上搜索各个需要的字母，组成单词来表达意思。杂志字符串中的每个字符只能在赎金信字符串中使用一次。)
//
// 
//
//注意：
//
//你可以假设两个字符串均只含有小写字母。
//
//canConstruct("a", "b") -> false
//canConstruct("aa", "ab") -> false
//canConstruct("aa", "aab") -> true
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/ransom-note
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 对勒索信进行字符计数, 然后遍历杂志,
     * 时间复杂度: O(log(m + n))
     * 空间复杂度: O(m) 对勒索信进行 hash 计数
     * @param String $ransomNote
     * @param String $magazine
     * @return Boolean
     */
    function canConstruct($ransomNote, $magazine)
    {
        $hash = [];
        $len1 = strlen($ransomNote);
        for ($i = 0; $i < $len1; $i++) {
            if (!isset($hash[$ransomNote[$i]])) {
                $hash[$ransomNote[$i]] = 0;
            }
            $hash[$ransomNote[$i]]++;
        }
        $len2 = strlen($magazine);
        for ($i = 0; $i < $len2; $i++) {
            if (isset($hash[$magazine[$i]])) {
                $hash[$magazine[$i]]--;
                if ($hash[$magazine[$i]] === 0) {
                    unset($hash[$magazine[$i]]);
                    if (empty($hash)) {
                        return true;
                    }
                }
            }
        }
        return empty($hash);
    }
}

$s = new Solution();

var_dump($s->canConstruct('a', 'b')); // false
var_dump($s->canConstruct('aa', 'ab')); // false
var_dump($s->canConstruct('aa', 'aab')); // true