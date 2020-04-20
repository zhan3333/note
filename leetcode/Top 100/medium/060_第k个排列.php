<?php

/*
* @lc app=leetcode.cn id=60 lang=php
*
* [60] 第k个排列
*/

// @lc code=start
class Solution
{

    private $count = 0;
    private $ans;

    function getPermutation($n, $k)
    {
        $trace = [];
        $nums = [];
        $f = [1];
        for ($i = 1; $i <= $n; $i++) {
            $f[$i] = $f[$i - 1] * $i;
            $nums[] = $i;
        }
        $k--;
        for ($i = 1; $i <= $n; $i++) {
            $num = $f[$n - $i]; // 对应位置的阶乘数
            $index = (int)($k / $num); // 获取这一层的数字
            $trace[] = $nums[$index]; // 记录
            // 将用掉的数字去掉, PHP 没有set + index 的实现
            unset($nums[$index]);
            $nums = array_values($nums);
            // 进入下一层
            $k %= $num;
        }
        return implode('', $trace);
    }


    /**
     * 回溯法超时
     * @param Integer $n
     * @param Integer $k
     * @return String
     */
    function getPermutation1($n, $k)
    {
        $this->backtrack($n, $k, []);
        return $this->ans;
    }

    function backtrack($n, $k, $trace)
    {
        if (count($trace) === $n) {
            $this->count++;
            if ($this->count === $k) {
                $this->ans = implode('', $trace);
            }
            return;
        }
        for ($i = 1; $i <= $n; $i++) {
            if (!in_array($i, $trace, true)) {
                $trace[] = $i;
                $this->backtrack($n, $k, $trace);
                array_pop($trace);
            }
        }
    }
}

// @lc code=end

$s = new Solution();

var_dump($s->getPermutation(3, 3)); // 213
var_dump($s->getPermutation(4, 9)); // 2314