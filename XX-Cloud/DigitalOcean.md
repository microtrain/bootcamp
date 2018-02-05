<p>Create and login to your droplet over SSH. You will be prompted to change your password. Once you have updated your password update apt and run any upgrades.</p>

<pre>
apt-get update
apt-get upgrade
</pre>
<p>
Now create a less privleged user. For the sake of this article we will call that user production. Give the production user a good strong password and follow the prompts, you may leave these questions blank.
</p>

<pre>
adduser production 
</pre>

Git should already be installed. You can verify this by running git --version. Switch to the production user and create an ssh key <a href="https://help.github.com/articles/connecting-to-github-with-ssh/" target="_blank">Create an ssh key and add it to your GitHub account</a>. 

<p>Install the Apache webserver and the modules we will need for out web site.</p>

<pre>
apt-get install apache2
a2enmod ssl proxy rewrite headers proxy_http
</pre>

<p>Restart Apache</p>

<pre>
service apache2 restart
</pre>

<p>Test Apache by entering you droplets IP address into a browser window. If you see a page that says <em>Apache2 Ubuntu Default Page</em> then your Apache web server is working.</p>

Assign ownership of the web directory to the production user.
<pre>
chown production:production /var/www -fR
</pre>

Reboot your droplet
<pre>
reboot -n
</pre>

```sh
root@YOUR-IP
```

<pre>
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
apt-get install -y nodejs
apt-get install -y build-essential

apt-get update
apt-get upgrade
</pre>

<p>Be sure npm is setup globally</p>

<pre>
npm install npm -g
</pre>

Install pm2

<pre>npm -g install pm2</pre>

<p>Install your website on the /var/www path from GitHub. For jasonsnider.com I would say</p> 

<pre>
cd /var/www && git clone git@github.com:YOUR-GITHUB-ACCOUNT/mean.example.com.git
cd mean.jasonsnider.com && npm install --production
npm start
</pre>

<p>Test that the site is running by opening a browser and entering the ip address of your droplet on port :3000. Use <code>ctrl + c</code> to shut down the application. As with MongoDB we want our website to start up on boot.</p>
<pre>vim /etc/rc.local</pre>
<p>Add the line</p>
<pre>cd /var/www/mean.jasonsnider.com/app && ./bin/www</pre>

<p>/etc/rc.local should now look like the following. You MUST start MongoDB prior to starting the website.</p>

<pre>
#!/bin/sh -e
#
# rc.local
#
# This script is executed at the end of each multiuser runlevel.
# Make sure that the script will "exit 0" on success or any other
# value on error.
#
# In order to enable or disable this script just change the execution
# bits.
#
# By default this script does nothing.


#start mean.YOUR-DOMAIN.TLD
pm2 start /var/www/YOUR-DOMAIN.TLD/bin/www

exit 0
</pre>

Reboot your droplet.

<pre>
reboot -n
</pre>

<p>Test that the site is running by opening a browser and entering the ip address of your droplet on port :3000. If you see your webiste both MongoDB and mean.jasonsnider.com have started on boot.</p>

<p>Setup Apache as a reverse proxy</p>

<pre>
	<Proxy *>
		Order deny,allow
		Allow from all
	</Proxy>

	ProxyRequests Off
	ProxyPreserveHost On
	ProxyPass / http://localhost:3000/
	ProxyPassReverse / http://localhost:3000/
</pre>

--------------------------------------------------------------------------------

apt-get install python-letsencrypt-apache

letsencrypt --apache

crontab -e
0 0 15 * * letsencrypt renew
