#!/bin/bash

CONFIG="$1"
COMMAND="$2"

if [ $# -ne 2 ]
then
        echo "Usage: $0 {virtual-host} {restart|reload}"
        echo "Reloads a target virtual host"
        exit 1
fi

# Disable the existing hosts configuration
sudo a2dissite $CONFIG
sudo service apache2 $COMMAND

# Enable the existing hosts configuration
sudo a2ensite $CONFIG
sudo service apache2 $COMMAND
