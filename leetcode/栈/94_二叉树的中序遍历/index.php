<?php

// 给定一个二叉树，返回它的中序 遍历。
//
//示例:
//
//输入: [1,null,2,3]
//   1
//    \
//     2
//    /
//   3
//
//输出: [1,3,2]
//进阶: 递归算法很简单，你可以通过迭代算法完成吗？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/binary-tree-inorder-traversal
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 使用栈来实现迭代中序遍历
// 当处理一个节点的时候:
// 1. 如果节点不为空, 则入栈, 并将当前处理节点切换为left
// 2. 如果节点为空, 则出栈(中节点), 并保存值, 然后当前处理节点切换为right
// 3. 当栈不为空或者当前节点不为空时循环1,2步

// 栈通常用在需要回退操作的算法上
// 在这道题中, 中序遍历需要 左->中->右 的顺序来读取值, 在读中节点时, 需要保存中节点, 然后去操作左节点, 回退到中节点记录值, 然后操作右节点

class TreeNode {
     public $val = null;
     public $left = null;
     public $right = null;
     function __construct($value) { $this->val = $value; }
}

class Solution {

    /**
     * @param TreeNode $root
     * @return Integer[]
     */
    function inorderTraversal($root) {
        $arr = [];
        $stack = [];
        /** @var TreeNode $curNode */
        $curNode = $root;
        while ($curNode !== null || !empty($stack)) {
            if ($curNode !== null) {
                $stack[] = $curNode;
                $curNode = $curNode->left;
            } else {
                $curNode = array_pop($stack);
                $arr[] = $curNode->val;
                $curNode = $curNode->right;
            }
        }
        return $arr;
    }

    /**
     * @param TreeNode|null $root
     * @return array
     */
    function inorderTraversal2($root) {
        if ($root === null ){
            return [];
        }
        return array_merge($this->inorderTraversal2($root->left), [$root->val], $this->inorderTraversal2($root->right));
    }
}

$s = new Solution();
$root = new TreeNode(1);
$root->right = new TreeNode(2);
$root->right->left = new TreeNode(3);
print_r($s->inorderTraversal($root)); // [1, 3, 2]
print_r($s->inorderTraversal2($root)); // [1, 3, 2]