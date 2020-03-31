<?php

// 给定一个仅包含数字 2-9 的字符串，返回所有它能表示的字母组合。
//
//给出数字到字母的映射如下（与电话按键相同）。注意 1 不对应任何字母。
//
//
//
//示例:
//
//输入："23"
//输出：["ad", "ae", "af", "bd", "be", "bf", "cd", "ce", "cf"].
//说明:
//尽管上面的答案是按字典序排列的，但是你可以任意选择答案输出的顺序。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/letter-combinations-of-a-phone-number
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    private $res;

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits)
    {
        if ($digits === '') {
            return [];
        }
        $map = [
            ' ', '*', 'abc', 'def', 'ghi', 'jkl', 'mno', 'pqrs', 'tuv', 'wxyz',
        ];
        $res = [];
        $res[] = '';
        $len = strlen($digits);
        for ($i = 0; $i < $len; $i++) {
            $letters = $map[(int)($digits[$i])];
            $size = count($res);
            for ($j = 0; $j < $size; $j++) {
                $tmp = array_shift($res);
                $lettersLen = strlen($letters);
                for ($k = 0; $k < $lettersLen; $k++) {
                    $res[] = $tmp . $letters[$k];
                }
            }
        }
        return $res;
    }
}

$s = new Solution();

var_dump($s->letterCombinations('23')); // ["ad", "ae", "af", "bd", "be", "bf", "cd", "ce", "cf"]