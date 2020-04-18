<?php

// 给定一个整数 n，求以 1 ... n 为节点组成的二叉搜索树有多少种？
//
//示例:
//
//输入: 3
//输出: 5
//解释:
//给定 n = 3, 一共有 5 种不同结构的二叉搜索树:
//
//   1         3     3      2      1
//    \       /     /      / \      \
//     3     2     1      1   3      2
//    /     /       \                 \
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/unique-binary-search-trees
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 卡特兰数
     * C(n+1) = 2 * C(n) *(2n + 1) / (n + 2)
     * @param $n
     * @return float|int
     */
    function numTrees($n)
    {
        $c = 1;
        for ($i = 0; $i < $n; $i++) {
            $c = $c * 2 * (2 * $i + 1) / ($i + 2);
        }
        return $c;
    }

    /**
     * 动态规划
     * 分别以           1, 2, 3, ..., n 为根节点, 那么
     * 左节点数量分别为: 0, 1, 2, ...., n-1
     * 右节点数量分别为: n-1, n-2, n-3, ..., 0
     * 可得 f(n) = f(0)*f(n-1) + f(1)*f(n-2) + ... + f(n-1)*f(0)
     * 设置 dp[0] = 1; dp[1] = 1; dp[2] = 2;
     * 可以递推后面的值
     * @param Integer $n
     * @return Integer
     */
    function numTrees1($n)
    {
        $dp = [1, 1, 2];
        $i = 3;
        while ($i <= $n) {
            $sum = 0;
            for ($j = 0; $j < $i; $j++) {
                $sum += $dp[$j] * $dp[$i - $j - 1];
            }
            $dp[$i] = $sum;
            $i++;
        }
        return $dp[$n];
    }
}