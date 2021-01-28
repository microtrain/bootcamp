# Bash Scripting Basics
In this section, you will learn how to create a Bash script to automate repetitive tasks.

## Exercise 1 - Scripting Repetitive Tasks
In a previous lesson, you learned the four commands for reloading a virtual-host configuration. While that may not seem too cumbersome when your not updating your site all that often; it gets a little annoying when your testing updates. We will write a Bash script to reduce the burden of this task. A typical Bash script is an arrangement or sequence of Linux commands wrapped in a control structure. In addition to Linux commands shell scripts may accept parameters, utilize control statements, variables, and functions.


**Requirements**

Write a bash script that will reduce the four commands for reloading a virtual host configuration and restarting a server on a Debian based LAMP stack to a single command.

In a previous lesson, we used the following four commands to reload a virtual-host configuration and restart the Apache webserver.

```sh
sudo a2dissite * && sudo service apache2 reload && sudo a2ensite * && sudo service apache2 restart
```

That single line equates to the following four lines.

```sh
sudo a2dissite *
sudo service apache2 reload
sudo a2ensite *
sudo service apache2 restart
```
Anding these statements together makes a copy/paste easier but that is about the only advantage.

[</> code](https://github.com/stack-x/restart_apache/commit/5292f0793b7d55e7afbec0d40876ff9e00a294e8) **Create a repository and initial commit**

On GitHub [create a repository](https://help.github.com/articles/create-a-repo/) called *restart_apache*.

![Create a Repo](/img/bash/create_repo.png)

Clone the restart_apache repository onto your local development machine.

![Create a Repo](/img/bash/clone.png)


```sh
cd ~
git clone git@github.com:YOUR-GITHUB-USERNAME/restart_apache
```

[</> code](https://github.com/stack-x/restart_apache/commit/2557e8cc6c43736c4965e0d6aa89f3a9020ec17c) **Proof of Concept**

I like to start with a simple proof of concept, this is working code provides either a starting or talking point. For some projects, a proof of concept code may represent a complete working solution but may not be considered the optimal solution.

Add *~/restart_apache* as a [new folder](https://code.visualstudio.com/docs/editor/multi-root-workspaces) in your VSC workspace and create a new file *re.sh*.

By default, Ubuntu executes shell scripts using the Dash interpreter. Dash is faster than Bash by virtue of a lack of features and limited syntax, making it ideal for quickly parsing out a large number of simple startup scripts. Bash is better suited for interactive scripts. Since start-up scripts are typically run as one-off programs the performance hit is a non-issue. Our scripts will invoke the Bash shell. Add the following to *re.sh*, this will allow you reload all Apache configurations with a single command.

A shebang ```#!``` followed by a path is used to invoke an interpreter, this must be the first line of the file.

```sh
#!/bin/bash
```

In Bash, any line that begins with a # denotes a comment. Comments are not processed by the interpreter. Comments are used to explain the program to other humans.
```sh
# Move the current execution state to the proper directory
cd /etc/apache2/sites-available

# Disable a vhost configuration
sudo a2dissite *
sudo service apache2 restart

# Enable a vhost configuration
sudo a2ensite *
sudo service apache2 restart
```

Now we want to make sure the file is executable by adding the executable flag.

```sh
cd ~/restart_apache
chmod +x re.sh
```

Since many of the commands require root access you will want to sudo this script when you run it.
```sh
sudo ./re.sh
```

You should see the following results.
```sh
Site 000-default disabled.
Site default-ssl disabled.
To activate the new configuration, you need to run:
  service apache2 reload
  Enabling site 000-default.
  Enabling site default-ssl.
To activate the new configuration, you need to run:
  service apache2 reload
```

### Commit your changes and push them to GitHub

```sh
git add .
git commit -a
```

VI will open an ask you to enter a commit message. 
1. Press the letter [i] to enter insert mode. 
1. Then type the message _Proof of concept version_. 
1. Press [esc] followed by [:x] and enter to save the commit message.

Push your changes to the main branch.

```sh
git push origin main
```

#### [Semantic Versioning](https://semver.org/)

[</> code](https://github.com/stack-x/restart_apache/commit/8666e8d3070669e171b9e3c6d2e40abcfb72b0ee) Semantic versioning is s community standard that helps you communicate the compatibility of a change. We will use it here as an introduction to the concept.

1. Create the file VERSION.txt
1. Add the text _0.0.1_
1. git add VERSION.txt
git commit VERSION.txt

VI will open an ask you to enter a commit message. 
1. Press the letter [i] to enter insert mode. 
1. Then type the message _Version 0.0.1_. 
1. Press [esc] followed by [:x] and enter to save the commit message.

Push your changes to the main branch.
 
```sh
git push origin main
```

#### Add a tag

In addition to Semantic Versioning, a common practice is to tag significant versions.

1. git tag 0.0.1
1. git push origin --tags

Go to your project on GitHub and find everything that is tagged.

### Summary

In this exercise, you learned how 
* to create a basic shell script (Bash, Programming)
* commit your code changes (Git)
* apply semantic versioning (Git)
* use tags to create code releases (Git)


## Arguments and conditionals.

### [Conditionals](http://www.cs.utah.edu/~germain/PPS/Topics/conditionals.html)

A conditional (aka if-then-else) is a programming construct that uses equality to make decisions.
Examples of equality given the variable a is equal to one and the variable b is equal to 2.

If a = 0 and b = 1

* a == b (a -eq b ) //false
* a < b (a -lt b ) //true
* a > b (a -gt b ) //false
* a == 0 (a -eq 0 ) //true
* a >= 0 (a -gte 0 ) //true
* a <= 0 (a -lte 0 ) //true

### [Arguments](https://stackoverflow.com/questions/7252812/what-is-an-argument)

Arguments or parameters are additional data that are supplied when invoking a program, function, method, sub-route, etc. These provide a specific context upon which a called block of logic will execute.

Examples
* vim hello.txt - Opens vim and loads the file hello.txt
* add(1, 2) - Passes two arguments into a function called add (the values 1 and 2). One might suspect that this would return the number 3.
* Check.word('random') - This passes _random_ as an argument into the word method of the (fictitious) Check class. Perhaps we are checking the spelling of the word _random_ or maybe this is an argument that tells the method to return a random word.

## Exercise 2 - Working with Arguments and Conditionals

In this exercise, we will work with the file *~/restart_apache/re.sh* on a *branch called feature/arguments*.
Create a [feature branch](https://www.atlassian.com/agile/branching) called _feature/arguments_.

```sh
cd ~/restart_apache
git checkout -B feature/arguments
```

We have reduced four repetitive commands down to a single command, but there is a problem. This only works with a single immutable configuration and an immutable single service directive. It would be far more useful if we could specify which virtual host configuration and which service directive we wanted to use. Let's rewrite re.sh to take some arguments.

Our new shell will take two arguments; the target virtual host configuration and the service directive. Bash accepts arguments using a numeric index which starts at zero, zero, however, is the name of the script so the argument that sits at index one will access the first parameter. In Bash, the value of a stored variable is accessed using a dollar sign. Combining a dollar sign with a number ```"$1"``` will allow you to access a given argument.

Our first argument will be the virtual host configuration we want to work with and the second argument will be the service command. We will set these to an aptly named variable to make them easier to work with. We will store the first argument as a variable named CONFG and the second as a variable named COMMAND. When referencing a variable in bash it advisable to always [quote the variable](http://tldp.org/LDP/abs/html/quotingvar.html).

[</> code](https://github.com/stack-x/restart_apache/commit/868e8670b543040460e0ffbc6468e1bbd2a21b29) Add the following lines right after _#!/bin/bash_.

```sh
CONFIG="$1"
COMMAND="$2"
```

The first thing we want our program to do is to verify we have the correct number of arguments. We will do this with an equality check (if-then-else). In Bash ```$#``` will return the number of input parameters (starting at index number one). We can check this with an if/then statement _if [ $# -ne 2 ] then_. In this context _-ne_ translates to _not equal_ or in plain English _if the number of input parameters is not equal to 2 then do something_. In our case, we will want to provide the user with feedback about the expected arguments and exit the program.

Add the following lines to the file. Bellow the CONFIG and COMMAND variables but above the lines from the previous example. In Bash, ```echo``` is a command that writes its arguments to the standard output while ```exit``` stops the execution of the program and returns control back to the caller. In this case, both the standard output and the caller would be the terminal.

```sh
if [ $# -ne 2 ]
then
    echo "$0 requires two parameters {virtual-host} {restart|reload}"
    exit 1
fi
```

Finally, replace the _*_ with a call to the _CONFIG_ variable by prefixing CONFIG with a dollar sign _$CONFIG_ and do the same for _COMMAND_

```sh
sudo a2dissite "$CONFIG"
sudo service apache2 "$COMMAND"

sudo a2ensite "$CONFIG"
sudo service apache2 "$COMMAND"
```

./re.sh 000* restart

Commit your changes to _feature/arguments_ with the message _Added the ability to specify virtual hosts and service command_.

Push your new feature branch to GitHub, you can delete this branch once the feature is complete.
```sh
git push origin feature/arguments
```

[</> code](https://github.com/stack-x/restart_apache/commit/4a6452772617248942ac6c78c5cc88071eda472f) Update README.txt so people know how to use it. Add something like the following.

````md
## Usage
Clone the repository or download the latest release. 

From a command-line call re.sh with two arguments.
1. The vhost configuration
1. The service directive {restart|reload}
```sh
./re.sh 000* restart
```
````

Commit the change with the message *README updates*
```sh
git commit -a
git push origin feature/arguments
```

Then open VERSION.txt and move the version to 0.1.0 and commit with a message of *Version 0.1.0*. 
```sh
git commit -a
git push origin feature/arguments
```

Push your changes to the main branch.

```sh
git push origin main
```

Merge your changes into main

```sh
git checkout main
git merge feature/arguments
git push origin main
```

[</> code](https://github.com/stack-x/restart_apache/commit/a1d7c591db2bc6518c714063d01d1c1190dbbf70) Tag a new version
1. git tag 0.1.0
1. git push origin --tags

Now that all code changes have been applied to main you can remove your working branch.

```sh
git branch -D feature/arguments
git push origin :feature/arguments
```

### Summary

In this exercise, you learned how 
* work with arguments and variables (Bash, Programming)
* use an if-then statement (Bash, Programming)
* create a feature branch (Git)
* merge a feature branch into main (Git)
* remove old working branches (Git)


## Exercise 3 - Reject unwanted service commands

For this exercise, create a feature branch called *feature/validate*. When you are finished increment the version to 0.2.0 then merge into and push to main.

**Requirements**

The product owner has requested that we only pass *reload* or *restart* into the service command. To achieve this we will need to run a test against the second argument to verify it matches a valid command.

To accomplish this we can then test against the value of the $COMMAND argument to make sure it is in the approved list. If it is then we can allow the program to proceed. Otherwise, we will return an error message to the user.

We will start with a simple if-then-else statement. This if-statement differs from the previous exercise in that it adds an OR statement. In Bash OR statements are represented as a double pipe ```||```. If either of these conditions equates to true then the code inside the ```then``` block will execute. Otherwise, we will drop into the ```else``` block. 

```sh
# only allow reload or restart.
if [ "$COMMAND" == "reload" ] || [ "$COMMAND" == "restart" ]
then

else
    echo "ERROR: $COMMAND is an invalid service command {restart|reload}"
    exit 1
fi
```

[</> code](https://github.com/stack-x/restart_apache/commit/b83b3dda2a4c4a67b368f2872ecc1cc9e2bd7abc) Once we have our basic statement in place cut and paste the reload/reset logic into the ```then``` block.

```sh
if [ "$COMMAND" == "reload" ] || [ "$COMMAND" == "restart" ]
then
    # Move the current execution state to the proper directory
    cd /etc/apache2/sites-available

    # Disable a vhost configuration
    sudo a2dissite "$CONFIG"
    sudo service apache2 "$COMMAND"

    # Enable a vhost configuration
    sudo a2ensite "$CONFIG"
    sudo service apache2 "$COMMAND"
else
    echo "ERROR: $COMMAND is an invalid service command {restart|reload}"
    exit 1
fi
```
```sh
git add .
git commit -m 'Added the ability to reject unauthorized service directives'
git push origin main
```
 
[</> code](https://github.com/stack-x/restart_apache/commit/170b1e43c47c346362440cbb939f3b9ca3733b38) Update VERSION.txt to 0.2.0
```sh
git add .
git commit -m 'Version 0.2.0'
git push origin main

git tag 0.2.0
git push origin --tags
```

### Attention to Detail

[</> code](https://github.com/stack-x/restart_apache/commit/122e30e7396d219a0fba9c8b29a2a7875965732d) Check out the format of our new error message. It begins with the word _ERROR:_ in all caps. This is good UX in that it removes any ambiguity about the message. To keep user feedback consistent prefix the error message in the first if statement with _ERROR:_.

```sh
git commit -am 'Improved messaging'
git push origin main
```

[</> code](https://github.com/stack-x/restart_apache/commit/708d8f60ca6694268d74dbb36df1fa0780d1da4d) Since this commit does not add or remove it is considered a patch so we will increment version as a patch.
Update VERSION.txt to 0.2.1
```sh
git commit -am 'Version 0.2.1'
git push origin main

git tag 0.2.1
git push origin --tags
```


## Exercise 4 - Loops and Arrays

When I think of a loop I'm usually thinking about iterating over or parsing out some sort of a list. This might be an array of service commands or all of the configuration files in the _/etc/apache2/sites-available/_ directory. 

In this exercise, we will build an array of valid service commands and iterate over those commands.

For each element in the COMMANDS array where an element is defined by the variable COMMAND, if an element exists (meaning we have not iterated past the end of the list) ```do``` echo the value of COMMAND back to the user otherwise ```break``` the loop or _do echo the value of COMMAND until the list is done_.

Create the file */var/www/mtbc/bash/loop.sh* and make it executable

```sh
mkdir -p /var/www/mtbc/bash
cd /var/www/mtbc/bash
touch loop.sh
chmod +x loop.sh
vim loop.sh
```

Add the following lines and execute the file.

```sh
#!/bin/bash

# A list of service commands
COMMANDS=( reload restart )

for COMMAND in "${COMMANDS[@]}"
do
  echo $COMMAND
done
```

Execute the code
```sh
./loop.sh
```

[</> code](https://github.com/stack-x/mtbc/commit/97af863e19d1aa0d38df2231f88c90eb52ea6bd0) 
Commit your code and push it to the main branch of the mtbc project.
*Bash exercise 4 - loop example*

### Summary

In this exercise, we learned
* how to create an array
* how to iterate over an array
* how to create a file using the *touch* command

## Exercise 5 - Loop through all files in a Directory
For each file in VHOSTS_PATH array where a file is defined by FILENAME, if an element exists (meaning we have not iterated past the end of the list) ```do``` echo the value of FILENAME back to the user otherwise ```break``` the loop or _do echo the value of FILENAME until the list is done_.

Add the following to */var/www/mtbc/bash/loop.sh* with the following.

```sh
# List all of the configuration files in the _/etc/apache2/sites-available/_ directory
VHOSTS_PATH=/etc/apache2/sites-available/*.conf

for FILENAME in $VHOSTS_PATH
do
  echo $FILENAME
done
```
Running ```./loop.sh``` will now yield the following.
```sh
/etc/apache2/sites-available/000-default.conf
/etc/apache2/sites-available/default-ssl.conf
```

[</> code](https://github.com/stack-x/mtbc/commit/5539ba0cc994bc083779bd5fac435acbe6647159) 
Commit your code and push it to the main branch of the mtbc project.
*Bash exercise 5 - loop example*

### Summary

In this exercise, we learned
* loop through files in a directory

## Exercise 6 - Strings

String concatenation is the addition of one string to another, typically through the use of variables.
Create an executable Bash file at _/var/www/mtbc/bash/string.sh_ and add the following code.

```sh
#!/bin/bash

STRING1='Hello'
STRING2='World'
echo "${STRING1} ${STRING2}"
```

[</> code](https://github.com/stack-x/mtbc/commit/f7047686a4314f412e8829f836c4f2776399293e) 
Commit your code and push it to the main branch of the mtbc project.
*Bash exercise 6 - string example*

### Summary

In this exercise, we learned how to
* concatenate two strings.


## Exercise 7 - Not Empty

The [comparison operator](http://tldp.org/LDP/abs/html/comparison-ops.html) -z returns true if a string has a length of zero. _!_ is the operator for not so _if [ ! -z  "$STRING" ]_ equates to true if the string contains any characters.

_-z_ is an equality check for zero.

Create an executable Bash file at _/var/www/mtbc/notEmpty.sh_ and add the following logic.

* While the variable STRING is not equal to _"Hello World"_ continually check the value of STRING.
* If STRING has a length of zero change the value of STRING to _"Hello"_.
* If STRING has anything other than a zero-length append _" World"_ to the current value.

```sh
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

    echo "$STRING"
    
done
```

[</> code](https://github.com/stack-x/mtbc/commit/edd6e7e924bf05dda48dcbed5ade53cd17c563fb) 
Commit your code and push it to the main branch of the mtbc project.
*Bash exercise 7 - not empty example*

## Exercise 8 - String Position

String-position allows you to extract parts of a string by specifying a numeric index starting at 0. Bash allows you to define string positions using colons with a variable. 

A starting position of 0 will return the entire string.
```sh
${VARIABLE:starting-position} 
```
A starting position of 0 and an end position of 4 will return the first four characters of a string. 
```sh
${VARIABLE:starting-position:length}
```

A starting position of 0 and an end position of -4 will return everything between the first character and the fourth character from the end.
```sh
${VARIABLE:starting-position:end-position}
```

Create the executable Bash file _/var/www/mtbc/stringPosition.sh_ and add the following logic.
```sh
#!/bin/bash

STRING="The quick brown fox jumped over the lazy dog"

echo "${STRING:41}"
echo "${STRING:4:5}"
echo "${STRING:36:-4}"
```
This string will return 
```sh
dog
quick
lazy
```
[</> code](https://github.com/stack-x/mtbc/commit/81c6b40bf64bdffb4617b20162d75de1821d976a) Commit your code and push it to the main branch of the mtbc project. Bash exercise 8 - string position example

## Lab

Update the re.sh script such that
* The user will receive an error message if they attempt to reload/restart a virtual-host file that does not exist in /etc/apache2/sites-available.
* The system will return a list of valid files as a part of the error message.
* The system will exit prior to evaluating the reload command if an invalid virtual-host has been chosen.

### Extra Credit

Google "formatting bash", find and read some results about formatting output text in bash. Look for things like escape characters, font colors, bold and italic text, carriage returns/newlines, etc. Using this new knowledge, improve the output of the error messages so that they may read in a more intuitive, scan friendly manner.

## Questions

1. In Bash, why should you quote variables when referencing them?
1. In Bash, what is *-z*?
1. In Bash, when do you prefix a variable with a dollar sign?
1. How many ways can you come up with to create an array in Bash?
1. What is an array?
1. What does the __*__ in _/etc/apache2/sites-available/*.conf_ do?


## Additional Resources
* [A Few Words on Shell Scripts](https://jasonsnider.com/posts/view/a-few-words-on-shell-scripts)
* [Bash Guide for Beginners](http://www.tldp.org/LDP/Bash-Beginners-Guide/Bash-Beginners-Guide.pdf)
* [Advanced Bash-Scripting Guide](http://www.tldp.org/LDP/abs/abs-guide.pdf)
* [service](http://manpages.ubuntu.com/manpages/precise/man8/service.8.html)
* [Better Bash Scripting in 15 Minutes](http://robertmuth.blogspot.com/2012/08/better-bash-scripting-in-15-minutes.html)
* [Better Bash Scripting in 15 Minutes (Discussion)](https://news.ycombinator.com/item?id=7595499)
* [Bash String Manipulation](https://www.thegeekstuff.com/2010/07/bash-string-manipulation/)
* [FLOZz' MISC » bash:tip_colors_and_formatting](https://misc.flogisoft.com/bash/tip_colors_and_formatting)

[Next: Servers and the Internet](/04-ServersAndTheInternet/README.md)
