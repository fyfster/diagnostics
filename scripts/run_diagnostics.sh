#!/bin/bash

# Attempt to connect using Sakis3G
while true; do
    echo "$(date): Attempting to connect using Sakis3G" >> $LOGFILE
    sudo /home/fyf/scripts/sakis3g connect USBMODEM="12d1:1436" USBINTERFACE="0" APN='internet.vodafone.ro'
    sleep 2

    # Check for internet access by pinging Google's DNS server
    if ping -q -c 1 -W 1 8.8.8.8 >/dev/null; then
        echo "$(date): The network is up" >> $LOGFILE
        break
    else
        echo "$(date): The network is down" >> $LOGFILE
    fi
done

# Attempt to connect using rfcomm until successful
sleep 30
sudo python3 /home/fyf/scripts/diagnostics.py --run-rpm True --run-vin True --run-speed True --run-fuel True --run-coolant True