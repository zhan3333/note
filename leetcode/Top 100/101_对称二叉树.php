<?php

// 给定一个二叉树，检查它是否是镜像对称的。
//
// 
//
//例如，二叉树 [1,2,2,3,4,4,3] 是对称的。
//
//    1
//   / \
//  2   2
// / \ / \
//3  4 4  3
// 
//
//但是下面这个 [1,2,2,null,3,null,3] 则不是镜像对称的:
//
//    1
//   / \
//  2   2
//   \   \
//   3    3
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/symmetric-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

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

class Solution
{
    /**
     * 使用递归
     * 时间复杂度: 遍历所有节点 O(n)
     * 空间复杂度: 每次递归都会对两个节点进行判断, 并且没有重复的, 所以空间复杂度为 O(n)
     * @param $root
     * @return bool
     */
    function isSymmetric($root)
    {
        if ($root === null) {
            return true;
        }
        return $this->isSame($root->left, $root->right);
    }

    function isSame($left, $right)
    {
        if ($left && $right) {
            return $left->val === $right->val
                && $this->isSame($left->left, $right->right)
                && $this->isSame($left->right, $right->left);
        }
        if ($left === null && $right === null) {
            return true;
        }
        return false;
    }

    /**
     * 用层序遍历+栈实现
     * 空间复杂度: 使用了栈+队列来储存每一层的数据, O(logN)
     * 时间复杂度: 遍历所有节点: O(n)
     * @param $root
     * @return bool
     */
    function isSymmetric1($root)
    {
        $queue = [$root];
        while (!empty($queue)) {
            $newQueue = [];
            $arr = [];
            while (!empty($queue)) {
                $node = array_shift($queue);
                if ($node !== null) {
                    $newQueue[] = $node->left;
                    $newQueue[] = $node->right;
                    $arr[] = $node->val;
                } else {
                    $arr[] = null;
                }
            }
            $queue = $newQueue;
            $len = count($arr);
            $mid = $len >> 1;
            for ($i = 0; $i < $mid; $i++) {
                if ($arr[$i] !== $arr[$len - $i - 1]) {
                    return false;
                }
            }
        }
        return true;
    }
}