# Cloud Server

In this unit we will launch our cloud infrastructure. This will include creating a thrid party database, registering a domain name, spinning up a web server and creating a valid TLS connection against a real CA.

# Amazon Web Services (AWS)

[AWS](https://aws.amazon.com "AWS's Homepage")
is an auxiliary of Amazon.com that provides on-demand cloud computing platforms such as IaaS, PaaS and SaaS. AWS offers compute power, database storage, content delivery and other functionality to help businesses scale and grow.

## Terminology

### Cloud Computing
Term used for allowing convenient, on-demand access from anywhere, to computing resources. 

##### 5 Charactics of Cloud Computing

- On-Demand Service
- Broad Network Acess
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
4. Enter code for Identity Verification.
5. Select Support Plan - Basic(Free).
6. Sign in to the Console.

## Amazon EC2

[https://aws.amazon.com/ec2/?nc2=h_m1](https://aws.amazon.com/ec2/?nc2=h_m1)

EC2 web service interface provides you with complete control of your computing resources. This provides virtual servers known as instances to host web applications. Amazon Free Tier provides up to 750 Hours per month of EC2 usages before additional fees apply. This applies to t2.micro instance types!

### Amazon EC2 Install

1. Navigate Services tab for Amazon EC2.
2. Launch Instance under Create Instance Header.
3. Chose an (AMI) - Ubuntu Server 20.04 Free Tier 64-bit.
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
Now that your server is accessible let's install a LAMP stack.

ux console
```
sudo apt update
sudo apt upgrade

sudo apt install lamp-server^
sudo mysql_secure_installation

sudo service mysql stop
sudo mkdir -p /var/run/mysqld
sudo chown mysql:mysql /var/run/mysqld
sudo /usr/sbin/mysqld --skip-grant-tables --skip-networking &
jobs
```

mysql console
```sql
mysql -u root
FLUSH PRIVILEGES;
USE mysql; 

UPDATE user SET authentication_string=PASSWORD("SET-A-PASSWORD") WHERE User='root';
UPDATE user SET plugin="mysql_native_password" WHERE User='root';
quit  
```

ux console
```sh
sudo pkill mysqld
jobs
sudo service mysql start

mysql -u root -p
```

Enable Apache Modules
```sh
a2enmod ssl proxy rewrite headers proxy_http
service apache2 restart
```

```sh
curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
apt install -y nodejs
apt install -y build-essential

apt update
apt upgrade
```

Be sure npm is setup globally
```sh
sudo npm install npm -g
```

### Add your GitHub Key
[Generating a new SSH key and adding it to the ssh-agent](https://help.github.com/articles/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent/)
[Adding a new SSH key to your GitHub account](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)

### Clone your project

```sh
cd ~
git clone [PATH-TO-GIHUB-PROJECT]
```

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

```sh
# Added the ability to connect to either a dev or prod config
git commit -a
git push origin main
```

From your server
```sh
cd ~/mean.example.com
git pull origin main
```

Install pm2
```sh
sudo npm -g install pm2
```

Add *NODE_ENV* as a system var
```sh
echo export NODE_ENV=production | tee -a .bashrc
. .bashrc
echo $NODE_ENV
```

Start PM2
```sh
cd ~/mean.example.com
pm2 start process.yml
sudo env PATH=$PATH:/usr/bin /usr/lib/node_modules/pm2/bin/pm2 startup systemd -u ubuntu --hp /home/ubuntu
pm2 save
```

Test that pm2 is working by rebooting your server. Then open a browser and entering you domain name against port 3000. If you see your website pm2 has taken effect.

#### Virtual Host (VHOST) Configuration

```sh
cd /etc/apache2/sites-available
cp default-ssl mean.example.com
```

comment out the ```DocumentRoot``` directive.
```sh
## DocumentRoot /var/www
```

Add a ```ServerName``` directive, replace MYDOAMIN.TLD with the lowercase version of your domain name.

```sh
ServerName MYDOMAIN.TLD
```

Finally set up you reverse proxy.
```apache
<Proxy *>
	Order deny,allow
	Allow from all
</Proxy>

ProxyRequests Off
ProxyPreserveHost On
ProxyPass / http://localhost:3000/
ProxyPassReverse / http://localhost:3000/
```

Force NON-SSL to an SSL connection, add the following to the top of the VHOST file.
```apache
<VirtualHost *:80>
    RewriteEngine On
    RewriteCond %{HTTPS} !=on
    RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
</VirtualHost>
```

Force non-www
```apache
RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
```

Optional - Force www to non-www
```sh
RewriteEngine On
RewriteBase /
RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ https://%1/$1 [R=301,L]
```
Optional - Force non-www to www
```sh
RewriteEngine On
RewriteBase /
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteRule ^(.*)$ https://www.%{HTTP_HOST}/$1 [R=301,L]
```
Restart Apache
```sh
a2dissite *
service apache2 restart
a2ensite mean*
service apache2 restart
```

## Route 53

[https://aws.amazon.com/route53/](https://aws.amazon.com/route53/)

Amazon Route 53 is scalable cloud Domain Name System (DNS). This is amazons preferred way of connecting user request to infrastructures running in AWS.

## Amazon S3

[https://aws.amazon.com/s3/?nc2=h_m1](https://aws.amazon.com/s3/?nc2=h_m1)

S3 is object storage built to store and retrieve any amount of data from anywhere. Its a secure, durable and scalable infrastructure. Amazon Free Tier provides free services of S3 up to 5GB of standard storage, 20,000 Get Requests and 2,000 Put Requests.

#### S3 Setup

1. Navigate Services tab for Amazon S3.
2. Create Bucket.
3. Set Bucket Index Page, Properties and Permissions.
4. Start storing data such as static files( html, javascript, css ), photos, videos and etc.
5. Access/Manage objects in bucket.

A bucket is a flat container of objects and doesn't provide hierarchical organization. You can create hierarchy by using object key names that imply a folder structure. When you store data, you assign a unique object key that can later be used to retrieve the data. Object names are prefixed with folder names. Every folder created must have an index document at each level.

## RDS

[https://aws.amazon.com/rds/?nc2=h_m1](https://aws.amazon.com/rds/?nc2=h_m1)

Rational Database Service for MySQL, PostgreeSQL, MariaDB, Oracle BYOL or SQL Server. Amazon Free Tier includes 750 Hours of RDS usage per month of db.t2.micro database usage. RDS Free Tier allows up to 20GB of storage.

## DynamoDB

[https://aws.amazon.com/dynamodb/?nc2=h_m1](https://aws.amazon.com/dynamodb/?nc2=h_m1)

Similar to RDS, DynamoDB is a fully managed NoSQL database service. This Free Tier service allows up to 25GB of storage and suppose to handle up to 200M request per month.

## Other AWS Free Tier Services

### SNS

[https://aws.amazon.com/sns/](https://aws.amazon.com/sns/)

Free service provided by AWS Free Tier. Amazon Simple Notification Service is a flexible and fully managed messaging and mobile notification service for subscribing endpoints and clients.


### Elastic Beanstalk

[https://aws.amazon.com/elasticbeanstalk/?nc2=h_m1](https://aws.amazon.com/elasticbeanstalk/?nc2=h_m1)

Free Tier services that is an easy-to-use services for deploying and scaling web applications without much installation and management of application. You can upload your code and Elastic Beanstalk automatically handles deployment with management containers for environments such as Java, .NET, PHP, NODE.js, and Python on familiar servers. Elastic Beanstalk leverages other AWS Services such as EC2, S3, and SNS.

### Elastic Block Storage

[https://aws.amazon.com/ebs/?nc2=h_m1](https://aws.amazon.com/ebs/?nc2=h_m1)

Service for additional EC2 instance storage. EBS is a storage volume for an EC2 instance. These blocks can be attached to any running instance to add, transfer or copy data.

### CloudFront

[https://aws.amazon.com/cloudfront/](https://aws.amazon.com/cloudfront/)

Web service to distribute content to users with high data transfer speeds. Up to 50GB of data transfer total. 

