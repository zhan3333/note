<?php

// 某公司内有 4 个项⽬组，项⽬组 A、B、C、D，项⽬组A现有10⼈，项⽬组B现有7⼈，项⽬组C现
//有5⼈，项⽬组D现有4⼈。为了实现跨项⽬组协作，公司决定每⽉从⼈数最多的项⽬组中抽调 3 ⼈
//出来，到其他剩下 3 组中，每组 1 ⼈，这称之为⼀次调整优化（亦即经过第⼀次调整后，A组有7
//⼈，B组有8⼈，C组有6⼈，D组有5⼈）。
//那么请问，经过⼗年的优化调整后，各项⽬组各有⼏⼈？
//编程求解该问题，并思考是否为最优解。

class Solution
{
    /**
     * @param $arr
     * @param $months
     * @return mixed
     */
    function teamOptimization($arr, $months)
    {
        $len = count($arr);
        if ($months <= 0 || $len < 2) {
            return $arr;
        }
        while ($months > 4) {
            $months %= 4;
        }
        if ($months === 0) {
            $months = 4;
        }
        // 实际上对于符合题目规则的任意四个数,
        // 都是4个月一循环, 下面的 while 还可以在类中直接缓存起来,
        // 可以避免每次对同样数据不同的months调用时循环
        while ($months > 0) {
            $maxIndex = 0;
            for ($i = 1; $i < $len; $i++) {
                if ($arr[$i] > $arr[$maxIndex]) {
                    $maxIndex = $i;
                }
                $arr[$i]++;
            }
            $arr[0]++;
            $arr[$maxIndex] -= 4;
            $months--;
        }
        return $arr;
    }
}

$s = new Solution();

var_dump($s->teamOptimization([10, 7, 5, 4], -1)); // 10, 7, 5, 4
var_dump($s->teamOptimization([10, 7, 5, 4], 0)); // 10, 7, 5, 4
var_dump($s->teamOptimization([10, 7, 5, 4], 1)); // 7, 8, 6, 5
var_dump($s->teamOptimization([10, 7, 5, 4], 2)); // 8, 5, 7, 6
var_dump($s->teamOptimization([10, 7, 5, 4], 10 * 12)); // 6, 7, 5, 8