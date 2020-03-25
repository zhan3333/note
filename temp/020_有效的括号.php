<?php

class Solution
{
    function isValid(string $s): bool
    {
        $stack = [];
        $len = strlen($s);
        $map = [
            ')' => '(',
            ']' => '[',
            '}' => '{',
        ];
        for ($i = 0; $i < $len; $i++) {
            if (in_array($s[$i], ['(', '[', '{'])) {
                $stack[] = $s[$i];
            } else {
                if (empty($stack) || array_pop($stack) !== $map[$s[$i]]) {
                    return false;
                }
            }
        }
        return empty($stack);
    }
}

$s = new Solution();

var_dump($s->isValid('()')); // true
var_dump($s->isValid('[()]')); // true
var_dump($s->isValid('(]')); // false