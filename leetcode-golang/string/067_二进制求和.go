package string

import (
	"fmt"
	"strconv"
	"strings"
)

func addBinary(a string, b string) string {
	if len(a) < len(b) {
		a = fmt.Sprintf("%s%s", strings.Repeat("0", len(b)-len(a)), a)
	} else {
		b = fmt.Sprintf("%s%s", strings.Repeat("0", len(a)-len(b)), b)
	}
	up := int64(0)
	ans := ""
	for i := len(a) - 1; i >= 0; i-- {
		n1, _ := strconv.ParseInt(string(a[i]), 10, 64)
		n2, _ := strconv.ParseInt(string(b[i]), 10, 64)
		t := n1 + n2 + up
		ans = strings.Join([]string{strconv.Itoa(int(t % 2)), ans}, "")
		up = t / 2
	}
	if up != 0 {
		return strings.Join([]string{"1", ans}, "")
	}
	return ans
}
