# [GIT](https://git-scm.com/)

[Git](https://git-scm.com/) is a free and open-source distributed [version control system](https://en.wikipedia.org/wiki/Version_control) (VCS). Google Trends suggested git is the [most popular](https://www.google.com/trends/explore?date=all&q=%2Fm%2F05vqwg,%2Fm%2F012ct9,%2Fm%2F08441_,%2Fm%2F08w6d6,%2Fm%2F09d6g&hl=en-US) VCS in the world. Git is now a part of the Ubuntu standard installation so there is nothing to install.

For a list of git commands type

```
git --help
```

## [GitHub](https://github.com)
GitHub is a hosted solution popular among both open and closed source developers and will be the solution we use in this course. While we do not need to install Git we will want to bind our GitHub account to our dev machine.

### [Setup](https://help.github.com/articles/connecting-to-github-with-ssh/)
The following tutorials will walk you through the process of binding your development machine to your GitHub account using an SSH key. An SSH key uses public-key crypto to authenticate your machine against your GitHub account. This allows you to push and pull to and from GitHub without needing to provide a username and password.  

#### [Generating a new SSH key and adding it to the ssh-agent](https://help.github.com/articles/generating-ssh-keys/)
Accept the defaults for the following. Do not change the file paths, do not enter any passwords.

```ssh
ssh-keygen -t rsa -b 4096 -C "YOUR-EMAIL-ADDRESS"
```[] Enter, [] Enter, [] Enter```
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/id_rsa
```

#### [Adding a new SSH key to your GitHub account](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)
Intall x-xlip and copy the contents of the key to your clipboard

```sh
sudo apt install -y xclip
xclip -sel clip < ~/.ssh/id_rsa.pub
```

Log into your GitHub account and find _Settings_ in the top right corner under your avatar. Then click on SSH and GPG Keys in the left-hand navigation and click the green **New SSH Key** button. Enter a title, this should be something that identifies your machine (I usually use the machine name) and paste the SSH key into the key field.

![Add Your SSH Key](/img/git/account.png)

#### [Testing your SSH connection](https://help.github.com/articles/testing-your-ssh-connection/)

```sh
ssh -T git@github.com
```

#### [First-Time Git Setup](https://git-scm.com/book/en/v2/Getting-Started-First-Time-Git-Setup)

Set up your git identity, replace my email and name with your own. For this class, we will use VIM (VI) as our Git editor.
```sh
git config --global user.email "YOUR-EMAIL-ADDRESS"
git config --global user.name "YOUR-FIRST-LAST-NAME"
git config --global core.editor "vim"
```

Confirm set-up.
```sh
git config --list
```

In this lesson, you learned how to
* Create an SSH key.
* Add an SSH key to your GitHub account.
* Establish a Git identity on your local machine.


## Exercise 1 - Create a repository

For this exercise, we will create your working directory for this course on GitHub and clone into your local environment. You will do most of your work from this repository and push the results to GitHub.

__Create a new repository__

Log in to your GitHub account and click on the repositories tab then find the _New Repository_ button.

![Find the New Repo Button](/img/git/repo_btn.png)

Create a project called *mtbc* (MicroTrain Bootcamp). This is the project you will use for much of this course.

* Create a description, something like _My working directory for MicroTrain's Dev Bootcamp_ (you can change this later).  
* Be sure _Initialize this repository with a README_ is checked.
* Choose a License, for this course I would recommend the MIT License. Since this isn't a product, choosing the perfect license is not critical. 
* Finally, click the create button.

![Create a New Repo](/img/git/new_repo.png)

__Clone the repository__

Now you will want to pull the repository from GitHub onto your local machine.
Then clone your fork onto your local machine. After creating your repository you should have been redirected to the new repository. If not, you can find it under the repositories tab. Find the _Clone or Download_ and copy the URL which will look something like ```https://github.com/[your-github-user-name]/mtbc```

![Clone](/img/git/clone.png)

Now we will clone this repository into the root directory of our web server. This will allow us to access all of our work through the browser by way of _localhost_.

```sh
cd /var/www
git clone git@github.com:YOUR-GITHUB-USERNAME/mtbc
```

Now use the ```ls``` command to verify the existence of *mtbc*. If you open your browser and navigate to [http://localhost/mtbc](http://localhost/mtbc) you will see the following directory structure.

![Index](/img/git/base_index.png)

### Summary

In this exercise, you learned how to
* create a Git repository on GitHub (Git)
* clone a repository (Git)


## Exercise 2 - Commit a Code Change
Now open Visual Studio Code and click into the workspace. Right-click and choose *"add a new folder to the workspace"*. Navigate to _/var/www/mtbc_ and press ```OK```.

![Add a new folder to the workspace](/img/git/add_folder.png)

![New Folder](/img/git/new_folder.png)

Now click on the file README.md from the _mtbc_ project folder. README files are a best practice in software development. README files are human-readable files that contain information about other files in a directory or archive. The information in these files ranges from basic information about the project team to build instructions for source code. An emerging defacto standard is to write in a format called Markdown (.md). A raw Markdown file should be human-readable while providing just enough markup for formatting. If you want to preview the formatted version you can use Visual Studio Code's _Markdown Preview_ by opening the file and pressing ```Shift + Ctrl + V```.

Open the file README.md from the mtbc project folder in the VSCode sidebar and open the _Markdown Preview_. Change the content of the level 1 heading *# mtbc* to *# MicroTrain's Dev Boot Camp*. Save your changes with the keyboard shortcut [Ctrl + S].# MicroTrain's Dev Boot Camp

Open a terminal (command line or CLI) and navigate to the mtbc directory.

```sh
cd /var/www/mtbc
```

Check your repository for changes, this will return a list of dirty files. A dirty file is any file containing a change.

```sh
git status
```

Commit your code changes
```sh
git commit README.md
```

VI will open an ask you to enter a commit message. 
1. Press the letter [i] to enter insert mode. 
1. Then type the message _Proof of concept version_. 
1. Press [esc] followed by [:x] and enter to save the commit message.

Push your changes to the main branch.

```sh
git push origin main
```

You will see a message that indicates the README.md file has been changed.

![Modified](/img/git/status.png)

```sh
git commit README.md
```

This will open an editor window that asks you to enter a commit message. Enter _Changed the header_ and save the file. You will see a message that indicating changes to the file have been committed.

![Modified](/img/git/commit.png)

Finally, push your changes to GitHub.

```sh
git push origin main
```

![Modified](/img/git/push.png)

In the previous example, we committed our code changes directly to the main branch. In practice, you will never work on a main branch. At the very least you should have a development branch (we call it dev). I like to create branches using the *checkout* command.

```sh
git checkout -B dev
```

You will see the message _Switched to a new branch 'dev'_.

* ```checkout``` - This tells git to switch to a different branch.
* ```-B``` - When following the _checkout_ command this tells git to create a new branch. This is a copy of the branch you are currently on.
* ```dev``` - The name of the new branch.

In plain English ```git checkout -B dev``` says *"make a copy of the branch I am on, name it _dev_ and switch me to that branch"*.

If you are working directly on your dev branch and want to push those changes into main; it might look like this.

```sh
git checkout main
git pull origin main
git checkout dev
git rebase main
git checkout main
git merge dev
```

1. ```git checkout main``` - Switch to the main branch.
1. ```git pull origin main``` - Pull any new changes into main.
1. ```git checkout dev``` - Switch back to the dev branch.
1. ```git rebase main``` - Apply outside changes from main into the dev branch. This will rewind the branch and apply the outside changes. All of the commits you made after branch deviation will be applied on top of the branch deviation.
1. ```git checkout main``` - Move back to the main branch.
1. ```git pull origin main``` - Recheck for changes, if any new changes have been applied return to step 3 and repeat.
1. ```git merge dev``` - Once you have a clean pull, merge your changes into main.
1. ```git push origin main``` - Push your new changes to the repository.

Technically, there is no right or wrong way to use git. Each project would have a set of guidelines. If you were to deviate from those guidelines then your usage within the context of working on that project would be considered wrong. [The Diaspora* Project](https://wiki.diasporafoundation.org/Git_workflow) has a very well defined branching model that is typical of what you will see in the real world. If I had to come up with one and only one rule it would be to never build on the main branch.

## Exercise 3 - Serve Static Page From GitHub Repository
In Visual Studio Code click into the workspace `/mtbc`.

Right-click and choose "New File" to the workspace.

Create an `index.html` page */mtbc/index.html*.

Add the following code.
```sh
<html>
<header><title>GitHub Page Example</title></header>
<body>
Hello world, Welcome to My GitHub.io
</body>
</html>
```
Save the file.

Open a terminal (command line or CLI) and navigate to the *cd ~ /var/www/mtbc* directory.
Check your repository for changes, `git status` will return a list of dirty files.

```sh
git status
```
Use git add . to track changed file
```sh
git add .
```
Commit your *index.html* file addition
```sh
git commit
```
VI will open an ask you to enter a commit message. 
1. Press the letter [i] to enter insert mode. 
1. Then type the message _Github Page Example_. 
1. Press [esc] followed by [:x] and enter to save the commit message.

Push your changes to the main branch.

```sh
git push origin main
```

Log in to your GitHub account and click on the repositories tab then find the `mtbc` Repository folder.
* Choose **_Settings_** in the far right corner
* Scroll down to **_GitHub Pages_**
* Under Source dropdown select **_main branch_**

**Note**
> Message will change to _Your site is ready to be published at [https://`<yourname>`.github.io/mtbc]_

* Right click on the GItHub pages link to Navigate to your site url.


## Git Guidelines

A basic set of guidelines for working with a git repository.
See [RFC 2119](http://www.ietf.org/rfc/rfc2119.txt) for keyword usage.

* main - pristine 
    * You MUST NOT work on or apply changes directly to main.
    * Only approved changes SHALL be merged into main.
* dev - main working branch
    * You SHOULD NOT work on or apply changes directly to dev.
    * You SHOULD create a feature/bug (working) and commit changes to that branch.
    * The working branch SHOULD always be a decedent of dev.

Replace *GITHUB-USER_NAME* with your GitHub user name.
```sh
#Clone an existing repository
git clone origin git@github.com:GITHUB-USER_NAME/mtbc.git
cd mtbc

#If there IS NOT a dev branch, create one
git checkout -B dev
git push origin dev

#If there IS a dev branch, fetch it
git fetch origin dev:dev
git checkout dev

git checkout -B feature/some-feature
git push origin feature/some-feature

# After you have made you code changes
# Add and commit the new feature
git add .
git commit -a
git push origin feature/some-feature

# Integrate the new feature with dev
git checkout dev
git pull origin dev
git checkout feature/some-feature
git rebase dev
git checkout dev
git merge feature/some-feature
git push origin dev

## After integration testing
## Integrate the changes with your production branch
git checkout main
git pull origin main
git checkout dev
git rebase main
git checkout main
git merge dev
git push origin main

## Clean Up
# Delete the remote branch
git push origin :feature/some-feature

#Delete the local branch
git branch -D feature/some-feature
```

### Summary

In this exercise, you learned 
* how to create a new branch with the checkout command (Git)
* how to serve a static page from your github repository (Git)
* basic Git commands (Git)


## Additional Resources
* [Documentation](https://git-scm.com/book/en/v2)
* [ProGit](https://git-scm.com/book/en/v2)
* [3 Git Commands I use every day](https://medium.com/@jasonmccreary/3-git-commands-i-use-every-day-1d9402daf3ba)

[Next: Programming Basics](../02-ProgrammingBasics/README.md)
