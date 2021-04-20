package main

import (
	"bytes"
	"encoding/json"
	"fmt"
	"io/ioutil"
	"net/http"
	"unsafe"
)

func main() {
	arr := []int{1, 2}
	fmt.Printf("%+v \n", arr[0:0])
	fmt.Printf("%+v \n", arr[1:])
	fmt.Printf("%+v \n", arr[:])
	fmt.Printf("%+v", fmt.Errorf("test"))
}

func (this *TxInfo) SamplePost(aaa *TxInfo) () {
	var song map[string]interface{}
	song = make(map[string]interface{})
	song["addr"] = "TBbL9zihj1K6QossDKHnbPVX9PW22RUhvw,TANpa4XZxg4VfBH5Y6u1Gi1TnKK9apa5Zm"
	song["amount"] = "Amount"
	song["addrType"] = "1,2"
	song["symbol"] = "USDT"
	bytesData, err := json.Marshal(
		map[string]interface{}{
			"data": song,
		})
	if err != nil {
		fmt.Println(err.Error())
		return
	}
	reader := bytes.NewReader(bytesData)
	url := "https://app.vitescoi.com/viteapp/common/pullWalletServerAssets"
	request, err := http.NewRequest("POST", url, reader)
	if err != nil {
		fmt.Println(err.Error())
		return
	}
	request.Header.Set("Content-Type", "application/json;charset=UTF-8")
	client := http.Client{}
	resp, err := client.Do(request)
	if err != nil {
		fmt.Println(err.Error())
		return
	}
	respBytes, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		fmt.Println(err.Error())
		return
	}
	//byte数组直接转成string，优化内存
	str := (*string)(unsafe.Pointer(&respBytes))
	println(*str)
	//     return (*str)
}
