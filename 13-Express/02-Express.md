# Express

Express is a web application framework for NodeJS. In short, Express is a library that provides server-side functionality to JavaScript. We will use it to spin up a web server via NodeJS. Express provides middleware that allows us to hook into a server request by routing it to a target endpoint, process that request, then hook the response object to send the sum of our processing back to the client.

If you recall from Chapter 4 the Internet works on an IPO model.
* Input - a *request* from the client to the server.
* Process - Taking action on the client request.
* Output - Using the product of our processing to send a *response* to the client.

In Express, each endpoint is middleware. That is to say, www.example.com/hello will likely resolve to a file (aka, the route to and endpoint) that contains a function that references */hello*.

```js
router.get('/hello', function(request, response, next) {
  //process the request...
  //Send a response to the client
  response.render(//the sum of the processing) 
  //OR send the request to the next piece of middleware 
  next()
});
```
In the above snippet, ```router.get()``` routes a GET request, meaning the client has made an HTTP GET request. The method signature consists of the name of the endpoint and a piece of middleware, which in this case is a callback method. In this example *example.com/hello* routes to the first argument of the method ```'/hello'```. The way you would read 
```router.get('/hello', function(request, response, next){...})``` is as follows. "When a client makes a GET request to *example.com/hello* execute the following callback method as defined by the second argument; in this case, it is the callback ```function(request, response, next){...}```.

[Getting Started with Express](https://expressjs.com/)

> In-class examples may differ from the attached GitHub repositories. 

## Create an Express-based Project

Go to GitHub and create a new repository *mean.example.com*. You can change this to your domain name if you have one *mean.YOUR-DOMAIN.TLD*. If you use your domain, moving forward, remember to replace example.com with that of your domain. 

We will 
* Install Express Generator.
* Create a repository on GitHub.
* Clone the repository to our home directory.
* Use Express Generator to create a skeleton for our project.
* Cover some very basic coding concepts in Express.
* Introduce ourselves to Pug.
* Create an [editorconfig](https://editorconfig.org/) file.

Install the Express Generator

```sh
sudo npm install express-generator -g
```

### Create the repository

[</> code](https://github.com/microtrain/mean.example.com/commit/1f903e33269d0892da3d48ee58c02835c3e10328) mean.example.com

An Express-based web site and REST API with user authentication.

[x] Public

[x] Initialize this repository with a README


Add gitignore: None
Add a license: MIT License

Clone the repository into your home directory. Replace YOUR-GITHUB-ACCOUNT with the actual account details (for the sale of this lesson we will refer to this as *mean.example.com*).

```sh
cd ~/
git clone git@github.com:YOUR-GITHUB-ACCOUNT/mean.example.com.git
```

Create an Express-based website, we will use PUG as our template engine.

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

#### Default File Structure

**app.js**

This is the application. If you wanted to, you could code your entire site into this file but most people wouldn't do that. This tends to serve as the entry point to your website. This file initializes critical functionality and setups routing.

**bin/**

This contains a file called WWW. This is the first and last file to execute.

**node_modules/**

Third-party libraries. Anytime you run ```npm install``` you are installing third-party libraries. When you run that command without the ```-g``` option you are installing that library in the current project and opposed to installing it at the system level.

**package.json**

This tracks every third-party library you have installed. If you need to rebuild your project you can run ```npm install``` and that will read from *project.json* as opposed to installing each library individually. 

**package-lock.json**

Most third-party libraries will be dependent upon other third-party libraries. Every third-party library you install brings these libraries with them. The *package.json* file tracks the exact version of each library that was installed and prevent the same library from being installed twice (in the case of multiple dependencies relying on that library.
    * [package.json vs package-lock.json](https://stackoverflow.com/questions/45052520/do-i-need-both-package-lock-json-and-package-json)
    * [Everything You Wanted To Know About package-lock.json But Were Too Afraid To Ask](https://medium.com/@Quigley_Ja/everything-you-wanted-to-know-about-package-lock-json-b81911aa8ab8)
    
**public/**

Publicly accessible code and assets. This where you would host CSS, JavaScript, images, PDFs, static web pages, etc. 

**routes/**

All server endpoints.

**views/**

Page templates, in this class we will use a templating language called pug. This is where your pug files will live.


### Ignore Node Modules
The *node_modules* directory contains third-party software that should not be a part of our repository. Npm will handle these dependencies so we do not need them in our repo. Open VSC and add *mean.example.com* as a project folder.

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

[</> code](https://github.com/microtrain/mean.example.com/commit/708e34a36597a23531fb1a4cc7f0b34d604316fe) Commit the remaining files created during setup and push both commits to the main branch.

```sh
git add .
git commit -am 'Setup ExpressJS with Pug'
git push origin main
```

Navigate to Then [http://localhost:3000/](http://localhost:3000/) to access your new app.

## Exercise - Pug and Express Basics

In this exercise, we will make a few basic changes to familiarize ourselves with the basics of Express. If something breaks don't worry; our last commit created a rollback point. At the end of this exercise, we will stash our changes and roll back to our last commit. From the VSC explorer open *mean.example.com/routes/index.js* and change the following

```js
//change
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});
//to
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express', name: 'YOUR-NAME'});
});
```

The following code snippet routes the default home page for the express project. The first argument ```router.get('/',``` says "I will handle all GET requests to the home page". The callback arguments *req*, *res*, and *next* represent *request*, *response*, and *next* respectively. 

```js
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});
```

```res.render()``` calls the ```render()``` method from the response object. The ```render()``` method accepts two arguments; the path to a template and a JSON string for passing data to the template file. The first argument assumes you are looking for a *pug* file in your project's *view* directory. Thus, ```'index'``` correlates to */view/index.pug*. The second argument is a JSON object that allows us to create variables that we can pass to a template. The string ```{ title: 'Express', name: 'YOUR-NAME'})``` will make the variables *title* and *name* both available to the template (aka, view). 


### Templates, Views, and Pug

In this context, a *template* (aka, layout) is a file that contains common elements to be used by multiple pages. A template may provide something similar to the following. 

> The terms template and view are often used interchangeably so don't get too hung up on the terminology. 

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>title</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
  </head>
  <body>
    <!-- Inject a view here -->
  </body>
</html>
```
Notice the comment ```<!-- Inject a view here -->```. In this context, the view is a snippet that gets injected into the page such as

```html
<h1>Hello World</h1>
<p>I'm not a complete webpage but when you inject me into a template we complete the picture.</p>
```

By default, Express uses a templating language called pug. Pug is a special syntax that represents HTML elements. Pug is processed by the server and converted to HTML. The HTML makes up the response we return to the client.

Instead of tags, pug uses keywords and indentation. Instead of ```<!doctype html>``` we have ```doctype html``` likewise instead of ```<p>Hello world</p>``` we would have ```p Hello World```. Rather than nesting tags inside of tags we use indentation such that
```html
<div>
  <p>Hello</p>
</div>
```

becomes 

```pug
div
    p Hello
```

Pug has two ways of reading in variables. You can use an equals sign against an element ```title= title``` or you can use a hashtag with curly braces ```p Welcome to #{title}```. The latter allows you to inject the variable into a string whereas the former requires the variable to be the only data in the element. Pug has additional keywords such as ```extends``` which is used to call a particular template and ```block``` which is used to create a block of content to inject into a template. Don't worry if this doesn't make sense we will cover this again in a few minutes.

From the VSC explorer navigate to *mean.example.com/views/index.pug* and change the following. 

> Please note the indentation, **indentation matters** when it comes to Pug.

```js
//- change
extends layout

block content
  h1= title
  p Welcome to #{title}
//- to
extends layout

block content
  h1= title
  p Welcome to #{title}

  p My name is #{name}
```

From the same terminal in which your NodeJS server is running press [ctrl+c] then type ```npm start``` this will restart the server. Navigate to [http://localhost:3000/](http://localhost:3000/) and refresh the page. You will now see a tag line which states "My name is _YOUR-NAME_"

#### Another Look
Let's take a minute to reiterate what is happening. In the routing file *mean.example.com/routes/index.js* you define your application's endpoints (aka actions) by making an HTTP request of a given type (typically get or post) in the form of a router method against the router object. The first argument of this method names the endpoint, the second argument is a call back function that defines the server-side functionality for the action.

```js
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express', name: 'YOUR-NAME'});
});
```

So far we have been dealing with the site's home page. This is handled as a get request via ```router.get()```. The first argument denotes the desired endpoint and the last argument is a call back function. The callback function tells the server how to deal with the request. The call back will always have three arguments _req_, _res_, and _next_.

* req - shorthand for _request_, this is the request object. This represents the request the user is making of the server. This will contain user-supplied data in the form of _req.params_ and _req.body_ and provides several additional properties.
* res - shorthand for _response_, this is the response object. This represents the response the server is building for the user. This will tell the server which views to render, the type of response headers to include and provides several additional properties.
* next - _next()_ tells the current request to move to the next piece of middleware.

Take note of the line ```res.render('index', { title: 'Express', name: 'YOUR_NAME'});```. The ```render()``` method is a member of the response object. As its name suggests, ```render()``` renders a view and serves it to the user. The first argument is the view's directory path. In our project the views directory is located at *mean.example.com/views* making the path to index *mean.example.com/views/index*; express knows where to find the views directory so all we need to call is the path relative to views. For example, ```render('users/index')``` would have the path *mean.example.com/views/users/index*. The second argument is a json object. This object holds a list of key-to-value pairs that get passed into the view.

The view is a _.pug_ file. Pug is a template engine designed for NodeJS. Pug files are processed server-side and the resulting HTML is sent to the user. Calling ```res.render('index', { title: 'Express', name: 'YOUR-NAME'});``` pass two variables ```title``` and ```name``` into the view files *mean.example.com/views/index.pug* and build the HTML document that will be served to the user. A pug can handle variables in one of two ways.

```pug
//-An element in which the innerHTML consists of only the variable
h1= title

//-An element in which the variable is injected into a string
p Welcome to #{title} how do you do?
```

*index.pug*
```pug
//-The layout into which this page will be injected
extends layout

//-creates a content variable, everything below this will be injected into the layout
block content
  // Pug flavored markup
  h1= title
  p Welcome to #{title}
```

*layout.pug*
```
//-standard markup
doctype html
html
  head
    title= title
    link(rel='stylesheet', href='/stylesheets/style.css')
  body
    //-the content block of index.pug will be injected here.
    block content
```
Open a browser and navigate to [http://localhost:3000/](http://localhost:3000/users). You'll see an unstyled web page that says "respond with a resource". This because this endpoint is not calling ```res.render()``` rather it is calling ```res.send()```. The ```send()``` method will not attempt to render a view, this method simply prints any text passed into it to the screen. This is similar to ```res.json()``` in that no view is rendered.

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

## [EditorConfig](https://editorconfig.org/) helps developers define and maintain consistent coding styles between different editors and IDEs

[</> code](https://github.com/microtrain/mean.example.com/commit/edafcefac47149661a856d0235d7c77dd9ebef67) If you have not already done so, add a *.editorconfig* file to the top level of your project.

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
git push origin main
```

## Additional Resources
* [THE BEGINNER’S GUIDE: Understanding Node.js & Express.js fundamentals](https://medium.com/@LindaVivah/the-beginners-guide-understanding-node-js-express-js-fundamentals-e15493462be1)

[Next: REST API](03-RESTAPI.md)
