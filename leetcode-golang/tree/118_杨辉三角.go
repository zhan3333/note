package tree

func generate(numRows int) [][]int {
	ans := [][]int{
		{1},
		{1, 1},
	}
	if numRows < 1 {
		return [][]int{}
	}
	if numRows == 1 {
		return [][]int{{1}}
	}
	for len(ans) < numRows {
		l := len(ans)
		t := []int{}
		for i := 0; i <= l; i++ {
			if i == 0 || i == l {
				t = append(t, 1)
			} else {
				t = append(t, ans[l-1][i-1]+ans[l-1][i])
			}
		}
		ans = append(ans, t)
	}
	return ans
}
