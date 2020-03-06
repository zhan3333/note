<?php

// 给定一个排序数组，你需要在原地删除重复出现的元素，使得每个元素只出现一次，返回移除后数组的新长度。
//
//不要使用额外的数组空间，你必须在原地修改输入数组并在使用 O(1) 额外空间的条件下完成。
//
//示例 1:
//
//给定数组 nums = [1,1,2],
//
//函数应该返回新的长度 2, 并且原数组 nums 的前两个元素被修改为 1, 2。
//
//你不需要考虑数组中超出新长度后面的元素。
//示例 2:
//
//给定 nums = [0,0,1,1,1,2,2,3,3,4],
//
//函数应该返回新的长度 5, 并且原数组 nums 的前五个元素被修改为 0, 1, 2, 3, 4。
//
//你不需要考虑数组中超出新长度后面的元素。
//说明:
//
//为什么返回数值是整数，但输出的答案是数组呢?
//
//请注意，输入数组是以“引用”方式传递的，这意味着在函数里修改输入数组对于调用者是可见的。
//
//你可以想象内部操作如下:
//
//// nums 是以“引用”方式传递的。也就是说，不对实参做任何拷贝
//int len = removeDuplicates(nums);
//
//// 在函数里修改输入数组对于调用者是可见的。
//// 根据你的函数返回的长度, 它会打印出数组中该长度范围内的所有元素。
//for (int i = 0; i < len; i++) {
//    print(nums[i]);
//}
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/remove-duplicates-from-sorted-array
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 该问题需要在原数组中进行操作
// 空间复杂度为 O(1)
// 一种思想是从数组的最后一个开始储存, 从后往前扫描, 当遇到后面存在的数字跳过, 不存在则依序往后储存

class Solution
{

    /**
     * 空间复杂度 O(1)
     * 时间复杂度 O(n) 遍历n步得到结果
     * @param Integer[] $nums
     * @return Integer 返回修改后数组的长度
     */
    function removeDuplicates(&$nums)
    {
        $len = count($nums);
        $i = 1;
        $saveI = 1;
        while ($i < $len) {
            if ($nums[$i] !== $nums[$saveI - 1]) {
                // 不是重复的数字, 需要移动到 saveI 点
                $nums[$saveI] = $nums[$i];
                $saveI++;
            }
            $i++;
        }
        // 移动完毕, 开头到 saveI 都是不重复的排序
        return $saveI;
    }
}

$s = new Solution();

$nums1 = [1, 1, 2];
var_dump($s->removeDuplicates($nums1)); // 2
var_dump($nums1);
//$nums2 = [0, 0, 1, 1, 1, 2, 2, 3, 3, 4];
//var_dump($s->removeDuplicates($nums2)); // 5
//var_dump($nums2);