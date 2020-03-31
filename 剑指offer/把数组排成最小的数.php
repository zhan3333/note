<?php

// 输入一个正整数数组，把数组里所有数字拼接起来排成一个数，
//打印能拼接出的所有数字中最小的一个。例如输入数组{3，32，321}，
//则打印出这三个数字能排成的最小数字为321323。

function PrintMinNumber($numbers)
{
    $len = count($numbers);
    for ($i = 0; $i < $len; $i++) {
        for ($j = $i + 1; $j < $len; $j++) {
            $num1 = $numbers[$i] . $numbers[$j];
            $num2 = $numbers[$j] . $numbers[$i];
            if ($num1 > $num2) {
                $temp = $numbers[$i];
                $numbers[$i] = $numbers[$j];
                $numbers[$j] = $temp;
            }
        }
    }
    return implode('', $numbers);
}

var_dump(PrintMinNumber([3, 32, 321])); // 321323