package leetcode_golang

//给出两个 非空 的链表用来表示两个非负的整数。其中，它们各自的位数是按照 逆序 的方式存储的，并且它们的每个节点只能存储 一位 数字。
//
// 如果，我们将这两个数相加起来，则会返回一个新的链表来表示它们的和。 
//
// 您可以假设除了数字 0 之外，这两个数都不会以 0 开头。 
//
// 示例： 
//
// 输入：(2 -> 4 -> 3) + (5 -> 6 -> 4)
//输出：7 -> 0 -> 8
//原因：342 + 465 = 807
// 
// Related Topics 链表 数学

//leetcode submit region begin(Prohibit modification and deletion)
/**
 * Definition for singly-linked list.
 * type ListNode struct {
 *     Val int
 *     Next *ListNode
 * }
 */
func addTwoNumbers(l1 *ListNode, l2 *ListNode) *ListNode {
	l3 := &ListNode{
		Val:  0,
		Next: nil,
	}
	c := l3
	up := 0
	for l1 != nil || l2 != nil || up != 0 {
		n := up
		if l1 != nil {
			n += l1.Val
		}
		if l2 != nil {
			n += l2.Val
		}
		if n > 9 {
			up = 1
		} else {
			up = 0
		}
		c.Next = &ListNode{
			Val:  n % 10,
			Next: nil,
		}
		c = c.Next
		if l1 != nil {
			l1 = l1.Next
		}
		if l2 != nil {
			l2 = l2.Next
		}
	}
	return l3.Next
}

//leetcode submit region end(Prohibit modification and deletion)
