1. `go mod init $FOLDERNAME`
2. import "$FOLDERNAME/subfoldername"
3. subfoldername.CapitalExportedFunction()
4. go run cmd/binary1/main.go
4. go build automatically discovers, `go build -o bin/binary1 cmd/binary1/main.go`
5. go test -cover ./...

# See

https://www.golangprograms.com/how-to-use-function-from-another-file-golang.html


