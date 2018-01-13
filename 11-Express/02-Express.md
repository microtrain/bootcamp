# Express

Express is a web application framework for NodeJS.

[Getting Started with Express](https://expressjs.com/)

Install the Express Generator

```sh
sudo npm install express-generator -g

```

Create an Express based website, we will use PUG as our template engine.

```sh
cd /var/www
express --view=pug mean.example.com
```
Open Atom and add _mean.example.com_ as a project folder. Then ```cd``` into the express directory and finsih the install.

```sh
cd mean*
npm install
```

Start a local web server.

```sh
npm start
```

Navigate to Then [http://localhost:3000/](http://localhost:3000/) to access your new app.

## Exercise - Express Basics

From Atom open *mean.example.com/routes/index.js* and change the following

```js
//change
{ title: 'Express'}
//to
{ title: 'Express', name: 'YOUR-NAME'}
```

From Atom navigate to *mean.example.com/views/index.pug* and change the following. Pleas note the indentation, indentation matters when it comes to Pug.

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

## Creating API routes (aka end points).

An API end point (in this case a data API) is a server response that does not render an HTML view. Rather, the end point would return json, jsonp, xml, soap or the like. Typcially the point of an API is to accept a data request or return a server response in the form of unformatted data. The intent is to create an end point that can interact with other software rather than a human. For example */api/users/create* could allow a user to be created from a web app, desktop app, mobile app, console app, etc. The point is having a single end point that can serve data between to any medium.

@todo create a users API

@add unique-validator to the model

@todo in class, create an SPA that views a list a users, a single user, creates and deletes a user, save the delete functionality for a lab.

@todo Add user authentication

## Labs

1. Create an method in _user_app_ that will make an Ajax request to _/api/users/delete/:id_ and provide a UI element to allow a user to delete another user.
1. Build a CMS
    * Start by defining a post model
    * Build an API for managing blog post with the following end points
        * index
        * edit
        * create
        * view
        * delete
    * Build a JS app that allows us to work with the API.
    * Build a static view page that is not Ajax.
1. Add an additional Passport strategy of your choosing (GitHub, Facebook, Twitter, etc)
1. Add the ability to reset passwords
1. Create a PSA called auth, this will provide
    * user registration
    * user login
    * the ability to change a password
1. Build a layout for website and style the app.
1. Gulp Task
    * Add *src* and *dist* folders to the public directory.
    * Create a Gulp task that will automate the front end packaging

## Additional Resources
* [Express](https://expressjs.com/)
* [Pug](https://pugjs.org/api/getting-started.html)
