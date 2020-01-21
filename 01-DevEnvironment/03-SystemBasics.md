# System Basics
In this section, we will use some of the basic Linux commands from the previous section to install a few basic software packages.

Log into your system and open a terminal window using ```Ctrl + Alt + T```. Then type the following commands. Pressing enter after each command.

```sh
sudo apt update
sudo apt upgrade
```
Let's look at these commands a little closer.
* [sudo](https://help.ubuntu.com/community/RootSudo) - in short ```sudo``` will run whatever commands that follow it with root-level privileges.
* [```apt```](http://manpages.ubuntu.com/manpages/zesty/man8/apt.8.html) - [Apt](https://help.ubuntu.com/lts/serverguide/apt.html) is a package manager for Linux. This works by maintaining a list of remote repositories from which packages can be installed. Most of the management is done automatically.
    * ```apt update``` - tells the system to update everything it knows about the repositories.   
    * ```apt upgrade``` - tells the system to upgrade all packages to their latest versions.

## [Terminator](https://gnometerminator.blogspot.com/p/introduction.html)

Terminator is a terminal emulator that allows for multiple tabs and split screens. This makes life a lot easier when you are dealing with several command-line applications and background processes all at once.

```sh
sudo apt install terminator
```
Now close your terminal window and use [Dash](https://help.ubuntu.com/lts/ubuntu-help/unity-dash-intro.html) to find and open Terminator. Open Dash ```Super + F``` and type _terminator_ into the search field. Click the Terminator icon to launch Terminator. You'll notice the Terminator icon is now in the [Launcher](https://help.ubuntu.com/stable/ubuntu-help/unity-launcher-intro.html) right-click the Terminator icon and select _Lock to Launcher_ from the context menu.

## [VIM](http://www.vim.org/)

An old school command-line text editor. This is nice to know when you need to edit files on a server or directly on a command-line.

```sh
sudo apt install vim
```
## [Google Chrome](https://support.google.com/chrome/?hl=en#topic=3227046)

Download Google Chrome from [https://www.google.com/chrome/browser/desktop/index.html](https://www.google.com/chrome/browser/desktop/index.html) be sure to save the file. If this returns no errors then your good to go, however, this sometimes fails and if it does you can clean it up with using Apt.

```sh
cd ~/Downloads
```

* [```cd```](http://manpages.ubuntu.com/manpages/zesty/man1/cd.1posix.html) - Changes your working directory (Change Directory)
* [```~```](http://www.gnu.org/software/bash/manual/html_node/Tilde-Expansion.html) -
Tilde Expansion, in this case, it's a short cut to the home directory (~ evaluates to /home/jason). So ```cd ~/Downloads``` will change my current working directory to ```/home/jason/Downloads```.

You will have downloaded a file called google-chrome-stable_current_amd64.deb. [```.deb```](https://www.debian.org/doc/manuals/debian-faq/ch-pkg_basics.en.html) files are software packages designed for Debian based Linus distros.

```sh
sudo dpkg --install google-chrome-stable_current_amd64.deb
```

* [```dpkg```](https://help.ubuntu.com/lts/serverguide/dpkg.html) - A package manager for Debian based systems. Primarily used to work with locally installed .deb packages.

```sh
sudo apt install -f
```

Use the search box from the activity panel to find and open Chrome. Click the Chrome icon to launch the Chrome browser. You'll notice the Chrome icon is now in the [Launcher](https://help.ubuntu.com/stable/ubuntu-help/unity-launcher-intro.html) right-click the Chrome icon and select _Lock to Launcher_ from the context menu. Now right-click the FireFox icon in the launcher and click choose _Unlock from Launcher_ from the context menu.

## [Visual Studio Code](https://code.visualstudio.com/)

Visual Studio Code (VSC) is the IDE we will be using to write code. Install VSC using the same steps you used to install Chrome. Remember to pin VSC to your launcher after the install.

## Cleanup
Check the contents of your Downloads directory by typing [```ls```](http://manpages.ubuntu.com/manpages/zesty/man1/ls.1.html) at the command prompt. You should see the two files we just downloaded and installed.

```sh
ls ~/Downloads
code*.deb  google-chrome-stable_current_amd64.deb
```

Now type ```ls -l``` and note the difference between the two result sets.

```sh
$ ls -l
total 129080
-rw-rw-r-- 1 jason jason 86270030 Feb 16 16:11 code_1.20.0-1518023506_amd64.deb
-rw-rw-r-- 1 jason jason 45892904 Feb 16 16:18 google-chrome-stable_current_amd64.deb
```

Since the have been installed we no longer the files lets remove them from the system.

```sh
rm ~/Downloads/*
```

* [```rm```](http://manpages.ubuntu.com/manpages/zesty/man1/rm.1.html) - removes a file or a folder
* -```-fR``` - Force Recursive
    * ```-f``` - ignore nonexistent files and arguments, never prompt [^fn1]
    * ```-R``` - remove directories and their contents recursively. [^fn1]
* \* - A [wildcard](http://www.tldp.org/LDP/GNU-Linux-Tools-Summary/html/x11655.htm)
for matching all characters and strings. ```rm ~/Downloads/*``` will remove everything on the ~/Downloads path

Now typing ```ls ~/Downloads``` into the command-line will return an empty result set.


## [Filezilla](https://filezilla-project.org/)

Filezilla is my goto [FTP](https://en.wikipedia.org/wiki/File_Transfer_Protocol) client. While FTP by itself is insecure and not recommended, running FTP over [SSH](https://en.wikipedia.org/wiki/Secure_Shell) is secure and Filezilla allows us to do just that. We work with FTP and SSH in later lessons.

```sh
sudo apt install filezilla
```

## [cURL](https://curl.haxx.se/docs/manpage.html)

The best way to think of cURL is as a browser that is used by code.

```sh
sudo apt install curl
```

## Enable new file creation via right-click

```sh
touch ~/Templates/Empty\ Document
```

Rather than running each of the above statements as one-off statements, we can combine them into a single command using ```&&``` to concatenate the commands.

```sh
sudo apt install terminator vim filezilla curl -y && touch ~/Templates/Empty\ Document
```

## Summary
In this lesson, you learned
* how to install programs using apt (Linux)
* how to install Debian package using dpkg (Linux)
* how to force a broken install using apt (Linux)

## Required Reading and Videos
* [VIDEO - Getting Started with VSCode](https://code.visualstudio.com/docs/introvideos/basics)
* [VSCode User Interface](https://code.visualstudio.com/docs/getstarted/userinterface)
* [Navigating Files and Directories](https://datacarpentry.org/shell-genomics/02-the-filesystem/index.html)
* [VIDEO - Linux/Mac Terminal Tutorial: Navigating your Filesystem](https://www.youtube.com/watch?v=j6vKLJxAKfw)

## Additional Resources
* [VIM Book](http://ftp.vim.org/pub/vim/doc/book/vimbook-OPL.pdf)
* [Chrome Dev Tools](https://developer.chrome.com/devtools)
* [VSC Docs](https://code.visualstudio.com/docs)
* [Filezilla Docs](https://wiki.filezilla-project.org/Documentation)
* [SSH Man Page](http://linuxcommand.org/man_pages/ssh1.html)


[Next: LAMP Stack](04-LAMPStack.md)
