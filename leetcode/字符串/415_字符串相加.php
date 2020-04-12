<?php

// 给定两个字符串形式的非负整数 num1 和num2 ，计算它们的和。
//
//注意：
//
//num1 和num2 的长度都小于 5100.
//num1 和num2 都只包含数字 0-9.
//num1 和num2 都不包含任何前导零。
//你不能使用任何內建 BigInteger 库， 也不能直接将输入的字符串转换为整数形式。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/add-strings
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 实现 大数 相加的函数
     * @param String $num1
     * @param String $num2
     * @return String
     */
    function addStrings($num1, $num2)
    {
        $len1 = strlen($num1);
        $len2 = strlen($num2);
        $i = $len1 - 1;
        $j = $len2 - 1;
        $ans = '';
        $carry = 0;
        while ($i >= 0 || $j >= 0 || $carry !== 0) {
            $n1 = $i >= 0 ? (int)$num1[$i] : 0;
            $n2 = $j >= 0 ? (int)$num2[$j] : 0;
            $sum = $n1 + $n2 + $carry;
            $carry = $sum > 9 ? 1 : 0;
            $ans = ($sum % 10) . $ans;
            $i--;
            $j--;
        }
        return $ans;
    }
}

$s = new Solution();

var_dump($s->addStrings('123', '45')); // 168
var_dump($s->addStrings('9', '1')); // 10