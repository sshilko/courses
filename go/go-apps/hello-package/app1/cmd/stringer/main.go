package main

import (
	"app1/pkg/myinterface"
	"fmt"
)

type Person struct {
	Name string
	Age  int
}

func (p Person) String() string {
	return fmt.Sprintf("%v (%v years)", p.Name, p.Age)
}

func main() {
	a := Person{"Arthur Dent", 42}
	z := Person{"Zaphod Beeblebrox", 9001}
	fmt.Println(a, z)

	// #runtime check - interface assertion
	//https://www.pixelstech.net/article/1588481241-How-to-check-whether-a-struct-implements-an-interface-in-GoLang
	_, ok := interface{}(a).(myinterface.Mystringer)
	if ok {
		fmt.Println("a implements Mystringer interface")
	}

	var aasinterface interface{} = a
	v, ok := aasinterface.(myinterface.Mystringer)
	if ok {
		fmt.Println("a implements Mystringer interface", v)
	}

	// #compile-time check
	// var _ myinterface.Myinter = new(Person)
	// if ok {
	// 	fmt.Println("a implements Myinter interface")
	// }

}
