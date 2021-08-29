#!/bin/bash

# example call
# http://www.server.com/file.php?loc=33T&cc=337447a45secret054e88fc2cb442b6ff9143d21

# crontab @daily, @weekly or @monthly

loc='33T' # location code
cc_salt='salty_salt' # the receiving sever needs this to confirm the sender, adds some simple security
call_server='http://www.server.com/file.php?'

# gen a call code
CC=$(echo -n $loc$cc_salt | sha1sum | awk '{print $1}')

echo 'CC:'
echo $CC

curl $call_server"loc=$loc&cc=$CC"

echo ''
