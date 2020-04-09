<?php

// 我们正在玩一个猜数字游戏。 游戏规则如下：
//我从 1 到 n 选择一个数字。 你需要猜我选择了哪个数字。
//每次你猜错了，我会告诉你这个数字是大了还是小了。
//你调用一个预先定义好的接口 guess(int num)，它会返回 3 个可能的结果（-1，1 或 0）：
//
//-1 : 我的数字比较小
// 1 : 我的数字比较大
// 0 : 恭喜！你猜对了！
//示例 :
//
//输入: n = 10, pick = 6
//输出: 6
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/guess-number-higher-or-lower
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

/**
 * The API guess is defined in the parent class.
 * @param num   your guess
 * @return         -1 if num is lower than the guess number
 *                  1 if num is higher than the guess number
 *               otherwise return 0
 * public function guess($num){}
 */
class Solution extends GuessGame
{
    /**
     * @param Integer $n
     * @return Integer
     */
    function guessNumber($n)
    {
        $start = 1;
        $end = $n;
        while ($start < $end) {
            $mid = (int)(($end - $start) / 2) + $start;
            $guess = $this->guess($mid);
            if ($guess === 0) {
                return $mid;
            } elseif ($guess === 1) {
                $start = $mid + 1;
            } else {
                $end = $mid - 1;
            }
        }
        return $start;
    }
}