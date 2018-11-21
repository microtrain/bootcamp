# Authentication API
In the previous section we created a REST API that performs CRUD operations against a users API. In this section we will build an API that that will allow for user authentication and session creation.

## User Authentication with Passport
We will use [express-session](https://www.npmjs.com/package/express-session) as our session manager and store our session data in our mongo database using [connect-mongo](https://www.npmjs.com/package/connect-mongo). We will use a combonation of [Passport](http://www.passportjs.org/) modules to manage authentication.

### Passport Local Strategy
[</> code](https://github.com/microtrain/mean.example.com/commit/5b9cdccf310b15c295ac5d864110903de0d1fd1a) Install all the packages needed for building a passport session and storing it in the database. The commit points to the package.json files, you can install these pacakges using the following npm commands or you can update your package.json file from the repo and run a single ```npm install```.

```sh
npm install passport
npm install passport-local
npm install passport-local-mongoose
npm install express-session
npm install connect-mongo
```

Commit your changes and push to master
```sh
# Added authentication packages
git status
git add .
git commit -a
git push origin master
```
Commit your changes and push to master

[</> code](https://github.com/microtrain/mean.example.com/commit/c6625250735e6ad3cb2dfa00a92afa8928593f3d) Import session and Passport packages.

*app.js*
```js
//~line 7 after mongoose
var session = require('express-session');
var MongoStore = require('connect-mongo')(session);
var passport = require('passport');
```
Commit your changes
```sh
# Import session and passport packages
git commit -a
```

[</> code](https://github.com/microtrain/mean.example.com/commit/89ec8019f911a7e02729b3c5c309bd204ae9495a) Add configuration objects for sessions and cookies
*config.dev.js*
```js
//Session configuration object
config.session = {};

//Cookie configuration object
config.cookie = {};

//Create a random string to sign the session data
//Bigger is better, more entropy is better
//The is OK for dev, change for production
config.session.secret = '7j&1tH!cr4F*1U';

//Define the domain for which this cookie is to be set
config.cookie.domain = 'localhost';
```

Commit your changes
```sh
# Configure session and cookie data
git commit -a
```

[</code>](https://github.com/microtrain/mean.example.com/commit/eb9896604ca174513fe262ef92dea4db8626ff84) Configure and initialize the [express session](https://github.com/expressjs/session)
```js
//~line 32 before routes
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
    maxAge:3600000 //1 hour
  }
}));
app.use(passport.initialize());
app.use(passport.session());
```

Commit your changes
```sh
# Configure and initialize the express session
git commit -a
```

[</> code](https://github.com/microtrain/mean.example.com/commit/0a65cf01f3438ddeb23e78f13c772de5d7f55780) Serialize the session data
```js
//~line 53
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

Commit your changes
```sh
# Serialize the session data
git commit -a
git push origin master
```

#### User Registration

##### Passport Local Mongooose

[</> code](https://github.com/microtrain/mean.example.com/commit/63fb2211d8b8aaea883e3462a361f3fddca8f64b) Update the user model to require hash and salt as strings.

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

Commit your changes
```sh
# Add authentication fields to the users model
git commit -a
```

[</> code](https://github.com/microtrain/mean.example.com/commit/5af15521dd1cae39926d0ea61e85de7a839e395f) Add passport-local-mongoose

*models/users.js*
```js
//~line 4
var passportLocalMongoose = require('passport-local-mongoose'); 

...
//~line 55
User.plugin(passportLocalMongoose);
```

Commit your changes
```sh
# Add Passport to the users model
git commit -a
```

[</>code](https://github.com/microtrain/mean1.example.com/commit/28c347207038ac9bb5e853753cbe8a25a40f81dd) Require and use Passport Local Strategy as defined in the user model

*app.js*
```js
//~line 10
var LocalStrategy = require('passport-local').Strategy;

//~line 12
var User = require('./models/user');

...
//~line 55
passport.use(User.createStrategy());
```

Commit your changes
```sh
# Define a local strategy for authentication
git commit -a
git push origin master
```

##### Post the Registration Form to the Users API
[</> code](https://github.com/microtrain/mean.example.com/commit/ef260abec56a72e219d3d8fdceb9eb60f384ba1) Add a registration end point the the users API. */users/register* is a GET request that will load a registration form. */api/users/register* is a POST request that creates a user record complete with salt and has values. For now, registartion will end with duping a JSON string onto the screen. Later we can convert this to an AJAX application.

Create the file *routes/api/auth* and add the following content

```js
//Register a new user
var express = require('express');
var router = express.Router();
var Users = require('../../models/users');

router.post('/register', function(req,res,next){
  var data = req.body;

  Users.register(new Users({
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

module.exports = router;
```

Once you have created the file you'll need to wire it up to *app.js*.

```js
//~line 16
var apiAuthRouter = require('./routes/api/auth');

//~line 74
app.use('/api/auth', apiAuthRouter);
```

Test with a curl command
```sh
curl -d '{"email":"test5@example.com", "username":"testuser3", "first_name": "Bob", "last_name": "smith", "password":"test123"}' -H "Content-Type: application/json" -X POST http://localhost:3000/api/auth/register
```

Commit your changes
```sh
# Add an endpoint for user registration
git commit -a
git push origin master
```

#### User Login/Logout

[</> code](https://github.com/microtrain/mean1.example.com/commit/9330c1d01aa872e7adc9d8aebb7494d4ed7954fc) Create a GET and POST end points for login

*routes/api/auth.js*
For a traditional web application Passport would allow you to create a login with just a few lines of code. Since we are building a REST API we need to crack open the black box and manage error handling on our own. Fortunately Passport exposes many of it's internals to the outside world making this a simple task. See the [Passport Documentation](http://www.passportjs.org/docs/authenticate/) for more details.

*Black box implementation*, this works by injecting the ```passport.authenticate()``` middleware into method signature. The downside to this is either you're logged in or your not. You use redirects to convey the authentication state.
```js
router.post('/login', passport.authenticate('local'), function(req, res){
  res.redirect('/users');
});
```

*API implementation*, this works by using the ```passport.authenticate()``` middleware as a callback function. At this point you have access to errors and additional information that you can use to halt execution and return a JSON string denoting an error. At this point the black box functionality has been removed and you'll need to manually invoke the session. You can do this by accessing ```req.logIn()``` which will either return an error or create a session. Since we are testing with curl, with curl we do not have access to the browsers session cookie meaning the session sill not persist beyond the server request that created it. To test session creation we will ```console.log()``` the ```req.session``` variable. A successful login will create a session and return a JSON string with an error message and unsuccessful login will return an JSON string with ae error message. 
```js
//~line 37
router.post('/login', function(req, res, next) {
  //
  passport.authenticate('local', function(err, user, info) {

    if (err) { 
      return res.json({success:false, error: err});
    }

    if (!user) {
      return res.json({success:false, error: info.message });
    }

    req.logIn(user, function(err) {

      if (err) { 
        return res.json({success:false, error: err });
      }

      //we will use a console.log() to test the session data
      console.log(req.session);

      return res.json({success:true, user: user });

    });
  })(req, res, next);
});
```

Test with a curl command
```sh
curl -d '{"username":"testuser3", "password":"test123"}' -H "Content-Type: application/json" -X POST http://localhost:3000/api/auth/login
```

Commit your changes
```sh
# Add an endpoint for user authentication
git commit -a
git push origin master
```



router.get('/logout', function(req, res){
  req.logout();
});




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
