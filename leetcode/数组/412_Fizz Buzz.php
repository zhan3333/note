<?php

// 写一个程序，输出从 1 到 n 数字的字符串表示。
//
//1. 如果 n 是3的倍数，输出“Fizz”；
//
//2. 如果 n 是5的倍数，输出“Buzz”；
//
//3.如果 n 同时是3和5的倍数，输出 “FizzBuzz”。
//
//示例：
//
//n = 15,
//
//返回:
//[
//    "1",
//    "2",
//    "Fizz",
//    "4",
//    "Buzz",
//    "Fizz",
//    "7",
//    "8",
//    "Fizz",
//    "Buzz",
//    "11",
//    "Fizz",
//    "13",
//    "14",
//    "FizzBuzz"
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/fizz-buzz
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * @param Integer $n
     * @return String[]
     */
    function fizzBuzz($n)
    {
        $arr = [];
        $count3 = 0;
        $count5 = 0;
        for ($i = 1; $i <= $n; $i++) {
            $count3++;
            $count5++;
            if ($count3 === 3 && $count5 === 5) {
                $arr[] = 'FizzBuzz';
                $count3 = 0;
                $count5 = 0;
            } elseif ($count3 === 3) {
                $arr[] = 'Fizz';
                $count3 = 0;
            } elseif ($count5 === 5) {
                $arr[] = 'Buzz';
                $count5 = 0;
            } else {
                $arr[] = '' . $i;
            }
        }
        return $arr;
    }
}

$s = new Solution();

var_dump($s->fizzBuzz(15));