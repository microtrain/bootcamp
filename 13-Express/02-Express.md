# Express

Express is a web application framework for NodeJS. In short, Express is a library that provides server side functionality to JavaScript. We will use it to spin up a web server via NodeJS. Express provides middleware that allows us hook into a server request by routing it to a target endpoint, process that request, then hook the response object to send the sum of our processing back to the client.

If you recall from Chapter 4 the Internet works on an IPO model.
* Input - a *request* from the client to the server.
* Process - Taking action on the client request.
* Output - Using the production or processing to send a *response* to the client.

In Express, each endpoint is middleware. That is to www.example.com/hello will likely resolve to a file (aka: route to and endpoint) that contains a function called

```js
router.get('/hello', function(request, response, next) {
  //process the request...
  //Send a reponse to the clinet
  response.render(//the sum of the processing) 
  //OR send the request to the next piece of middleware 
  next()
});
```
In that above snippet, ```router.get()``` routes a GET request, meaning the the client has made an HTTP GET request. The method signature consits of the name of the endpoint and a piece of middleware, which in this case is a callback method. In this example *example.com/hello* routes to the first argument of this method ```'/hello'```. The way you would read this
```router.get('/hello', function(request, response, next){...})``` is "When a client makes a GET request to *example.com/hello* execute the folowing callback method as defined by the second argument, thin case the callback method ```function(request, response, next){...}```.

[Getting Started with Express](https://expressjs.com/)

> In class examples may differ from the attached GitHub repositories. 

## Create an ExpressJS based Project

Go to GitHub and create a new project *mean.example.com*. You can change this to your own domain name if you have one *mean.YOUR-DOMAIN.TLD*. If you use your own domain, moving forward, remember to replace example.com with that of your domain. 

We will 
* Install Express Generator 
* Create a project on GitHub.
* Clone the project to our home directory.
* Use Express Generator to create a skeleton for our project.
* Cover basic coding concepts in Express.
* 

Install the Express Generator

```sh
sudo npm install express-generator -g
```

### Create the repository

[</> code](https://github.com/microtrain/mean.example.com/commit/1f903e33269d0892da3d48ee58c02835c3e10328) mean.example.com

An Express based wed site and REST API with user authentication.

[x] Public

[x] Initialize this repository with a README


Add gitignore: None
Add a license: MIT License

Clone the project into your home directory. Replace YOUR-GITHUB-ACCOUNT with the actual account details (for the sale of this lesson we will refer to this as *mean.example.com*).

```sh
cd ~/
git clone git@github.com:YOUR-GITHUB-ACCOUNT/mean.example.com.git
```

Create an Express based website, we will use PUG as our template engine.

Setup ExpressJS with Pug
```sh
cd mean.example.com
npm install express --save
express --view=pug
npm install
npm start			
```

Split your Terminator window and run ```git status```

Running ```git status``` at this point will show the following.

```sh
$ git status
app.js
bin/
node_modules/
package-lock.json
package.json
public/
routes/
views/
```

@todo - Explain routing and the express file structure.

* app.js
* bin/
* node_modules/
* package.json
* package-lock.json
    * [package.json vs package-lock.json](https://stackoverflow.com/questions/45052520/do-i-need-both-package-lock-json-and-package-json)
    * [Everything You Wanted To Know About package-lock.json But Were Too Afraid To Ask](https://medium.com/@Quigley_Ja/everything-you-wanted-to-know-about-package-lock-json-b81911aa8ab8)
* public/
* routes/
* views/

The *node_modules* directory contains third party software that should not be a part of our repository. Npm will handle these dependencies so we do not need them in our repo. Open VSC and add *mean.example.com* as a project folder.

[</code>](https://github.com/microtrain/mean.example.com/commit/819be3c16875eb10aa6d3f27345c20f3c800155b) Add a .gitignore file to exclude *node_modules* from future commits.

*.gitignore*
```sh
node_modules
```

Commit the *.gitignore* file.
```sh
git add .gitignore
git commit -m 'Ignore node_modules from future commits' .gitignore
```

[</> code](https://github.com/microtrain/mean.example.com/commit/708e34a36597a23531fb1a4cc7f0b34d604316fe) Commit the remaining files created during setup and push both commits to the master branch.

```sh
git add .
git commit -am 'Setup ExpressJS with Pug'
git push origin master
```

Navigate to Then [http://localhost:3000/](http://localhost:3000/) to access your new app.

## Exercise - Express Basics

In this exercise we will make a few basic changes to familiarize ourselves with the basics of ExpressJS. If something breaks don't worry; our last commit created a rollback point. At the end of this exercise we will stash out changes and roll back to our last commit. From the VSC explorer open *mean.example.com/routes/index.js* and change the following

```js
//change
{ title: 'Express'}
//to
{ title: 'Express', name: 'YOUR-NAME'}
```

From the VSC explorer navigate to *mean.example.com/views/index.pug* and change the following. Please note the indentation, indentation matters when it comes to Pug.

```js
//change
extends layout

block content
  h1= title
  p Welcome to #{title}
//to
extends layout

block content
  h1= title
  p Welcome to #{title}

  p My name is #{name}
```

From the same terminal in which your NodeJS server is running press [ctrl+c] then type ```sh npm start``` this will restart the server. Navigate to [http://localhost:3000/](http://localhost:3000/) and refresh the page. You will now see a tag line which states "My name is _YOUR-NAME_"

Let's break this down a bit. In the routing file *mean.example.com/routes/index.js* you define your application's end points (aka actions) by calling an HTTP request request type (typically get or post) in the form of a router method against the router object. The first argument of this method names the end point, the second argument is a call back function that defines the server side functionality for the action.

```js
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express', name: 'YOUR-NAME'});
});
```

So far we we have been dealing with the sites home page. This is handled as a get request via ```router.get()```. The first argument denotes the desired end point and the last argument is a call back function. The callback function tells the server how to deal with the request. The call back will always have three arguments _req_, _res_, and _next_.

* req - shorthand for _request_, this is the request object. This represents the request the user is making of the server. This will contain user supplied data in the for of _req.params_ and _req.body_ and provides a number of other useful properties.
* res - shorthand for _response_, this is the response object. This represents the response the server is building for the user. This will tell the server which views to render, the type of response headers to include and provides a number of other useful properties.
* next - _next()_ tells the current request to move to the next piece of middle ware.

Take note of the line ```res.render('index', { title: 'Express', name: 'YOUR_NAME'});```. The ```render()``` method is a member of the of response object. As it's name suggests, ```render()``` renders a view and serves it to the user. The first argument is a view directory path. In our project the views directory is located at *mean.example.com/views* making the path to index *mean.example.com/views/index*; express knows where to find the views directory so all we need to call is the path relative to views. For example, ```render('users/index')``` would have the path *mean.example.com/views/users/index*. The second argument is a json object. This object holds a list of key to value pairs that get passed into the view.

The view is a _.pug_ file. Pug is a template engine designed for NodeJS. Pug files are processed server side and the resulting HTML is sent to the user. Calling ```res.render('index', { title: 'Express', name: 'YOUR-NAME'});``` pass two variables ```title``` and ```name``` into the view files *mean.example.com/views/index.pug* and build the HTML document that will be served to the user. A pug can handle variables in one of two ways.

```pug
//An element in which the innerHTML consists of only the variable
h1= title

//An element in which the the variable is injected into a string
p Welcome to #{title} how do you do?
```

*index.pug*
```pug
//The layout into which this page will be injected
extends layout

//creates a content variable, every thing below this will be injected into the layout
block content
  // Pug flavored markup
  h1= title
  p Welcome to #{title}
```

*layout.pug*
```
//standard markup
doctype html
html
  head
    title= title
    link(rel='stylesheet', href='/stylesheets/style.css')
  body
    //the content block of index.pug will be injected here.
    block content
```
Open a browser and navigate to [http://localhost:3000/](http://localhost:3000/users). You'll see an unstyled web page the say "respond with a resource".  This because this endpoint is not calling ```res.render()``` rather it is calling ```res.send()```. The ```send()``` method makes no attempt to render a view, this method simply prints any text passed into it to the screen. This is similar to ```res.json()``` in that no view is rendered.

```js
router.get('/', function(req, res) {
  res.send('respond with a resource');
});
```

Now that we have a general feel for our ExpressJS application. Let's stash our changes and start building our application.

```sh
git add .
git stash
git stash clear
```

[</> code](https://github.com/microtrain/mean.example.com/commit/edafcefac47149661a856d0235d7c77dd9ebef67) If you have not already done so, add an *.editorconfig* file to the top level of you project.

*.editorconfig*
```sh
# EditorConfig helps developers define and maintain consistent coding styles between different editors and IDEs
# editorconfig.org

root = true

[*]
indent_style = space
indent_size = 2

# We recommend you to keep these unchanged
end_of_line = lf
charset = utf-8
trim_trailing_whitespace = true
insert_final_newline = true

[*.md]
trim_trailing_whitespace = false
```

```sh
# Add .editorconfig
git add .
git commit -a
git git push origin master
```

## Additional Resources
* https://medium.com/@LindaVivah/the-beginners-guide-understanding-node-js-express-js-fundamentals-e15493462be1

[Next: REST API](03-RESTAPI.md)
