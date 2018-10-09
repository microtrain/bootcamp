# REST API

An API end point (in this case a data API) is a server response that does not render an HTML view. Rather, the end point would return json, jsonp, xml, soap or the like. Typically, the point of an API is to either accept a data request or return a server response in the form of unformatted data. The intent is to create an end point that can interact with other software rather than a human. For example, */api/users/create* could allow a user to be created from a web app, desktop app, mobile app, console app, etc. The point is having a single end point that can serve data between to any medium. Our applications will use HTTP verbs (GET, PUT, POST, DELETE) to create a CRUD based REST API that interacts with JSON data.

* Relevant HTTP Verbs - POST, GET, PUT, DELETE
* CRUD - Create, Read, Update, Delete
* REST - REpresentational State Transfer

**Translate HTTP Verbs to CRUD**

  * Create - POST
  * Read - GET
  * Update - PUT
  * Delete - DELETE

## Create a Data Model

We will start with a JSON based users API. This will provide end points for creating and managing users. This is also known as a data API, since this deals with data; the data model is a logical place to start.


## Create the Database
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

## Add a Config File

[</> code](https://github.com/microtrain/mean.example.com/commit/20f3de96edc60b3ddaaedc228e25181d00c966d2) A config file is a good practice for storing and managing API keys and other configuration variables from a central location. I often create two files, one for production and one for development. We will start by adding a connection string for MongoDB.

Create the file *config.dev.js*

*config.dev.js*
```js
var config = {};
config.mongodb = 'mongodb://localhost/mean-cms';
module.exports = config;
```

Import the configuration file into *app.js*, add a console log to test the config file.

*app.js*
```js
var config = require('./config.dev');

//Test the file
console.log(config);
```

Remove the ```console.log()``` and commit your code with the message *Create a sitewide configuration file*.

```sh
git status
git add .
git commit -a
git push origin master
```

## Install Mongoose

[</> code](https://github.com/microtrain/mean.example.com/commit/6d50043da96f021bd609c7d0c614bc2e62c576cc) Now that we have a configuration file with a MongoDB connection string we can start working with a database. To do this we will use NPM to install an ODM (Object Document Mapper) called Mongoose.

```sh
# Install Mongoose
npm install mongoose
git commit -a 
git push origin master
```

[</> code](https://github.com/microtrain/mean.example.com/commit/9524d63b356770436c5f648b1d10d3210d51b441) Validation is a key feature of Mongoose. Executes before making a save to MongoDB. This allows us to define rules at the model level. We will want to make sure usernames and email addresses are unique. Mongoose does not have a built in validator for this but the community does. We will install the [mongoose-unique-validator](https://www.npmjs.com/package/mongoose-unique-validator) plugin and set uniqueness as needed.

```sh
# Install mongoose-unique-validator
npm install mongoose-unique-validator
git commit -a
git push origin master
```

Your *package.json* file should look something like the following, version numbers may vary.

```json
{
  "name": "mean.example.com",
  "version": "0.0.0",
  "private": true,
  "scripts": {
    "start": "node ./bin/www"
  },
  "dependencies": {
    "cookie-parser": "~1.4.3",
    "debug": "~2.6.9",
    "express": "~4.16.0",
    "http-errors": "~1.6.2",
    "mongoose": "^5.2.17",
    "mongoose-unique-validator": "^2.0.2",
    "morgan": "~1.9.0",
    "pug": "2.0.0-beta11"
  }
}
```

[</> code](https://github.com/microtrain/mean.example.com/commit/2c94aa05bbbd87c07f437d65a00fd4383f6c317d) Import mongoose and create a connection to the database.

*app.js*
```js
var mongoose = require('mongoose');

...

//Connect to MongoDB
mongoose.connect(config.mongodb, { useNewUrlParser: true });
```

```sh
# Connect to the database
git status
git add .
git commit -a
git push origin master
```

## Define the Schema

[</> code](https://github.com/microtrain/mean.example.com/commit/63221876843dacb1fe43b0359cf78b78bb6b7ef5) Next we will create a *models* directory in the root of our project and in it a file named *users.js*.

*mean.example.com/models/users.js*.
```js
var mongoose = require('mongoose');
var Schema = mongoose.Schema;
var uniqueValidator = require('mongoose-unique-validator');

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

//Add unique validation properties to the model
Users.plugin(uniqueValidator);

module.exports  = mongoose.model('Users', Users);
```

```sh
# Added a users model/schema
git status
git add .
git commit -a
git push origin master
```

## Implement the REST/CRUD Functionality

* create - A POST request that creates a user
* read - A GET request that returns either a single user record
* read - A GET request that returns a list of user records
* update - A PUT request that updates an existing record
* delete - A delete request that removes an existing user

### GET/Read All
[</> code](https://github.com/microtrain/mean.example.com/commit/17f79de963a53458842241d23126905964676dc4) Add a routing file for api/users.

Create an empty file.
*routes/api/users.js*

Commit your changes and push to master.
```sh
# Add a rotuing file for api/users
git status
git add .
git commit -a
git push origin master
```

[</> code](https://github.com/microtrain/mean.example.com/commit/8ca083840f50b796f6d16113127991558546a4fd) Add api/users route to app.js

The following lines will import the route into the ```apiUsersRouter``` variable (~line 10) then bind that route to a URL endpoint (~line 32) which means any url that starts with */api/users* will look into the */api/users.js* file to complete the request.

*app.js*
```js
//~line 10
var apiUsersRouter = require('./routes/api/users');

//~line 32
app.use('/api/users', apiUsersRouter);
```

The following will resolve any get requests to */api/users/* to the ```router.get()``` method (~line 3).

*routes/api/users.js*
```js
var express = require('express');
var router = express.Router();

router.get('/', function(req, res, next) {
  res.json({success: true});
});

module.exports = router;
```

Commit your changes and push to master.
```sh
# Implement a route for api/users
git status
git add .
git commit -a
git push origin master
```


[</> code](https://github.com/microtrain/mean.example.com/commit/95d133992ef597e6ed584b4a523d9e17cc8628cc) Accessing the */api/users/* route using a GET request shall return a list of all users.

* HTTP verb - GET
* CRUD action - read/read all

*routes/api/users.js*
```js
var Users = require('../../models/users');

router.get('/', function(req, res, next) {
  Users.find({},function(err, users){
    if(err){
     return res.json({'success':false, 'error': err});
   }
    return res.json({'success':true, 'users': users});
  });
});
```

Test by running a curl command from a terminal window.
```sh
curl -H "Content-Type: application/json" -X GET http://localhost:3000/api/users/
```

Commit your changes and push to master.
```sh
# Retrieve a list of all users
git status
git add .
git commit -a
git push origin master
```

### GET/Read One
[</> code](https://github.com/microtrain/mean.example.com/commit/6415441f5caf337a19be63cabb0b892f4a58ee5d) Accessing the route */api/users/:userId* (for which :userId is the id of a known user) using a GET request shall return the user with that id.

* HTTP verb - GET
* CRUD action - read/read one

*/routes/api/users.js*
```js
router.get('/:userId', function(req,res){
  
  var userId = req.params.userId;
   Users.findOne({'_id':userId}, function(err, user){
     if(err){
      return res.json({'success':false, 'error': err});
    }
     return res.json({'success':true, 'user': user});
   });
 });
```

Test by running a curl command from a terminal window.
```sh
curl -H "Content-Type: application/json" -X GET http://localhost:3000/api/users/5a763b67a5d70c115d81536a
```

Commit your changes and push to master.
```sh
# Retrieve a single user by _id
git status
git add .
git commit -a
git push origin master
```

### POST/Create
[</> code](https://github.com/microtrain/mean.example.com/commit/65061eb74a8708571db616917f0ae88998da1090) Sending a json payload over a POST request to the *api/users* endpoint shall create a new user record.

* HTTP verb - POST
* CRUD action - create

*/routes/api/users.js*
```js
router.post('/', function(req, res) {
  Users.create(new Users({
    username: req.body.username,
    email: req.body.email,
    first_name: req.body.first_name,
    last_name: req.body.last_name
  }), function(err, user){
    
    if(err){
      return res.json({success: false, user: req.body, error: err});
    }

    return res.json({success: true, user: user});
    
  });
});
```

Test with a simple curl request
```sh
curl -d '{"email":"test2@example.com", "username":"testuser2", "first_name": "Bob", "last_name": "smith"}' -H "Content-Type: application/json" -X POST http://localhost:3000/api/users

curl -d '{"email":"test3@example.com", "username":"testuser3", "first_name": "Sally", "last_name": "Smith"}' -H "Content-Type: application/json" -X POST http://localhost:3000/api/users
```
Commit your changes and push to master
```sh
# Create a new user record
git status
git add .
git commit -a
git push origin master
```

### PUT/Update
[</> code](https://github.com/microtrain/mean.example.com/commit/3f688eacef3db03d098dd55ae8d9f63cbfbd279d) Sending a json payload with an id, over a PUT request to the *api/users* endpoint shall update an exisiting user record.

* HTTP verb - PUT
* CRUD action - update

*/routes/api/users.js*
```js
router.put('/', function(req, res){

  Users.findOne({'_id': req.body._id}, function(err, user){

   if(err) {
     return res.json({success: false, error: err});
   }

   if(user) {

    let data = req.body;

    if(data.username){
      user.username = data.username;
    };

    if(data.email){
    user.email = data.email;
    };

    if(data.first_name){
    user.first_name = data.first_name;
    };

    if(data.last_name){
    user.last_name = data.last_name;
    };

    user.save(function(err){
      if(err){
        return res.json({success: false, error: err});
      }else{
        return res.json({success: true, user:user});
      }
    });

   }

  });
  
});
```

Test with a simple curl request
```sh
curl -d '{"_id":"5b92c4a5aae3570145ed77e5", "first_name":"Robert"}' -H "Content-Type: application/json" -X PUT http://localhost:3000/api/users
```

Commit your changes and push to master
```sh
# Edit a user record
git status
git add .
git commit -a
git push origin master
```

### DELETE/Delete
[</code>](https://github.com/microtrain/mean.example.com/commit/51ec33a5666ac84e52586e82c1556f8e1204c53c) Accessing the route */api/users/:userId* (for which :userId is the id of a known user) using a DELETE request shall delete the user with that id.

* HTTP verb - DELETE
* CRUD action - delete

*/routes/api/users.js*
```js
router.delete('/:userId', function(req,res){

  var userId = req.params.userId;

  Users.remove({'_id':userId}, function(err,removed){

    if(err){
      return res.json({success: false, error: err});
    }

    return res.json({success: true, status: removed});

  });

});
```

Test with a simple curl request
```sh
curl -H "Content-Type: application/json" -X DELETE http://localhost:3000/api/users/5a766d52cbe495128293baef
```

```sh
# Delete a user record
git status
git add .
git commit -a
git push origin master
```
#### Add Created and Modified Dates

[</code>](https://github.com/microtrain/mean.example.com/commit/f0f8c08f01c85985fc37e35c3da55835e9c5a819) Creating a new user shall automatically populate created and modified dates.

*models/users.js*
```js
  ,
  created: {
    type: Date,
    default: Date.now
  },
  modified: {
    type: Date,
    default: Date.now
  }
```

```sh
# Auto-populate created and modified dates on record creation
git status
git add .
git commit -a
git push origin master
```

##### Auto Update the Modified Date When a Document is Saved

[</code>](https://github.com/microtrain/mean.example.com/commit/51ec33a5666ac84e52586e82c1556f8e1204c53c) Modifying an exisiting user shall automatically update the modified date.

*models/users.js*
```js
Users.pre('save', function(next){
  this.modified = new Date().toISOString();
  next();
});
```

```sh
# Auto-update the modified date on edit
git status
git add .
git commit -a
git push origin master
```

[Next: Auth API](04-AuthAPI.md)
