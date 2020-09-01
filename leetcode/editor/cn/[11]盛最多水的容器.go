package leetcode_golang

//给你 n 个非负整数 a1，a2，...，an，每个数代表坐标中的一个点 (i, ai) 。在坐标内画 n 条垂直线，垂直线 i 的两个端点分别为 (i, 
//ai) 和 (i, 0)。找出其中的两条线，使得它们与 x 轴共同构成的容器可以容纳最多的水。 
//
// 说明：你不能倾斜容器，且 n 的值至少为 2。 
//
// 
//
// 
//
// 图中垂直线代表输入数组 [1,8,6,2,5,4,8,3,7]。在此情况下，容器能够容纳水（表示为蓝色部分）的最大值为 49。 
//
// 
//
// 示例： 
//
// 输入：[1,8,6,2,5,4,8,3,7]
//输出：49 
// Related Topics 数组 双指针

//leetcode submit region begin(Prohibit modification and deletion)

func maxArea(height []int) int {
	// 两头指针, 每次向中间移动较小的边 (因为移动大的边面积一定减少)
	if len(height) == 0 {
		return 0
	}
	i := 0
	j := len(height) - 1
	max := 0
	for i < j {
		max = getMax(max, (j-i)*getMin(height[j], height[i]))
		if height[i] > height[j] {
			j--
		} else {
			i++
		}
	}
	return max
}

func maxArea2(height []int) int {
	max := 0
	for i := 0; i < len(height); i++ {
		for j := i; j < len(height); j++ {
			min := getMin(height[i], height[j])
			max = getMax(max, (j-i)*min)
		}
	}
	return max
}

func getMax(a int, b int) int {
	if a > b {
		return a
	}
	return b
}

func getMin(a int, b int) int {
	if a > b {
		return b
	}
	return a
}

//leetcode submit region end(Prohibit modification and deletion)
