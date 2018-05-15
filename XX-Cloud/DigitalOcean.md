# Cloud Server

In this unit we will launch our cloud infrastructure. This will include creating a thrid party database, registering a domain name, spinning up a web server and creating a valid TLS connection against a real CA.

## Create a MongoDB Atlas Sandbox

[https://www.mongodb.com/cloud/atlas](https://www.mongodb.com/cloud/atlas)

1. Create an account
1. Choose the free sandbox account
1. Create a cluster name
1. Generate a password

### Update Your Local App to Connect to the Sandbox

Add a configuration file, since the repository is public create this outside of the repository. We will use Filezilla to transfer this file to the server.

*~/config.prod.js*
```js

var config = {};
config.session = {};
config.cookie = {};

config.mongodb = 'mongodb://USERNAME:PASSWORD@cluster0-shard-00-00-XXXXX.mongodb.net:27017,cluster0-shard-00-01-XXXXX.mongodb.net:27017,cluster0-shard-00-02-XXXXX.mongodb.net:27017/mean-cms?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin';

//Create a high entropy secret, I would recomend something from https://www.grc.com/passwords.htm
config.session.secret = ';7x,^SpXNq6*X9{9V4\?h:M3?tN96;lhuX_K@WM:]v~~@8V]KYgQ1[.T<uV0B)6';

config.cookie.domain = 'your-new-domain.tld';

module.exports = config;
```

Require the config file in app.js
```js
//Call the config file
var config = require('../config.prod');
```

Load a config file base on enviromental variables
```js
if(process.env.NODE_ENV==='production'){
  var config = require('../config.prod');
}else{
  var config = require('./config.dev');
}
```

## Purchase a Domain
I reccomend [Hover](https://hover.com/2WvTmBun) use this [referal link - https://hover.com/2WvTmBun](https://hover.com/2WvTmBun) and get a $2 off your domain name. 

## Purchase a Cloud Based Web Server
Digital Ocean use this [referal link - https://m.do.co/c/7d5ded2774f3](https://m.do.co/c/7d5ded2774f3) and get a $10 credit.

### Set Up Your Droplet
Login to your droplet over SSH. You will be prompted to change your password. Once you have updated your password update apt and run any upgrades.

```sh
apt-get update
apt-get upgrade
```

Now create a less privileged user. For the sake of this article we will call that user production. Give the production user a good strong password and follow the prompts, you may leave these questions blank.


```sh
adduser production
```

Git should already be installed. You can verify this by running ```git --version```.

Switch to the production user and follow create an ssh key

```sh
su production
```
* [Create an ssh key and add it to your GitHub account](href="https://help.github.com/articles/connecting-to-github-with-ssh/").

Start by switching back to the root user

```sh
su root
```

Install the LAMP stack and the modules needed to run a reverse proxy.

```sh
apt-get install lamp-server^
a2enmod ssl proxy rewrite headers proxy_http
```

Restart Apache

```sh
service apache2 restart
```

Test Apache by entering your domain name into a browser window. If you see a page that says *Apache2 Ubuntu Default Page* then your Apache web server is working.

> Due to firewall settings this may not yet work in the classroom.

Assign ownership of the web directory to the production user.

```sh
chown production:production /var/www -fR
```

Reboot your droplet

```sh
reboot -n
```

Log back into the server and install NodeJs

```sh
ssh root@YOUR-IP
```

```sh
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
apt-get install -y nodejs
apt-get install -y build-essential

apt-get update
apt-get upgrade
```

Be sure npm is setup globally

```sh
npm install npm -g
```

Install pm2

```sh
npm -g install pm2
```

Install your website on the */var/www* path from GitHub.

```sh
su production
```

Add the production variable to .bashrc
```sh
vim ~/.bashrc
```
Press [shift] + [g] to go to the bottom of the file. Enter insert mode by pressing [i] and move the cursor to a new blank line at the bottom of the page. Add the following.

```bash
export NODE_ENV=production
```

Save your changes with [esc] followed by [shift] + [:] then [x] and [enter]. Reload .bashrc with the follwing.
```sh
cd ~
. .bashrc
```

Clone the repo, install the production packages and start the application.
```sh
cd ~ && git clone git@github.com:YOUR-GITHUB-ACCOUNT/mean.example.com.git
cd mean.example.com && npm install --production
npm start
```

Test that the site is running by opening a browser and entering your new doamin name followed by port :3000, *YOUR-DOMAIN.TLD:3000*.

## Set up pm2
1. Login as production
1. Start the pm2 process
```sh
cd /var/www/mean.example.com
pm2 start process.yml
```
1. switch to root
```sh
su root
```
1. Add production to the sudoers list
```sh
usermod -aG sudo production
```
1. Write the current pm2 state to production home.
```sh
sudo env PATH=$PATH:/usr/bin /usr/lib/node_modules/pm2/bin/pm2 startup systemd -u production --hp /home/production
```
1. Save the current state
```sh
pm2 save
```

Test that pm2 is working by rebooting your server. Then open a browser and entering you domain name against port 3000. If you see your webiste pm2 has taken effect.

## Setup Apache as a Reverse Proxy

```sh
<Proxy *>
	Order deny,allow
	Allow from all
</Proxy>

ProxyRequests Off
ProxyPreserveHost On
ProxyPass / http://localhost:3000/
ProxyPassReverse / http://localhost:3000/
```

## LetsEncypt
```sh
apt-get install python-letsencrypt-apache

certbot renew --dry-run

crontab -e
```
```sh
0 0 15 * * certbot renew
```

```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule (.*) https://%{SERVER_NAME}$1 [R,L]
```

```sh
a2dissite *
service apache2 restart
a2ensite *le*
service apache2 restart
```

Force non-www
```apache
RewriteEngine On
RewriteCond %{HTTP_HOST} ^www\.jasonsnider\.net [NC]
RewriteRule ^(.*)$ https://jasonsnider.net$1 [L,R=301]
```

```sh
a2dissite *
service apache2 restart
a2ensite *le*
service apache2 restart
```

