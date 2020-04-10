<?php

// 给定一个字符串，找到它的第一个不重复的字符，并返回它的索引。如果不存在，则返回 -1。
//
//案例:
//
//s = "leetcode"
//返回 0.
//
//s = "loveleetcode",
//返回 2.
// 
//
//注意事项：您可以假定该字符串只包含小写字母
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/first-unique-character-in-a-string
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 显然用hash表来做
     * 时间复杂度: O(n) 两次遍历
     * 空间复杂度: O(1) 辅助hash表最大长度为 26
     * @param String $s
     * @return Integer
     */
    function firstUniqChar($s)
    {
        $hash = [];
        $len = strlen($s);
        for ($i = $len - 1; $i >= 0; $i--) {
            if (!isset($hash[$s[$i]])) {
                $hash[$s[$i]] = 0;
            }
            $hash[$s[$i]]++;
        }
        for ($i = 0; $i < $len; $i++) {
            if ($hash[$s[$i]] === 1) {
                return $i;
            }
        }
        return -1;
    }
}

$s = new Solution();

var_dump($s->firstUniqChar('leetcode'));      // 0
var_dump($s->firstUniqChar('loveleetcode'));  // 2
