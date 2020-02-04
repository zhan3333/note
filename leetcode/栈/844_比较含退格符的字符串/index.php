<?php

//给定 S 和 T 两个字符串，当它们分别被输入到空白的文本编辑器后，判断二者是否相等，并返回结果。 # 代表退格字符。
//
// 
//
//示例 1：
//
//输入：S = "ab#c", T = "ad#c"
//输出：true
//解释：S 和 T 都会变成 “ac”。
//示例 2：
//
//输入：S = "ab##", T = "c#d#"
//输出：true
//解释：S 和 T 都会变成 “”。
//示例 3：
//
//输入：S = "a##c", T = "#a#c"
//输出：true
//解释：S 和 T 都会变成 “c”。
//示例 4：
//
//输入：S = "a#c", T = "b"
//输出：false
//解释：S 会变成 “c”，但 T 仍然是 “b”。
// 
//
//提示：
//
//1 <= S.length <= 200
//1 <= T.length <= 200
//S 和 T 只含有小写字母以及字符 '#'。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/backspace-string-compare
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 两个字符串逐个字符读取入两个栈, 最后栈pop出来对比即可

class Solution {

    /**
     * @param String $S
     * @param String $T
     * @return Boolean
     */
    function backspaceCompare($S, $T) {
        $s1 = new SplStack();
        $s2 = new SplStack();
        for($i = 0, $count = strlen($S); $i< $count; $i ++) {
            if ($S[$i] === '#') {
                if (!$s1->isEmpty()) {
                    $s1->pop();
                }
            } else {
                $s1->push($S[$i]);
            }
        }
        for($i = 0, $count = strlen($T); $i< $count; $i ++) {
            if ($T[$i] === '#') {
                if (!$s2->isEmpty()) {
                    $s2->pop();
                }
            } else {
                $s2->push($T[$i]);
            }
        }
        if ($s1->count() !== $s2->count()) {
            return false;
        }
        while (!$s1->isEmpty()) {
            if ($s1->pop() !== $s2->pop()) {
                return false;
            }
        }
        return true;
    }
}

$solution = new Solution();
var_dump($solution->backspaceCompare('ab#c', 'ad#c')); // true
var_dump($solution->backspaceCompare('ab##', 'c#d#')); // true
var_dump($solution->backspaceCompare('a#c', 'b')); // false
var_dump($solution->backspaceCompare('abcde#f', 'abcdf')); // true
