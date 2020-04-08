<?php

// 编写一个函数，以字符串作为输入，反转该字符串中的元音字母。
//
//示例 1:
//
//输入: "hello"
//输出: "holle"
//示例 2:
//
//输入: "leetcode"
//输出: "leotcede"
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/reverse-vowels-of-a-string
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * @param String $s
     * @return String
     */
    function reverseVowels($s)
    {
        $swap = [
            'a' => true, 'e' => true, 'i' => true, 'o' => true, 'u' => true,
            'A' => true, 'E' => true, 'I' => true, 'O' => true, 'U' => true
        ];
        $start = 0;
        $end = strlen($s) - 1;
        while ($start < $end) {
            if (isset($swap[$s[$start]], $swap[$s[$end]])) {
                // swap
                $tmp = $s[$start];
                $s[$start] = $s[$end];
                $s[$end] = $tmp;
                $start++;
                $end--;
            } else {
                if (isset($swap[$s[$start]])) {
                    $end--;
                } elseif (isset($swap[$s[$end]])) {
                    $start++;
                } else {
                    $end--;
                    $start++;
                }
            }
        }
        return $s;
    }
}


$s = new Solution();

var_dump($s->reverseVowels('hello')); // holle
var_dump($s->reverseVowels('leetcode')); // leotcede