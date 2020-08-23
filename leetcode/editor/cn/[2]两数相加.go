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
	carry := 0
	c1 := l1
	c2 := l2
	l3 := &ListNode{}
	c3 := l3
	for c1 != nil && c2 != nil {
		sum := c1.Val + c2.Val + carry
		c3.Next = &ListNode{
			Val:  sum % 10,
			Next: nil,
		}
		carry = sum / 10
		c1 = c1.Next
		c2 = c2.Next
		c3 = c3.Next
	}
	for c1 != nil {
		sum := c1.Val + carry
		c3.Next = &ListNode{
			Val:  sum % 10,
			Next: nil,
		}
		carry = sum / 10
		c1 = c1.Next
		c3 = c3.Next
	}
	for c2 != nil {
		sum := c2.Val + carry
		c3.Next = &ListNode{
			Val:  sum % 10,
			Next: nil,
		}
		carry = sum / 10
		c2 = c2.Next
		c3 = c3.Next
	}
	if carry != 0 {
		c3.Next = &ListNode{
			Val:  carry,
			Next: nil,
		}
		c3 = c3.Next
	}
	return l3.Next
}

//leetcode submit region end(Prohibit modification and deletion)
