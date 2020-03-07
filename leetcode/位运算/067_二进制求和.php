<?php

// 给定两个二进制字符串，返回他们的和（用二进制表示）。
//
//输入为非空字符串且只包含数字 1 和 0。
//
//示例 1:
//
//输入: a = "11", b = "1"
//输出: "100"
//示例 2:
//
//输入: a = "1010", b = "1011"
//输出: "10101"
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/add-binary
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 这个问题的关键点是补全短的字符串0字符, 然后逐位从末尾相加, while外需要再判断一次有没有进位

class Solution
{

    /**
     * @param String $a
     * @param String $b
     * @return String
     */
    function addBinary($a, $b)
    {
        // 补全短的字符
        if (strlen($a) < strlen($b)) {
            $a = str_pad($a, strlen($b), '0', STR_PAD_LEFT);
        } else {
            $b = str_pad($b, strlen($a), '0', STR_PAD_LEFT);
        }
        $len = strlen($a);
        $i = $len - 1;
        $res = '';
        $up = 0;
        while ($i >= 0) {
            $num = $a[$i] + $b[$i] + $up;
            if ($num === 3) {
                $up = 1;
                $res = 1 . $res;
            }
            if ($num === 2) {
                $up = 1;
                $res = 0 . $res;
            }
            if ($num === 1 || $num === 0) {
                $up = 0;
                $res = $num . $res;
            }
            $i--;
        }
        if ($up === 1) {
            $res = 1 . $res;
        }
        return $res;
    }
}

$s = new Solution();

var_dump($s->addBinary('11', '1')); // 100
var_dump($s->addBinary('1010', '1011')); // 10101

