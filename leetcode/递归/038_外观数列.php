<?php

// 「外观数列」是一个整数序列，从数字 1 开始，序列中的每一项都是对前一项的描述。前五项如下：
//
//1.     1
//2.     11
//3.     21
//4.     1211
//5.     111221
//1 被读作  "one 1"  ("一个一") , 即 11。
//11 被读作 "two 1s" ("两个一"）, 即 21。
//21 被读作 "one 2",  "one 1" （"一个二" ,  "一个一") , 即 1211。
//
//给定一个正整数 n（1 ≤ n ≤ 30），输出外观数列的第 n 项。
//
//注意：整数序列中的每一项将表示为一个字符串。
//
// 
//
//示例 1:
//
//输入: 1
//输出: "1"
//解释：这是一个基本样例。
//示例 2:
//
//输入: 4
//输出: "1211"
//解释：当 n = 3 时，序列是 "21"，其中我们有 "2" 和 "1" 两组，"2" 可以读作 "12"，也就是出现频次 = 1 而 值 = 2；类似 "1" 可以读作 "11"。所以答案是 "12" 和 "11" 组合在一起，也就是 "1211"。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/count-and-say
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 使用循环来解决这个问题
// 问题有, 如何将描述的过程用程序表达出来
// 从左往右读字符串, 相同字符串计数, 计成当前描述的一部分
// 可以使用递归做这个问题

class Solution
{

    /**
     * 双指针做法
     * 时间复杂度: O(n)
     * @param Integer $n
     * @return String
     */
    function countAndSay($n)
    {
        if ($n === 1) {
            return '1';
        }
        $cur = '1';
        for ($i = 2; $i <= $n; $i++) {
            $curLen = strlen($cur);
            $fast = $slow = 0;
            // temp是这一层的描述
            $temp = '';
            while ($fast < $curLen) {
                if (($cur[$fast] === $cur[$slow])) {
                    $fast++;
                } else {
                    $temp .= ($fast - $slow) . $cur[$slow];
                    $slow = $fast;
                }
            }
            // 最后的数字
            $temp .= ($fast - $slow) . $cur[$slow];
            $cur = $temp;
        }
        return $cur;
    }
}

$s = new Solution();

var_dump($s->countAndSay(1)); // 1
var_dump($s->countAndSay(4)); // 1211