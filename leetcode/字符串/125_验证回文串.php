<?php

// 给定一个字符串，验证它是否是回文串，只考虑字母和数字字符，可以忽略字母的大小写。
//
//说明：本题中，我们将空字符串定义为有效的回文串。
//
//示例 1:
//
//输入: "A man, a plan, a canal: Panama"
//输出: true
//示例 2:
//
//输入: "race a car"
//输出: false
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/valid-palindrome
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//
// 思考
// 使用双指针
// 遇到非字母和数字时跳过, 验证每个对称位置的相等性

class Solution
{

    /**
     * 双指针做法
     * 时间复杂度: O(n)
     * 空间复杂度: O(1)
     * @param String $s
     * @return Boolean
     */
    function isPalindrome($s)
    {
        $len = strlen($s);
        if ($len === 0) return true;
        $star = 0;
        $end = $len - 1;
        while ($star < $end) {
            if (!ctype_alnum($s[$star])) {
                $star++;
                continue;
            }
            if (!ctype_alnum($s[$end])) {
                $end--;
                continue;
            }
            if (strtolower($s[$star]) !== strtolower($s[$end])) {
                return false;
            }
            $star ++;
            $end--;
        }
        return true;
    }
}

$s = new Solution();

var_dump($s->isPalindrome('A man, a plan, a canal: Panama')); // true
var_dump($s->isPalindrome('race a car')); // false