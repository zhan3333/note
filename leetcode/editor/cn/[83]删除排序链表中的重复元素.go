package leetcode_golang

//给定一个排序链表，删除所有重复的元素，使得每个元素只出现一次。 
//
// 示例 1: 
//
// 输入: 1->1->2
//输出: 1->2
// 
//
// 示例 2: 
//
// 输入: 1->1->2->3->3
//输出: 1->2->3 
// Related Topics 链表

//leetcode submit region begin(Prohibit modification and deletion)
/**
 * Definition for singly-linked list.
 * type ListNode struct {￿￿
 *     Val int
 *     Next *ListNode
 * }
 */
func deleteDuplicates(head *ListNode) *ListNode {
	if head == nil {
		return head
	}
	l := head
	r := head.Next
	for r != nil {
		if r.Val != l.Val {
			l.Next = r
			l = l.Next
			r = r.Next
		} else {
			r = r.Next
		}
	}
	l.Next = nil
	return head
}

//leetcode submit region end(Prohibit modification and deletion)
