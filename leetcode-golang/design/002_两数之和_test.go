package design

import (
	"fmt"
	"testing"
)

func TestAdd(t *testing.T) {
	l1 := &ListNode{
		Val: 2,
		Next: &ListNode{
			Val: 4,
			Next: &ListNode{
				Val:  3,
				Next: nil,
			},
		},
	}
	l2 := &ListNode{
		Val: 5,
		Next: &ListNode{
			Val: 6,
			Next: &ListNode{
				Val:  7,
				Next: nil,
			},
		},
	}
	l3 := addTwoNumbers(l1, l2)
	fmt.Printf("%v", l3)
}
