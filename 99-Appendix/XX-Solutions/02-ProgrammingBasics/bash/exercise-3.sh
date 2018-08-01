#!/bin/bash

CONFIG="$1"
COMMAND="$2"
OK=false

if [ $# -ne 2 ]
then

  echo "Usage: $0 {virtual-host} {restart|reload}"
  echo "Reloads a target virtual host"
  exit 1

fi

# restart is allowed
if [ "$COMMAND" == "restart" ]
then
  OK=true
fi

# reload is allowed


# reject any service command that was not whitelisted
if [ "$OK" == false ]
then
  echo "Usage: $0 $CONFIG {restart|reload}"
  exit 1
fi

# Disable the existing hosts configuration
sudo a2dissite $CONFIG
sudo service apache2 $COMMAND

# Enable the existing hosts configuration
sudo a2ensite $CONFIG
sudo service apache2 $COMMAND
