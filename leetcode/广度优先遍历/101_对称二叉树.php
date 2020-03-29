<?php

// 给定一个二叉树，检查它是否是镜像对称的。
//
//例如，二叉树 [1,2,2,3,4,4,3] 是对称的。
//
//    1
//   / \
//  2   2
// / \ / \
//3  4 4  3
//但是下面这个 [1,2,2,null,3,null,3] 则不是镜像对称的:
//
//    1
//   / \
//  2   2
//   \   \
//   3    3
//说明:
//
//如果你可以运用递归和迭代两种方法解决这个问题，会很加分。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/symmetric-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//
// 思路
// 使用先序遍历, 每次pop两个节点出来检查, 入栈两个节点的子节点, 按照 a->left, b->right, a->right, b->left 这样的对称形式入栈
// false条件, pop出来的节点之一是null || 两节点val不相等

class TreeNode
{
    public $val = null;
    public $left = null;
    public $right = null;

    function __construct($value)
    {
        $this->val = $value;
    }
}

/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($value) { $this->val = $value; }
 * }
 */
class Solution
{

    /**
     * 递归做法
     *
     * @param $root
     * @return bool
     */
    function isSymmetric($root)
    {
        return $this->same($root, $root);
    }

    function same($t1, $t2)
    {
        if ($t1 === null && $t2 === null) {
            return true;
        }
        if ($t1 === null || $t2 === null || ($t1->val !== $t2->val)) {
            return false;
        }
        return $this->same($t1->left, $t2->right) && $this->same($t1->right, $t2->left);
    }

    /**
     * 先序遍历做法
     * 时间复杂度: O(n)
     * 空间复杂度: 最糟糕O(n), 和树的高度有关, 最糟糕情况树是线性的
     * @param TreeNode $root
     * @return Boolean
     */
    function isSymmetric1($root)
    {
        if ($root === null) return true;
        $stack = [$root->left, $root->right];
        while (!empty($stack)) {
            $p1 = array_pop($stack);
            $p2 = array_pop($stack);
            if ($p1 === null && $p2 === null) {
                continue;
            }
            if ($p1 === null || $p2 === null || ($p1->val !== $p2->val)) {
                return false;
            }
            // 关键点在于入栈的顺序
            $stack[] = $p1->left;
            $stack[] = $p2->right;
            $stack[] = $p1->right;
            $stack[] = $p2->left;
        }
        return true;
    }

    /**
     * 广度优先遍历, 能更早的发现不对称
     * @param $root
     * @return bool
     */
    function isSymmetric2($root)
    {
        $queue = [$root];
        while (!empty($queue)) {
            $n = count($queue);
            $arr = [];
            for ($i = 0; $i < $n; $i++) {
                $node = array_shift($queue);
                $arr[] = $node->val ?? PHP_INT_MIN;
                if ($node !== null) {
                    $queue[] = $node->left;
                    $queue[] = $node->right;
                }
            }
            $mid = (int)($n / 2);
            for ($i = 0; $i <= $mid; $i++) {
                if ($arr[$i] !== $arr[$n - $i - 1]) {
                    return false;
                }
            }
        }
        return true;
    }
}

$s = new Solution();

$p = new TreeNode(1);
$p->left = new TreeNode(2);
$p->right = new TreeNode(3);

$q = new TreeNode(1);
$q->left = new TreeNode(2);
$q->right = new TreeNode(2);


var_dump($s->isSymmetric($p));  // false
var_dump($s->isSymmetric($q));  // true