# Amazon Web Services (AWS) Basics

In this section we will launch a cloud infrastructure. This will include 
* Creating an AWS account
* Spinning up a web server on EC2
* Configuraing an Elastic IP
* Creating a valid TLS connection against a real CA.

[AWS](https://aws.amazon.com "AWS's Homepage")
is an auxiliary of Amazon.com that provides on-demand cloud computing platforms such as IaaS, PaaS and SaaS. AWS offers compute power, database storage, content delivery and other functionality to help businesses scale and grow.

## Terminology

### Cloud Computing
Term used for allowing convenient, on-demand access from anywhere, to computing resources. 

##### 5 Charactics of Cloud Computing

- On-Demand Service
- Broad Network Access
- Resource pooling
- Rapid Elasticty
- Metering


These includes servers, storage, networking, applications and services. That can be easy revised and released.


### Software as a Service
On-Demand Pay Per Use of Application. Popular SaaS Providers are:

- Google Systems, Microsoft, and Slack.

### Platform as a Service
Encapsulated environments where users can build, compile and run programs without infrastructure worries.

- Elastic Beanstalk
- Windows Azure
- 
### Infrastructure as a Service
Offering of computer resources to deploy virtual machines and etc.

- Amazon EC2; Virtual Environments


## AWS Free Tier
AWS Free Tier offers 12 months of semi free service and AWS products. Notable services in the Free Tier include:

| Services        | Storage     | Hours/Month  |
| ------------- |:-------------:| -----:|
| Amazon S3     | 5GB           |        |
| Amazon EC2    |               |   750  |
| Amazon RDS    |               |   750  |
| DynamoDB      | 25GB          |        |
| SNS           |               |        |
| CloudFront    | 50GB          |        |

## Register an AWS Account
Head over to [AWS](https://aws.amazon.com "AWS's Homepage") hompage and signup.
1. Create AWS Account with credentials.
2. Provide contact information for selected Personal Account.
3. Enter payment information - even though AWS offers free services, they require a valid payment type to register.
4. Enter code for Identity Verification. *Sent to phone*
5. Select Support Plan - Basic(Free).
6. Sign in to the Console.

## Amazon EC2

[https://aws.amazon.com/ec2/?nc2=h_m1](https://aws.amazon.com/ec2/?nc2=h_m1)

EC2 web service interface provides you with complete control of your computing resources. This provides virtual servers known as instances to host web applications. Amazon Free Tier provides up to 750 Hours per month of EC2 usages before additional fees apply. This applies to t2.micro instance types!

### Amazon EC2 Install

1. Navigate Services tab for Amazon EC2.
2. Launch Instance under Create Instance Header.
3. Chose an (AMI) - Ubuntu Server 18.04 Free Tier 64-bit.
4. Choose an Instance Type - t2.micro Free Tier.
5. Configure Instance Details (Default).
6. Add Storage (Default).
7. Add Tags - Add a name tag and value.
8. Configure Security Group - *Create a new security group and add rule with the types SSH, HTTP, HTTPS, and Custom port 3000.*
9. Review Instance Launch.
10. Configure and [Elastic IP](https://aws.amazon.com/premiumsupport/knowledge-center/intro-elastic-ip-addresses/) 
11. Create a new key pair - *This is the only time you can download the key file*.
12. Launch Instance

#### Accessing server instance from terminal

To access AWS instance the public IP and downloaded key.pem file are required. First move the .pem file to your .ssh directory. Next we need to check/configure our permissions.

```
mv Downloads/MY-AWS-SERVER-KEY.pem ~/.ssh/
chmod 400 .ssh/MY-AWS-SERVER-KEY.pem
ssh ubuntu@YOUR-PUBLIC-DNS -i .ssh/my-aws-serverKey.pem
```
> Create a document in Text Editor, copy and paste *ssh ubuntu@YOUR-PUBLIC-DNS -i .ssh/my-aws-serverKey.pem*
name and save the *AWS Server* in /Documents

Now that your server is accessible let's install a LAMP stack.

ux console
```
sudo apt update
sudo apt upgrade
```

# [LAMP Stack](https://en.wikipedia.org/wiki/LAMP_(software_bundle))

The LAMP stack (Linux, Apache, MySQL, PHP) is one of the oldest and most mature and popular technology stacks on the web. Ubuntu allows you to install the entire stack with a single command.

```sh
sudo apt install lamp-server^
```

**DO NOT LEAVE THE MYSQL PASSWORD FIELD BLANK**, when prompted; enter the password for the MySQL root user. Since this is a local development environment just enter *password*; **NEVER** use *password* as your password on a public-facing server.


## Apache Configuration

Open a browser and navigate to http://your-amazon-ip.compute.amazonaws.com and you will land on your AWS default apache landing page. That is because the default Apache's configuration points to the path */var/www/html*, html is a folder that contains a single file called index.html. By default, Apache looks for files named index.\* (where \* can be any file extension). Let's configure Apache's default path to */var/www* and see what happens.

First, open a command line an navigate to sites-available. On Debian based systems this is where Apache stores per-site configurations aka, VHOST (virtual host) files, on non-Debian systems these may be part of a larger configuration file. Once in the sites-available directory run the command to list the directory contents.

```sh
cd /etc/apache2/sites-available
ls
```

The ls command should yield the following results.

```sh
000-default.conf  default-ssl.conf
```

000-default.conf is the default configuration for Apache on Debian based systems. Let's take a look at its contents. You can read this file without sudo but we want to make some changes to it, so let's ```sudo```.

```sh
sudo vim 000-default.conf
```

You will notice a few default settings more commonly called directives in Apache terms. Right now we are only concerned with the ```DocumentRoot``` directive.   Move your cursor down to line 12 and remove _/html_ from the end of this line. Remember ```i``` enters insert mode and ```Esc``` followed by ```:x``` saves the file.

The final result will be.
```apache
DocumentRoot /var/www
```

Now we want to tell apache to reload the configuration. This is a four-step process.
* Disable the site configuration ```sudo a2dissite 000-default```
* Reload Apache ```sudo  apache reload```
* Enable the new site configuration ```sudo a2ensite 000-default```
* Reload Apache ```sudo service apache2 reload```

You can execute all four commands at once with the following.
```sh
sudo a2dissite 0* && sudo service apache2 reload && sudo a2ensite 0* && sudo service apache2 reload
```

The double ampersand ```&&``` appends two commands running them one after the other. For example

```sh
cd /etc/apache2/sites-available && vim 0*
```

Would change your current working directory to _/etc/apache2/sites-available && vim 0*_ and use vim to open any files that match the pattern _0*_, in this case, it would only match one file _000-default.conf_. Using wild cards can save a few keystrokes and cut down on typos. But be careful you don't open the wrong files.

Once you have reloaded the configuration, open your browser and return to *http://your-amazon-ip.compute.amazonaws.com*. Now, rather than the default Apache landing page, you will see a directory listing with a link to the *html* directory. Clicking this will open the default Apache landing page.

Restart Apache

```sh
sudo service apache2 restart
```

Test Apache by entering your domain name into a browser window. If you see a page that says *Apache2 Ubuntu Default Page* then your Apache web server is working.

> Due to firewall settings this may not yet work in the classroom.


## Set up your Github

Git should already be installed. You can verify this by running ```git --version```.

#### [Create an SSH key and add it to the ssh-agent](https://help.github.com/articles/generating-ssh-keys/)
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

Additional support
