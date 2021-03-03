package process_test

import (
	"github.com/stretchr/testify/assert"
	"io/ioutil"
	"os/exec"
	"os/user"
	"testing"
	"wpe/process"
)

func TestProcesses(t *testing.T) {
	ps, err := process.Processes()
	assert.Nil(t, err)
	for _, p := range ps {
		name, _ := p.Name()
		username, _ := p.Username()
		t.Log(p.Pid, name, username)
	}
	u, err := user.Current()
	assert.Nil(t, err)
	t.Log(u.Username, u.Name, u.Uid)
}

func TestUserName(t *testing.T) {
	u, err := user.Current()
	assert.Nil(t, err)
	username := process.UserName()
	assert.Equal(t, u.Username, username)
}

func TestRunCommand(t *testing.T) {
	cmd := exec.Command("bash", "-c", "lsof -P -p72081 | grep -E 'IPv6|IPv4'| awk '{print $9}' | awk -F: '{print $2}'")
	stdout, err := cmd.StdoutPipe()
	assert.Nil(t, err)
	err = cmd.Start()
	assert.Nil(t, err)
	if err != nil {
		t.Log(err.Error())
	}
	bytes, err := ioutil.ReadAll(stdout)
	t.Log(string(bytes))
}

func TestGetProcessPorts(t *testing.T) {
	ports, err := process.GetProcessPorts(53777)
	assert.Nil(t, err)
	t.Log(ports)
	t.Log(len(ports))
}
