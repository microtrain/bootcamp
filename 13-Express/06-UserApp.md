# User App

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
