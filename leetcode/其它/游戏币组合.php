<?php

// ⼩明的抽屉⾥有n个游戏币，总⾯值m，游戏币的设置有1分的，2分的，5分的，10分的，⽽在⼩明
// 所拥有的游戏币中有些⾯值的游戏币可能没有，求⼀共有多少种可能的游戏币组合⽅式？
// 输⼊：输⼊两个数n(游戏币的个数)，m(总⾯值)。
// 输出：请输出可能的组合⽅式数；

class Solution
{
    function all($n, $m)
    {
        $trace = []; // 组合值
        $ans = [];
        $this->backtrace($m, $n, $trace, $ans);
        return count($ans);
    }

    function backtrace($m, $n, $trace, &$ans)
    {
        $sum = array_sum($trace);
        $count = count($trace);
        if ($sum > $m || $count > $n) {
            return;
        }
        if ($sum === $m && $count === $n) {
            sort($trace);
            if (!in_array($trace, $ans, false)) {
                $ans[] = $trace;
            }
            return;
        }
        $arr = [1, 2, 5, 10];
        for ($i = 0; $i < 4; $i++) {
            $trace[] = $arr[$i];
            $this->backtrace($m, $n, $trace, $ans);
            array_pop($trace);
        }
    }
}


$s = new Solution();

//var_dump($s->all(1, 1)); // 1
//var_dump($s->all(3, 3)); // 1
var_dump($s->all(5, 10)); // 1