#!/bin/bash

/usr/local/entware/bin/install.sh >> /var/log/entware.log 2>&1
retval=$?
if [[ $retval -ne 0 ]]; then
  echo "Error executing script $retval" >> /var/log/entware.log
fi
