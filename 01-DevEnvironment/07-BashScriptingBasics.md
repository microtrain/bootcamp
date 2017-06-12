# Bash Scripting Basics

In the previous lesson you learned the four commands for reloading virtual-host configuration. While that may not seem to cumbersome when your not updating your site all that often; it gets a little repetitive when your testing updates. Let's write a Bash script to reduce this process to one command. A Bash script us typically little more than scripted arrangement or sequence of Linux commands. In addition to Linux commands shell scripts may accept parameters and may utilize variables, functions and control statements.

## Exercise 1 - Write a bash script that will replace all four commands for restarting a website with a single command.

Create a file with a path of _/etc/apache2/sites-available/re.sh_. This is in an area that should only be accessible by root; don't forget to sudo.

````
 sudo vim /etc/apache2/sites-available/re.sh
````

By default, Ubuntu executes shell scripts using the Dash interpreter. Dash is faster by virtue of a lack of features and limited syntax making it ideal for quickly parsing out a large number of simple start up scripts. Bash is better suited for interactive scripts, since these are typically run as one off programs, the performance hit is a non-issue. We will have our script invoke the bash shell.

A shebang ````#!```` followed by a path is used to invoke an interpreter, this must be the first line of the file. Add the following line to _/etc/apache2/sites-available/re.sh_.

````
#!/bin/bash
````

Our shell will take two arguments; the target host and the service directive. Bash accepts arguments using a numeric index which starts at zero, zero however, is the name of the script so index argument number one will access the first argument. In Bash, the value of stored variables are accessed using a dollar sign. Combining a dollar sign with a number will allow you to access a given argument.

Our first argument will be the vhost we want to work with and the second argument will be the service command. We will set these to an aptly named variable to make them easier to work with. We will store the first argument in a variable called _VHOST_ and the second in a variable called _COMMAND_.
````
VHOST="$1"
COMMAND="$2"
````

The first thing we want out program to do is to verify we have the correct number of arguments. In bash ````$#```` will return the number of input parameters. We can check this with and if statement _if [ $# -ne 2 ] then_ where _-ne_ represents not equal of in plain English _if the number of input parameters is not equal to 2 then do something_. In our case we will want to provide the user feedback about the expected arguments and exit the program.

Add the following lines to the file. Can you guess what the ````echo```` and ````exit```` statements do?

````
if [ $# -ne 2 ]
then
        echo "Usage: $0 {virtual-host} {restart|reload}"
        echo "Reloads a target virtual host"
        exit 1
fi
````
Finally, add the four commands that promoted this program to be written. In the previous lesson we ran all command together and used a wild card to specify the default vhost and told the service command to perforn a full restart.
````
sudo a2dissite d* && sudo service apache2 reload && sudo a2ensite d* && sudo service apache2 restart
````

We will break each of these out into a separate lines and and pass the VHOST and COMMAND variables as the arguments. We will also comment the code. Please note the ````#```` symbol denotes a comment in Bash.

Add the following to the end of the file.

````
#=============================================================================
# Disable the existing hosts configuration
#=============================================================================
sudo a2dissite $VHOST
sudo service apache2 $COMMAND

#=============================================================================
# Enable the existing hosts configuration
#=============================================================================
sudo a2ensite $VHOST
sudo service apache2 $COMMAND
````

Now we want to make sure the file is executable by adding the executable flag.
````
sudo chmod +x /etc/apache2/sites-available/re.sh
````
We can test this by simply typing the full path into a CLI or by navigating to the parent directory and entering the file name
````
/etc/apache2/sites-available/re.sh

cd /etc/apache2/sites-available && ./re.sh

cd /etc/apache2/sites-available
./re.sh
````
Regardless of the way you choose to execute the file, you will see  the following message _Usage: ./re.sh {virtual-host} {restart|reload}_. let's run this again with but this time we will restart the default-ssl host.  

````
/etc/apache2/sites-available/re.sh default-ssl.conf restart
````

You mat be promted for a password and after executionsomething like the following should print to the screen.

````
Site default-ssl disabled.
To activate the new configuration, you need to run:
  service apache2 reload
Enabling site default-ssl.
To activate the new configuration, you need to run:
  service apache2 reload
````

/etc/apache2/sites-available/re.sh
````
#!/bin/bash

VHOST="$1"
COMMAND="$2"

if [ $# -ne 2 ]
then
        echo "Usage: $0 {virtual-host} {restart|reload}"
        echo "Reloads a target virtual host"
        exit 1
fi


#=============================================================================
# Disable the existing hosts configuration
#=============================================================================
sudo a2dissite $VHOST
sudo service apache2 $COMMAND

#=============================================================================
# Enable the existing hosts configuration
#=============================================================================
sudo a2ensite $VHOST
sudo service apache2 $COMMAND
````

Lab 1 - Improved validation
* Find the documentation for the the service command to determine all valid values for the second parameter.
* Update the validation (if-then) statement to allow only the values listed in the documentation.
* Update the user feedback to include all possible values.
* Change the output color of the error message.

## Additional Reading
* [Bash Guide for Beginners](http://www.tldp.org/LDP/Bash-Beginners-Guide/Bash-Beginners-Guide.pdf)
* [Advanced Bash-Scripting Guide](http://www.tldp.org/LDP/abs/abs-guide.pdf)
* [service](http://manpages.ubuntu.com/manpages/precise/man8/service.8.html)
* [Better Bash Scripting in 15 Minutes](http://robertmuth.blogspot.com/2012/08/better-bash-scripting-in-15-minutes.html)
* [Better Bash Scripting in 15 Minutes (Discussion)](https://news.ycombinator.com/item?id=7595499)

[Next: PHP Basics](07-PHPBasics.md)
