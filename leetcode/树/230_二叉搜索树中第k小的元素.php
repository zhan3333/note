<?php

// 给定一个二叉搜索树，编写一个函数 kthSmallest 来查找其中第 k 个最小的元素。
//
//说明：
//你可以假设 k 总是有效的，1 ≤ k ≤ 二叉搜索树元素个数。
//
//示例 1:
//
//输入: root = [3,1,4,null,2], k = 1
//   3
//  / \
// 1   4
//  \
//   2
//输出: 1
//示例 2:
//
//输入: root = [5,3,6,2,4,null,null,1], k = 3
//       5
//      / \
//     3   6
//    / \
//   2   4
//  /
// 1
//输出: 3
//进阶：
//如果二叉搜索树经常被修改（插入/删除操作）并且你需要频繁地查找第 k 小的值，你将如何优化 kthSmallest 函数？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/kth-smallest-element-in-a-bst
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
     * 中序遍历第k个即为最小的数
     * @param TreeNode $root
     * @param Integer $k
     * @return Integer
     */
    function kthSmallest($root, $k)
    {
        $stack = [[$root, false]];
        $count = 0;
        while (!empty($stack)) {
            [$node, $visited] = array_pop($stack);
            if ($node === null) {
                continue;
            }
            if ($visited) {
                $count++;
                if ($count === $k) {
                    return $node->val;
                }
            } else {
                $stack[] = [$node->right, false];
                $stack[] = [$node, true];
                $stack[] = [$node->left, false];
            }
        }
        return -1;
    }
}

$s = new Solution();

$t = new TreeNode(3);
$t->left = new TreeNode(1);
$t->left->right = new TreeNode(2);
$t->right = new TreeNode(4);

var_dump($s->kthSmallest($t, 1)); // 1
var_dump($s->kthSmallest($t, 2)); // 2
var_dump($s->kthSmallest($t, 3)); // 3
var_dump($s->kthSmallest($t, 4)); // 4
var_dump($s->kthSmallest($t, 5)); // -1

