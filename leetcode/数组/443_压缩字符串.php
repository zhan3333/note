<?php

// 给定一组字符，使用原地算法将其压缩。
//
//压缩后的长度必须始终小于或等于原数组长度。
//
//数组的每个元素应该是长度为1 的字符（不是 int 整数类型）。
//
//在完成原地修改输入数组后，返回数组的新长度。
//
// 
//
//进阶：
//你能否仅使用O(1) 空间解决问题？
//
// 
//
//示例 1：
//
//输入：
//["a","a","b","b","c","c","c"]
//
//输出：
//返回6，输入数组的前6个字符应该是：["a","2","b","2","c","3"]
//
//说明：
//"aa"被"a2"替代。"bb"被"b2"替代。"ccc"被"c3"替代。
//示例 2：
//
//输入：
//["a"]
//
//输出：
//返回1，输入数组的前1个字符应该是：["a"]
//
//说明：
//没有任何字符串被替代。
//示例 3：
//
//输入：
//["a","b","b","b","b","b","b","b","b","b","b","b","b"]
//
//输出：
//返回4，输入数组的前4个字符应该是：["a","b","1","2"]。
//
//说明：
//由于字符"a"不重复，所以不会被压缩。"bbbbbbbbbbbb"被“b12”替代。
//注意每个数字在数组中都有它自己的位置。
//注意：
//
//所有字符都有一个ASCII值在[35, 126]区间内。
//1 <= len(chars) <= 1000。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/string-compression
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class Solution
{

    /**
     * 遍历一次数组, 时间复杂度: O(n)
     * 使用了一些常量, 空间复杂度: O(1)
     * @param String[] $chars
     * @return Integer
     */
    function compress(&$chars)
    {
        $chars[] = '!'; // 末尾加 # 作为结束符
        $i = 1;         // 读取点
        $savePoint = 0; // 保存点
        $len = count($chars);
        $char = $chars[0];
        $count = 1;
        while ($i < $len) {
            if ($chars[$i] !== $char) {
                $chars[$savePoint++] = $char;
                if ($count > 1) {
                    foreach (str_split((string)$count) as $item) {
                        $chars[$savePoint++] = $item;
                    }
                }
                $count = 1;
                $char = $chars[$i];
            } else {
                $count++;
            }
            $i++;
        }
        $chars = array_slice($chars, 0, $savePoint);
    }
}

$s = new Solution();

$nums = ["a", "a", "b", "b", "c", "c", "c"];
$s->compress($nums);
var_dump($nums);
$nums = ["a", "b", "b", "b", "b", "b", "b", "b", "b", "b", "b", "b", "b"];

$s->compress($nums);
var_dump($nums);