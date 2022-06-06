package main

//https://medium.com/golangspec/import-declarations-in-go-8de0fd3ae8ff
import (
	"app1/internal/binary1/helpers1"
	bbb "app1/internal/binary1/helpers1"
	. "app1/pkg/tools"
	tools "app1/pkg/tools"
	"fmt"
	"sync"
	"time"
)

type anyname struct {
	fakename string
}

//https://eli.thegreenplace.net/2020/embedding-in-go-part-1-structs-in-structs/
//https://yourbasic.org/golang/structs-explained/
type aaa struct {
	name string
	anyname
	age int
}

var wg = sync.WaitGroup{}

func main() {
	var x uint64 = uint64(555)

	var a aaa
	a.name = "Bob"
	a.age = 5

	aa := aaa{}
	aa.name = "c"
	aa.age = 66
	aa.fakename = "harry"

	b := aaa{name: "xxx"}

	c := new(aaa)
	d := &aaa{}

	e := aaa{name: "xxx"}

	var what string = bbb.Hello()

	fmt.Println("ops:", x, what, a, b, c, d, c == d, b == e, aa)

	helpers1.DisplayTime()

	fmt.Println(tools.CompileHelloWorld(what))
	fmt.Println(CompileHelloWorld("import to global scope with import . "))

	wg.Add(1)
	go sendData("data1")
	wg.Add(1)
	go sendData("data2")
	wg.Add(1)
	go sendData("data3")
	wg.Wait()
}

func sendData(data string) {
	time.Sleep(1 * time.Second)
	fmt.Println("#################")
	fmt.Printf("Sending data:\n %v \n", data)
	fmt.Println("#################")
	wg.Done()
}
