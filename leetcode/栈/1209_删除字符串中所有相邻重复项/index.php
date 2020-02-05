<?php

// 给你一个字符串 s，「k 倍重复项删除操作」将会从 s 中选择 k 个相邻且相等的字母，并删除它们，使被删去的字符串的左侧和右侧连在一起。
//
//你需要对 s 重复进行无限次这样的删除操作，直到无法继续为止。
//
//在执行完所有删除操作后，返回最终得到的字符串。
//
//本题答案保证唯一。
//
// 
//
//示例 1：
//
//输入：s = "abcd", k = 2
//输出："abcd"
//解释：没有要删除的内容。
//示例 2：
//
//输入：s = "deeedbbcccbdaa", k = 3
//输出："aa"
//解释：
//先删除 "eee" 和 "ccc"，得到 "ddbbbdaa"
//再删除 "bbb"，得到 "dddaa"
//最后删除 "ddd"，得到 "aa"
//示例 3：
//
//输入：s = "pbbcggttciiippooaais", k = 2
//输出："ps"
// 
//
//提示：
//
//1 <= s.length <= 10^5
//2 <= k <= 10^4
//s 中只含有小写英文字母。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/remove-all-adjacent-duplicates-in-string-ii
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


// 思路
// 使用栈
// 遍历字符串, 当top与cur不相等时, 清空栈, push cur
// 当count===$key时, 置这$key个位置为., 然后清空栈, 继续
// 当字符串中有.符号时, 替换成空, 然后进入下一个循环, 否则break

class Solution {

    /**
     * @param String $s
     * @param Integer $k
     * @return String
     */
    function removeDuplicates($s, $k) {
        do {
            $stack = [];
            $hasReplace = false;
            for ($i = 0, $count = strlen($s); $i < $count; $i ++) {
                $c = $s[$i];
                if (empty($stack)) {
                    $stack[] = $c;
                } else if ($stack[count($stack) - 1] !== $c) {
                    $stack = [$c];
                } else {
                    $stack[] = $c;
                    if (count($stack) === $k) {
                        // k 个重复了, 置为.
                        for ($j = 0; $j < $k; $j ++) {
                            $s[$i - $k + 1 + $j] = '.';
                        }
                        $stack = []; // 栈清空
                        $hasReplace = true;
                    }
                }
            }
            $s = str_replace('.', '', $s);
        } while($hasReplace);
        return $s;
    }
}

$s = new Solution();
var_dump(1, $s->removeDuplicates('abcd',2)); // abcd
var_dump(2, $s->removeDuplicates('deeedbbcccbdaa', 3)); // aa
var_dump(3, $s->removeDuplicates('pbbcggttciiippooaais', 2)); // ps


