<?php


// 二进制手表顶部有 4 个 LED 代表小时（0-11），底部的 6 个 LED 代表分钟（0-59）。
//
//每个 LED 代表一个 0 或 1，最低位在右侧。
//
//
//
//例如，上面的二进制手表读取 “3:25”。
//
//给定一个非负整数 n 代表当前 LED 亮着的数量，返回所有可能的时间。
//
//案例:
//
//输入: n = 1
//返回: ["1:00", "2:00", "4:00", "8:00", "0:01", "0:02", "0:04", "0:08", "0:16", "0:32"]
// 
//
//注意事项:
//
//输出的顺序没有要求。
//小时不会以零开头，比如 “01:00” 是不允许的，应为 “1:00”。
//分钟必须由两位数组成，可能会以零开头，比如 “10:2” 是无效的，应为 “10:02”。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/binary-watch
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 位运算解决
     * @param $num
     */
    function readBinaryWatch($num)
    {
        $res = [];
        for ($i = 0; $i < 12; $i++) {
            $countI = $this->count1($i);
            for ($j = 0; $j < 60; $j++) {
                if ($countI + $this->count1($j) === $num) {
                    $res[] = $i . ':' . ($j < 10 ? '0' . $j : $j);
                }
            }
        }
        return $res;
    }

    function count1($num)
    {
        $count = 0;
        while ($num !== 0) {
            $count++;
            $num &= ($num - 1);
        }
        return $count;
    }


    /**
     * @param Integer $num
     * @return String[]
     */
    function readBinaryWatch1($num)
    {
        $nums = [1, 2, 4, 8, 1, 2, 4, 8, 16, 32];
        $ans = [];
        $this->backtrack($num, $nums, [], $ans);
        return $ans;
    }

    function backtrack($num, $nums, $trace, &$ans)
    {
        $traceLen = count($trace);
        if ($traceLen > $num) {
            return;
        }
        $hours = 0;
        $minutes = 0;
        // 计算当前的数值
        for ($i = 0; $i < $traceLen; $i++) {
            $index = $trace[$i];
            if ($index < 4) {
                $hours += $nums[$index];
            } else {
                $minutes += $nums[$index];
            }
        }
        if ($traceLen === $num) {
            $str = $hours . ':' . ($minutes < 10 ? '0' . $minutes : $minutes);
            if (!in_array($str, $ans, true)) {
                $ans[] = $str;
            }
            return;
        }
        for ($i = 0; $i < 10; $i++) {
            if (!in_array($i, $trace, true)) {
                if ($i < 4 && $hours + $nums[$i] > 11) {
                    continue;
                }
                if ($i >= 4 && $minutes + $nums[$i] > 59) {
                    continue;
                }
                $trace[] = $i;
                $this->backtrack($num, $nums, $trace, $ans);
                array_pop($trace);
            }
        }
    }
}

$s = new Solution();

var_dump($s->readBinaryWatch(1));
var_dump($s->readBinaryWatch(2));