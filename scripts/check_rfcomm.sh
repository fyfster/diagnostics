#!/bin/bash

# Log file path
LOGFILE="/var/log/rfcomm_check.log"

# Check if log file exists, if not, create it
if ! [ -e $LOGFILE ]; then
    touch $LOGFILE
fi

# Log the date and action
echo "$(date): Checking /dev/rfcomm0" >> $LOGFILE

# Check if /dev/rfcomm0 exists
if [ -e /dev/rfcomm0 ]; then
    echo "$(date): /dev/rfcomm0 found, exiting" >> $LOGFILE
    exit 0
fi

echo "$(date): /dev/rfcomm0 not found, attempting to connect" >> $LOGFILE
# Try to connect if it does not exist
sudo timeout 55 rfcomm connect /dev/rfcomm0 66:1E:11:00:12:CE 1 >> $LOGFILE 2>&1
if [ $? -eq 0 ]; then
    echo "$(date): Connection successful" >> $LOGFILE
else
    echo "$(date): Connection failed" >> $LOGFILE
    # Check if /dev/rfcomm0 was created during the failed connection attempt
    if [ -e /dev/rfcomm0 ]; then
        echo "$(date): /dev/rfcomm0 found, releasing and deleting" >> $LOGFILE
        # Release the device
        sudo rfcomm release /dev/rfcomm0
        # Delete the device file
        sudo rm /dev/rfcomm0
    fi
fi