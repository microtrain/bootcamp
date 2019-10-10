# [NPM](https://www.npmjs.com/)

Non-Parametric Mapping or (as it is most commonly but incorrectly known) Node Package Manager (NPM) is a package management system for managing Node.JS (JavaScript) packages. This is akin to Gems, Composer, or PIP as they relate to Ruby, PHP, and Python respectively. Under the hood, these may be very different in terms of how they operate, but practically speaking they all accomplish the same goal; package and dependency management.

Node.js (Node) is an insanely popular platform that allows you to build cross-platform applications using web technology. As a result, many web development tools are written in Node. These tools can be installed using NPM. We will need to install Node to get started with these tools. Follow the [installation instructions](https://github.com/nodesource/distributions/blob/master/README.md) from NodeSource instructions to install the latest stable LTS (long term support) version. 

I always recommend building on the latest stable LTS version of a language or framework. As of this writing, the current LTS is version 10.x you can use the [Node release schedule](https://github.com/nodejs/Release#release-schedule) to verify the current LTS. Node uses even-numbered releases to denote LTS versions and odd-numbered releases would be short term (experimental, bleeding edge, etc) releases. I would not use a short term release for product development.

**Node.js v10.x**:

```sh
curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
sudo apt-get install -y nodejs
```

After install run the following commands
```sh
node -v
npm -v
```

These should return versions >= 10.16.0 and 6.9.0 respectively.

## Summary
In this lesson, you learned
* how to install Node.js (Linux, Node)

## Additional Resources
* [Debian and Ubuntu Based Linux Distribution](https://nodejs.org/en/download/package-manager/#debian-and-ubuntu-based-linux-distributions)

[Next: Git](07-Git.md)
