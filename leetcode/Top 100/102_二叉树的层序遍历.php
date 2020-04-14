<?php

// 给你一个二叉树，请你返回其按 层序遍历 得到的节点值。 （即逐层地，从左到右访问所有节点）。
//
// 
//
//示例：
//二叉树：[3,9,20,null,null,15,7],
//
//    3
//   / \
//  9  20
//    /  \
//   15   7
//返回其层次遍历结果：
//
//[
//  [3],
//  [9,20],
//  [15,7]
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/binary-tree-level-order-traversal
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 层序遍历, 每次掏空队列
     * @param TreeNode $root
     * @return Integer[][]
     */
    function levelOrder($root)
    {
        if ($root === null) {
            return [];
        }
        $res = [];
        $queue = [$root];
        while (!empty($queue)) {
            $count = count($queue);
            $arr = [];
            while ($count > 0) {
                $count--;
                $node = array_shift($queue);
                if ($node !== null) {
                    if ($node->left !== null) {
                        $queue[] = $node->left;
                    }
                    if ($node->right !== null) {
                        $queue[] = $node->right;
                    }
                    $arr[] = $node->val;
                }
            }
            $res[] = $arr;
        }
        return $res;
    }
}