#!/bin/bash

# Log file path
LOGFILE="/var/log/rfcomm_check.log"

# Check if log file exists, if not, create it
if ! [ -e $LOGFILE ]; then
    touch $LOGFILE
fi

# Log the date and action
echo "$(date): Checking for reset /dev/rfcomm0" >> $LOGFILE

# Check if /dev/rfcomm0 exists
if [ -e /dev/rfcomm0 ]; then
    echo "$(date): /dev/rfcomm0 found, reseting" >> $LOGFILE
    sudo rfcomm release /dev/rfcomm0
fi

echo "$(date): /dev/rfcomm0, attempting to connect" >> $LOGFILE
# Try to connect if it does not exist
sudo rfcomm connect /dev/rfcomm0 66:1E:11:00:12:CE 1 >> $LOGFILE 2>&1