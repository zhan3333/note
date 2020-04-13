<?php

// 给定一个字符串数组，将字母异位词组合在一起。字母异位词指字母相同，但排列不同的字符串。
//
//示例:
//
//输入: ["eat", "tea", "tan", "ate", "nat", "bat"]
//输出:
//[
//  ["ate","eat","tea"],
//  ["nat","tan"],
//  ["bat"]
//]
//说明：
//
//所有输入均为小写字母。
//不考虑答案输出的顺序。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/group-anagrams
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 尝试用一个结果来表示相同的异位字符串
     * @param $strs
     */
    function groupAnagrams($strs)
    {
        $map = [
            'a' => 2,
            'b' => 3,
            'c' => 5,
            'd' => 7,
            'e' => 11,
            'f' => 13,
            'g' => 17,
            'h' => 19,
            'i' => 23,
            'j' => 29,
            'k' => 31,
            'l' => 37,
            'm' => 41,
            'n' => 43,
            'o' => 47,
            'p' => 53,
            'q' => 59,
            'r' => 61,
            's' => 67,
            't' => 71,
            'u' => 73,
            'v' => 79,
            'w' => 83,
            'x' => 89,
            'y' => 97,
            'z' => 101,
        ];
        $hash = [];
        $len = count($strs);
        for ($i = 0; $i < $len; $i++) {
            $sum = 1;
            $str = $strs[$i];
            for ($j = 0, $jMax = strlen($str); $j < $jMax; $j++) {
                $sum *= $map[$str[$j]];
            }
            if (!isset($hash[$sum])) {
                $hash[$sum] = [];
            }
            $hash[$sum][] = $str;
        }
        return array_values($hash);
    }

    /**
     *
     * 时间复杂度: O(n * mLog(m))
     * 空间复杂度: O(n)
     *
     * 将每个字符串进行排序, 然后 hash 储存, 最后返回数据
     * @param String[] $strs
     * @return String[][]
     */
    function groupAnagrams1($strs)
    {
        $hash = [];
        $len = count($strs);
        for ($i = 0; $i < $len; $i++) {
            $str = $strs[$i];
            $sortStr = $this->sortStr($str);
            if (!isset($hash[$sortStr])) {
                $hash[$sortStr] = [];
            }
            $hash[$sortStr][] = $str;
        }
        return array_values($hash);
    }

    function sortStr($str)
    {
        $arr = str_split($str);
        sort($arr);
        return implode('', $arr);
    }
}

$s = new Solution();

// [
//  ["ate","eat","tea"],
//  ["nat","tan"],
//  ["bat"]
//]
var_dump($s->groupAnagrams(["eat", "tea", "tan", "ate", "nat", "bat"]));