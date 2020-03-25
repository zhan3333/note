<?php

class Solution
{
    function romanToInt($s)
    {
        $len = strlen($s);
        $sum = 0;
        $map = [
            'I' => 1,
            'V' => 5,
            'X' => 10,
            'L' => 50,
            'C' => 100,
            'D' => 500,
            'M' => 1000,
            'IV' => 4,
            'IX' => 9,
            'XL' => 50,
            'XC' => 90,
            'CD' => 400,
            'CM' => 900,
        ];
        for ($i = 0; $i < $len; $i++) {
            if ($i < $len - 1 && isset($map[$s[$i] . $s[$i + 1]])) {
                $sum += $map[$s[$i] . $s[$i + 1]];
                $i++;
            } else {
                $sum += $map[$s[$i]];
            }
        }
        return $sum;
    }
}

$s = new Solution();

var_dump($s->romanToInt('III'));    // 3
var_dump($s->romanToInt('IV')); // 4
var_dump($s->romanToInt('IX')); // 9
var_dump($s->romanToInt('LVIII'));  // 58
var_dump($s->romanToInt('MCMXCIV')); // 1994