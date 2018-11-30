# Authentication App

In this lesson we will build a JavaScript application that works with our REST API. In order to access this application we will need to provide a non-API endpoint, that is to a say a traditional webpage that will allow us to load the application. One of the keys to this chapter will be the ability to differentiate between front end JavaScript and back end JavaScript. Until now, everything we have done in Express has been back end JavaScript. 

## Non API Endpoint
[</> code](https://github.com/microtrain/mean.example.com/commit/Add a non-API end point for accessing the authentication app) Add a non-API endpoint for accessing the authentication app. This will be a new file called *auth.js* and will be placed directly under the *routes* directory. Where this endpoint differs from our API endpoints is in what the endpoint returns. Previously we returned a JSON string ```res.json()``` this time we will render a view ```res.render()```.

*routes/auth.js*
```js
var express = require('express');
var router = express.Router();

router.get('/', function(req, res, next) {
  res.render('auth/index', { title: 'User Authentication' });
});

module.exports = router;
```

Next, we will create a view for the auth endpoint. By default, all views are expected to be in the *views* directory. To keep things organized each routing file will have it's own view directory. Our view will extend the layout, call content from the view file, provide a div into which we will load our JavaScript application, and call the app into the script tag.

*views/auth/index.pug*
```pug
extends ../layout

block content

  div#app

  script(src='/dist/js/auth.app.min.js')
```

Finally, we will add our new route to app.js.
*app.js*
```js
//~line 14
var authRouter = require('./routes/auth');

//~line 74
app.use('/auth', authRouter);
```

```sh
cd ~/mean.example.com
# press [ctl]+[c]
npm start
```

Open a browser and navigate to [http://localhost:3000/auth](http://localhost:3000/auth). If the tab reads "User Authentication" then everything is working as it should. Commit your changes and push to master.

![User Authentication](/img/auth/title.png)

```sh
# Add a non-API end point for accessing the authentication app
git status
git add .
git commit -a
git push origin master
```

## Login Form

[</> code](https://github.com/microtrain/mean.example.com/commit/703d65db611b6b63880a1e4fefddff84ee211c30) We will start by loading a closure into a variable called ```authApp```. Then we will add a method to create a form, load that form into to the view and update the styles. 

Before we start writing code we will run ```gulp watch``` this will automatically compile all changes made to source code into distribution code.

> I would typically run this from the terminal in my IDE. This allows me to watch the Gulp process while I writing code.
```sh
cd ~/mean.example.com
gulp watch
```

Create a closure
*src/js/auth.app.js*
```js
var authApp = (function() {

})();
```

Add a ```loginForm()``` method to the closure.
*src/js/auth.app.js*
```js
var authApp = (function() {

  function loginForm(){
    let app = document.getElementById('app');

    let form =  `
      <div class="card login-form">
        <form id="loginForm" class="card-body">
          <h1 class="card-title text-center">Please Sign In</h1>
          <div class="alert alert-danger text-center">Invalid username or password</div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
          </div>
          <div>
            <input type="submit" value="Sign In" class="btn btn-lg btn-primary btn-block">
          </div>
        </form>
      </div>
    `;

    app.innerHTML=form;
  }

})();
```

Add a return statement to your closure. This statement will return a JSON object that is accessible outside of the closure and will have access to everything that is outside of the return statement. In other words we have public access to the JSON object and the JSON object has private access the rest of the closure. Calling ```authApp.load();``` from outside the closure will execute the ```loginForm()``` logic.

Emulate private and public properties and load the login form.
*src/js/auth.app.js*
```js
var authApp = (function() {

  function loginForm(){
    let app = document.getElementById('app');

    let form =  `
      <div class="card login-form">
        <form id="loginForm" class="card-body">
          <h1 class="card-title text-center">Please Sign In</h1>
          <div class="alert alert-danger text-center">Invalid username or password</div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
          </div>
          <div>
            <input type="submit" value="Sign In" class="btn btn-lg btn-primary btn-block">
          </div>
        </form>
      </div>
    `;

    app.innerHTML=form;
  }

  return {
    load: function(){
      loginForm();
    }
  }

})();

authApp.load();
```

With dev tool [f12] open hold down the refresh button and choose "Empty Cache and Hard Reload" from the subtext menu.

![Empty Cache and Hard Reload](/img/empty_cache.png)

If you see a login form all is working as it should, commit your code changes, commit your code changes.
```sh
# Add a method to load the login form
git commit -a
```

### Responsive Form

Add this point the form is using bootstraps default block level styles and the error message displays by default. If we add a few lines of SASS we can contain this to something that looks reasonable on a desktop or large device while maintaining it's block level style on a smaller device.

[</> code](https://github.com/microtrain/mean.example.com/commit/4b09db7d805fb7f6c9820750043a15a86da847de) Add responsive styles.

*src/scss/forms.scss*
```scss
.login-form {
  width: 100%;
  max-width: 360px;
  margin: 2rem auto 0;
}

#formMsg {
  display: none;
}
```

Commit your code changes
```sh
# Add responsive styles to the login form
git commit -a
```

## XHR Request (AKA AJAX)

We will write a method that allows us to make a post request via AJAX. We will generalize this method so that we use it to post multiple forms.

[</> code](https://github.com/microtrain/mean.example.com/commit/xxx) Add an XHR post request

```js
//~line 29
function postRequest(formId, url){
  let form = document.getElementById(formId);
  form.addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData(form);
    let uri = `${window.location.origin}${url}`;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', uri);

    xhr.setRequestHeader(
      'Content-Type',
      'application/json; charset=UTF-8'
    );

    let object = {};
    formData.forEach(function(value, key){
      object[key]=value;
    });

    xhr.send(JSON.stringify(object));
    xhr.onload = function(){
      let data = JSON.parse(xhr.response);
      console.log(data);
    }
  });
}

//~line 60
postRequest('loginForm', '/api/auth/login');
```

Use developer tools to test the submit logic. 
* The JavaScript console will show you the resulting json strings
![terminal view](/img/auth/auth_response.png)
* The networking panel will allow you to inspect various states of the response and request.
![terminal view](/img/auth/network.png)
* The application tab will show you the session cookie.
![terminal view](/img/auth/application.png)

Commit your code changes
```sh
# Add styles for the login form
git commit -a
```

[</> code](https://github.com/microtrain/mean.example.com/commit/5571dc3b5ebe2afa29931f55e67b4be045eecaac) Add error/success handling to the login form. 

* If the submit returns a success message redirect the user to the homepage. 
* If the submit returns an error message display an error message on the screen.

```js
  //~line 52
  if(data.success===true){
    window.location.href = '/';
  }else{
    document.getElementById('formMsg').style.display='block';
  }
```

Commit your code changes and push to master
```sh
# Add styles for the login form
git commit -a
git push origin master
```

Now that we can authenticate the user a create a session cookie the browser, lets test the session. By adding a ```console.log()``` to the index method we can verify the session survives a reload. Update the ```/``` endpoint as stated in the following code sample.

*routes/index.js*
```js
router.get('/', function(req, res, next) {
  console.log(req.session);
  res.render('index', { title: 'Express' });
});
```

Now, navigate to the login page [http://localhost:3000/auth](http://localhost:3000/auth) and login. A successful login will redirect you to the home page. Check the terminal window in which the Express server is running and look for the passport object.

![terminal view](/img/auth/passport.png)

Since that was just a test, we can stash our changes and finish implementing the logout logic.

[</> code](https://github.com/microtrain/mean.example.com/commit/ba7c0673d02a1d0b6dcb42d77f2d261fc300b4f0) Implement logout methods

You can use the following to get a feel for what's going on inside the logout method
```js
router.get('/logout', function(req, res){
  console.log(req.session);
  req.logout();
  console.log(req.session);
});
```

We can determine success by testing for a user object inside the passport object. If this no longer exists the logout was successful.

*routes/api/auth.js*
```js
//~line 60
router.get('/logout', function(req, res){
  req.logout();
  if(req.session.passport.user){
    return res.json({success: 'false'});
  }
  return res.json({success: 'true'});
});
```

The session is site wide and can accessed utilized outside of any JavaScript applications. For this reason it would make sense to provide a non-API endpoint for logging out of a session as well.

*routes/auth.js*
```js
//~line 7
router.get('/logout', function(req, res){
  req.logout();
  res.redirect('/auth');
});
```

Commit your code changes and push to master
```sh
# Implement logout methods
git commit -a
git push origin master
```

## Implement a GUI for User Registration

In the last lesson we created a user by making a curl request to an API. The login for we just created allows us to login with that user. Now we will build a form to allow for user registration using our app. Start by removing the call to ```loginForm()``` at the end of the file and replace it with the a new method called ```registrationForm()```. We will then call the ```registrationForm()``` method.
### Create the Registration Form
We will create this the same way we created the login form. The main difference will be the field names.

*publid/dist/js/app.auth.js*
```js
//~line 29
function registrationForm(){
  var app = document.getElementById('app');

  var form =  `
    <form id="registerForm" class="form-auth-app">
      <div id="formMsg" class="error-message">Please correct the errors below</div>
      <div>
        <label for="first_name".First name</label>
        <input type="text" id="first_name" name="first_name">
      </div>
      <div>
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name">
      </div>
      <div>
        <label for="email">Email</label>
        <input type="text" id="email" name="email">
      </div>
      <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username">
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
      </div>
      <div>
        <input type="submit" value="Sign In">
      </div>
    </form>
  `;

  app.innerHTML=form;
}
```

Change the load method load the registration form.
```js
  return {
    load: function(){
      registrationForm();
    }
  }
```
At this point navigating to [http://localhost:3000/auth](http://localhost:3000/auth) will load the registration form.

Commit your code changes
```sh
# Add a registration form
git commit -a
```

## Navigate Your App Using Hash Tags
We will navigate the app by listening for a change in the hash tag. This will determine which form to load and which parameters we will load into the ```postRequest(formId, url)``` method. 

```js
//~line 98
return {
  load: function(){
    switch(window.location.hash){
      case '#register':
        registrationForm();
        postRequest('registrationForm', '/api/auth/register');
        break;

      default:
        loginForm();
        postRequest('loginForm', '/api/auth/login');
        break;
    }
  }
}

//~line 115
authApp.load();

window.addEventListener("hashchange", function(){
  authApp.load();
});
```

## Working with Session Data

Use Express middleware to expose session data to the views. This exposes the the session data to the view through a variable called ```session```.

*app.js*
```js
//~line 73
app.use(function(req,res,next){
  res.locals.session = req.session;
  next();
});
```

### Controlling Navigation
The session contains a passport object which is empty prior to session instantiation. Upon instantiation a user object is added to the passport object. We can use the presence of the user object or lack there of to determine which links to turn on or off in the navigation. If we detect a session we can hide the login and register links and show the logout link. We can reverse this when we no longer detect the session.

*views/layout.pug*
```js
//~line 36
if !session.passport.user
  li.nav-item
    a.nav-link(href='/auth#register') Register
  li.nav-item
    a.nav-link(href='/auth#login') Login
else
  li.nav-item
    a.nav-link(href='/auth/logout') Logout
```

### Authenticated Whitelist
By default all endpoints are publicly accessible. Some endpoints should only be accessible by authenticated users. There are several ways to do this, I prefer the whitelist approach. This means unauthenticated access is denied to all endpoints by default; unauthenticated access is granted as needed.

```js
//~line 78
//Session based access control
app.use(function(req,res,next){
  //return next();

  var whitelist = [
    '/',
    '/auth'
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

  return res.redirect('/auth#login');
});
```
