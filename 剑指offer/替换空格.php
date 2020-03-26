<?php

// 请实现一个函数，将一个字符串中的每个空格替换成“%20”。
// 例如，当字符串为We Are Happy.则经过替换之后的字符串为We%20Are%20Happy。


function replaceSpace($str)
{
    $len = strlen($str);
    $ans = '';
    for ($i = 0; $i < $len; $i++) {
        if ($str[$i] === ' ') {
            $ans .= '%20';
        } else {
            $ans .= $str[$i];
        }
    }
    return $ans;
}

var_dump(replaceSpace('We Are Happy')); // We%20Are%20Happy