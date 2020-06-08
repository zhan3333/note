package list

func getIntersectionNode(headA, headB *ListNode) *ListNode {
	cA := headA
	cB := headB
	changeA := false
	changeB := false
	for cA != nil && cB != nil {
		if cA == cB {
			return cA
		}
		cA = cA.Next
		cB = cB.Next
		if cA == nil && !changeA {
			changeA = true
			cA = headB
		}
		if cB == nil && !changeB {
			changeB = true
			cB = headA
		}
	}
	return nil
}
