<?php

// 给定一个二叉树，返回其节点值的锯齿形层次遍历。（即先从左往右，再从右往左进行下一层遍历，以此类推，层与层之间交替进行）。
//
//例如：
//给定二叉树 [3,9,20,null,null,15,7],
//
//    3
//   / \
//  9  20
//    /  \
//   15   7
//返回锯齿形层次遍历如下：
//
//[
//  [3],
//  [20,9],
//  [15,7]
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/binary-tree-zigzag-level-order-traversal
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 按层来遍历, 需要使用两个栈来分别储存不同层, 处理一层时, 子节点就储存到另一个栈, 依次执行

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
     * 栈实现
     * @param TreeNode $root
     * @return Integer[][]
     */
    function zigzagLevelOrder($root)
    {
        if ($root === null) {
            return [];
        }
        $stack = [
            [],
            [],
        ];
        $flag = 0;
        $cur = $root;
        $result = [];
        $buf = [];
        do {
            $buf[] = $cur->val;
            if ($flag === 0) {
                // 先左后右
                if ($cur->left !== null) $stack[$flag][] = $cur->left;
                if ($cur->right !== null) $stack[$flag][] = $cur->right;
            } else {
                if ($cur->right !== null) $stack[$flag][] = $cur->right;
                if ($cur->left !== null) $stack[$flag][] = $cur->left;
            }
            if (!empty($stack[1 - $flag])) {
                // 若果另一个栈不为空, 则pop出来当做cur
                $cur = array_pop($stack[1 - $flag]);
            } else {
                // 这一层处理完了, 需要入栈
                if (count($buf) !== 0) {
                    $result[] = $buf;
                }
                $buf = [];
                $cur = array_pop($stack[$flag]);
                $flag = 1 - $flag;
            }
        } while ($cur !== null);
        return $result;
    }
}

$s = new Solution();
$root = new TreeNode(3);
$root->left = new TreeNode(20);
$root->right = new TreeNode(9);
$root->right->left = new TreeNode(15);
$root->right->right = new TreeNode(7);


//[
//  [3],
//  [20,9],
//  [15,7]
//]
print_r($s->zigzagLevelOrder($root));

