package bite

func singleNumber(nums []int) int {
	ans := 0
	for _, a := range nums {
		ans ^= a
	}
	return ans
}
