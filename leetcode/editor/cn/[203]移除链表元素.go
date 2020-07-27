package leetcode_golang

//删除链表中等于给定值 val 的所有节点。 
//
// 示例: 
//
// 输入: 1->2->6->3->4->5->6, val = 6
//输出: 1->2->3->4->5
// 
// Related Topics 链表

//leetcode submit region begin(Prohibit modification and deletion)
/**
 * Definition for singly-linked list.
 * type ListNode struct {
 *     Val int
 *     Next *ListNode
 * }
 */
func removeElements(head *ListNode, val int) *ListNode {
	p := &ListNode{
		Next: head,
		Val:  0,
	}
	c := p.Next
	prev := p
	for c != nil {
		if c.Val == val {
			prev.Next = c.Next
		} else {
			prev = c
		}
		c = c.Next
	}
	return p.Next
}

//leetcode submit region end(Prohibit modification and deletion)
