# System Basics
In this section we will learn use some of the basic Linux commands from the previous section to install a few basic software packages.

Login in to your system and open a terminal window using ```Ctrl + Alt + T```. Then type the following commands. Pressing enter after each command.

```sh
sudo apt-get update
sudo apt-get upgrade
```
Lets look at these commands a little closer.
* [sudo](https://help.ubuntu.com/community/RootSudo) - in short ```sudo``` will run what ever commands that follow it with root level privleges.
* [```apt-get```](http://manpages.ubuntu.com/manpages/zesty/man8/apt.8.html) - [Apt](https://help.ubuntu.com/lts/serverguide/apt.html) is a package manager for Linux. This works by maintaining a list of remote repositories from which packages can be installed. Most of the management is done automatically.
    * ```apt-get update``` - tells the system to update everything it knows about the repositories.   
    * ```apt-get upgrade``` - tells the system to upgrade all packages to their latest versions.

## [Terminator](https://gnometerminator.blogspot.com/p/introduction.html)

Terminator is a terminal emulator that allows for multiple tabs and split screens. This makes life a lot easier when you are dealing with several command line applications and background processes all at once.

```sh
sudo apt-get install terminator
```
Now close your terminal window and use [Dash](https://help.ubuntu.com/lts/ubuntu-help/unity-dash-intro.html) to find and open Terminator. Open Dash ```Super + F``` and type _terminator_ into the search field. Click the Terminator icon to launch Terminator. You'll notice the Terminator icon is now in the [Launcher](https://help.ubuntu.com/stable/ubuntu-help/unity-launcher-intro.html) right click the Terminator icon and select _Lock to Launcher_ from the context menu.

## [VIM](http://www.vim.org/)

An old school command line text editor. This is really nice to know when you need to edit files on a server or directly on a command line.

```sh
sudo apt-get install vim
```
## [Google Chrome](https://support.google.com/chrome/?hl=en#topic=3227046)

Download Google Chrome from [https://www.google.com/chrome/browser/desktop/index.html](https://www.google.com/chrome/browser/desktop/index.html) be sure to save the file. If this returns no errors then your good to go, however, this sometimes fails and if it does you can clean it up with using Apt.

```sh
cd ~/Downloads
```

* [```cd```](http://manpages.ubuntu.com/manpages/zesty/man1/cd.1posix.html) - Changes your working directory (Change Directory)
* [```~```](http://www.gnu.org/software/bash/manual/html_node/Tilde-Expansion.html) -
Tilde Expansion in this case it's a short cut to the home directory (~ evaluates to /home/jason). So ```cd ~/Downloads``` will change my current working directory to ```/home/jason/Downloads```.

You will have downloaded a file called google-chrome-stable_current_amd64.deb. [```.deb```](https://www.debian.org/doc/manuals/debian-faq/ch-pkg_basics.en.html) files are software packages designed for Debian based Linus distros.

```sh
sudo dpkg --install google-chrome-stable_current_amd64.deb
```

* [```dpkg```](https://help.ubuntu.com/lts/serverguide/dpkg.html) - A package manager for Debian based systems. Primarily used to work with locally installed .deb packages.

```sh
sudo apt-get install -f
```

Use [Dash](https://help.ubuntu.com/lts/ubuntu-help/unity-dash-intro.html) to find and open Chrome. Open Dash ```Super + F``` and type _chrome_ into the search field. Click the Chrome icon to launch the Chrome browser. You'll notice the Chrome icon is now in the [Launcher](https://help.ubuntu.com/stable/ubuntu-help/unity-launcher-intro.html) right click the Chrome icon and select _Lock to Launcher_ from the context menu. Now right click the FireFox icon in the launcher and click choose _Unlock from Launcher_ from the context menu.

## [Atom](https://atom.io/)

Atom is the text editor or pseudo IDE we will be using to write code. Install Atom using the same steps you used to install Chrome. Remember to pin Atom to your launcher after the install. If you cannot find Atom using Dash try launching it from the commandline by typing ```atom```.

## Cleanup
Check the contents of your Downloads directory by typing [```ls```](http://manpages.ubuntu.com/manpages/zesty/man1/ls.1.html) at the command prompt. You should see the two files we just downloaded and installed.

```sh
ls ~/Downloads
atom-amd64.deb  google-chrome-stable_current_amd64.deb
```

Now type ```ls -l``` and note the difference between the two result sets.

```sh
$ ls -l
total 129080
-rw-rw-r-- 1 jason jason 86270030 Feb 16 16:11 atom-amd64.deb
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

Now typing ```ls ~/Downloads``` into the command line will return an empty result set.

## [Meld](http://meldmerge.org/)

Meld is a visual diff tool. This is the default tool called by Atom when doing a file comparison.

```sh
sudo apt-get install meld
```

## [Filezilla](https://filezilla-project.org/)

Filezilla is my goto [FTP](https://en.wikipedia.org/wiki/File_Transfer_Protocol) client. While FTP by itself is insecure and not recommended, running FTP over [SSH](https://en.wikipedia.org/wiki/Secure_Shell) is secure and Filezilla allows us to do just that. We work with FTP and SSH in later lessons.



## [cURL](https://curl.haxx.se/docs/manpage.html)

The best way to think of cURL is as a browser that is used by code.

```sh
sudo apt-get install curl
```

## Additional Resources
* [VIM Book](ftp://ftp.vim.org/pub/vim/doc/book/vimbook-OPL.pdf)
* [Chrome Dev Tools](https://developer.chrome.com/devtools)
* [Atom Flight Manual](http://flight-manual.atom.io/)
* [Filezilla Docs](https://wiki.filezilla-project.org/Documentation)
* [SSH Man Page](http://linuxcommand.org/man_pages/ssh1.html)

[Next: LAMP Stack](04-LAMPStack.md)
