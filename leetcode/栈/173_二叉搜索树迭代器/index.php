<?php

// 实现一个二叉搜索树迭代器。你将使用二叉搜索树的根节点初始化迭代器。
//
//调用 next() 将返回二叉搜索树中的下一个最小的数。
//
// 
//
//示例：
//      7
//     / \
//    3   15
//        / \
//       9  20
//
//
//
//BSTIterator iterator = new BSTIterator(root);
//iterator.next();    // 返回 3
//iterator.next();    // 返回 7
//iterator.hasNext(); // 返回 true
//iterator.next();    // 返回 9
//iterator.hasNext(); // 返回 true
//iterator.next();    // 返回 15
//iterator.hasNext(); // 返回 true
//iterator.next();    // 返回 20
//iterator.hasNext(); // 返回 false
//
//提示：
//
//next() 和 hasNext() 操作的时间复杂度是 O(1)，并使用 O(h) 内存，其中 h 是树的高度。
//你可以假设 next() 调用总是有效的，也就是说，当调用 next() 时，BST 中至少存在一个下一个最小的数。
//
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/binary-search-tree-iterator
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 二叉查找树的中序遍历是递增的
// 中序遍历: 左->中->右
// 需要实现O(h)内存的

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
class BSTIterator
{
    private $stack;
    /**
     * @param TreeNode $root
     */
    function __construct($root)
    {
        $this->push($root);
    }

    private function push($node) {
        while ($node !== null) {
            $this->stack[] = $node;
            $node = $node->left;
        }
    }

    /**
     * return the next smallest number
     * @return Integer
     */
    function next()
    {
        $pop = array_pop($this->stack);
        if ($pop->right !== null) {
            $this->push($pop->right);
        }
        return $pop->val;
    }

    /**
     * return whether we have a next smallest number
     * @return Boolean
     */
    function hasNext()
    {
        return !empty($this->stack);
    }
}

/**
 * Your BSTIterator object will be instantiated and called as such:
 * $obj = BSTIterator($root);
 * $ret_1 = $obj->next();
 * $ret_2 = $obj->hasNext();
 */

$root = new TreeNode(7);
$root->left = new TreeNode(3);
$root->right = new TreeNode(15);
$root->right->left = new TreeNode(9);
$root->right->right = new TreeNode(20);

$s = new BSTIterator($root);

var_dump($s->next());  // 3
var_dump($s->next());  // 7
var_dump($s->hasNext()); // true
var_dump($s->next()); // 9
var_dump($s->hasNext()); // true
var_dump($s->next()); // 15
var_dump($s->hasNext()); // true
var_dump($s->next()); // 20
var_dump($s->hasNext()); // false