package dynamic

import "math"

func maxProfit(prices []int) int {
	res := 0
	min := prices[0]
	for i := 1; i < len(prices); i++ {
		if prices[i] > min {
			res = int(math.Max(float64(res), float64(prices[i]-min)))
		} else {
			min = prices[i]
		}
	}
	return res
}
