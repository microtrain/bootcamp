# [GIT](https://git-scm.com/)

[Git](https://git-scm.com/) is a free and open source distributed [version control system](https://en.wikipedia.org/wiki/Version_control) (VSC). Google Trends suggested git is the [most popular](https://www.google.com/trends/explore?date=all&q=%2Fm%2F05vqwg,%2Fm%2F012ct9,%2Fm%2F08441_,%2Fm%2F08w6d6,%2Fm%2F09d6g&hl=en-US) VCS in the world.Git is now a part of the Ubuntu standard installation so there is nothing to install.

For a list of git commands type

````
git --help
````

## [GitHub](https://github.com)
GitHub is a hosted solution popular among open source developers and will be the solution we use in this course. While we do not need to install git we will want to bind our GitHub account to our dev machine.

### Setup
The following tutorials will walk you through the binding process.
1. [Add an SSH Key](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)
1. [Setting up Git](http://help.github.com/linux-set-up-git/)
1. [Testing your SSH connection](https://help.github.com/articles/testing-your-ssh-connection/)

## Fork and clone

Forking allows you to create your own copy of a repository. With this copy you can offer code changes back to the original project or take an existing in a different direction. Go to GitHub and create a fork of the [https://github.com/microtrain/bootcamp](https://github.com/microtrain/bootcamp).

Then clone your fork onto your local machine.

````
cd ~
git clone https://github.com/[your-github-user-name]/bootcamp
````

Now open Atom and click on the file menu. Choose _Add Project Folder..._ and add the bootstrap directory. You can now navigate the browse the courseware using the Atom editor. Our course ware is written in language markdown. The raw file should be human readable but if you want a formatted version choose _Markdown Preview_ open a file and click ````Shift + Ctrl + M````

## Additional Reading
* If your new to git you should review the [documentation](https://git-scm.com/book/en/v2)
* [ProGit](https://git-scm.com/book/en/v2). A free EBook
* (3 Git Commands I use every day)https://jason.pureconcepts.net/2016/11/3-everyday-git-commands/
