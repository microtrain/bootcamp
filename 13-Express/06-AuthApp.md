# Authentication App

In this lesson we will build a JavaScript application that works with our REST API. In order to access this application we will need to provide a non-API endpoint, that is to a say a traditional webpage that will allow us to load the application. One of the keys to this chapter will be the ability to differentiate between front end JavaScript and back end JavaScript. Until now, everything we have done in Express has been back end JavaScript. 

## Non API Endpoint
[</> code](https://github.com/microtrain/mean.example.com/commit/73c9706453a0b5df15c34c2f7dfa174b09d3686f) Add a non-API endpoint for accessing the authentication app. This will be a new file called *auth.js* and will be placed directly under the *routes* directory. Where this endpoint differs from our API endpoints is in what the endpoint returns. Previously we returned a JSON string ```res.json()``` this time we will render a view ```res.render()```.

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

[</> code](https://github.com/microtrain/mean.example.com/commit/39364af9ef5f989b882dbeed2e9a09c41a5aae4e) We will start by loading a closure into a variable called ```authApp```. Then we will add a method to create a form, load that form into to the view and update the styles. 

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
          <div id="formMsg" class="alert alert-danger text-center">Invalid username or password</div>
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
          <div id="formMsg" class="alert alert-danger text-center">Invalid username or password</div>
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

[</> code](https://github.com/microtrain/mean.example.com/commit/3e2c8a4516b90b46fec1acf55e029819779c8c16) Add responsive styles.

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

[</> code](https://github.com/microtrain/mean.example.com/commit/79d758ed6c8e868dc30e05cfc4bd480d115513eb) Add an XHR post request method

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
# Add an XHR post request method
git commit -a
```

[</> code](https://github.com/microtrain/mean.example.com/commit/32dc98ab94ef82008516280f436ec61230e8bf80) Add error/success handling to the login form. 

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
# Add error/success handling to the login form
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

[</> code](https://github.com/microtrain/mean.example.com/commit/d296184a6157b59865eecd1ceb3d13207c56f781) Implement logout methods

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
router.delete('/logout', function(req, res){
  req.logout();
  if(!req.session.passport.user){
    return res.json({success: 'true'});
  }else{
    return res.json({success: 'false'});
  }
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
# Add logout methods
git commit -a
git push origin master
```

## Implement a GUI for User Registration

In the last lesson we created a user by making a curl request to an API. The login for we just created allows us to login with that user. Now we will build a form to allow for user registration using our app. Start by removing the call to ```loginForm()``` at the end of the file and replace it with the a new method called ```registrationForm()```. We will then call the ```registrationForm()``` method.

### Create the Registration Form
[</> code](https://github.com/microtrain/mean.example.com/commit/c9ce0a1d30091ccf04ed4f5f25c7b0a6e8aa3856) We will create this the same way we created the login form. The main difference will be the field names and the addition of [HTML5 validation](https://developer.mozilla.org/en-US/docs/Learn/HTML/Forms/Form_validation).

*src/js/app.auth.js*
```js
//~line 29
  function registrationForm(){
    var app = document.getElementById('app');

    var form =  `

        <div class="card login-form">
          <form id="registrationForm" class="card-body">
            <h1 class="card-title text-center">Create an Account</h1>
            <div id="formMsg" class="alert alert-danger text-center">Your form has errors</div>

            <div class="form-group">
              <label for="first_name">First Name</label>
              <input type="text" id="first_name" name="first_name" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" id="last_name" name="last_name" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>

            <div>
              <input type="submit" value="Sign In" class="btn btn-lg btn-primary btn-block">
            </div>
          </form>
        </div>
    `;

    app.innerHTML=form;
  }
```

Change the load method load the registration form.
```js
  return {
    load: function(){
      registrationForm();
      postRequest('registrationForm', '/api/auth/register');
    }
  }
```
At this point navigating to [http://localhost:3000/auth](http://localhost:3000/auth) will load the registration form.

Commit your code changes
```sh
# Add a registration form
git commit -a
```

### Extending HTML5 Validation

We can invoke [HTML5 validation](https://developer.mozilla.org/en-US/docs/Learn/HTML/Forms/Form_validation) by adding the required attribute. HTML provides front end validation, front end validation meaning a savvy user can shut it off. It should be used with, not in lieu of back end validation. Front end has the advantage of not requiring a full form submission and when done well can create a better user experience. For the sake of this lesson we will only focus on front end validation.

The addition of the ```required``` attribute will at the very least force a non-empty field. When applied to an input field of a specific type such as ```type="email"``` it would require the data to be of the correct type. You can use JavaScript to override HTML's default validation rules and customize front end validation to your needs. 

[</> code](https://github.com/microtrain/mean.example.com/commit/c47c8e3734129da3e48fc81fe08d2492815fcf4a) Create a validation object and bind it the click event of the submit button. This will trigger custom validation just before the submit event fires thus blocking the submit if any of the fields fail validation. 

```js
// ~line 121
var validate = (function() {

  function confirmPasswordMatch() {

    let pw = document.getElementById('password');
    let cpw = document.getElementById('confirm_password');

    if(pw.value !== cpw.value){
      cpw.setCustomValidity("Passwords do not match");
    } else {
      cpw.setCustomValidity("");
    }

  }

  return {
    registrationForm: function(){
      document.querySelector('#registrationForm input[type="submit"]').addEventListener(
        'click',
        function(){
        confirmPasswordMatch();
      });
    }
  }

})();

// ~line 115
validate.registrationForm();
```

Commit your code changes
```sh
# Add custom HTML5 validation
git commit -a
```

## Navigate Your App Using the Hash Tag
[</> code](https://github.com/microtrain/mean.example.com/commit/2505d52039e272d06a29ad58a4f4d7bc09d1bd38)

*auth.app.js*
```js
//~line 111
return {
  load: function(){

    switch(window.location.hash){
      case '#register':
        registrationForm();
        postRequest('registrationForm', '/api/auth/register');
        validate.registrationForm();
        break;

      default:
        loginForm();
        postRequest('loginForm', '/api/auth/login');
        break;
    }

  }
}

//~line 159
authApp.load();

window.addEventListener("hashchange", function(){
  authApp.load();
});
```

Commit your code changes
```sh
# Add location.hash detection for app navigation
git commit -a
```

## Working with Session Data

Now that we can create a proper and login to the system, creating a user session; we will want to work with the session data.

[</> code](https://github.com/microtrain/mean.example.com/commit/ba9906db766cb5e6d0d6b04eac548918a9121d77) Use Express middleware to expose session data to the views. This exposes the the session data to the view through a variable called ```session```.

*app.js*
```js
//~line 73
app.use(function(req,res,next){
  res.locals.session = req.session;
  next();
});
```

Commit your code changes
```sh
# Expose session data to the views
git commit -a
```

### Controlling the UI with Session Data

[</> code](https://github.com/microtrain/mean.example.com/commit/eb72758f6bb9189dd3f45e5c7a4aa8499679a464) The session contains a passport object which is empty prior to session instantiation. Upon instantiation, a user object is added to the passport object. We can use the presence of the user object or lack there of to determine which links to turn on or off in the navigation. If we detect a session we can hide the login and register links and show the logout link. We can reverse this when we no longer detect the session.

*views/includes/navbar.pug*
```js
//~line 23
if !session.passport.user
  li.nav-item
    a.nav-link(href='/auth#register') Register
  li.nav-item
    a.nav-link(href='/auth#login') Login
else
  li.nav-item
    a.nav-link(href='/auth/logout') Logout
```

Commit your code changes
```sh
# Show/Hide links based on session data
git commit -a
```

### Authenticated Whitelist
By default all endpoints are publicly accessible. Some endpoints should only be accessible by authenticated users. There are several ways to do this, I prefer the whitelist approach. This means unauthenticated access is denied to all endpoints by default; unauthenticated access is granted as needed.

[</> code](https://github.com/microtrain/mean.example.com/commit/ac8b8657e3fe7907eaf69c89c088436781a6d112) Deny unauthenticated access to all end points by default. Create a whitelist that will allow unauthenticated access to specific endpoints.

```js
//~line 78
//Session based access control
app.use(function(req,res,next){
  //Uncomment the following line to allow access to everything.
  //return next();

  //Allow any endpoint that is an exact match. The server does not
  //have access to the hash so /auth and /auth#xxx would bot be considered 
  //exact matches.
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
    '/api/auth/'
  ];

  //The query string provides a partial URL match beginning
  //at position 0. Both /api/auth/login and /api/auth/logout would would 
  //be considered a match for /api/auth/
  for(var sub of subs){
    if(req.url.substring(0, sub.length)===sub){
      return next();
    }
  }

  //There is an active user session, allow access to all endpoints.
  if(req.isAuthenticated()){
    return next();
  }

  //There is no session nor are there any whitelist matches. Deny access and
  //redirect the user to the login screen.
  return res.redirect('/auth#login');
});
```

Test by navigation to [http://localhost:3000/api/users](http://localhost:3000/api/users) while logged out of the system and again while logged into the system.

Commit your code changes
```sh
# Whitelist endpoints that do not require authentication
git commit -a
```
