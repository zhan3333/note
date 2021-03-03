package device

import (
	"fmt"
	"github.com/google/gopacket/pcap"
	"log"
)

// 获取网卡设备
func GetDevices() ([]pcap.Interface, error) {
	version := pcap.Version()
	fmt.Println(version)
	var err error
	var devices []pcap.Interface
	devices, err = pcap.FindAllDevs()
	return devices, err
}

//选择网卡
func ScanDeviceName() string {
	//展示所有网卡
	devices, err := GetDevices()
	if err != nil {
		log.Panicf("获取网卡失败: %+v", err)
	}
	for i, dev := range devices {
		fmt.Printf("[%d]: %s %s", i+1, dev.Name, dev.Description)
		for _, address := range dev.Addresses {
			fmt.Printf(" %s", address.IP)
		}
		fmt.Println()
	}
	fmt.Println("输入选择的设备编号(默认1):")
	var selectDeviceIndex int
	for selectDeviceIndex == 0 {
		if _, err := fmt.Scanln(&selectDeviceIndex); err != nil {
			if err.Error() == "unexpected newline" {
				selectDeviceIndex = 1
			} else {
				fmt.Printf("读取用户输入失败: %+v\n", err)
				selectDeviceIndex = 0
				continue
			}
		}
		if selectDeviceIndex > len(devices) {
			fmt.Printf("有效值范围为: %d - %d\n", 1, len(devices))
			selectDeviceIndex = 0
		}
	}
	return devices[selectDeviceIndex-1].Name
}
