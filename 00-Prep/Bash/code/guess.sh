#!/bin/bash

# Ask the user to guess a number
echo -n "Choose a number between 1 and 10 and press [ENTER]: "
read number

# Generate a random number between 1 and 10
RAND_NUMBER=$((1 + RANDOM % 10))

echo "You guessed  $number"

if [ $RAND_NUMBER == $number ]; then
	echo "We have a winner!"
else
	echo "I'm sorry, the answer was $RAND_NUMBER" 
fi
