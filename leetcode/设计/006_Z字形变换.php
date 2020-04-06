<?php

// 将一个给定字符串根据给定的行数，以从上往下、从左到右进行 Z 字形排列。
//
//比如输入字符串为 "LEETCODEISHIRING" 行数为 3 时，排列如下：
//
//L   C   I   R
//E T O E S I I G
//E   D   H   N
//之后，你的输出需要从左往右逐行读取，产生出一个新的字符串，比如："LCIRETOESIIGEDHN"。
//
//请你实现这个将字符串进行指定行数变换的函数：
//
//string convert(string s, int numRows);
//示例 1:
//
//输入: s = "LEETCODEISHIRING", numRows = 3
//输出: "LCIRETOESIIGEDHN"
//示例 2:
//
//输入: s = "LEETCODEISHIRING", numRows = 4
//输出: "LDREOEIIECIHNTSG"
//解释:
//
//L     D     R
//E   O E   I I
//E C   I H   N
//T     S     G
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/zigzag-conversion
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 用 numRows 大小的数组来储存即可, 可以理解为 numRows 个栈, 每个栈相当于一行,
     * 读取每个字符, 找到要入的栈即可.
     * 时间复杂度 O(n)
     * 空间复杂度 O(n)
     * @param $s
     * @param $numRows
     * @return string
     */
    function convert($s, $numRows)
    {
        $len = strlen($s);
        $arr = array_fill(0, $numRows + 1, '');
        $curRow = 0;
        $goingDown = false;
        for ($i = 0; $i < $len; $i++) {
            $arr[$curRow] .= $s[$i];
            if ($curRow === 0 || $curRow === $numRows - 1) {
                $goingDown = !$goingDown;
            }
            $curRow += $goingDown ? 1 : -1;
        }
        return implode('', $arr);
    }

    /**
     * 暴力解法
     * @param String $s
     * @param Integer $numRows
     * @return String
     */
    function convert1($s, $numRows)
    {
        $len = strlen($s);
        $i = 0;
        $line = 0;
        $row = 0;
        $arr = [];
        $goingDown = true;
        while ($i < $len) {
            $arr[$line][$row] = $s[$i];
            if ($line === $numRows - 1 || $line === 0) {
                $goingDown = !$goingDown;
            }
            if ($goingDown) {
                if ($numRows > 1) {
                    $line--;
                }
                $row++;
            } else {
                if ($numRows > 1) {
                    $line++;
                } else {
                    $row++;
                }
            }
            $i++;
        }
        $ans = '';
        for ($i = 0; $i < $numRows; $i++) {
            for ($j = 0; $j <= $row; $j++) {
                if (isset($arr[$i][$j])) {
                    $ans .= $arr[$i][$j];
                }
            }
        }
        return $ans;
    }
}

$s = new Solution();

var_dump($s->convert('LEETCODEISHIRING', 3)); // LCIRETOESIIGEDHN
var_dump($s->convert('PAYPALISHIRING', 3)); // PAHNAPLSIIGYIR
var_dump($s->convert('AB', 1)); // PAHNAPLSIIGYIR