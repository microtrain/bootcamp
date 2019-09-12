#!/bin/bash

# This program writes Hello World to stdout.
if [ -z "$1" ]
then
        NAME="World"
else
        NAME="$1"
fi

echo "$0 says: Hello $NAME"