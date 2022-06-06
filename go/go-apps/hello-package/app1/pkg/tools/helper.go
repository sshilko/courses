package tools

import (
	"fmt"
)

func CompileHelloWorld(what string) string {
	return fmt.Sprintf("%s world", what)
}
