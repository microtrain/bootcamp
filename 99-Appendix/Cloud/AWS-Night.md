# Amazon Web Services (AWS)

In this unit we will launch a cloud infrastructure. This will include 
* Registering a domain name
* Creating an AWS account
* Creating a thrid party database
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
