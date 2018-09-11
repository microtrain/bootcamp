# Express

Express is a web application framework for NodeJS.

[Getting Started with Express](https://expressjs.com/)

> In class examples may differ from the attached GitHub repositories. 

## Create an ExpressJS based Project

Go to GitHub and create a new project *mean.example.com*. You can change this to your own domain name if you have one *mean.YOUR-DOMAIN*.

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

The *node_modules* directory contains third party software that should not be a part of our repository. Npm will handle these dependencies so we do not need them in our repo. Open Atom and add *mean.example.com* as a project folder.

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

In this exercise we will make a few basic changes to familiarize ourselves with the basics of ExpressJS. If something breaks don't worry; our last commit created a rollback point. At the end of this exercise we will stash out changes and roll back to our last commit. From Atom open *mean.example.com/routes/index.js* and change the following

```js
//change
{ title: 'Express'}
//to
{ title: 'Express', name: 'YOUR-NAME'}
```

From Atom navigate to *mean.example.com/views/index.pug* and change the following. Please note the indentation, indentation matters when it comes to Pug.

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

## Create a Data API

An API end point (in this case a data API) is a server response that does not render an HTML view. Rather, the end point would return json, jsonp, xml, soap or the like. Typically, the point of an API is to either accept a data request or return a server response in the form of unformatted data. The intent is to create an end point that can interact with other software rather than a human. For example, */api/users/create* could allow a user to be created from a web app, desktop app, mobile app, console app, etc. The point is having a single end point that can serve data between to any medium. Our applications will use HTTP verbs (GET, PUT, POST, DELETE) to create a CRUD based REST API that interacts with JSON data.

* Relevant HTTP Verbs - POST, GET, PUT, DELETE
* CRUD - Create, Read, Update, Delete
* REST - REpresentational State Transfer

**Translate HTTP Verbs to CRUD**

  * Create - POST
  * Read - GET
  * Update - PUT
  * Delete - DELETE

### Create a Data Model

We will start with a JSON based users API. This will provide end points for creating and managing users. This is also known as a data API, since this deals with data; the data model is a logical place to start.


#### Create the Database
Open MongoDB

```sh
sudo service mongod start
mongo
```

From the MongoDB shell (be sure you see a ```>```) create a database called *mean-cms*. Then create a test document by inserting running an insert against the users collection.

```sh
use mean-cms
db.users.insert({email: 'test@example.com', username: 'testuser'})
```

#### Add a Config File

[</> code](https://github.com/microtrain/mean1.example.com/commit/3f2277d3a874126b2590c26b9d495e00f0b53be4) A config file is a good practice for storing and managing API keys and other configuration variables from a central location. I often create two files, one for production and one for development.

* Create the file *config.dev.js*

*config.dev.js*
```js
var config = {};
config.mongodb = 'mongodb://localhost/mean-cms';
module.exports = config;
```

* Call the configuration file from *app.js*

*app.js*
```js
var config = require('./config.dev');

//Test the file
console.log(config);
```

Remove the ```console.log()``` and connect to the database. Call mongoose from the top of app.js.

*app.js*
```js
var mongoose = require('mongoose');
```

Then call the connection string. Be sure to place this after the call to config file.
```js
//Connect to MongoDB
mongoose.connect(config.mongodb);
```

```sh
git commit -am 'Added a connection to the database'
git push origin master
```

#### Define the Schema

Next we will create a *models* directory in the root of our project and in it a file named *users.js* resulting is *mean.example.com/models/users.js*.

```sh
npm install mongoose
git commit -am 'Install Mongoose'
git push origin master
```

Validation is a key feature of Mongoose. Executes before making a save to MongoDB. This allows us to define rules at the model level. We will want to make sure usernames and email addresses are unique. Mongoose does not have a built in validator for this but the community does. We will install the [mongoose-unique-validator](https://www.npmjs.com/package/mongoose-unique-validator) plugin and set uniqueness as needed.

```sh
npm install mongoose-unique-validator
git commit -am 'Install mongoose-unique-validator'
git push origin master
```

```js
var mongoose = require('mongoose'),
  Schema = mongoose.Schema,
  uniqueValidator = require('mongoose-unique-validator');

//Create a schema
var Users = new Schema({
  email: {
    type: String,
    required: [true, 'Please enter an email'],
    unique: [true, 'Email must be unique']
  },
  username: {
    type: String,
    required: [true, 'Please enter a username'],
    unique: [true, 'Usernames must be unique']
  },
  first_name: String,
  last_name: String,
  admin: {
    type: Boolean,
    default: false
  }
});

Users.plugin(uniqueValidator);

module.exports  = mongoose.model('Users', Users);
```

#### Implement the REST/CRUD Functionality

* create - A POST request that creates a user
* read - A GET request that returns either a single user record
* read - A GET request that returns a list of user records
* update - A PUT request that updates an existing record
* delete - A delete request that removes an existing user

##### GET/Read All
[</> code](https://github.com/microtrain/mean1.example.com/commit/e97e24c4acbeb7ad4d215fae7230ffe81215fd80) GET/Read all users

```sh
curl -H "Content-Type: application/json" -X GET http://localhost:3000/api/users/
```

##### GET/Read One
[</> code](https://github.com/microtrain/mean1.example.com/commit/a788806f4fade23968121572b6ac9a9bdf7c74ea) GET/Read a single user

```sh
curl -H "Content-Type: application/json" -X GET http://localhost:3000/api/users/5a763b67a5d70c115d81536a
```

##### POST/Create
[</> code](https://github.com/microtrain/mean1.example.com/commit/3fbb13f87bfee5c3de9679e2df6d9b22ed89016e) CREATE/Create a user

Test with a simple curl request
```sh
curl -d '{"email":"test2@example.com", "username":"testuser2", "first_name": "Bob", "last_name": "smith"}' -H "Content-Type: application/json" -X POST http://localhost:3000/api/users

curl -d '{"email":"test3@example.com", "username":"testuser3", "first_name": "Sally", "last_name": "Smith"}' -H "Content-Type: application/json" -X POST http://localhost:3000/api/users
```

##### PUT/Update
[</> code](https://github.com/microtrain/mean1.example.com/commit/3fbb13f87bfee5c3de9679e2df6d9b22ed89016e) PUT/Update a user

```sh
curl -d '{"_id":"5a77536ad7e4c37d6f792716", "first_name":"Robert"}' -H "Content-Type: application/json" -X PUT http://localhost:3000/api/users
```

##### DELETE/Delete
[</code>](https://github.com/microtrain/mean1.example.com/commit/4420ef4064c9240a85c53a0fac51d5a302a6078c) DELETE/Delete a user

```sh
curl -H "Content-Type: application/json" -X DELETE http://localhost:3000/api/users/5a766d52cbe495128293baef
```

#### Add Created and Modified Dates

[</code>](https://github.com/microtrain/mean1.example.com/commit/b1f8bf0597c270df42ebb0cdfaddd6d2505db03e) Add and auto-populate created and modified dates on document creation.

##### Auto Update the Modified Date When a Document is Saved

[</code>](https://github.com/microtrain/mean1.example.com/commit/daedc8e236e9d5c03efbee02920113a0bfaecc00) Auto update the modifed timestamp prior to saving the document.

## User Authentication with Passport

### Passport Local Strategy
[</> code](https://github.com/microtrain/mean1.example.com/commit/78b0dc53d4851621d4dc7b8ea2d6a2a6d48f2fbb) Install all the packages needed for building a passport session and storing it in the database. The commit points to the package.json files, you can install these packages over the commandline or 

```sh
npm install passport
npm install passport-local
npm install passport-local-mongoose
npm install express-session
npm install connect-mongo
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/321cdc5936a0bb85cc89b33a04b50720a7844226) Require session packages
*app.js*
```js
var session = require('express-session');

//Add this after the Mongo connection
var MongoStore = require('connect-mongo')(session);
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/bf31173528bd3815cde62e472678b426cd3aff70) Add configuration objects for sessions and cookies
*config.dev.js*
```js
//Session configuration object
config.session = {};

//Cookie configuration object
config.cookie = {};

//Create a renadom string to sign the session data
//Bigger is better, more entropy is better
//The is OK for dev, change for production
config.session.secret = '7j&1tH!cr4F*1U';

//Define the domain for which this cookie is to be set
config.cookie.domain = 'localhost:3000';
```

[</code>](https://github.com/microtrain/mean1.example.com/commit/61048acfce52c12fcc747a775e275f57e0e5c8ac) Configure the [express session](https://github.com/expressjs/session)
```js
var passport = require('passport');

...

app.use(require('express-session')({
  //Define the session store
  store: new MongoStore({
    mongooseConnection: mongoose.connection
  }),
  //Set the secret
  secret: config.session.secret,
  resave: false,
  saveUninitialized: false,
  cookie: {
    path: '/',
    domain: config.cookie.domain,
    //httpOnly: true,
    //secure: true,
    maxAge: 1000 * 60 * 24 // 24 hours
  }
}));
app.use(passport.initialize());
app.use(passport.session());
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/9513474495901b01f4fdc2a891de91b6f79b060d)Serialize the session data
```js
passport.serializeUser(function(user, done){
  done(null,{
    id: user._id,
    username: user.username,
    email: user.email,
    first_name: user.first_name,
    last_name: user.last_name
  });
});

passport.deserializeUser(function(user, done){
  done(null, user);
});
```

#### User Registration

##### Passport Local Mongooose

[</> code](https://github.com/microtrain/mean1.example.com/commit/94efcb4fc6f3e0daa2e6461fb9ec090e166b2079) Update the user model to require hash and salt as strings.

*models/user.js*
```js
    hash: {
        type: String,
        required: [
            true, 
            'There was a problem creating your password'
        ]
    },
    salt: {
        type: String,
        required: [
            true, 
            'There was a problem creating your password'
        ]
    },
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/4408263d8af4e2709c795aa27c35d6817054efb4) Add passport-local-mongoose

*models/user.js*
```js
var passportLocalMongoose = require('passport-local-mongoose'); 

...

User.plugin(passportLocalMongoose);
```

[</>code](https://github.com/microtrain/mean1.example.com/commit/86b74c55499f5f690f636a9014b52ba87d8359ac) Require and use Passport Local Strategy as defined in the user model
```js
var LocalStrategy = require('passport-local').Strategy;

//Require models
var User = require('./models/user');

...
//Use LocalStrategy as defined in the user model
passport.use(User.createStrategy());
```

###### Clean Up  
* [</> code](https://github.com/microtrain/mean1.example.com/commit/e82d3d183d175f3df7b14b03afe77116fe030a1a) Improve Comments  
* [</> code](https://github.com/microtrain/mean1.example.com/commit/858577d248028026e42464d0729fd50b0b915f12) Improve Variable Names  

##### Registration Endpoint

[</> code](https://github.com/microtrain/mean1.example.com/commit/e6094aae8742a1bdea513ef330e11da8970e1175) Add a users route with an end point for registering a user.

Create the file *routes/users.js*. This will need access to express, passport and the user model.
```js
var express = require('express');
var router = express.Router();
var passport = require('passport');
var User = require('../models/user');

router.get('/register', function(req, res, next) {
  res.render('users/register', { 
    title: 'Create an Account'
   });
});

module.exports = router;
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/96895ae42309bd5928235328916ced131a4265c4) Add the new user route to *app.js*
```js
var usersRouter = require('./routes/users');

...


app.use('/users', usersRouter);
```

##### Registration View

[</> code](https://github.com/microtrain/mean1.example.com/commit/22edc04c8c765df223d4f2a995cb0cb946a68030) Create a users view directory with a registration view.

*views/users/register.pug*

```js
extends ../layout

block content
  h1 Create an Account
  form(method='post' action='/api/users/register')
    div
      label(for='username') Username
      input(type='text' name='username' id='username')
    div
      label(for='email') Email
      input(type='text' name='email' id='email')
    div
      label(for='first_name') First Name
      input(type='text' name='first_name' id='first_name')
    div
      label(for='last_name') Last Name
      input(type='text' name='last_name' id='last_name')
    div
      label(for='password') Password
      input(type='password' name='password' id='password')
    div
      input(type='submit' value='submit')
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/84bae780c246b3d9ef6becc89be46e39cc355e2b) Add some simple fomr style to *public/stylesheets/style.css*
```css
label {
  display: block;
  font-weight: bold;
}

input[type="text"],
input[type="password"],
textarea{
  font: 24px monospace;
  padding: .75rem 1.25rem;
  margin: .5rem 0 1rem;
  display: inline-block;
  border: 1px solid #ddd;
  box-sizing: border-box;
  width: 100%;
  border-radius: 2px;
}

input[type="submit"],
button,
a.button{
  padding: .75rem 1.25rem;
  font: 24px monospace;
  text-decoration: none;
  appearance: button;
  color: #fff;
  border: 1px solid #0055ee;
  background: #fff;
  cursor: pointer;
  background: #0099ee;
  border-radius: 2px;
}
```

##### Post the Registration Form to the Users API
[</> code](https://github.com/microtrain/mean1.example.com/commit/2df8937648a513b4b07cfc116cd5ed119a233ff8) Add a registration end point the the users API. */users/register* is a GET request that will load a registration form. */api/users/register* is a POST request that creates a user record complete with salt and has values. For now, registartion will end with duping a JSON string onto the screen. Later we can convert this to an AJAX application.

Add the following to *routes/api/users*

```js
//Register a new user
router.post('/register', function(req,res,next){
    var data = req.body;

    User.register(new User({
      username: data.username,
      email: data.email,
      first_name: data.first_name,
      last_name: data.last_name
    }), 
    data.password, 
    function(err, user){

      if(err){

        return res.json({
          success: false, 
          user: req.body, 
          errors: err
        });
        
      }

      return res.json({
        success: true,
        user: user
      });

    });

});
```
#### User Login/Logout

[</> code](https://github.com/microtrain/mean1.example.com/commit/9330c1d01aa872e7adc9d8aebb7494d4ed7954fc) Create a GET and POST end points for login

*routes/users.js*

```js
router.get('/login', function(req, res){
  res.render('users/login');
});

router.post('/login', passport.authenticate('local'), function(req, res){
  res.redirect('/users');
});
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/42c7611d9c341188d3e81a774a26a652f6469a7f) Create a login form

*views/users/login.pug*

```pug
extends ../layout

block content
  form(method='post' action='/users/login')
    div
      label(for='username') Username
      input(type='text' name='username' id='username')
    div
      label(for='password') Password
      input(type='password' name='password' id='password')
    div
      input(type='submit' value='Login')
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/3dda162467dca14ff4fb16816705aedf274d7ba9) Add an index end point for users

*routes/users.js*
```js
router.get('/', function(req, res){
  res.render('users/index');
});
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/c09512dcb83cabd719ddd67e2483fa8fb029cf08) Add a view for the users index.

*views/users/index.pug*

```pug
extends ../layout

block content
  h1 Users Management
```

[</> code](https://github.com/microtrain/mean1.example.com/commit/66234e08d491c77e2a011eb8fa55ae38dd607e73) Create a GET end point for logout

*routes/users.js*

```js
router.get('/logout', function(req, res){
  req.logout();
  res.redirect('/users/login');
});
```

### Authenticated Whitelist

```js
//Session based access control
app.use(function(req,res,next){
  //return next();

  var whitelist = [
    '/',
    '/favicon.ico',
    '/users/login'
  ];

  //req.url holds the current URL
  //indexOf() returns the index of the matching array element
  //-1, in this context means not found in the array
  //so if NOT -1 means is found in the whitelist
  //return next(); stops execution and grants access
  if(whitelist.indexOf(req.url) !== -1){
    return next();
  }

  //Allow access to dynamic end points
  var subs = [
    '/public/',
  ];

  //The query string provides a partial URL match begining
  //at position 0
  for(var sub of subs){
    if(req.url.substring(0, sub.length)===sub){
      return next();
    }
  }

  //There is an active user session
  if(req.isAuthenticated()){
    return next();
  }

  return res.redirect('/users/login');
});
```

## Create an AJAX Appliction to for Managing Users

### CORS Cross-Origin Resource Sharing
```js
//Set up CORS
app.use(function(req, res, next) {
  res.header('Access-Control-Allow-Credentials', true);
  res.header("Access-Control-Allow-Origin", "*");
  res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
  res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept');
  if ('OPTIONS' == req.method) {
    res.send(200);
  } else {
    next();
  }
});
```


## AJAX

Create a method called viewIndex. This method will make an API call to the users index end point aka */*.
```js
function viewIndex(){
  //Define the target url
  var url = 'http://localhost:3000/api/users';  

  //Create a new AJAX request
  var xhr = new XMLHttpRequest();
  xhr.open('GET', url);
  xhr.send();

  xhr.onload = function(){
    console.log(JSON.parse(xhr.response));
  }
```

```js
function viewIndex(){
    var url = 'http://localhost:3000/api/users';

    var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.send();

    xhr.onload = function(){
        let data  = JSON.parse(xhr.response);
        var rows = '';

        for(var i=0; i<data['users'].length; i++){
            let x = data['users'][i];
            let name = `${x.first_name} ${x.last_name}`;
            rows = rows + `<tr>
                <td>
                    <a href="#edit-${x._id}" 
                        onclick="viewUser('${x._id}')">
                        ${name}
                    </a>
                </td>
                <td>${x.username}</td>
                <td>${x.email}</td>
            </tr>`;
        }

        var app = document.getElementById('app');
        app.innerHTML = `<table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>`;

    }
}

function viewUser(id){
    var url = 'http://localhost:3000/api/users/' + id;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.send();

    xhr.onload = function(){
        var data = JSON.parse(xhr.response);
        var user = data.user;
        var app = document.getElementById('app');

        app.innerHTML = `
            <h2>${user.last_name}, ${user.first_name}</h2>
            <table class="table">
                <tbody>
                    <tr><th>ID</th><td>${user._id}</td></tr>
                    <tr><th>First Name</th><td>${user.first_name}</td></tr>
                    <tr><th>Last Name</th><td>${user.last_name}</td></tr>
                    <tr><th>Username</th><td>${user.username}</td></tr>
                    <tr><th>Email</th><td>${user.email}</td></tr>
                </tbody>
            </table>
            
            <h3>Edit the User Record</h3>
            <form id="editUser" action="/api/users" method="put">
                <input type="hidden" name="_id" value="${user._id}">
                <div>
                    <label for="username">Username</label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        value="${user.username}">
                </div>

                <div>
                    <label for="email">Email</label>
                    <input 
                        type="text" 
                        name="email" 
                        id="email" 
                        value="${user.email}">
                </div>

                <div>
                    <label for="first_name">First Name</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        id="first_name" 
                        value="${user.first_name}">
                </div>

                <div>
                    <label for="last_name">Last Name</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        id="last_name" 
                        value="${user.last_name}">
                </div>

                <input type="submit" value="Submit">
            </form>
            
            <div class="actions">
                <a href="#deleteUser-${user._id}"
                    onclick="deleteUser('${user._id}');"
                    class="text-danger"
                >Delete</a>
            </div>
            `;

        var editUser = document.getElementById('editUser');
        editUser.addEventListener('submit', function(e){
            e.preventDefault();
            var formData = new FormData(editUser);
            var url = 'http://localhost:3000/api/users';
            var xhr = new XMLHttpRequest();
            xhr.open('PUT', url);
            xhr.setRequestHeader(
                'Content-Type', 
                'application/json; charset=UTF-8');

            var object={};
            formData.forEach(function(value, key){
                object[key] = value;
            });
            xhr.send(JSON.stringify(object));

            xhr.onload = function(){
                let data = JSON.parse(xhr.response);
                if(data.success===true){
                    viewIndex();
                }
            }

        });

    }
}

function createUser(){
    var app = document.getElementById('app');
    app.innerHTML = `<h2>Create a New User</h2>
    <form id="createUser" action="/api/users" method="post">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
        </div>

        <div>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name">
        </div>

        <div>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name">
        </div>

        <input type="submit" value="Submit">
    </form>`;

    var createUser = document.getElementById('createUser');
    createUser.addEventListener('submit', function(e){
        e.preventDefault();

        var formData = new FormData(createUser);
        var url = 'http://localhost:3000/api/users';
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url);

        xhr.setRequestHeader(
            'Content-Type',
            'application/json; charset=UTF-8'
        );

        var object = {};
        formData.forEach(function(value, key){
            object[key]=value;
        });

        xhr.send(JSON.stringify(object));
        xhr.onload = function(){
            let data = JSON.parse(xhr.response);
            if(data.success===true){
                viewIndex();
            }
        }
    });
}

function deleteUser(id){
    if(confirm('Are you sure?')){
        
        var url = 'http://localhost:3000/api/users/' + id;

        var xhr = new XMLHttpRequest();
        xhr.open('DELETE', url);
        xhr.send();
    
        xhr.onload = function(){
            let data = JSON.parse(xhr.response);
            if(data.success===true){
                viewIndex();
            }
        }
    }
}

var hash = window.location.hash.substr(1);
if(hash){
    let chunks = hash.split('-');

    switch(chunks[0]){

        case 'edit':
            viewUser(chunks[1]);
        break;

        case 'createUser':
            createUser();
        break;

        default:
            viewIndex();
        break;
        
    }
}else{
    viewIndex();
}
```




## Lab

1. Create an articles model
    1. The schema MUST contain the following fields
        * title - String
        * slug - String 
        * keywords - String
        * description - String
        * body - String
        * published - Date
        * created - Date 
        * modified - Date
    1. Created and modified dates MUST default to to now
    1. Published date MUST be required
    1. Published date SHOULD default to now
    1. The modeified datae MUST autoset on on update (pre save)
    1.The slug MUST autoset from the title (pre validation)
1. Create a full CRUD REST API for articles


### Walkthrough

#### Create a New Feature Branch

A feature branch gives us a place to develop a new feature. Here, we can commit changes specific to a given feature. Once that feature is complete we can merge our changes into the master branch.

```sh
git checkout -B articles
```

[</>code](https://github.com/microtrain/mean1.example.com/commit/2221d9e27307816a0e5ffd82c1f6f06d92ca8b4f) Create the Arcitle Model 

[</>code](https://github.com/microtrain/mean1.example.com/commit/a10eae84f3e5af72f78417e6473a258df0607072) Auto gen a slug prior to validation

[</>code](https://github.com/microtrain/mean1.example.com/commit/7bfb625f644754f222263950af1ded317a6b908d) Add routes

## UI

1. Build a CMS
    * Build a JS app that allows us to work with the API.
    * Build a static view page that is not Ajax.
1. Add an additional Passport strategy of your choosing (GitHub, Facebook, Twitter, etc)
1. Add the ability to reset passwords
1. Create a SPA (single page application) called auth, this will provide
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
* [NodeJS Security Checklist](https://blog.risingstack.com/node-js-security-checklist/)

[Next: Reverse Proxy](03-ReverseProxy.md)
