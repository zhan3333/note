package dynamic

func climbStairs(n int) int {
	// dp[1] = 1
	// dp[2] = 2
	// dp[n] = dp[n - 1] + dp[n - 2]
	if n == 1 {
		return 1
	}
	d1 := 1
	d2 := 2
	for i := 3; i <= n; i++ {
		d2, d1 = d1+d2, d2
	}
	return d2
}
