
# BASH

Bash is a scripting language that relies heavily on underlying *nix system. 
While you can use Bash to create complex programs, libraries, frameworks, etc. I
have mainly seen it used for automating redundant tasks. In this lesson we will 
use bash to write to standard output and create a guessing game.

## Write to Standard Output

In this section we will use VIM as our text editor to write a Hello program.

From your home directory create the file *hello.sh*.
```sh
cd ~
vim hello.sh
```

> In VI, ou can edit a file by entering insert mode. To enter insert mode press
> the letter i. If ```--insert--`` appears in the lower left hand corner you
> in insert mode.

*~/hello.sh*
```bash
#!/bin/bash

# This program writes Hello World to stdout.

echo "Hello World"
```

> To save you changes and exit VI press [esc] followed by [shift] + [:]. This 
> open a command prompt ```:``` in the lower left hand corner. Press the [x]
> key followed by [enter].

All shell scripts should start with a shebang statement ```#!/bin/bash``` this 
tells the system which interpreter you want to use to process the file. The 
default shell for Ubuntu Linux is Dash and a opposed to Bash. 

The bash symbol (aka hash or pound) denotes a comment. Anything following and 
on the sign line as the bash symbol will be interpreted as a comment and not
executed as code.

An ```echo``` statement
is a built in Bash command that writes it's arguments to standard output 
(stdout). In this case ```echo "Hello World" would write *Hello World* to
stdout.

Now that we understand the syntax we have just written we will want to run our 
code. In Linux typing ```./``` followed by the filename (with no spaces) 
into the terminal will execute the code in that file.

```sh
./hello.sh
```
This should throw a permission error similar to the following

```sh
bash: ./hello.sh: Permission denied
```
This is because the file is not yet executable. You can make this file 
executable by adding the executable flag.

```sh
chmod +x hello.sh
```

Now if you rerun the script it will write *Hello Wolrd* to stdout.
```sh
./hello.sh
```

As an alternative to ```./``` you may use the ```source``` command to execute a 
shell script.
```sh
source hello.sh
```

### Arguments and Control Structures

Bash provides a special mechanism for dealing with user input and that is 
```$#``` in which ```$#``` represents the total number of parameters starting 
with 0. ```$0``` returns either the name of the file or the execution path 
depending on how it was called. ```./hello.sh``` returns the name of the file 
while ```source hello.sh``` returns the execution path.

Open the hello.sh script in VIM and ```$0 says:``` to the echo statement.
```sh
vim hello.sh
```

Change the last line of the script to the following.
```bash
echo "$0 says: Hello World"
```
Now execute the script suing both of the methods stated above and you will see 
the following.

```sh
./hello.sh
```
will return 
```sh
./hello.sh says: Hello World
```

```sh
source hello.sh
```
will return
```sh
/bin/bash says: Hello World
```

Now we can modify the output by calling the script with additional parameters.

Change the last line as follows.
```bash
echo "$0 says: Hello $i"
```

Then you can call the script, passing your name as an argument.
```sh
./hello.sh Jason
```

The expected output is as follows.
```sh
./hello.sh says: Hello Jason
```

Executing the script without a parameter will return the following.
```sh
./hello.sh says: Hello
```

Now we can use an if statement to make a decision.


Now that we know how to pass and argument lets use an if,then,else to modify the 
output based upon whether or not an argument has been passed. By testing the
first argument ```$1``` against a zero byte operator ```-z``` we can determine 
if an argument has been passed.

```bash
if [ -z "$1" ]
then
# If no arguments have been passed set the value of NAME to "World"
        NAME="World"
else
# If $1 does not equate to zero bytes use it's value to set NAME.
        NAME="$1"
fi

echo "$0 says: Hello $NAME"
```

## Guessing Game
Now that we can write to stdout and use an if statement let's use that knowledge
to build a guessing game. 

In our guessing game the program will pick a number between one and ten then
prompt the user to do the same. If the numbers match then the user wins.

We can start our guessing game by asking the user to enter a number between one
and ten. We can do this with a simple echo statement. 

Create the file *~guess.sh*.
```sh
vim ~/guess.sh
```

Then add the following lines and make the file executable and run it.
```bash
#!/bin/bash

# Ask the user to guess a number
echo -n "Choose a number between 1 and 10 and press [ENTER]: "
```

> To save you changes and exit VI press [esc] followed by [shift] + [:]. This 
> open a command prompt ```:``` in the lower left hand corner. Press the [x]
> key followed by [enter]. 

```sh
chmod +x guess.sh
./guess.sh
```

At this point the program will write *Choose a number between 1 and 10 and press 
[ENTER]:* to stdout and exit. We can keep the program from exiting by giving it 
something to do. We know the ```echo``` statement writes to stdout; in contrast
the ```read``` statement reads from the standard input stream (stdin). Any
string immediately following the ```read``` command will be used a vairable 
for the remainder of our programs execution. In this case we will read the value
of stdin into a variable called ```number```. To test this we will immediately 
dump this variable back to stdout.

```bash
#!/bin/bash

# Ask the user to guess a number
echo -n "Choose a number between 1 and 10 and press [ENTER]: "
read NUMBER

echo "You guessed $NUMBER"
```

At this point executing the program will ask for a number and write it back to 
stdout. The next thing we will want to do is generate a random number between
one and ten. The question is how do we do that? I would start by Googling it.

Head over to Google (or your favorite search engine) and enter [Generate a random number in bash](https://www.google.com/search?q=Generate+a+random+number+in+bash) into the search field. These types of searches will usually return 
something from [StackOverflow](https://stackoverflow.com/questions/1194882/how-to-generate-random-number-in-bash/1195035).
If you really want to learn how to think in terms of code, reading these threads 
are a great source of info. They usually involve multiple working answers and 
the thought process behind them. A lot of the answers will point to the built in
Bash function [```$RANDOM```](http://www.ing.iac.es/~docs/external/bash/abs-guide/randomvar.html). 

```$RANDOM``` returns a number between 0 and 32767. By applying modulo 10 to 
```$RANDOM``` you can contain the range to 0 - 9, so adding to this will get
you a random number between 1 and 10.

* ```RANDOM % 10``` will provide a range of 0 - 9.
* ```1 + RANDOM % 10``` will provide a range of 1 - 10.



```bash
#!/bin/bash

# Ask the user to guess a number
echo -n "Choose a number between 1 and 10 and press [ENTER]: "
read NUMBER

# Generate a random number between 1 and 10
RAND_NUMBER=$((1 + RANDOM % 10))

echo "You guessed  $NUMBER"
echo "The system picked  $RAND_NUMBER"
```

Now if you were to execute the code you would see your guess followed by the 
computers pick. Now we can compare your guess to the computer pick to see if
you're a winner.

```bash
#!/bin/bash

# Ask the user to guess a number
echo -n "Choose a number between 1 and 10 and press [ENTER]: "
read NUMBER

# Generate a random number between 1 and 10
RAND_NUMBER=$((1 + RANDOM % 10))

echo "You guessed  $NUMBER"

if [ $RAND_NUMBER == $NUMBER ]; then
	echo "We have a winner!"
else
	echo "I'm sorry, the answer was $RAND_NUMBER" 
fi
```

## References
1. https://bash.cyberciti.biz/guide/Shebang
2. http://www.linfo.org/echo.html
