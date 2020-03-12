<?php

// 给定一个Excel表格中的列名称，返回其相应的列序号。
//
//例如，
//
//    A -> 1
//    B -> 2
//    C -> 3
//    ...
//    Z -> 26
//    AA -> 27
//    AB -> 28
//    ...
//示例 1:
//
//输入: "A"
//输出: 1
//示例 2:
//
//输入: "AB"
//输出: 28
//示例 3:
//
//输入: "ZY"
//输出: 701
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/excel-sheet-column-number
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * @param String $s
     * @return Integer
     */
    function titleToNumber($s)
    {
        $sum = 0;
        $len = strlen($s);
        for ($i = 0; $i < $len; $i++) {
            $sum += (ord($s[$i]) - 64) * (26 ** ($len - $i - 1));
        }
        return $sum;
    }
}

$s = new Solution();

var_dump($s->titleToNumber('A')); // 1
var_dump($s->titleToNumber('AB')); // 28
var_dump($s->titleToNumber('ZY')); // 701