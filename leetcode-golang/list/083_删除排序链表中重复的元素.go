package list

func deleteDuplicates(head *ListNode) *ListNode {
	if head == nil {
		return nil
	}
	prev := head
	cur := head.Next
	for cur != nil {
		if cur.Val == prev.Val {
			// 删除 cur 节点
			prev.Next = cur.Next
			cur = prev.Next
		} else {
			prev = cur
			cur = cur.Next
		}
	}
	return head
}
