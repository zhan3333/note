package main

import (
	"fmt"
	"github.com/google/gopacket"
	"github.com/google/gopacket/layers"
	"github.com/google/gopacket/pcap"
	"wpe/device"
)

func main() {
	var err error
	fmt.Println("packet start...")

	deviceName := device.ScanDeviceName()
	fmt.Printf("选择了 %s\n", deviceName)

	snapLen := int32(65535)
	port := uint16(52270)
	filter := getFilter(port)
	fmt.Printf("dev:%v, snapLen:%v, port:%v\n", deviceName, snapLen, port)
	fmt.Println("filter:", filter)

	//打开网络接口，抓取在线数据
	handle, err := pcap.OpenLive(deviceName, snapLen, true, pcap.BlockForever)
	if err != nil {
		fmt.Printf("pcap open live failed: %v", err)
		return
	}
	sender, err := pcap.OpenLive(deviceName, snapLen, true, pcap.BlockForever)
	if err != nil {
		fmt.Printf("pcap open live failed: %v", err)
		return
	}

	// 设置过滤器
	if err := handle.SetBPFFilter(filter); err != nil {
		fmt.Printf("set bpf filter failed: %v", err)
		return
	}
	defer handle.Close()

	// 抓包
	packetSource := gopacket.NewPacketSource(handle, handle.LinkType())
	packetSource.NoCopy = true
	for packet := range packetSource.Packets() {
		if packet.NetworkLayer() == nil || packet.TransportLayer() == nil || packet.TransportLayer().LayerType() != layers.LayerTypeTCP {
			fmt.Println("unexpected packet")
			continue
		}
		fmt.Println("--------------------")
		//fmt.Printf("packet:%v\n", packet)
		fmt.Printf("[Packet] %s\n", packet.String())
		fmt.Println()
		go func(packet gopacket.Packet) {
			err = sender.WritePacketData(packet.Data())
			if err != nil {
				fmt.Println("send error", err)
			}
		}(packet)

		//if ipv4Layer := packet.Layer(layers.LayerTypeIPv4); ipv4Layer != nil {
		//	ipv4, _ := ipv4Layer.(*layers.IPv4)
		//	fmt.Printf("[ipv4请求] %s - %s\n", ipv4.SrcIP, ipv4.DstIP)
		//	fmt.Printf("content len: %d\n", ipv4.Length)
		//	fmt.Printf("content:\n")
		//	fmt.Printf("%s\n", ipv4.Contents)
		//}

		// tcp 层
		tcpLayer := packet.Layer(layers.LayerTypeTCP)
		if tcpLayer != nil {
			tcp, _ := tcpLayer.(*layers.TCP)
			//fmt.Printf("[TCP %s -> %s]", tcp.SrcPort, tcp.DstPort)
			fmt.Printf("content: %s\n", tcp.Payload)
		}
	}
}

//定义过滤器
//过滤IP： 10.1.1.3
//过滤CIDR： 128.3/16
//过滤端口： port 53
//过滤主机和端口： host 8.8.8.8 and udp port 53
//过滤网段和端口： net 199.16.156.0/22 and port
//过滤非本机 Web 流量： (port 80 and port 443) and not host 192.168.0.1
func getFilter(port uint16) string {
	//filter := fmt.Sprintf("tcp and ((src port %v) or (dst port %v))", port, port)
	//filter := fmt.Sprintf("(src port %v) or (dst port %v)", port, port)
	//filter := fmt.Sprintf("(src port %v) or (dst port %v)", port, port)
	filter := fmt.Sprintf("src port %v", port)
	return filter
}
