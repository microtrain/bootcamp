
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
output based upon whether or not an argument has been passed.

```bash
if [ "$#" == 1 ]
then
        NAME="$1"
else
        NAME="World"
fi

echo "$0 says: Hello $NAME"
```

## References
1. https://bash.cyberciti.biz/guide/Shebang
2. http://www.linfo.org/echo.html
