# Labs - Programming Basics

## Bash Lab 1 - Improved validation

For our program the only acceptable values for the second argument are *reload* and *restart*. Using conditional statements determine if the value of the second parameter is one of the allowed values.

If it is not
* Send a message to the user that states the input was in error and includes list of the valid commands.
* Stop the execution of the program.
* Commit your changes to your _bash/ex_ branch.

We have already added the logic for restart, now we need to add the logic for reload. Find the file _/var/www/mtbc/labs/bash/lab-1.sh_ and add the logic to allow for a reload.

This would would solve the following user story.

As an _end user_, I need _the ability to perform a graceful reboot of the server_ to _keep current connections in tact_.

## Bash Lab 2 - Validating in a loop

To better help the user provide good arguments we want to return a list of allowed commands and a list of vhost configurations for the user to choose from. We have already completed the latter. Find the file _/var/www/mtbc/labs/bash/lab-2.sh_ and add the logic to provide the user a list of allowed commands.

*Hint: use a loop to perform a string concatenation of all values in the COMMANDS array*
