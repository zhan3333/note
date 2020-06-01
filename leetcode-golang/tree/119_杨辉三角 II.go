package tree

func getRow(rowIndex int) []int {
	if rowIndex < 0 {
		return []int{}
	}
	ans := []int{}
	for len(ans) <= rowIndex {
		t := []int{}
		l := len(ans)
		for i := 0; i <= l; i++ {
			if i == 0 || i == l {
				t = append(t, 1)
			} else {
				t = append(t, ans[i-1]+ans[i])
			}
		}
		ans = t
	}
	return ans
}
