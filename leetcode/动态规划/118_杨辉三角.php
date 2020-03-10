<?php

// 给定一个非负整数 numRows，生成杨辉三角的前 numRows 行。
//
//
//
//在杨辉三角中，每个数是它左上方和右上方的数的和。
//
//示例:
//
//输入: 5
//输出:
//[
//     [1],
//    [1,1],
//   [1,2,1],
//  [1,3,3,1],
// [1,4,6,4,1]
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/pascals-triangle
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class Solution
{

    /**
     * 循环即可, 注意要初始化最开始的1和最后的1
     * 优化: 杨辉三角是左右对称的
     * 时间复杂度: O(numRows^2)
     * 空间复杂度: O(numRows^2)
     * @param Integer $numRows
     * @return Integer[][]
     */
    function generate($numRows)
    {
        if ($numRows === 0) {
            return [];
        }
        $ans = [[1]];
        for ($i = 1; $i < $numRows; $i++) {
            $ans[$i] = [1];
            $left = 1;
            while ($left < $i) {
                $ans[$i][$left] = $ans[$i - 1][$left - 1] + $ans[$i - 1][$left];
                $left++;
            }
            $ans[$i][$i] = 1;
        }
        return $ans;
    }
}

$s = new Solution();

// 输入: 5
//输出:
//[
//     [1],
//    [1,1],
//   [1,2,1],
//  [1,3,3,1],
// [1,4,6,4,1]
//]
var_dump($s->generate(5));
var_dump($s->generate(0));
var_dump($s->generate(1));
var_dump($s->generate(2));