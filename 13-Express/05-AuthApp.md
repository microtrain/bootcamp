# Authentication App

In this chapter we will build a JavaScript application that works with our REST API. In order to access this application we will need to provide a non-API or that is to a say a traditional webpage that will allow us to load the application. One of the keys to this chapter will be the ability to differentiate between front end JavaScript and back end JavaScript. Until now, everything we have done in Express has been back end JavaScript. 

[</> code](https://github.com/microtrain/mean.example.com/commit/7425d097bbadb973bbb240821e6f93040c3e34e8) Add a non-API end point for accessing the authentication app. 

We will start by creating a creating the frontend JavaScript file. For this we will create the path *public/dist/js/app.auth.js*. In Express, all front end assets are stored the *public* directory and accessed via URL. In this case [http://localhost:3000/dist/js/app.auth.js](http://localhost:3000/dist/js/app.auth.js) would serve the *app.auth.js* file. Normally we would build all of our JavaScript using a Gulp process but I don't want that to get in the way so we will integrate Gulp at the end of this chapter and build with it in later lessons. For now we just need to understand that dist is the directory to where all Gulped files will be written. We will add a simple alert as a test.

*public/dist/js/app.auth.js*
```js
alert('hi');
```

The second thing we add will be the auth endpoint. This will a new file called *auth.js* and will be placed directly under the *routes* directory.

*routes/auth.js*
```js
var express = require('express');
var router = express.Router();

router.get('/', function(req, res, next) {
  res.render('auth/index', { title: 'User Authentication' });
});

module.exports = router;
```

The third thing will be the view for the auth endpoint. By default, all views are expected to by in the *views*  directory. The keep things organized each routing file will have it's own view folder.

*views/auth/index.pug*
```pug
extends ../layout

block content

  div#app

  script(src='/dist/js/auth.app.js')
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

Open a browser and navigate to [http://localhost:3000/auth](http://localhost:3000/auth). If you see an alert dialog that says "hi" then everything is working as it should. Open the file *public/dist/js/app.auth.js* and remove the alert. Commit your changes and push to master.

```sh
# Add a non-API end point for accessing the authentication app
git status
git add .
git commit -a
git push origin master
```


## AJAX
[</> code](https://github.com/microtrain/mean.example.com/commit/42bcba5f714773b0c0dd80434cdaad835e23670a) Add a method to load the login form. Create a method called viewLoginForm. This method will load a login form into the view.

```js
function loadLoginForm(){
  var app = document.getElementById('app');

  var form =  `
    <form id="logInForm">
      <div id="errorMessage">Invalid username or password</div>
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

loadLoginForm();
```

Commit your code changes
```sh
# Add a method to load the login form
git commit -a
```

[</> code](https://github.com/microtrain/mean.example.com/commit/606bbe63212ba1d19414e0cdb57ffa0183ef4549) Add styles for the login form
```css
/*~line 9 */
/** LOGIN FORM **/
#logInForm {
  width: 600px;
  max-width: 100%;
  margin: 0 auto;
  padding: 1rem;
  background: #ededed;
  border-radius: 6px;
  border: 1px solid #ccc;
}

#logInForm #errorMessage {
  display:  none;
  color: #990000;
  padding: .5rem .4rem;
  margin: .5rem 0;
  border: 1px solid #990000;
  text-align: center;
  border-radius: 6px;
  background: #fff;
}

#logInForm input{
  margin-bottom: 1rem;
  border-radius: 6px;
  border: 1px solid #ccc;
}

#logInForm label,
#logInForm input[type="text"],
#logInForm input[type="password"] {
  box-sizing: border-box;
  display: block;
  width: 100%;
  font-size: 1.3rem;
  padding: .5rem .4rem;
}

#logInForm input[type="submit"] {
  font-size: 1.1rem;
  padding: .8rem .6rem .6rem;
  background: #fff;
}
```

Commit your code changes
```sh
# Add styles for the login form
git commit -a
```

[</> code](https://github.com/microtrain/mean.example.com/commit/306f79b19dc0885953ef8e1e16af8e51d251eec7) Add an AJAX submit to the login form
```js
  //~line 22
  var logInForm = document.getElementById('logInForm');
  logInForm.addEventListener('submit', function(e){
    e.preventDefault();

    var formData = new FormData(logInForm);
    var url = 'http://localhost:3000/api/auth/login';
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
      console.log(data);
    }
  });
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
  //~line 45
  if(data.success===true){
    window.location.href = '/';
  }else{
    document.getElementById('errorMessage').style.display='block';
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
app.get('/logout', function(req, res){
  req.logout();
  res.redirect('/auth');
});
```



### Authenticated Whitelist

```js
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

  return res.redirect('/auth');
});
```
