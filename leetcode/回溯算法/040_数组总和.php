<?php

// 给定一个数组 candidates 和一个目标数 target ，找出 candidates 中所有可以使数字和为 target 的组合。
//
//candidates 中的每个数字在每个组合中只能使用一次。
//
//说明：
//
//所有数字（包括目标数）都是正整数。
//解集不能包含重复的组合。 
//示例 1:
//
//输入: candidates = [10,1,2,7,6,1,5], target = 8,
//所求解集为:
//[
//  [1, 7],
//  [1, 2, 5],
//  [2, 6],
//  [1, 1, 6]
//]
//示例 2:
//
//输入: candidates = [2,5,2,1,2], target = 5,
//所求解集为:
//[
//  [1,2,2],
//  [5]
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/combination-sum-ii
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class Solution
{

    /**
     * 时间复杂度: O(n!), 元素不能重复只用, 所以每层都会少一个元素
     * 空间复杂度啊: O(n), 只保存 trace 路径. 如果说要储存所有的过程的话, 空间复杂度就为 O(2**n) 或者 O(n!)
     * @param Integer[] $candidates
     * @param Integer $target
     * @return Integer[][]
     */
    function combinationSum2($candidates, $target)
    {
        sort($candidates); // nLog(n)
        $ans = [];
        $this->backtrack($candidates, $target, 0, [], $ans);
        return $ans;
    }

    function backtrack($candidates, $target, $start, $trace, &$ans)
    {
        $sum = array_sum($trace);
        if ($sum === $target) {
            // 这里判断不需要去重了, 因为重复值在[剪枝2]的时候去掉了
            $ans[] = $trace;
            return;
        }
        $len = count($candidates);
        for ($i = $start; $i < $len; $i++) {
            // 剪枝1: 已经大于的数跳过, 后面的数更加大于结果了, 没必要继续
            if ($candidates[$i] + $sum > $target) {
                break;
            }
            // 剪枝2: 除了第一个数外, 后边的数遇到与前一个数相同的, 减掉, 因为 trace 一致
            if ($i > $start && $candidates[$i] === $candidates[$i - 1]) {
                continue;
            }
            $trace[] = $candidates[$i];
            $this->backtrack($candidates, $target, $i + 1, $trace, $ans);
            array_pop($trace);
        }
    }
}


$s = new Solution();

//所求解集为:
//[
//  [1, 7],
//  [1, 2, 5],
//  [2, 6],
//  [1, 1, 6]
//]
var_dump($s->combinationSum2([10, 1, 2, 7, 6, 1, 5], 8));