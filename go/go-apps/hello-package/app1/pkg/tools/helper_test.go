package tools

import (
	"testing"
)

func TestCompileHelloWorld(t *testing.T) {
	cases := []struct {
		in, want string
	}{
		{"Hello", "Hello world"},
		{"世界", "世界 world"},
		{"1", "1 world"},
	}
	for _, c := range cases {
		got := CompileHelloWorld(c.in)
		if got != c.want {
			t.Errorf("CompileHelloWorld(%q) == %q, want %q", c.in, got, c.want)
		}
	}
}
