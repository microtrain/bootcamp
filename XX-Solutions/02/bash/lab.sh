#!/bin/bash

# The first user supplied argument
CONFIG="$1"

# The second user supplied argument
COMMAND="$2"

# If true, execute the service commands
OK=false

# Holds a list of cmaands
COMMAND_STRING=''

# Holds a list of vhosts
VHOSTS_STRING=''

# An array of all vhosts files
VHOSTS_PATH=/etc/apache2/sites-available/*.conf

# User feedback
USAGE_STRING=''

# Whitelisted services commands
COMMANDS=( reload restart )

# Return non zero if a given $1 exists in the list of vhosts
IN_VHOST_PATH=$(echo ${VHOSTS_PATH[@]} | grep -o "$CONFIG" | wc -w)

# Return non zero if a given $2 is in the service command whitelist
IN_COMMAND=$(echo ${COMMANDS[@]} | grep -o "$COMMAND" | wc -w)

# Iterate over the whitelist of commands and inject them in to the user feedback
for COM in "${COMMANDS[@]}"
do

    # If $COMMAND_STRING is not empty, print a line break
    if [ ! -z  "$COMMAND_STRING" ]
    then
        COM="\n * ${COM}"
    fi

    COMMAND_STRING="${COMMAND_STRING}${COM}"

done

# If the user did not supply a config file, return a list of files to
# the user

for FILENAME in $VHOSTS_PATH
do
    # Strip the file extension
    FILE=${FILENAME##*/}

    # Strip the base path
    VHOST=${FILE%.*}

    # If $VHOST_STRING is not empty, print a seperator
    if [ ! -z  "$VHOSTS_STRING" ]
    then
        VHOST="\n * ${VHOST}"
    fi

    VHOSTS_STRING="${VHOSTS_STRING}${VHOST}"
done

USAGE_STRING="Usage: $0 vhost command  \nPlease choose one of the following vhosts\n * $VHOSTS_STRING \nPlease choose from the following commands\n * $COMMAND_STRING \n"

if [ $# -ne 2 ]
then

    printf "$USAGE_STRING"
    exit 1

fi

if [ "$IN_VHOST_PATH" -gt 0 ]
then
    OK=true
fi

if [ "$IN_COMMAND" -gt 0  ]  && [ "$OK" == true ]
then
    OK=true
else
    OK=false
fi

# Reject any service command that has not been whitelisted
if [ "$OK" == false ]
then
    printf "$USAGE_STRING"
    exit 1
fi

# Disable the existing hosts configuration
sudo a2dissite $CONFIG
sudo service apache2 $COMMAND

# Enable the existing hosts configuration
sudo a2ensite $CONFIG
sudo service apache2 $COMMAND
exit 1
