<?php

// 给定两个字符串 s 和 t，判断它们是否是同构的。
//
//如果 s 中的字符可以被替换得到 t ，那么这两个字符串是同构的。
//
//所有出现的字符都必须用另一个字符替换，同时保留字符的顺序。两个字符不能映射到同一个字符上，但字符可以映射自己本身。
//
//示例 1:
//
//输入: s = "egg", t = "add"
//输出: true
//示例 2:
//
//输入: s = "foo", t = "bar"
//输出: false
//示例 3:
//
//输入: s = "paper", t = "title"
//输出: true
//说明:
//你可以假设 s 和 t 具有相同的长度。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/isomorphic-strings
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * key => value 映射 map
     * value => key 映射 mapValue
     * 当读取到的字符串在 map key 中存在时, 判断 map[s[i]] === t[i]
     * 当读取的字符串在 map key 中不存在时, 判断在 mapValue[t[i]] 是否存在, 存在的话返回 false
     * @param String $s
     * @param String $t
     * @return Boolean
     */
    function isIsomorphic($s, $t)
    {
        $len = strlen($s);
        $map = [];
        $mapValues = [];
        for ($i = 0; $i < $len; $i++) {
            $sc = $s[$i];
            $tc = $t[$i];
            if (!isset($map[$sc])) {
                if (isset($mapValues[$tc])) {
                    return false;
                }
                $map[$sc] = $tc;
                $mapValues[$tc] = $sc;
            } elseif ($map[$sc] !== $tc) {
                return false;
            }
        }
        return true;
    }
}


$s = new Solution();
var_dump($s->isIsomorphic('egg', 'add')); // true
var_dump($s->isIsomorphic('foo', 'bar')); // false
var_dump($s->isIsomorphic('aba', 'baa')); // false
var_dump($s->isIsomorphic('ab', 'ca')); // true
var_dump($s->isIsomorphic('ab', 'aa')); // false