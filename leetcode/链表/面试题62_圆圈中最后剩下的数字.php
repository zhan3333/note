<?php

// 0,1,,n-1这n个数字排成一个圆圈，从数字0开始，每次从这个圆圈里删除第m个数字。求出这个圆圈里剩下的最后一个数字。
//
//例如，0、1、2、3、4这5个数字组成一个圆圈，从数字0开始每次删除第3个数字，则删除的前4个数字依次是2、0、4、1，因此最后剩下的数字是3。
//
// 
//
//示例 1：
//
//输入: n = 5, m = 3
//输出: 3
//示例 2：
//
//输入: n = 10, m = 17
//输出: 2
// 
//
//限制：
//
//1 <= n <= 10^5
//1 <= m <= 10^6
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/yuan-quan-zhong-zui-hou-sheng-xia-de-shu-zi-lcof
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class ListNode
{
    /** @var ListNode */
    public $next = null;
    /** @var ListNode */
    public $prev = null;
    public $val = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}

class Solution
{

    /**
     * todo 超时了
     * @param Integer $n
     * @param Integer $m
     * @return Integer
     */
    function lastRemaining($n, $m)
    {
        $head = new ListNode(0);
        $cur = $head;
        for ($i = 1; $i < $n; $i++) {
            $new = new ListNode($i);
            $cur->next = $new;
            $new->prev = $cur;
            $cur = $cur->next;
        }
        $cur->next = $head;
        $head->prev = $cur;
        $cur = $head;
        while ($cur->next !== $cur) {
            $count = $m;
            while ($count > 1) {
                $cur = $cur->next;
                $count--;
            }
            // unset cur
            $prev = $cur->prev;
            $next = $cur->next;
            $prev->next = $next;
            $next->prev = $prev;
            $cur = $next;
        }
        return $cur->val;
    }

}

$s = new Solution();

var_dump($s->lastRemaining(5, 3)); // 3
var_dump($s->lastRemaining(10, 17)); // 2