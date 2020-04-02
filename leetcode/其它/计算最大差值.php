<?php

// 有两组数，第⼀组数顺序固定，请编程实现让第⼆组数 相邻数字间的⼤⼩关系和第⼀组数相同，且
// 第⼆组相邻数字间的差值之和最⼤
// 下⾯给出⼀个示例
// 第⼀组数： 5 7 4 9
// 第⼆组数：1 2 3 4
// 第⼆组数排序结果：2 4 1 3
// 第⼆组数排序后的差值之和：7 = abs(2-4) + abs(4-1) + abs(1-3)

class Solution
{
    function maxSubVal($arr1, $arr2)
    {
        $len = count($arr1);
        if ($len < 2) {
            return $arr1;
        }
        if ($len !== count($arr2)) {
            return [];
        }
        // 进行回溯遍历所有可能
        $ans = [];
        for ($i = 0; $i < $len; $i++) {
            $this->backtrace($arr1, $arr2, [[$i, $arr2[$i]]], $ans);
        }
        // 对结果进行处理, 计算查询到差值最大的组合
        $map = [];
        $ansLen = count($ans);
        $max = 0;
        for ($i = 0; $i < $ansLen; $i++) {
            $sum = 0;
            for ($j = 0; $j < $len - 1; $j++) {
                $sum += abs($ans[$i][$j] - $ans[$i][$j + 1]);
            }
            $map[$sum] = $ans[$i];
            $max = max($max, $sum);
        }
        return $map[$max] ?? [];
    }

    function backtrace($arr1, $arr2, $track, &$ans)
    {
        $trackLen = count($track); // 查询到第几位了
        $arrLen = count($arr1);
        // 一条路径走完
        if ($trackLen === count($arr1)) {
            $ans[] = array_column($track, 1);
            return;
        }
        $left = $trackLen - 1;
        $right = $trackLen;
        $trackLast = $track[$trackLen - 1];
        $useIndexs = array_map(function ($val) {
            return $val[0];
        }, $track);
        // 遍历可能的结果, 符合排序规则的进入下一层
        for ($i = 0; $i < $arrLen; $i++) {
            if (!in_array($i, $useIndexs, true)) {
                // 递增 / 递减 / 相等
                if (($arr1[$left] < $arr1[$right] && $trackLast[1] < $arr2[$i]) ||
                    ($arr1[$left] > $arr1[$right] && $trackLast[1] > $arr2[$i]) ||
                    ($arr1[$left] === $arr1[$right] && $trackLast[1] === $arr2[$i])
                ) {
                    $track[] = [$i, $arr2[$i]];
                    $this->backtrace($arr1, $arr2, $track, $ans);
                    array_pop($track);
                }
            }
        }
    }
}

$s = new Solution();
var_dump($s->maxSubVal([], [])); // 7
var_dump($s->maxSubVal([5, 7, 4, 9], [1, 2, 3, 4])); // 7
var_dump($s->maxSubVal([5, 7, 9, 9], [1, 2, 4, 4])); // 3