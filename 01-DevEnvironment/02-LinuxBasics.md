# Linux Basics

This section is intended to provide a reference for the basic commands needed to navigate a Linux system from the command line. We will take a deeper dive and use these commands in later lessons. While we call these commands, they are really programs. In other words, when you type a command in Linux, you are really invoking a program. Most programs can be invoked with out any additional arguments (aka parameters), but in most cases, you will want to pass additional arguments into the program.

For example ```vim filename.txt``` would use an editor called vim to open a file that is named filename.txt. Some programs expect arguments to  be passed in a specific order while others have predefined arguments. All Linux programs predefine ```--help``` so you might type ```chown --help``` to learn how to use the chown command (or program).

* ```[command] --help``` - Returns a help file for any command (or program).
* ```sudo``` - Super-user do (elevates privs to admin).
* ```chown``` - CHange OWNership, changes the ownership of a file.
* ```chown user1:group1 some-file``` - Changes the ownership of some-file to user1 and group1.
* ```chmod``` - CHange MODe, changes file permissions.
* ```chmod +x filename``` - Makes a file executable.

* ```apt-get``` - Retrieves and maintains packages from authenticated sources.
* ```apt-get install [package]``` - Installs a target package from a repository.
* ```apt-get update``` - Update your package list..\
* ```apt-get upgrade``` - Upgrade all packages from the updated list
* ```apt-get remove``` - Remove all packages.
* ```apt-get purge``` - Remove all packages and their config files.

* ```dpkg``` - A package manager for Debian-based systems, this is primarily used to deal with files ending with a ```.deb``` extension.
* ```sudo dpkg --install some-pkg.deb``` - Installs some-pkg.deb.

* ```pwd``` - Print working directory (where am I?).
* ```ls``` - List (a list of files and directories).
* ```ls -l``` - List long format (file permissions, owner, group, size, last mod, directory name).
* ```ls -a``` List all (show hidden files).
* ```ls -la``` List all in long format(ls -l + ls -a).
* ```ls -R``` List recursive (shows all child files).
* ```cd``` - Change directory.
* ```cd ~``` - Change directory to home (a shortcut to your home directory).

Linux does not use drive letters, rather everything is mounted to a root name space. ```/```.
* ```/``` - root
* ```/etc``` - sytem configuration
* ```/var``` - installed software
* ```/var/log``` - log files
* ```/proc``` - real time system information
* ```/tmp``` - temp files, cleared on reboot

tip: Use tab expansions to auto-complete a command or an asterisk as a wild card. The up and down arrows can allow you to browse your command history and replay previous commands. Use ```Ctrl + r``` to search your command history by entering partial commands.

* ```cat``` - Concatenate (dumps a file to the console, a handy read only hack).
* ```cat [filename]|less``` - Pipe the cat command into a paginated CLI (less --help).
* ```cat [filename]|tail``` - Last line of the file, great for looking at log files.
* ```cat [filename]|tail -f``` - Last line of the file, great for looking at log files.

* ```find -name [x]``` Find all file for whom the name matches x.
* ```find -name [x]``` Print|less find all files for which the name matches x and print them to a paginated CLI.

On this system Apache writes log files to /var/log/apache2. For this example I only want to retrieve a list of the error logs.
* ```cd /var/log/apache2``` - Change to the Apache error log directory.

* ```find *error.log.*``` - Find all error logs in the current working directory (CWD).

* ```cd / && locate access.log``` - Locate all access logs (recursively) under the root directory.

* ```grep``` - Globally Search a Regular Expression and Print (Uses Regular Expressions (regex) to search inside of files).
* ```* - wildcard```
* ```/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/``` - Check an ip address regex in code.

Beyond Linux: Regex in code.
```
//Returns 1 if $string matches a valid IP, returns 0 if it does not.
$valid = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $string);
```

* ```grep ssl error*|less``` - Find all ssl errors.

* ```grep '\s404\s' access*|less``` - Find all 404 errors in the access logs, this is 404 surounded by whitespace.

* ```grep '^127' access*|less``` - Find every line that begins with 127 (access logs begin with an IP).

* ```sudo grep -ir error /var/log | less``` - Find all errors (-i case insensitive) in all logs, we sudo because some log files are only accessible to root.

* ```pgrep``` - Returns a list of process id(s) for given processes. The process can be requested using regex.

* ```pgrep chrome``` - Returns a list of all chrome process ids.

* ```pgrep chrome | xargs kill -9``` - Kills all running chrome processes.

* ```cat /etc/passwd|less``` - A nice hack to get a list of all users on a system.

## Additional Resources
* [Ten Steps to Linux Survival](http://dullroar.com/book/TenStepsToLinuxSurvival.pdf)
* [Linux Fundamentals](http://linux-training.be/files/books/LinuxFun.pdf)


[Next: System Basics](03-SystemBasics.md)
