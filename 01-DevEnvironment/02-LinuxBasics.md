# Linux Basics

This section is intended to provide a reference for the basic commands needed to navigate a Linux system from the command line. We will take a deeper dive and use these commands in later lessons. While we call these commands, they are really programs. In other words, when you type a command in Linux, you are really invoking a program. Most programs can be invoked with out any additional arguments (aka parameters), but in most cases, you will want to pass additional arguments into the program.

For example ````vim filename.txt```` would use an editor called vim to open a file that is nammed filename.txt. Some programs expect arguments to  be passed in a specific order while others have predefined arguments. All Linux programs predefine ````--help```` so you might type ````chown --help```` to learn how to use the chown command (or program).

* ````[command] --help```` - returns a help file for any command (or program).
* ````sudo```` - super-user do (elevates privs to admin)
* ````chown```` - CHange OWNership, changes the ownership of a file.
* ````chown user1:group1 some-file```` - changes the ownership of some-file to user1 and group1.
* ````chmod```` - CHange MODe, changes file permissions.
* ````chmod +x filename```` - makes a file executable.

* ````apt-get```` - retrieves and maintains packages from authenticated sources.
* ````apt-get install [package]```` - installs a target package from a repository.
* ````apt-get update```` - update your package list
* ````apt-get upgrade```` - upgrade all packages from the updated list
* ````apt-get remove```` - remove all packages
* ````apt-get purge```` - remove all packages and their config files

* ````dpkg```` - A package manager for Debian-based systems, this is primarily used to deal with files ending with a ````.deb```` extension.
* ````sudo dpkg --install some-pkg.deb```` - Installs some-pkg.deb.

* ````pwd```` - print working directory (where am I?)
* ````ls```` - list (a list of files and directories)
* ````ls -l```` - (file permissions, owner, group, size, last mod, directory name).
* ````ls -a```` (show hidden files)
* ````ls -la```` (ls -l + ls -a)
* ````ls -R```` (shows all child files)
* ````cd```` - change directory
* ````cd ~```` - a shortcut to your home directory

Linux does not use drive letters, rather everything is mounted to a root name space ````/````.
* ````/```` - root
* ````/etc```` - sytem configuration
* ````/var```` - installed software
* ````/var/log```` - log files
* ````/proc```` - real time system information
* ````/tmp```` - temp files, cleared on reboot

tip: Use tab expansions to auto-complete a command or an asterisk as a wild card. The up and down arrows can allow you to browse your command history and replay previous commands. Use ````Ctrl + r```` to search your command history by entering partial commands.

* ````cat```` - concatenate (dumps a file to the console, a handy read only hack)
* ````cat [filename]|less```` - pipe the cat command into a paginated CLI (less --help)
* ````cat [filename]|tail```` - last line of the file, great for looking at log files
* ````cat [filename]|tail -f```` - last line of the file, great for looking at log files

* ````find -name [x]```` find all file for whom the name matches x
* ````find -name [x]```` print|less find all files for which the name matches x and print them to a paginated CLI

On this system Apache writes log files to /var/log/apache2. For this example I only want to retreive a list of the error logs.
* ````cd /var/log/apache2```` find /*error.log.*

* ````cd / && locate access.log````


* ````grep```` - Globably Search a Regular Expression and Print (Uses Regular Expressions (regex) to search inside of files)
* ````* - wildcard````
* ````/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/```` - check an ip address regex in code.

Beyond Linux: Regex in code.
````
//Returns 1 if $string matches a valid IP, returns 0 if it does not.
$valid = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $string);
````

* ````grep ssl error*|less```` - find all ssl errors

* ````grep '\s404\s' access*|less```` - find all 404 errors in the access logs, this is 404 surounded by whitespace

* ````grep '^127' access*|less```` - find everyline that begins with 127 (access logs begin with an IP)

* ````sudo grep -ir error /var/log | less```` - find all errors (-i case insensitve) in all logs, we sudo because some log files are only accessable to root.

* ````cat /etc/passwd|less```` - a nice hack to get a list of all users on a system.

## Additional Reading
* [Ten Steps to Linux Survival](http://dullroar.com/book/TenStepsToLinuxSurvival.pdf)
* [Linux Fundamentals](http://linux-training.be/files/books/LinuxFun.pdf)


[Next: System Basics](03-SystemBasics.md)
