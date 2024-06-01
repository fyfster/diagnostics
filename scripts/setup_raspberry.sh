#!/bin/bash

# Update the package list
sudo apt-get update

# Install locate
sudo apt-get install mlocate

# Install Bluetooth tools and utilities
sudo apt-get install -y bluetooth bluez bluez-tools

# Install Python and pip
sudo apt-get install -y python3 python3-pip

# Install screen
sudo apt-get install -y screen

# Install WiFi and network management tools
sudo apt-get install -y network-manager net-tools wireless-tools wpasupplicant

# Install USB modem support tools
sudo apt-get install -y usb-modeswitch modemmanager

# Install curl
sudo apt-get install -y curl

# Install additional Python packages
echo "Installing pyserial"
sudo pip3 install pyserial --break-system-packages

echo "Installing python-crontab"
sudo pip3 install python-crontab --break-system-packages

echo "Installing python-can"
sudo pip3 install python-can --break-system-packages

echo "Installing requests"
sudo pip3 install requests --break-system-packages

echo "Installing obd"
sudo pip3 install obd --break-system-packages

# Install git and libbluetooth-dev for simulator and testing
echo "Installing git and libbluetooth-dev"
sudo apt-get install -y git cmake build-essential autoconf automake libtool libbluetooth-dev pkg-config git-core

# Enable and start NetworkManager service
sudo systemctl enable NetworkManager
sudo systemctl start NetworkManager

# Enable and start ModemManager service
sudo systemctl enable ModemManager
sudo systemctl start ModemManager

# Verify installations
echo "Verifying installations..."

echo -n "Bluetooth: "
if command -v bluetoothctl &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "sdptool: "
if command -v sdptool &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "Python3: "
if command -v python3 &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "pip3: "
if command -v pip3 &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "rfcomm: "
if command -v rfcomm &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "screen: "
if command -v screen &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "pyserial: "
if sudo python3 -m pip show pyserial &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "python-crontab: "
if sudo python3 -m pip show python-crontab &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "python-can: "
if sudo python3 -m pip show python-can &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "requests: "
if sudo python3 -m pip show requests &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "obd: "
if sudo python3 -m pip show obd &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "curl: "
if command -v curl &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "Network Manager: "
if systemctl is-active --quiet NetworkManager; then
    echo "Running"
else
    echo "Not Running"
fi

echo -n "Net-tools: "
if command -v ifconfig &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "Wireless-tools: "
if command -v iwconfig &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "wpasupplicant: "
if command -v wpa_supplicant &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "usb-modeswitch: "
if command -v usb_modeswitch &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "ModemManager: "
if systemctl is-active --quiet ModemManager; then
    echo "Running"
else
    echo "Not Running"
fi

echo -n "git: "
if command -v git &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo -n "libbluetooth-dev: "
if dpkg -l | grep libbluetooth-dev &> /dev/null; then
    echo "Installed"
else
    echo "Not Installed"
fi

echo "Setup complete."
