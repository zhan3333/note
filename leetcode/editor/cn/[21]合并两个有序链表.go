package leetcode_golang

//将两个升序链表合并为一个新的 升序 链表并返回。新链表是通过拼接给定的两个链表的所有节点组成的。 
//
// 
//
// 示例： 
//
// 输入：1->2->4, 1->3->4
//输出：1->1->2->3->4->4
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
func mergeTwoLists(l1 *ListNode, l2 *ListNode) *ListNode {
	l := &ListNode{
		Val:  0,
		Next: nil,
	}
	c := l
	for l1 != nil && l2 != nil {
		if l1.Val < l2.Val {
			c.Next = l1
			l1 = l1.Next
		} else {
			c.Next = l2
			l2 = l2.Next
		}
		c = c.Next
	}
	if l1 != nil {
		c.Next = l1
	}
	if l2 != nil {
		c.Next = l2
	}
	return l.Next
}

//leetcode submit region end(Prohibit modification and deletion)
