<?php

//题目描述
//输入一个字符串,按字典序打印出该字符串中字符的所有排列。例如输入字符串abc,则打印出由字符a,b,c所能排列出来的所有字符串abc,acb,bac,bca,cab和cba。
//输入描述:
//输入一个字符串,长度不超过9(可能有字符重复),字符只包括大小写字母。

function Permutation($str)
{
    if ($str === '') {
        return [];
    }
    $track = [];
    $ans = [];
    helper($str, $track, $ans);
    return $ans;
}

function helper($str, $track, &$ans)
{
    // 终止条件
    if ($str === '') {
        $ans[] = implode('', $track);
        return;
    }
    $cache = [];
    for ($i = 0, $iMax = strlen($str); $i < $iMax; $i++) {
        $track[] = $str[$i];
        $newStr = substr($str, 0, $i) . substr($str, $i + 1, $iMax - 1 - $i);
        if (!in_array($newStr, $cache, true)) {
            helper($newStr, $track, $ans);
            $cache[] = $newStr;
        }
        array_pop($track);
    }
}

//var_dump(Permutation('abc'));
var_dump(Permutation('a'));
var_dump(Permutation('aa'));