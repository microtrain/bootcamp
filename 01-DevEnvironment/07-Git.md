# [GIT](https://git-scm.com/)

[Git](https://git-scm.com/) is a free and open source distributed [version control system](https://en.wikipedia.org/wiki/Version_control) (VSC). Google Trends suggested git is the [most popular](https://www.google.com/trends/explore?date=all&q=%2Fm%2F05vqwg,%2Fm%2F012ct9,%2Fm%2F08441_,%2Fm%2F08w6d6,%2Fm%2F09d6g&hl=en-US) VCS in the world.Git is now a part of the Ubuntu standard installation so there is nothing to install.

For a list of git commands type

````
git --help
````

## [GitHub](https://github.com)
GitHub is a hosted solution popular among both open and closed source developers and will be the solution we use in this course. While we do not need to install git we will want to bind our GitHub account to our dev machine.

### Setup
The following tutorials will walk you through the binding process.
1. [Add an SSH Key](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)
1. [Setting up Git](http://help.github.com/linux-set-up-git/)
1. [Testing your SSH connection](https://help.github.com/articles/testing-your-ssh-connection/)


## Exercise 1 - Create a repository

For this exercise we will create your working directory for this course on GitHub and clone into your local environment. You will do most your work from this reporisitory and push the results to GitHub.

__Create a new repository__

Login to your GitHub account and click on the repositories tab then find the _New Repository_ button.

![Find the New Repo Button](/img/git/repo_btn.png)

Create a project called mtbc (MicroTrain Bootcamp). This is the project you will use for much of this course.

* Create a description, something like _My working directory for MicroTrain's Dev Bootcamp_ (you can change this later).  
* Be sure _Initialize this repository with a README_ is checked.
* Choose a License, for this course I would recommend the MIT License. Since this isn't product it really doesn't matter. Then click the create button.

![Create a New Repo](/img/git/new_repo.png)

__Clone the repository__

Now you will want to pull the repository from GitHub onto your local machine.
Then clone your fork onto your local machine. After creating your repository you should been directed to the new repository. If not, you can find it under the the repositories tab. Find the _Clone or Download_ and copy the URL which will look something like ````https://github.com/[your-github-user-name]/mtbc````

![Clone](/img/git/clone.png)

Now we will clone this repository into the root directory of our web server. This will allow us to access all of our work through the browser by way of _localhost_.

````
cd /var/www
git clone https://github.com/[your-github-user-name]/mtbc
````

Now use the ````ls```` command to verify the existence of mtbc. If you open your browser and navigate to [http://localhost/mtbc](http://localhost/mtbc) you will see the following directory structure.

![Index](/img/git/base_index.png)

Now open Atom and click on the file menu. Choose _Add Project Folder..._ drill down to /var/www and choose the _mtbc_ directory. Now click on the file README.md the raw file should be human readable but if you want a formatted version choose _Markdown Preview_ open a file and click ````Shift + Ctrl + M````

## Additional Reading
* [Documentation](https://git-scm.com/book/en/v2)
* [ProGit](https://git-scm.com/book/en/v2).
* (3 Git Commands I use every day)https://jason.pureconcepts.net/2016/11/3-everyday-git-commands/

[Next: Git](08-Git.md)
