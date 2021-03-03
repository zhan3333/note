package device_test

import (
	"github.com/stretchr/testify/assert"
	"testing"
	"wpe/device"
)

func TestGetDevices(t *testing.T) {
	devices, err := device.GetDevices()
	assert.Nil(t, err)
	t.Logf("%+v", devices)
	assert.NotEqual(t, 0, len(devices))
}

func TestScanDeviceName(t *testing.T) {
	dev := device.ScanDeviceName()
	assert.NotEmpty(t, dev)
}
