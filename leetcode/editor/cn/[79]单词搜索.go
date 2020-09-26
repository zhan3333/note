package leetcode_golang

//给定一个二维网格和一个单词，找出该单词是否存在于网格中。 
//
// 单词必须按照字母顺序，通过相邻的单元格内的字母构成，其中“相邻”单元格是那些水平相邻或垂直相邻的单元格。同一个单元格内的字母不允许被重复使用。 
//
// 
//
// 示例: 
//
// board =
//[
//  ['A','B','C','E'],
//  ['S','F','C','S'],
//  ['A','D','E','E']
//]
//
//给定 word = "ABCCED", 返回 true
//给定 word = "SEE", 返回 true
//给定 word = "ABCB", 返回 false 
//
// 
//
// 提示： 
//
// 
// board 和 word 中只包含大写和小写英文字母。 
// 1 <= board.length <= 200 
// 1 <= board[i].length <= 200 
// 1 <= word.length <= 10^3 
// 
// Related Topics 数组 回溯算法

//leetcode submit region begin(Prohibit modification and deletion)
func exist(board [][]byte, word string) bool {
	var ans bool
	var used [][]bool
	for i := 0; i < len(board); i++ {
		var t []bool
		for j := 0; j < len(board[0]); j++ {
			t = append(t, false)
		}
		used = append(used, t)
	}
	existBackTracking(board, 0, 0, word, 0, &ans, &used)
	return ans
}

func existBackTracking(board [][]byte, i, j int, word string, k int, ans *bool, used *[][]bool) {
	// 终止条件
	if *ans || k == len(word)+1 || (*used)[i][j] {
		return
	}
	if k == 0 {
		(*used)[i][j] = true
	}
	// 计数条件
	if board[i][j] == word[k] {
		k++
	}
	var helper = [][]int{{-1, 0}, {1, 0}, {0, 1}, {0, -1}}
	for _, h := range helper {
		// 移动
		i1 := i + h[0]
		j1 := j + h[1]
		// 剪枝
		if i1 < 0 || i1 == len(board) || j1 < 0 || j1 == len(board[0]) {
			continue
		}
		existBackTracking(board, i1, j1, word, k, ans, used)
	}
}

//leetcode submit region end(Prohibit modification and deletion)
