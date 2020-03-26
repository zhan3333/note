<?php

// https://leetcode-cn.com/problems/available-captures-for-rook/

class Solution
{

    /**
     * @param String[][] $board
     * @return Integer
     */
    function numRookCaptures($board)
    {
        $count = 0;
        for ($i = 0; $i < 8; $i++) {
            for ($j = 0; $j < 8; $j++) {
                if ($board[$i][$j] === 'R') {
                    $top = $i - 1;
                    $bottom = $i + 1;
                    $left = $j - 1;
                    $right = $j + 1;
                    while ($top >= 0) {
                        if ($board[$top][$j] === 'B') {
                            break;
                        }
                        if ($board[$top][$j] === 'p') {
                            $count++;
                            break;
                        }
                        $top--;
                    }
                    while ($bottom < 8) {
                        if ($board[$bottom][$j] === 'B') {
                            break;
                        }
                        if ($board[$bottom][$j] === 'p') {
                            $count++;
                            break;
                        }
                        $bottom++;
                    }
                    while ($left >= 0) {
                        if ($board[$i][$left] === 'B') {
                            break;
                        }
                        if ($board[$i][$left] === 'p') {
                            $count++;
                            break;
                        }
                        $left--;
                    }
                    while ($right < 8) {
                        if ($board[$i][$right] === 'B') {
                            break;
                        }
                        if ($board[$i][$right] === 'p') {
                            $count++;
                            break;
                        }
                        $right++;
                    }
                }
            }
        }
        return $count;
    }
}

$s = new Solution();
$board = [
    [".", ".", ".", ".", ".", ".", ".", "."],
    [".", ".", ".", "p", ".", ".", ".", "."],
    [".", ".", ".", "R", ".", ".", ".", "p"],
    [".", ".", ".", ".", ".", ".", ".", "."],
    [".", ".", ".", ".", ".", ".", ".", "."],
    [".", ".", ".", "p", ".", ".", ".", "."],
    [".", ".", ".", ".", ".", ".", ".", "."],
    [".", ".", ".", ".", ".", ".", ".", "."]
];
var_dump($s->numRookCaptures($board));