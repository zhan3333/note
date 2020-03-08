<?php

// 假设你正在爬楼梯。需要 n 阶你才能到达楼顶。
//
//每次你可以爬 1 或 2 个台阶。你有多少种不同的方法可以爬到楼顶呢？
//
//注意：给定 n 是一个正整数。
//
//示例 1：
//
//输入： 2
//输出： 2
//解释： 有两种方法可以爬到楼顶。
//1.  1 阶 + 1 阶
//2.  2 阶
//示例 2：
//
//输入： 3
//输出： 3
//解释： 有三种方法可以爬到楼顶。
//1.  1 阶 + 1 阶 + 1 阶
//2.  1 阶 + 2 阶
//3.  2 阶 + 1 阶
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/climbing-stairs
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 假设要爬 10 阶, 到第10阶的前一步要么是从第8阶走两步, 或者第9阶走一步, 故 f(10) = f(8) + f(9)
// 使用递归可以很好的完成这个问题
// 1. 截止条件 n <= 2
// 2. 递推公式 f(n) = f(n-1) + f(n-2)
// 递归有一个缺点, 会重复计算, 等会儿使用的时候回看到

class Solution
{

    /**
     * 动态规划方法
     * 时间复杂度: O(n)
     * 空间复杂度: O(n)
     * @param $n
     * @return mixed
     */
    function climbStairs($n)
    {
        $dp[1] = 1;
        $dp[2] = 2;
        $i = 3;
        while ($i <= $n) {
            $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
            $i++;
        }
        return $dp[$n];
    }

    /**
     * 直接递归法
     * 时间复杂度: O(2^n)) 树形递归的时间复杂度为 O(2^n)
     * 空间复杂度: O(n) 和树的层数有关
     * @param Integer $n
     * @return Integer
     */
    function climbStairs1($n)
    {
        if ($n === 1) {
            return 1;
        }
        if ($n === 2) {
            return 2;
        }
        return $this->climbStairs1($n - 1) + $this->climbStairs1($n - 2);
    }
}

$s = new Solution();

var_dump($s->climbStairs(2));  // 2
var_dump($s->climbStairs(3));  // 3