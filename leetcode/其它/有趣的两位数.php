<?php

// 有数学家发现⼀些两位数很有意思，⽐如，
// 34 * 86 = 43 * 68
// 也就是说，如果把他们的⼗位数和个位数交换，⼆者乘积不变。
// 编程求出满⾜该性质的两位数组合。
// 提示，暴⼒解法⾮最优解。

class Solution
{
    function funTwoNum()
    {
        $ans = [];
        for ($a = 1; $a < 10; $a++) {
            for ($c = 1; $c < 10; $c++) {
                for ($b = 1; $b < 10; $b++) {
                    for ($d = 1; $d < 10; $d++) {
                        if ($a * $c === $b * $d) {
                            $ans[] = [
                                10 * $a + $b,
                                10 * $c + $d,
                            ];
                        }
                    }
                }
            }
        }
        return $ans;
    }
}

$s = new Solution();
var_dump($s->funTwoNum());