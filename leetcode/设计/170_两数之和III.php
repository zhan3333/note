<?php

// 设计并实现一个 TwoSum 的类，使该类需要支持 add 和 find 的操作。
//
//add 操作 -  对内部数据结构增加一个数。
//find 操作 - 寻找内部数据结构中是否存在一对整数，使得两数之和与给定的数相等。
//
//示例 1:
//
//add(1); add(3); add(5);
//find(4) -> true
//find(7) -> false
//示例 2:
//
//add(3); add(1); add(2);
//find(3) -> true
//find(6) -> false
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/two-sum-iii-data-structure-design
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//————————————————
//版权声明：本文为CSDN博主「暴躁老哥在线刷题」的原创文章，遵循 CC 4.0 BY-SA 版权协议，转载请附上原文出处链接及本声明。
//原文链接：https://blog.csdn.net/qq_32424059/article/details/95550610

class Solution
{
    private $map = [];

    function add($num)
    {
        if (isset($this->map[$num])) {
            $this->map[$num]++;
        } else {
            $this->map[$num] = 1;
        }
    }

    /**
     * 时间复杂度: O(n)
     * 空间复杂度: O(n)
     * @param $num
     * @return bool
     */
    function find($num)
    {
        foreach ($this->map as $key => $value) {
            $target = $num - $this->map[$key];
            if (isset($this->map[$target])) {
                return true;
            }
        }
        return false;
    }
}

$s = new Solution();
$s->add(1);
$s->add(3);
$s->add(5);
var_dump($s->find(4)); // true
var_dump($s->find(7)); // false