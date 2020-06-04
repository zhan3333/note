package string

import (
	"fmt"
	"strings"
)

func isPalindrome(s string) bool {
	if s == "" {
		return true
	}
	l := 0
	r := len(s) - 1
	for l < r {
		for l < r && !allowChr(s[l]) {
			l++
		}
		for l < r && !allowChr(s[r]) {
			r--
		}
		fmt.Printf("%s:%s", string(s[l]), string(s[r]))
		fmt.Printf("%d:%d", s[l], s[r])
		if strings.ToLower(string(s[l])) != strings.ToLower(string(s[r])) {
			return false
		}
		l++
		r--
	}
	return true
}

func allowChr(c uint8) bool {
	if 48 <= c && c <= 57 {
		return true
	}
	if 65 <= c && c <= 90 {
		return true
	}
	if 97 <= c && c <= 122 {
		return true
	}
	return false
}
