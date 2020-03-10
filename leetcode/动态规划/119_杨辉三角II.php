<?php

// 给定一个非负索引 k，其中 k ≤ 33，返回杨辉三角的第 k 行。
//
//
//
//在杨辉三角中，每个数是它左上方和右上方的数的和。
//
//示例:
//
//输入: 3
//输出: [1,3,3,1]

class Solution
{

    /**
     * 动态规划, 要想优化到空间 O(k), 可以考虑重复利用数组
     * @param Integer $rowIndex
     * @return Integer[]
     */
    function getRow($rowIndex)
    {
        if ($rowIndex === 0) return [1];
        $arr = [1, 1];
        $line = 2;
        while ($line <= $rowIndex) {
            $temp = $arr;
            for ($i = 1; $i < $line; $i++) {
                $arr[$i] = $temp[$i - 1] + $temp[$i];
            }
            $arr[$line] = 1;
            $line++;
        }
        return $arr;
    }
}

$s = new Solution();
var_dump($s->getRow(3));