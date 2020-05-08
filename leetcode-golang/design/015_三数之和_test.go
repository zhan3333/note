package design

import "testing"

func TestThreeSum(t *testing.T) {
	sums := []int{
		-1, 0, 1, 2, -1, -4,
	}
	ans := threeSum(sums)
	t.Log(ans)
}
