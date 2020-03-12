<?php

// 给定一个正整数，返回它在 Excel 表中相对应的列名称。
//
//例如，
//
//    1 -> A
//    2 -> B
//    3 -> C
//    ...
//    26 -> Z
//    27 -> AA
//    28 -> AB
//    ...
//示例 1:
//
//输入: 1
//输出: "A"
//示例 2:
//
//输入: 28
//输出: "AB"
//示例 3:
//
//输入: 701
//输出: "ZY"
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/excel-sheet-column-title
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 注意原理, 取模运算算出来的是最后一位, 依次向左走
     * @param Integer $n
     * @return String
     */
    function convertToTitle($n)
    {
        if ($n <= 0) {
            return '';
        }
        $ans = '';
        while ($n > 0) {
            $n--;
            $ans = chr($n % 26 + 65) . $ans;
            $n = (int)($n / 26);
        }
        return $ans;
    }
}

$s = new Solution();

var_dump($s->convertToTitle(1)); // A
var_dump($s->convertToTitle(28)); // AB
var_dump($s->convertToTitle(701)); // ZY
