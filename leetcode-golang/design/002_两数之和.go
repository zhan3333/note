package design

type ListNode struct {
	Val  int
	Next *ListNode
}

func addTwoNumbers(l1 *ListNode, l2 *ListNode) *ListNode {
	up := 0
	c1 := l1
	c2 := l2
	l3 := &ListNode{
		Val:  0,
		Next: nil,
	}
	c3 := l3
	for c1 != nil || c2 != nil {
		v := 0
		if c1 == nil {
			v = c2.Val + up
			c2 = c2.Next
		} else if c2 == nil {
			v = c1.Val + up
			c1 = c1.Next
		} else {
			v = c1.Val + c2.Val + up
			c1 = c1.Next
			c2 = c2.Next
		}
		up = v / 10
		v = v % 10
		c3.Next = &ListNode{
			Val:  v % 10,
			Next: nil,
		}
		c3 = c3.Next
	}
	if up == 1 {
		c3.Next = &ListNode{
			Val:  1,
			Next: nil,
		}
	}
	return l3.Next
}
