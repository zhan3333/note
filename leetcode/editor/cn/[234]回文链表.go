package leetcode_golang

//请判断一个链表是否为回文链表。 
//
// 示例 1: 
//
// 输入: 1->2
//输出: false 
//
// 示例 2: 
//
// 输入: 1->2->2->1
//输出: true
// 
//
// 进阶： 
//你能否用 O(n) 时间复杂度和 O(1) 空间复杂度解决此题？ 
// Related Topics 链表 双指针

//leetcode submit region begin(Prohibit modification and deletion)
/**
 * Definition for singly-linked list.
 * type ListNode struct {
 *     Val int
 *     Next *ListNode
 * }
 */
func isPalindrome(head *ListNode) bool {
	// 反转后半部分, 两部分进行比较
	if head == nil || head.Next == nil {
		return true
	}
	s := head
	f := head
	var p *ListNode
	for f != nil && f.Next != nil {
		p = s
		s = s.Next
		f = f.Next.Next
	}
	p.Next = nil
	// s 为后半部分
	l1 := head
	l2 := reverse(s)
	for l1 != nil && l2 != nil {
		if l1.Val != l2.Val {
			return false
		}
		l1 = l1.Next
		l2 = l2.Next
	}
	return l2 == nil || l2.Next == nil
}

func reverse(head *ListNode) *ListNode {
	var p *ListNode
	c := head
	for c != nil {
		n := c.Next
		c.Next = p
		p = c
		c = n
	}
	return p
}

//leetcode submit region end(Prohibit modification and deletion)
