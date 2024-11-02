#!/bin/bash

# code to get config from:
# https://github.com/conciseusa/raspberry-pi-json-data-logger - remote-cmd.sh
# crontab @daily, @weekly or @monthly

DATE=`date +%Y-%m-%d:%H:%M:%S`
SCRIPT_DIR=$(dirname $(readlink -f "$BASH_SOURCE"))
# Seems like the output format of ip isn't quite stable so skip the awk part $(ip route get 1 | awk '{print $(NF-2);exit}')
# https://stackoverflow.com/questions/13322485/how-to-get-the-primary-ip-address-of-the-local-machine-on-linux-and-os-x
LANIP=$(ip route get 1)

# keep config seperate in a config dir in the parent dir
# source below has worked in testing, but may need to hardcode path in some situations
source $SCRIPT_DIR/../config/cron-config.sh
echo "$DATE - LOC = $LOC"
echo "$DATE - $SCRIPT_DIR - $0" # for troubleshooting in cron jobs, >> to append to a log file

# example call
# http://www.server.com/ip-endpoint.php?loc=33T&cc=337447a45secret054e88fc2cb442b6ff9143d21

# In config:
# LOC='33T' # location code
# ID='RPi3' # use if more then one device at a location
# CC_SALT='salty_salt' # the receiving sever needs this in its config to confirm the sender, adds some simple security
# CALL_SERVER='http://www.server.com/ip-endpoint.php'

# gen a call code, keep the same on the endpoint
CC=$(echo -n $LOC$MSG_SALT | sha1sum | awk '{print $1}')

echo 'CC:'
echo $CC

curl $CALL_SERVER"?loc=$LOC&id=$ID&lanip=$LANIP&cc=$CC"

echo ''
