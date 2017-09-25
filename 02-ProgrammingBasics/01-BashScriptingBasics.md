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

From a command line navigate to your webroot's mtbc directory and create a new branch called _bash/ex_. This must be created from the dev branch.

````
cd /var/www/mtbc
git checkout master
git pull master
git checkout dev
git pull origin dev
git rebase master
git checkout -B bash/ex
````

Create a file with a path of _/var/www/mtbc/exercises/bash/re.sh_
````
mkdir -p /var/www/mtbc/exercises/bash
touch /var/www/mtbc/exercises/bash/re.sh
````

From your Atom sidebar find and open the re.sh file from the mtbc project.

By default, Ubuntu executes shell scripts using the Dash interpreter. Dash is faster than Bash by virtue of a lack of features and limited syntax making it ideal for quickly parsing out a large number of simple start up scripts. Bash is better suited for interactive scripts, since these are typically run as one off programs, the performance hit is a non-issue. We will have our script invoke the bash shell.

A shebang ````#!```` followed by a path is used to invoke an interpreter, this must be the first line of the file. Add the following line to _re.sh_.

````
#!/bin/bash
````

Add the following to the end of the file. In Bash any line that begins with a _#_ denotes a comment and does not processed by the interpreter. Comments are used to explain the program to other humans.

````
# Disable a vhost configuration
sudo a2dissite default-ssl
sudo service apache2 restart

# Enable a vhost configuration
sudo a2ensite default-ssl
sudo service apache2 restart
````

Now we want to make sure the file is executable by adding the executable flag.

````
sudo chmod +x /var/www/mtbc/exercises/bash/re.sh
````

We can test this by simply typing the full path into a CLI or by navigating to the parent directory and entering the file name

````
/var/www/mtbc/exercises/bash/re.sh

cd /var/www/mtbc/exercises/bash && ./re.sh

cd /var/www/mtbc/exercises/bash
./re.sh
````

Regardless of the way you choose to execute the file you will likely be prompted for a password (on the first run). If all is good you will see something like the following. If you do not get any warnings or error messages then the configuration has been reloaded.

````
Site default-ssl disabled.
To activate the new configuration, you need to run:
  service apache2 reload
Enabling site default-ssl.
To activate the new configuration, you need to run:
  service apache2 reload
````

Commit your changes to _bash/ex_. Your commit message should be something like _Proof of concept_ or _Base implementation_.

## Arguments and conditionals.

### [Conditionals](http://www.cs.utah.edu/~germain/PPS/Topics/conditionals.html)

A conditional (aka if-then-else) is a programming construct that uses equality to make decisions.
Examples of equality given the variable a is equal to one and the variable b is equal to 2.
* a == b (a -eq 0 )//false
* a < b (a -lt 0 )//true
* a > b (a -gt 0 ) //false
* a == 0 (a -eq 0 ) //false
* a >= 0 (a -gte 0 ) //true

### [Arguments](https://stackoverflow.com/questions/7252812/what-is-an-argument)

Arguments or parameters are additional data that are supplied when invoking a program, function, method, sub-route, etc. These provide a specific context upon which a called block of logic will execute.

Examples
* vim hello.txt - Opens vim and loads the file hello.txt
* add(1, 2) - Passes two arguments into a function called add (the values 1 and 2). Once might suspect that this would return the number 3.
* Check.word('random') - This passes _random_ as an argument into the word method of the (fictitious) Check class. Perhaps we are checking the spelling of the word _random_ or maybe this is an argument that tells the method to return a random word.

## Exercise 2 - Working with Arguments and Conditionals
We have reduced four repetitive commands down to a single command, but there is a problem. This only works with a single immutable configuration file and a immutable single service directive. It would be far more useful if I could specify which vhost configuration and which service directive I wanted to use. Lets rewrite re.sh to take some arguments.

Our new shell will take two arguments; the target vhost configuration and the service directive. Bash accepts arguments using a numeric index which starts at zero, zero however, is the name of the script so the argument that sits at index one will access the first parameter. In Bash, the value of stored variables are accessed using a dollar sign. Combining a dollar sign with a number ````"$1"```` will allow you to access a given argument.

Our first argument will be the vhost configuration we want to work with and the second argument will be the service command. We will set these to an aptly named variable to make them easier to work with. We will store the first argument in a variable called _VHOST_ and the second in a variable called _COMMAND_.

Add the following lines right after _#!/bin/bash_. This will copy the first input parameter into a variable called _CONFIG_ and the second input parameter and a variable called _COMMAND_.

````
CONFIG="$1"
COMMAND="$2"
````

The first thing we want out program to do is to verify we have the correct number of arguments. We will do this with an equality check (if-then-else). In bash ````$#```` will return the number of input parameters (starting at index number one). We can check this with an if/then statement _if [ $# -ne 2 ] then_. In this context _-ne_ translates to _not equal_ or in plain English _if the number of input parameters is not equal to 2 then do something_. In our case we will want to provide the user feedback about the expected arguments and exit the program.

Add the following lines to the file. Bellow the CONFIG and COMMAND variable but above the lines from the previous example. In bash ````echo```` is a command that writes it arguments to the standard output while ````exit```` stops the execution of the program and returns control back to the caller. In this case both the standard output and the caller would be the terminal.

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
sudo a2dissite $CONFIG
sudo service apache2 $COMMAND

sudo a2ensite $CONFIG
sudo service apache2 $COMMAND
````

Commit your changes to _bash/ex_. Your commit message should be something like _Added the ability to specify virtual hosts and service commands_.


## Exercise 3 - Loops

When I think of a loop I'm usually thinking about iterating over or parsing out some sort of a list. This might be an array of service commands or all of the configuration files in the _/etc/apache2/sites-available/_ directory.

For each element in the COMMANDS array where an element is defined by the variable COMMAND, if an element exists (meaning we have not iterated past the end of the list) ````do```` echo the value of COMMAND back to the user otherwise ````break```` the loop or _do echo the value of COMMAND until the list is done_.
````
# A list of service commands
COMMANDS=( reload restart )

for COMMAND in "${COMMANDS[@]}"
do
  echo $COMMAND
done
````

For each file in VHOSTS_PATH array where a file is defined by FILENAME, if an element exists (meaning we have not iterated past the end of the list) ````do```` echo the value of FILENAME back to the user otherwise ````break```` the loop or _do echo the value of FILENAME until the list is done_.

````
# List all of the configuration files in the _/etc/apache2/sites-available/_ directory
VHOSTS_PATH=/etc/apache2/sites-available/*.conf

for FILENAME in $VHOSTS_PATH
do
  echo $FILENAME
done
````

Create an executable shell at _/var/www/mtbc/exercises/bash/loops.sh_ and add execute the above code snippets. Commit this to your _bash/ex_ branch with a message like _Added an example of for-in loops in bash_

String concatenation is the addition of one string to another typically through the use of variables.

## Exercise 4 - Strings
Create an executable file _string.sh_ with the following code and commit it to your _bash/ex_ branch.

````
STRING1 = 'Hello'
STRING2 = 'World'
echo "${STRING1} ${STRING2}"
````

The [comparison operator](http://tldp.org/LDP/abs/html/comparison-ops.html) -z returns true if a string has a length of zero. _!_ is the operator for not so _if [ ! -z  "$STRING" ]_ equates to true if the string contains any characters.

## Exercise 5 - Not Empty

While string is not equal to _Hello World_ do stuff until it is. If string is empty change string to _Hello_ otherwise append and blank space and _World_ to the the end of the string.

Create an executable file _/var/www/mtbc/exercises/bash/z.sh_ with the following code and commit it to your _bash/ex_ branch.

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

echo $STRING
````

## Additional Reading
* [A Few Words on Shell Scripts](https://jasonsnider.com/posts/view/a-few-words-on-shell-scripts)
* [Bash Guide for Beginners](http://www.tldp.org/LDP/Bash-Beginners-Guide/Bash-Beginners-Guide.pdf)
* [Advanced Bash-Scripting Guide](http://www.tldp.org/LDP/abs/abs-guide.pdf)
* [service](http://manpages.ubuntu.com/manpages/precise/man8/service.8.html)
* [Better Bash Scripting in 15 Minutes](http://robertmuth.blogspot.com/2012/08/better-bash-scripting-in-15-minutes.html)
* [Better Bash Scripting in 15 Minutes (Discussion)](https://news.ycombinator.com/item?id=7595499)

[Next: PHP Basics](09-PHPBasics.md)
