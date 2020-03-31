<?php

// 在一个字符串(0<=字符串长度<=10000，全部由字母组成)
// 中找到第一个只出现一次的字符,并返回它的位置,
// 如果没有则返回 -1（需要区分大小写）.


function FirstNotRepeatingChar($str)
{
    $hash = [];
    $out = [];
    $len = strlen($str);
    for ($i = 0; $i < $len; $i++) {
        $char = $str[$i];
        if (!isset($out[$char])) {
            if (!isset($hash[$char])) {
                $hash[$str[$i]] = $i;
            } else {
                unset($hash[$char]);
                $out[$char] = $i;
            }
        }
    }
    return empty($hash) ? -1 : current($hash);
}

var_dump(FirstNotRepeatingChar('abc')); // 0
var_dump(FirstNotRepeatingChar('aabc')); // 2