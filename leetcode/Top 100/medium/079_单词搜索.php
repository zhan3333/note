<?php

// 给定一个二维网格和一个单词，找出该单词是否存在于网格中。
//
//单词必须按照字母顺序，通过相邻的单元格内的字母构成，其中“相邻”单元格是那些水平相邻或垂直相邻的单元格。同一个单元格内的字母不允许被重复使用。
//
// 
//
//示例:
//
//board =
//[
//  ['A','B','C','E'],
//  ['S','F','C','S'],
//  ['A','D','E','E']
//]
//
//给定 word = "ABCCED", 返回 true
//给定 word = "SEE", 返回 true
//给定 word = "ABCB", 返回 false
// 
//
//提示：
//
//board 和 word 中只包含大写和小写英文字母。
//1 <= board.length <= 200
//1 <= board[i].length <= 200
//1 <= word.length <= 10^3
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/word-search
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    private $ans = false;

    /**
     * 使用动态规划
     * @param $board
     * @param $word
     */
    function exist($board, $word)
    {

    }


    /**
     * 暴力图搜索
     * @param String[][] $board
     * @param String $word
     * @return Boolean
     */
    function exist1($board, $word)
    {
        $h = count($board);
        $w = count($board[0]);
        for ($i = 0; $i < $h; $i++) {
            for ($j = 0; $j < $w; $j++) {
                if ($this->find($board, $word, $j, $i, 0)) {
                    return true;
                }
            }
        }
        return false;
    }

    function find(&$board, &$word, $x, $y, $index)
    {
        if ($x < 0
            || $y < 0
            || $x > count($board[0]) - 1
            || $y > count($board) - 1
            || $board[$y][$x] !== $word[$index]
        ) {
            return false;
        }
        if ($board[$y][$x] === $word[$index] && $index === strlen($word) - 1) {
            // 最后一个字也匹配上了
            return true;
        }
        // 当前点设置为 null, 禁止走入
        $board[$y][$x] = null;
        $index++;
        $arr = [[-1, 0], [1, 0], [0, -1], [0, 1]];
        for ($i = 0; $i < 4; $i++) {
            if ($this->find($board, $word, $x + $arr[$i][0], $y + $arr[$i][1], $index)) {
                // 这里找到了结果要及时返回
                return true;
            }
        }
        return false;
    }
}