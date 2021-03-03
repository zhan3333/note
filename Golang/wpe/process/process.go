package process

import (
	"fmt"
	pro "github.com/shirou/gopsutil/process"
	"io/ioutil"
	"os/exec"
	"os/user"
	"runtime"
	"strings"
)

func Processes() ([]*pro.Process, error) {
	return pro.Processes()
}

func UserName() string {
	u, _ := user.Current()
	return u.Username
}

type ProcessPort struct {
	Host string
	Port string
}

//获取进程监听的端口
func ProcessPorts(pid int) ([]ProcessPort, error) {
	var ports []ProcessPort
	sysType := runtime.GOOS
	switch sysType {
	case "linux":
		exec.Command("lsof -P -p72081 | grep -E 'IPv6|IPv4' | awk '{print %9}'")
	case "windows":
	default:
		return ports, fmt.Errorf("不被支持的平台: %s", sysType)
	}
	return ports, nil
}

func GetProcessPorts(pid int) ([]string, error) {
	cmd := exec.Command("bash", "-c", fmt.Sprintf("lsof -P -p%d | grep -E 'IPv6|IPv4'| awk '{print $9}' | awk -F: '{print $2}'", pid))
	stdout, err := cmd.StdoutPipe()
	if err != nil {
		return nil, err
	}
	err = cmd.Start()
	if err != nil {
		return nil, err
	}
	bytes, err := ioutil.ReadAll(stdout)
	if err != nil {
		return nil, err
	}
	arr := strings.Split(string(bytes), "\n")
	ans := make([]string, 0)
	for _, a := range arr {
		if a != "" {
			ans = append(ans, a)
		}
	}
	return ans, nil
}
