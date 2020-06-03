package dynamic

import "math"

func maxProfit2(prices []int) int {
	if len(prices) < 2 {
		return 0
	}
	min := prices[0]
	sum := 0
	for i := 1; i < len(prices); i++ {
		if prices[i] > min {
			sum += prices[i] - min
			min = prices[i]
		} else {
			min = int(math.Min(float64(min), float64(prices[i])))
		}
	}
	return sum
}
func maxProfit3(prices []int) int {
	sum := 0
	for i := 1; i < len(prices); i++ {
		if t := prices[i] - prices[i-1]; t > 0 {
			sum += t
		}
	}
	return sum
}
