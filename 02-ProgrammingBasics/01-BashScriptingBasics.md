# Bash Scripting and Programming Basics
In this lesson you will learn some of the very basics of programming an Bash scripting.

## Exercise 1 - Scripting Repetitive Tasks.
In the previous lesson you learned the four commands for reloading virtual-host configuration. While that may not seem to cumbersome when your not updating your site all that often; it gets a little repetitive when your testing updates. Let's write a Bash script to reduce this process to one command. A typical Bash script is little more than scripted arrangement or sequence of Linux commands. In addition to Linux commands shell scripts may accept parameters and may utilize variables, functions and control statements.

Write a bash script that will replace all four commands for restarting a website with a single command.

In the previous lesson we used the following four command to reload a vhost configuration and restart the Apache web server.
````
sudo a2dissite d* && sudo service apache2 reload && sudo a2ensite d* && sudo service apache2 restart
````

That single line equates to the following four lines.

````
sudo a2dissite d*
sudo service apache2 reload
sudo a2ensite d*
sudo service apache2 restart
````

[Create a fork](https://help.github.com/articles/fork-a-repo/) of [Restart Apache](https://github.com/microtrain/restart_apache) project from MicroTrain's GitHub repository.

````
cd ~
git clone https://github.com/YOUR-USERNAME/restart_apache
````

Add the *~/restart_apache* as a [project folder](http://blog.atom.io/2015/04/15/multi-folder-projects.html) to your Atom sidebar and open the file re.sh.

By default, Ubuntu executes shell scripts using the Dash interpreter. Dash is faster than Bash by virtue of a lack of features and limited syntax making it ideal for quickly parsing out a large number of simple start up scripts. Bash is better suited for interactive scripts, since these are typically run as one off programs the performance hit is a non-issue. Our scripts will invoke the Bash shell.

A shebang ````#!```` followed by a path is used to invoke an interpreter, this must be the first line of the file.

````
#!/bin/bash
````

In Bash any line that begins with a _#_ denotes a comment and does not processed by the interpreter. Comments are used to explain the program to other humans.

````
# Disable a vhost configuration
sudo a2dissite *
sudo service apache2 restart

# Enable a vhost configuration
sudo a2ensite *
sudo service apache2 restart
````

Now we want to make sure the file is executable by adding the executable flag.

````
cd ~/restart_apache
sudo chmod +x ~/restart_apache/re.sh
````

This script will attempt to treat all files in the current working directory (CWD) as virtual hosts. To test this shell we will want to move to the sites-available directory. Then we can invoke the file.

````
cd ~/restart_apache/re.sh
sudo cp re.sh /etc/apache2/sites-available/re.sh

cd /etc/apache2/sites-available
./re.sh
````

After invoking the script you will likely be prompted for a password (on the first run). If all is good you will see something like the following. If you do not get any warnings or error messages (other than *ERROR: Site re.sh does not exist!*) then the configuration has been reloaded.

````
Site default-ssl disabled.
To activate the new configuration, you need to run:
  service apache2 reload
  Enabling site 000-default.
  Enabling site default-ssl.
  ERROR: Site re.sh does not exist!
To activate the new configuration, you need to run:
  service apache2 reload
````

## Arguments and conditionals.

### [Conditionals](http://www.cs.utah.edu/~germain/PPS/Topics/conditionals.html)

A conditional (aka if-then-else) is a programming construct that uses equality to make decisions.
Examples of equality given the variable a is equal to one and the variable b is equal to 2.

* a == b (a -eq 0 ) //false
* a < b (a -lt 0 ) //true
* a > b (a -gt 0 ) //false
* a == 0 (a -eq 0 ) //false
* a >= 0 (a -gte 0 ) //true
* a <= 0 (a -lte 0 ) //false

### [Arguments](https://stackoverflow.com/questions/7252812/what-is-an-argument)

Arguments or parameters are additional data that are supplied when invoking a program, function, method, sub-route, etc. These provide a specific context upon which a called block of logic will execute.

Examples
* vim hello.txt - Opens vim and loads the file hello.txt
* add(1, 2) - Passes two arguments into a function called add (the values 1 and 2). Once might suspect that this would return the number 3.
* Check.word('random') - This passes _random_ as an argument into the word method of the (fictitious) Check class. Perhaps we are checking the spelling of the word _random_ or maybe this is an argument that tells the method to return a random word.

## Exercise 2 - Working with Arguments and Conditionals

In this exercise we will work with the file *~/restart_apache/re.sh* on a *branch called feature/arguments*.
Create a [feature branch](https://www.atlassian.com/agile/branching) called _feature/arguments_.
````
cd ~/restart_apache
git checkout -B feature/arguments
````

We have reduced four repetitive commands down to a single command, but there is a problem. This only works with a single immutable configuration and an immutable single service directive. It would be far more useful if we could specify which virtual host configuration and which service directive we wanted to use. Lets rewrite re.sh to take some arguments.

Our new shell will take two arguments; the target virtual host configuration and the service directive. Bash accepts arguments using a numeric index which starts at zero, zero however, is the name of the script so the argument that sits at index one will access the first parameter. In Bash, the value of stored variables are accessed using a dollar sign. Combining a dollar sign with a number ````"$1"```` will allow you to access a given argument.

Our first argument will be the virtual host configuration we want to work with and the second argument will be the service command. We will set these to an aptly named variable to make them easier to work with. We will store the first argument in a variable called _CONFG_ and the second in a variable called _COMMAND_. When referencing a variable in bash it advisable to always [quote the varaible](http://tldp.org/LDP/abs/html/quotingvar.html).

Add the following lines right after _#!/bin/bash_.

````
CONFIG="$1"
COMMAND="$2"
````

The first thing we want our program to do is to verify we have the correct number of arguments. We will do this with an equality check (if-then-else). In Bash ````$#```` will return the number of input parameters (starting at index number one). We can check this with an if/then statement _if [ $# -ne 2 ] then_. In this context _-ne_ translates to _not equal_ or in plain English _if the number of input parameters is not equal to 2 then do something_. In our case we will want to provide the user feedback about the expected arguments and exit the program.

Add the following lines to the file. Bellow the CONFIG and COMMAND variables but above the lines from the previous example. In bash ````echo```` is a command that writes it arguments to the standard output while ````exit```` stops the execution of the program and returns control back to the caller. In this case both the standard output and the caller would be the terminal.

````
if [ $# -ne 2 ]
then
    echo "Usage: $0 {virtual-host} {restart|reload}"
    echo "Reloads a target virtual host"
    exit 1
fi
````

Finally, replace the _ssl-default_ with a call to the _CONFIG_ variable by prefixing CONFIG with a dollar sign _$CONFIG_ and do the same for _COMMAND_

````
sudo a2dissite "$CONFIG"
sudo service apache2 "$COMMAND"

sudo a2ensite "$CONFIG"
sudo service apache2 "$COMMAND"
````

Test your changes like we did after forking the repository.

````
sudo rm /etc/apache2/sites-available/re.sh

cd ~/restart_apache/re.sh
sudo cp re.sh /etc/apache2/sites-available/re.sh

cd /etc/apache2/sites-available
./re.sh
````

Commit your changes to _feature/arguments_. Your commit message should be something like _Added the ability to specify virtual hosts and service command_.

Merge you changes into master

````
git checkout master
git merge -B feature/arguments
````

Now on master update the README.md file to explain how to use the latest version of the program and commit that change with an appropriate message. Then open VERSION.txt and move the version to 0.2.0 and commit with a message of *Version 0.2.0*. Push your changes to master.

````
git push origin master
````

## Exercise 3 - Reject unwanted service commands

For this exercise, create a feature branch called *feature/validate*. When you are finished increment the version to 0.2.1 and push to master.

The product owner has requested that we only be allowed to pass *reload* or *restart* into the service command. To accomplish this, lets add a new variable to the top of our script called OK and lets set that to false.

````
OK=false
````
We can then test against the value of the $COMMAND argument to make sure it is in the approved list. If it is we will change the value of OK to true. Add the following lines after the current block that checks for the proper number of arguments.

````

# reload is allowed
if [ "$COMMAND" == "reload" ]
then
  OK=true
fi

# restart is allowed
if [ "$COMMAND" == "restart" ]
then
  OK=true
fi

````

Finally, we MUST to exit the program if OK has NOT been set to true. Add the following after the block that checks fro a restart.

````
# reject any service command that was not white listed
if [ "$OK" == false ]
then
  echo "Usage: $0 $CONFIG {restart|reload}"
  exit 1
fi
````

## Exercise 4 - Loop through an Array

When I think of a loop I'm usually thinking about iterating over or parsing out some sort of a list. This might be an array of service commands or all of the configuration files in the _/etc/apache2/sites-available/_ directory.

For each element in the COMMANDS array where an element is defined by the variable COMMAND, if an element exists (meaning we have not iterated past the end of the list) ````do```` echo the value of COMMAND back to the user otherwise ````break```` the loop or _do echo the value of COMMAND until the list is done_.

Create the file *~/bash/loop.sh* and make it executable

````
mkdir -p ~/bash
cd ~/bash
touch loop.sh
chmod +x ./loop.sh
vim loop.sh
````

Add the following lines and execute the file.

````
#!/bin/bash

# A list of service commands
COMMANDS=( reload restart )

for COMMAND in "${COMMANDS[@]}"
do
  echo $COMMAND
done
````

## Exercise 5 - Loop through all files in a Directory
For each file in VHOSTS_PATH array where a file is defined by FILENAME, if an element exists (meaning we have not iterated past the end of the list) ````do```` echo the value of FILENAME back to the user otherwise ````break```` the loop or _do echo the value of FILENAME until the list is done_.

Update *~/bash/loop.sh* with the following.

````
# List all of the configuration files in the _/etc/apache2/sites-available/_ directory
VHOSTS_PATH=/etc/apache2/sites-available/*.conf

for FILENAME in $VHOSTS_PATH
do
  echo $FILENAME
done
````

String concatenation is the addition of one string to another typically through the use of variables.

## Exercise 6 - Strings
Create an executable Bash file at _~/bash/string.sh_ and add the following code.

````
STRING1 = 'Hello'
STRING2 = 'World'
echo "${STRING1} ${STRING2}"
````

The [comparison operator](http://tldp.org/LDP/abs/html/comparison-ops.html) -z returns true if a string has a length of zero. _!_ is the operator for not so _if [ ! -z  "$STRING" ]_ equates to true if the string contains any characters.

## Exercise 7 - Not Empty

_-z_ is an equality check for zero.

Create an executable Bash file at _~/bash/notEmpty.sh_ and add the following logic.

* While the variable STRING is not equal to _"Hello World"_ continually check the value of string.
* If STRING has a length of zero change the value of STRING to _"Hello"_.
* If STRING has anything other than a zero length append _" World"_ to the current value.

````
#!/bin/bash

STRING=''
while [ "$STRING" != "Hello World" ]
do
    if [ -z  "$STRING" ]
    then
      STRING="Hello"
    else
      STRING="${STRING} World"
    fi
done

echo "$STRING"
````

## Lab

Update the shell script restart apache project so that if the user does not provide valid options a list of available commands and apache configuration files is returned to the user.  


## Questions

1. In Bash, why should you quote variables when referencing them?
1. In Bash, what is *-z*?
1. In Bash, when do you prefix a variable with a dollar sign?
1. How many ways can you come up with to create an array in Bash.
1. What is an array?
1. What does the _*_ in _/etc/apache2/sites-available/*.conf_ do?


## Additional Reading

* [A Few Words on Shell Scripts](https://jasonsnider.com/posts/view/a-few-words-on-shell-scripts)
* [Bash Guide for Beginners](http://www.tldp.org/LDP/Bash-Beginners-Guide/Bash-Beginners-Guide.pdf)
* [Advanced Bash-Scripting Guide](http://www.tldp.org/LDP/abs/abs-guide.pdf)
* [service](http://manpages.ubuntu.com/manpages/precise/man8/service.8.html)
* [Better Bash Scripting in 15 Minutes](http://robertmuth.blogspot.com/2012/08/better-bash-scripting-in-15-minutes.html)
* [Better Bash Scripting in 15 Minutes (Discussion)](https://news.ycombinator.com/item?id=7595499)

[Next: PHP Basics](09-PHPBasics.md)
