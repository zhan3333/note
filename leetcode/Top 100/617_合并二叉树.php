<?php

// 给定两个二叉树，想象当你将它们中的一个覆盖到另一个上时，两个二叉树的一些节点便会重叠。
//
//你需要将他们合并为一个新的二叉树。合并的规则是如果两个节点重叠，那么将他们的值相加作为节点合并后的新值，否则不为 NULL 的节点将直接作为新二叉树的节点。
//
//示例 1:
//
//输入:
//	Tree 1                     Tree 2
//          1                         2
//         / \                       / \
//        3   2                     1   3
//       /                           \   \
//      5                             4   7
//输出:
//合并后的树:
//	     3
//	    / \
//	   4   5
//	  / \   \
//	 5   4   7
//注意: 合并必须从两个树的根节点开始。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/merge-two-binary-trees
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 队列解法
     * @param $t1
     * @param $t2
     * @return mixed
     */
    function mergeTrees($t1, $t2)
    {
        if ($t1 === null) {
            return $t2;
        }
        $queue = [[$t1, $t2]];
        while (!empty($queue)) {
            [$node1, $node2] = array_shift($queue);
            $node1->val += $node2->val;
            if ($node1->left === null) {
                $node1->left = $node2->left;
            } else {
                $queue[] = [$node1->left, $node2->left];
            }
            if ($node1->right === null) {
                $node1->right = $node2->right;
            } else {
                $queue[] = [$node1->right, $node2->right];
            }
        }
        return $t1;
    }

    /**
     * 递归解法, 将 t2 往 t1 合并
     * @param TreeNode $t1
     * @param TreeNode $t2
     * @return TreeNode
     */
    function mergeTrees1($t1, $t2)
    {
        if ($t1 !== null && $t2 !== null) {
            $t1->val += $t2->val;
            $t1->left = $this->mergeTrees($t1->left, $t2->left);
            $t1->right = $this->mergeTrees($t1->right, $t2->right);
        }
        return $t1 ?? $t2;
    }
}