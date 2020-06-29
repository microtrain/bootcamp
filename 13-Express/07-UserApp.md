# User App

In this lesson, we will build a JavaScript application (or a GUI) for managing users. For this app will:

* Build a users view.
* Provide a basic navigation structure.
* Build a form to create a user.
* Create a common method for processing web forms
* Build a view for a single user.
* Build a form to edit a user.
* Build a view for deleting a user.

## Prep

As with the authentication application, we will need to do a little bit of prep before we build the app. We will need to add a non-API endpoint, update our Gulp process, and stub out (create a placeholder) for our users application.

### Non-API Endpoint

[</> code](https://github.com/microtrain/mean.example.com/commit/b5f04e21759f8e54ac72714d260a09d4bd8fab0b) Add a non-API endpoint for accessing the user app

*routes/users.js*
```js
var express = require('express');
var router = express.Router();

router.get('/app', function(req, res, next) {
  res.render('users/app', { title: 'User Management' });
});

module.exports = router;
```

*views/users/app.pug*
```pug
extends ../layout

block content

  h1 User Management

  div#app

  script(src='/dist/js/users.app.min.js')
```

```sh
cd ~/mean.example.com
# press [ctl]+[c]
npm start
```
Open a browser and navigate to [http://localhost:3000/users/app](http://localhost:3000/users/app). If the tab reads "User Management" then everything is working as it should. Commit your changes and push to master.

```sh
# Add a non-API endpoint for accessing the user app
git status
git add .
git commit -a
git push origin master
```

### Update Our Gulp Process

[</> code](https://github.com/microtrain/mean.example.com/commit/59e994b48197400bf81f18f993ffd83eef158be1) Add a gulp process for the user app

*.gulpfile.js*
```js

//~line 49
gulp.task('build-users-js', function() {

  var userApp = gulp.src([
    'src/js/users.app.js',
  ])
  .pipe(concat('users.app.min.js'))
  .pipe(uglify())
  .pipe(gulp.dest('public/dist/js'));

  return merge(userApp);
});

//~line 76
//Compile all JS tasks
gulp.task('build-js', [
  'build-main-js',
  'build-auth-js',
  'build-users-js'
]);

```

Commit your code changes
```sh
# Add gulp processes for the user app
git commit -a
```

### Stub the Users App

[</> code](https://github.com/microtrain/mean.example.com/commit/18dfec2752ddcc9405e1d31fe664f08d1545d588) Stub out the user app.
*src/js/users.app.js*
```js
var usersApp = (function() {

  return {
    load: function(){
      alert('LOADED');
    }
  }

})();

usersApp.load();
```

Rebuild the Js files
```js
gulp build-js
```

Navigate to [http://localhost:3000/users/app](http://localhost:3000/users/app), if you see a dialog that says "LOADED" everything is working as expected. 

Commit your code changes
```sh
# Stub out the user app
git status
git add .
git commit -a
git push origin master
```

## Build a Users View

We will start by pulling a list of users from the API. Once we have that list we can use it to build a view.

### Pull a List of Users From the API

[</> code](https://github.com/microtrain/mean.example.com/commit/5974d5459407b2bd3165b47a47d7f97c4dab1ac8) Pull a list of users from the API.

*src/js/users.app.js*
```js
function viewUsers(){

  let uri = `${window.location.origin}/api/users`;
  let xhr = new XMLHttpRequest();
  xhr.open('GET', uri);

  xhr.setRequestHeader(
    'Content-Type',
    'application/json; charset=UTF-8'
  );

  xhr.send();

  xhr.onload = function(){
    let data = JSON.parse(xhr.response);
    console.log(data);
  }
}
```

If the AJAX request returns a success string similar to the following, everything is working as it should.
```json
{success: true, users: Array(9)}
```

```sh
# Pull a list of users from the API
git status
git add .
git commit -a
git push origin master
```

### Build an HTML View

[</> code](https://github.com/microtrain/mean.example.com/commit/79217972455750434d9295377c94a86cae094427) Display the users in an HTML table.

*src/js/users.app.js*
```js
//~line 16
xhr.onload = function(){
  let app = document.getElementById('app');
  let data = JSON.parse(xhr.response);
  let users = data.users;
  let table = '';
  let rows = '';

  //Loop each user record into it's own HTML table row, each user should
  //have a link a user view
  for (let i=0; i<users.length; i++) {
    rows = rows + `<tr>
      <td>
        <a href="#view-${users[i]['_id']}">${users[i]['last_name']}, ${users[i]['first_name']}</a>
      </td>
      <td>${users[i]['username']}</td>
      <td>${users[i]['email']}</td>
    </tr>`;
  }

  //Create a users panel, add a table to the panel, inject the rows into the
  //table
  table = `<div class="card">
    <div class="card-header clearfix">
      <h2 class="h3 float-left">Users</h2>
      <div class="float-right">
        <a href="#create" class="btn btn-primary">New User</a>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered">
        <thead>
          <tr>
            <td>Name</td>
            <td>Username</td>
            <td>Email</td>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>
    </div>
  </div>`;

  //Append the HTML to the #app
  app.innerHTML = table;
}
```

```sh
# Display the users in an HTML table
git status
git add .
git commit -a
git push origin master
```

## Provide a Basic Navigation Structure

We will set up the load function so that we can navigation a full CRUD application. This will be a switch statement similar to the one in the one we did for the authentication app. We will start by providing a mock-up for each case in the switch statement. We will replace these with implementation logic as we develop the logic.

[</> code](https://github.com/microtrain/mean.example.com/commit/7bedf36cc9a13d3b336d0034c39bd48b2642c35f) Mock-up the navigation

```js
//~line 
load: function(){
  let hash = window.location.hash;
  let hashArray = hash.split('-');

  switch(hashArray[0]){
    case '#create':
      console.log('CREATE');
      break;

    case '#view':
      console.log('VIEW');
      break;

    case '#edit':
      console.log('EDIT');
      break;

    case '#delete':
      console.log('DELETE');
      break;

    default:
      viewUsers();
      break;
  }
}
```

```sh
# Mock-up the navigation
git add .
git commit -a
```

[</> code](https://github.com/microtrain/mean.example.com/commit/c167c9440ec243dbef69451fcbb5e21e18c463b3) Add a link to the users app
*views/includes/navbar.pug*
```pug
//~line 28
else
  li.nav-item
    a.nav-link(href='/users/app') Users
```

```sh
# Add a link to the users app
git status
git add .
git commit -a
git push origin master
```

## Build a Form to Create a User

[</> code](https://github.com/microtrain/mean.example.com/commit/584ea096314f761c68028833069276123d8509ae) Add a user creation form.

*src/js/users.app.js*
```js
//~line 63
function createUser(){
  var app = document.getElementById('app');

  var form =  `
      <div class="card">
        <div class="card-header clearfix">
          <h2 class="h3 float-left">Create a New User</h2>
          <div class="float-right">
            <a href="#" class="btn btn-primary">Cancel</a>
          </div>
        </div>
        <div class="card-body">
          <form id="registrationForm" class="card-body">
            <div id="formMsg" class="alert alert-danger text-center">Your form has errors</div>

            <div class="row">
              <div class="form-group col-md-6">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required>
              </div>

              <div class="form-group col-md-6">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
              </div>

              <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
              </div>
            </div>

            <div class="text-right">
              <input type="submit" value="Submit" class="btn btn-lg btn-primary btn-sm-block">
            </div>
          </form>
        </div>
      </div>
  `;

  app.innerHTML=form;
}

//~line 70
case '#create':
  createUser();
  break;	    
```

Make the submit button responsive. While a block-level button makes sense on a small screen, it looks odd spanning the width of a desktop monitor. We can resolve this by making the button responsive. Make sure Gulp is running and add the following to *src/scss/form.scss*. You can test this by opening dev tools and toggling between mobile and desktop views.

*src/scss/form.scss*
```scss
//~line 11
@media all and (max-width:480px) {
  .btn-sm-block { width: 100%; display:block; }
}
```

Commit your changes and push to master.
```sh
# Add a user creation form
git status
git add .
git commit -a
git push origin master
```

## Create a Common Method for Processing Web Forms

[</> code](https://github.com/microtrain/mean.example.com/commit/14739211ac25e38c3b91f2ffca36564da9fd976d) Add a common method for processing web forms.

Change the form if to createUser
```html
  <!-- ~line 75 -->
  <form id="createUser" class="card-body">
```

Add a postRequest method
```js
  //~line 113
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
        if(data.success===true){
          window.location.href = '/';
        }else{
          document.getElementById('formMsg').style.display='block';
        }
      }
    });
  }
```

Call post request from the #create case of the navigation statement.
```js
//~line 150
case '#create':
  createUser();
  postRequest('createUser', '/api/users');
  break;
```

Commit your changes and push to master.
```sh
# Add a common method for processing web forms
git status
git add .
git commit -a
git push origin master
```

## Build a View for a Single User

[</> code](https://github.com/microtrain/mean.example.com/commit/4ee7ea3635d9e7f8e599d86f90f687d9fb1d0f34) Add a user view

```js
//~line 113
function viewUser(id){

  let uri = `${window.location.origin}/api/users/${id}`;
  let xhr = new XMLHttpRequest();
  xhr.open('GET', uri);

  xhr.setRequestHeader(
    'Content-Type',
    'application/json; charset=UTF-8'
  );

  xhr.send();

  xhr.onload = function(){
    let app = document.getElementById('app');
    let data = JSON.parse(xhr.response);
    let card = '';

    card = `<div class="card">
      <div class="card-header clearfix">
        <h2 class="h3 float-left">${data.user.first_name} ${data.user.last_name}</h2>
        <div class="float-right">
          <a href="#edit-${data.user._id}" class="btn btn-primary">Edit</a>
        </div>
      </div>
      <div class="card-body">
        <div>${data.user.username}</div>
        <div>${data.user.email}</div>
      </div>
    </div>`;

    app.innerHTML = card;
  }
}
```

Call ```viewUser(id)``` from the navigation logic.
```js
//~line 191
case '#view':
  viewUser(hashArray[1]);
  break;
```

Commit your changes and push to master.
```sh
# Add a user view
git status
git add .
git commit -a
git push origin master
```

## Build a Form to Edit a User

## Get the Data for User to be Edited
[</> code](https://github.com/microtrain/mean.example.com/commit/642cd6c913d458c7bdafcf0fe54ab81f2c7c2849) Get the data for the selected user.

```js
//~line 148
function editUser(id){

  let uri = `${window.location.origin}/api/users/${id}`;
  let xhr = new XMLHttpRequest();
  xhr.open('GET', uri);

  xhr.setRequestHeader(
    'Content-Type',
    'application/json; charset=UTF-8'
  );

  xhr.send();

  xhr.onload = function(){
    let data = JSON.parse(xhr.response);
    console.log(data);
  }
}
```

Call ```editUser(id)``` from the navigation logic.
```js
//~line 215
case '#edit':
  editUser(hashArray[1]);
  break;
```

```sh
# Get the data for the selected user
git commit -a
```

## Build a Web Form for Editing a User
[</> code](https://github.com/microtrain/mean.example.com/commit/a415894ea27fc8cb38b94c7c25c235ad5ae28f7e) Build a prepopulated web form.

```js
//~line 161
xhr.onload = function(){
  let app = document.getElementById('app');
  let data = JSON.parse(xhr.response);

  var form =  `
    <div class="card">
      <div class="card-header clearfix">
        <h2 class="h3 float-left">Edit</h2>
        <div class="float-right">
          <a href="#" class="btn btn-primary">Cancel</a>
        </div>
      </div>
      <div class="card-body">
        <form id="editUser" class="card-body">
          <input type="hidden" id="_id" name="_id" value="${data.user._id}">
          <div id="formMsg" class="alert alert-danger text-center">Your form has errors</div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="first_name">First Name</label>
              <input type="text" id="first_name" name="first_name" class="form-control" value="${data.user.first_name}" required>
            </div>

            <div class="form-group col-md-6">
              <label for="last_name">Last Name</label>
              <input type="text" id="last_name" name="last_name" class="form-control" value="${data.user.last_name}" required>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="username">Username</label>
              <input type="text" id="username" name="username" class="form-control" value="${data.user.username}" required>
            </div>

            <div class="form-group col-md-6">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control" value="${data.user.email}" required>
            </div>
          </div>

          <div class="text-right">
            <input type="submit" value="Submit" class="btn btn-lg btn-primary btn-sm-block">
          </div>
        </form>
      </div>
    </div>
  `;

  app.innerHTML=form;
}
```

```sh
# Build a prepopulated web form
git commit -a
```

### Process the Form Using Common Logic

[</>code](https://github.com/microtrain/mean.example.com/commit/a65a10d437f5ae664eab182be541d978f9ee3cc4) Update postRequest so that it is better suited for reuse. 

Change post to process and pass put.

Change ```postRequest(formId, url)``` to ```processRequest(formId, url)``` and add method as a third argument.

```js
//~line 214
function processRequest(formId, url, method){
```

Pass the method variable in ```xhr.open()``` instead of the string POST.
```js
//~line 222
xhr.open(method, uri);
```

Update the navigation logic.
```js
//~line 253
case '#create':
  createUser();
  processRequest('createUser', '/api/users', 'POST');
  break;
```

For the edit view we will add the ```processRequest()``` method to the end of the ```useredit()``` method. This is because the form cannot build until we have the user data which is delayed by the AJAX request.

```js
//~line 210
app.innerHTML=form;
processRequest('editUser', '/api/users', 'PUT');
```

## Build a View for Deleting a User

[</> code](https://github.com/microtrain/mean.example.com/commit/523576b427ea9ebbbc40c1e8ce941409708e891e) Provide a confirmation view.

Link to the delete view
```js
//~line 208
<div>
  <a href="#delete-${data.user._id}" class="text-danger">Delete</a>
</div>
```

Create a confirmation view prior to deleting the user.
```js
//~line 250
function deleteView(id){

  let uri = `${window.location.origin}/api/users/${id}`;
  let xhr = new XMLHttpRequest();
  xhr.open('GET', uri);

  xhr.setRequestHeader(
    'Content-Type',
    'application/json; charset=UTF-8'
  );

  xhr.send();

  xhr.onload = function(){
    let app = document.getElementById('app');
    let data = JSON.parse(xhr.response);
    let card = '';

    card = `<div class="card bg-transparent border-danger text-danger bg-danger">
      <div class="card-header bg-transparent border-danger">
        <h2 class="h3 text-center">Your About to Delete a User</h2>
      </div>
      <div class="card-body text-center">
        <div>
          Are you sure you want to delete
          <strong>${data.user.first_name} ${data.user.last_name}</strong>
        </div>

        <div>Username: <strong>${data.user.username}</strong></div>
        <div>Email: <strong>${data.user.email}</strong></div>

        <div class="text-center">
          <br>
          <a class="btn btn-lg btn-danger text-white">
            Yes delete ${data.user.username}
          </a>
        </div>

      </div>
    </div>`;

    app.innerHTML = card;
  }
}
```

Call the ```deleteView()``` from the navigation logic.
```js
//~line 314
case '#delete':
  deleteView(hashArray[1]);
  break;
```

```sh
git status
git add .
git commit -a
git push origin master
```

[</> code](https://github.com/microtrain/mean.example.com/commit/abc86c083e6d267450c35f40faac99cef710a4cb) Create a public facing method for user deletion.

Create the method for actually deleting the user.
```js
//~line 295
function deleteUser(id){

  let uri = `${window.location.origin}/api/users/${id}`;
  let xhr = new XMLHttpRequest();
  xhr.open('DELETE', uri);

  xhr.setRequestHeader(
    'Content-Type',
    'application/json; charset=UTF-8'
  );

  xhr.send();

  xhr.onload = function(){
    let data = JSON.parse(xhr.response);
    if(data.success === true){
      window.location.hash = '#';
    }else{
      alert('Unknown error, the user could not be deleted');
    }

  }

}
```

Expose the deleteUser method to the outside world
```js
//~line 347
},

deleteUser: function(id){
  deleteUser(id);
}
```

Delete the user onclick
```js
//~line 283 
<a onclick="usersApp.deleteUser('${data.user._id}');" class="btn btn-lg btn-danger text-white">
  Yes delete ${data.user.username}
</a>
```
[Next: Articles API](08-ArticlesAPI.md)
