<?php

// 编写一个函数，其作用是将输入的字符串反转过来。输入字符串以字符数组 char[] 的形式给出。
//
//不要给另外的数组分配额外的空间，你必须原地修改输入数组、使用 O(1) 的额外空间解决这一问题。
//
//你可以假设数组中的所有字符都是 ASCII 码表中的可打印字符。
//
// 
//
//示例 1：
//
//输入：["h","e","l","l","o"]
//输出：["o","l","l","e","h"]
//示例 2：
//
//输入：["H","a","n","n","a","h"]
//输出：["h","a","n","n","a","H"]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/reverse-string
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 双指针法, 更易理解
     * 时间复杂度: O(N)
     * 空间复杂度: O(1)
     * @param $s
     */
    function reverseString(&$s)
    {
        $left = 0;
        $right = count($s) - 1;
        while ($left < $right) {
            $tmp = $s[$left];
            $s[$left] = $s[$right];
            $s[$right] = $tmp;
            $left++;
            $right--;
        }
    }

    /**
     * 原地交换
     * 时间复杂度: O(N)
     * 空间复杂度: O(1)
     * @param String[] $s
     * @return NULL
     */
    function reverseString1(&$s)
    {
        $len = count($s);
        $even = $len % 2 === 0;
        $center = (int)($len / 2) - ($even ? 1 : 0);
        for ($i = 0; $i <= $center; $i++) {
            $tmp = $s[$i];
            $s[$i] = $s[$len - $i - 1];
            $s[$len - $i - 1] = $tmp;
        }
    }
}

$s = new Solution();

$string = ['h', 'e', 'l', 'l', 'o'];
$s->reverseString($string);
var_dump($string); // ['o', 'l', 'l', 'e', 'h']