<?php

// 编写一个算法来判断一个数是不是“快乐数”。
//
//一个“快乐数”定义为：对于一个正整数，每一次将该数替换为它每个位置上的数字的平方和，然后重复这个过程直到这个数变为 1，也可能是无限循环但始终变不到 1。如果可以变为 1，那么这个数就是快乐数。
//
//示例: 
//
//输入: 19
//输出: true
//解释:
//12 + 92 = 82
//82 + 22 = 68
//62 + 82 = 100
//12 + 02 + 02 = 1
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/happy-number
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * @param Integer $n
     * @return Boolean
     */
    function isHappy($n)
    {
        $fast = $n;
        $slow = $n;
        do {
            $slow = $this->squareSum($slow);
            $fast = $this->squareSum($fast);
            $fast = $this->squareSum($fast);
        } while ($slow !== $fast);
        return $slow === 1;
    }

    function squareSum($m)
    {
        $squareSum = 0;
        while ($m !== 0) {
            $squareSum += ($m % 10) * ($m % 10);
            $m = (int)($m / 10);
        }
        return $squareSum;
    }
}

$s = new Solution();
var_dump($s->isHappy(19)); // true