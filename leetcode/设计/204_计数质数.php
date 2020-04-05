<?php

// 统计所有小于非负整数 n 的质数的数量。
//
//示例:
//
//输入: 10
//输出: 4
//解释: 小于 10 的质数一共有 4 个, 它们是 2, 3, 5, 7 。

class Solution
{

    /**
     * 厄拉多塞筛法: 范围内质数的倍数均为非质数
     * @param $n
     * @return int
     */
    function countPrimes($n)
    {
        if ($n < 2) {
            return 0;
        }
        $res = array_fill(0, $n + 1, 1);
        $res[0] = $res[1] = $res[$n] = 0;
        $sum = 0;
        for ($i = 2; $i < $n; $i++) {
            if ($res[$i] === 1) {
                $sum++;
                for ($j = $i * $i; $j < $n; $j += $i) {
                    $res[$j] = 0;
                }
            }
        }
        return $sum;
    }


    /**
     * 暴力解法
     * @param Integer $n
     * @return Integer
     */
    function countPrimes1($n)
    {
        $count = 0;
        $n--;
        while ($n > 1) {
            if ($this->isPrimes($n)) {
                $count++;
            }
            $n--;
        }
        return $count;
    }

    function isPrimes($n)
    {
        $m = (int)(sqrt($n));
        while ($m > 1) {
            if ($n % $m === 0) {
                return false;
            }
            $m--;
        }
        return true;
    }
}

$s = new Solution();

var_dump($s->countPrimes(10)); // 4
var_dump($s->countPrimes(3)); // 1