# Users App

In this lesson, we will begin building an application for user management. Since this is our third time building this app and since Ionic is essentially Angular we will not dive into detail. Rather, we will build this on our own and review the build after the fact. You may use the following as a reference, but I would like to see each of you come up with a unique application.

> Based on Ionic 5.4.5

```sh
cd ~
ionic start ionicUsers sidemenu --type angular
```

Create an empty repository called *ionicUsers* on GitHub and push your project to the new repository. Don't worry about the initial commit as Ionic has taken care of this for you.

```sh
git remote add origin git@github.com:GITHUBUSERNAME/ionicUsers.git
git push origin master
ionic serve
```
## Authentication

We will start by providing an authentication mechanism. This will provide a 
service that gives us access to the login, logout, and register endpoints in the 
auth API. This will require the following assets.

* An authentication service
* a login page
* a logout page
* a registration page
* a user model (or schema/object)

```sh
ionic generate service auth
ionic generate page login
ionic generate page logout
ionic generate page register
```

Using VSC create the file *~/ionicUsers/src/app/user.model.ts* 

Test everything is working by navigating to the pages you just created.
* [http://localhost:8100/login](http://localhost:8100/login)
* [http://localhost:8100/logout](http://localhost:8100/logout
* [http://localhost:8100/register](http://localhost:8100/register)

[</> code](https://github.com/microtrain/ionicUsers/commit/44728844c94acec8d88faf84016616541b3c83db) At this point we have generated clean asset files. This is good place to commit as it would give us a clean rollback point.


```sh
# Added authentication assets
git add .
git commit -a
git push origin master
```

[</> code](https://github.com/microtrain/ionicUsers/commit/781014014b86801a855e030bf41798aeea7a8541) User

Our user model should provide a schema. In other words, the model defines the 
properties we expect the application to use.

```ts
export class User{
    _id: string;
    email: string;
    first_name: string;
    last_name: string;
    username: string;
    password: string;
}
```

[</> code](https://github.com/microtrain/ionicUsers/commit/27edefd8c4f66db50dcc529359337053260d78e3) AppModule

Import HttpClientModule into AppModule. You will want to add this to the imports
list.

[</> code](https://github.com/microtrain/ionicUsers/commit/573544231d896443344791df5a0716f4fd0dc408) AuthService

Now that we have defined the user object we will use it to implement the 
authentication service.

[</> code](https://github.com/microtrain/ionicUsers/commit/03fe1a23481e620ff183d0417a9855a25cf53cd8) LoginPage

We will a call to each of the AuthService methods by calling them in ngOnInit 
and reading the console logs. All we really care about at this point is a 200
response from each of the API endpoints.

[</> code](https://github.com/microtrain/ionicUsers/commit/e90908d87e6dcca0f00cd11fd23410047a5b88ee) Clean Up and Navigation

We can now remove HomePage and ListPage and update the menu so that it points 
to our authentication pages.

* Remove ListPage
* Remove HomePage
* Update AppRoutingModule
* Update AppComponent

At this point the home page will be blank. We will set this to something useful
later in the lesson.

### Login

[</> Code](https://github.com/microtrain/ionicUsers/commit/53988d7b334e513f21072d4f2a8ff77ab2eaf06f) Remove test code and add `onSubmit()`

We will start by removing our test code and placing the call to 
`UsersService::login()` in a new method called `onSubmit()`.

[</> Code](https://github.com/microtrain/ionicUsers/commit/f1291f58f6d3c913141cceaa8d6a895067363fd7) Add a login form

Add the markup for a login form then wire that up to the submit button. At this
point you will be able to receive a successful login message from the API.

[</> Code](https://github.com/microtrain/ionicUsers/commit/ca701f8ce3b8cb581a8cfc9024952211d1b5a969) Error Handling

For the sake of brevity we will flag all errors as *Invalid Credentials*. We 
could deal with errors in the `onSubmit()` but this would violate SRP. Instead,
we will add a `response()` method that is responsible for processing the 
response we get back from the API. We could take this a step further and methods 
for dealing with error and success conditions.

[</> Code](https://github.com/microtrain/ionicUsers/commit/b4c164eeab7a6d37a2b8f028fc7adc8cd3d0d5ad) Handle success

On success we will want to redirect the user to the users page. There are a 
couple of things we need to do first.

* Generate the users page
* Turn on hashStrategy

```sh
ionic generate page users
```

Once we have added the users page we will want to import `LocationStrategy` and
`HasLocationStrategy` from `@angular/common` and add them to your providers list
as `{ provide: LocationStrategy, useClass: HashLocationStrategy }`.

#### Test the Functionality

* Update your production build path.
* Add `/ionicUsers` to your whitelist's list of subs.
* Toggle the whitelist on and off depending on you environnement.

##### Testing in Production

[</> Code]() Update Ionic's Build Parameters

If we want to verify sessions are getting set, it is best to run a production 
build. 

You will be adding the following lines to the options object of the architect 
object of the projects object.

*angular.json - projects > architect > options*. 

```json
"baseHref": "/ng-auth/",
"outputPath": "/home/jason/mean.example.com/public/ng-auth",
```

![angular.json](/img/auth/angular_json.png)

Now that you have updated the angular.json file you can run a production build.

```sh
ionic build
```

Add `/ionicUsers` to the subs section of your whitelist. 

*~/mean.example.com/app.js*
```js
//Session-based access control
app.use(function(req,res,next){
  //Uncomment the following line to allow access to everything.
  //return next();

  //Allow any endpoint that is an exact match. The server does not
  //have access to the hash so /auth and /auth#xxx would bot be considered
  //exact matches.
  var whitelist = [
    '/',
    '/auth',
    '/articles'
  ];

  //req.url holds the current URL
  //indexOf() returns the index of the matching array element
  //-1, in this context means not found in the array
  //so if NOT -1 means is found in the whitelist
  //return next(); stops execution and grants access
  if(whitelist.indexOf(req.url) !== -1){
    return next();
  }

  //Allow access to dynamic endpoints
  var subs = [
    '/public/',
    '/api/auth/',
    '/articles',
    '/ionicUsers'
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
  //Redirect the user to the login screen.
  return res.redirect('/auth#login');
});
```

##### Testing in Dev
When running in dev mode via [http://localhost:8100](http://localhost:8100) we 
should turn off the whitelist found in *~/mean.example.com/app.js* 

*~/mean.example.com/app.js*
```js
app.use(function(req,res,next){
  //Uncomment the following line to allow access to everything.
  return next();
```

[</> Code](https://github.com/microtrain/ionicUsers/commit/a37e9f37413cf242e858101aaa2bb5ce73304591) Redirect the user

Now that we have our whitelist and build parameters up to date; we can redirect 
the user after a successful login.

[</> Code](https://github.com/microtrain/ionicUsers/commit/d1495e60be63ecca1c35219b16362d3e98853f44) Wire users to the API

```sh
ionic generate service users
```

You can test API access by implementing a users service and wiring your
users page up to the API. Use a console log to test the output.

> Based on an older lesson plan and Ionic 5.0.3. Please adjust accordingly

## Create a users page and wire it into navigation.

1. Import the UserService (also Service in Angular)
2. Declare users as an Array containing user objects
3. Inject the UserService
4. Create a wrapper for the users service
5. call the getUsers() wrapper


> The following snippets were written in Ionic Version 5.0.3. The current version is >= 5.6.3. According to Semantic Versioning rules the following snippets should still work. While the following code is still valid, PLEASE BE AWARE there may be some differneces in code generation.


UserService will give us access to a users API. We will create a getUsers() method that will return a list of users; this is the goal of UsersPage. To allow UsersPage to access UserProvider we will need to import and inject it into UsersPage.

[</> code](https://github.com/microtrain/ionic-cms/commit/708980c169ca58a8e6b76a3aa036430ab361c3e7) Import the UserService and inject it into UserPage.

At this point, your application should crash when attempting to access the UsersPage. This is because the data provider (UserProvider) is a calling HttpClient but HttpClientModule is not getting loaded. To resolve this issue we will load it into app.module.ts.

[</> code](https://github.com/microtrain/ionic-cms/commit/f71c37d378356286e1430d57af46163965bef089) Add HttpClientModule

It's always good to build one piece at a time. We want to make sure the connection between our service and controller (UsersPage) is working. While we may not yet be ready to implement each provider method it's a good practice to make sure we've accounted for everything we will need to work with the API. In this case, we will be dealing with basic CRUD (Create, Read, Update, Delete) logic. This translates in to
* get a user ```getUser()```
* get many users ```getUsers()```
* create a user ```createUser()```
* update a user ```updateUser()```
* delete a user ```deleteUser()```

[</> code](https://github.com/microtrain/ionic-cms/commit/7101ff4bb7163d3e6a7781317bae6502208f775a) Stub out the user service with the soon to be used methods. Start with having each method execute simple a ```console.log()```.

We will want to create a user data object, other paradigms may refer to this as a model or a schema. For the sake of argument, we will call it a model. For now, we will just define the class. Create a models directory and user model *models/user/user.ts*

[</> code](https://github.com/microtrain/ionic-cms/commit/2a47fa9797f86e22e163dc101e926534b343d8bd) Stub a User object.

[</> code](https://github.com/microtrain/ionic-cms/commit/635f989e910a2aa409d78b190855753bd5d3b41e) Import the User object (model) into UserService.

Before we begin implementing UserService against the API lets create a wrapper in our UserPage and test the connection to the service. To do this we will create a private method that calls the ```getUsers()``` method in UserService. We will call that method from the UserPage constructor. Opening the JS console in the dev tools panel then navigating to the users page in our app will now display "Get Users". At this point we know we have a good connection and we can focus on implementing the ```getUsers()``` logic.

[</> code](https://github.com/microtrain/ionic-cms/commit/2bc571d53cc0fc4a29fb1ed5d63cbb8e278301c5) Implement a basic wrapper for ```getUsers()```.

Now that we have a basic connection between UserService and UserPage we will want to implement an API call against ```UserService.getUsers()```. This will require the following steps.
1. Import Observable from RxJS
1. Set the base URL inside of UserService
1. Create an Observable of type User and implement the get logic
1. Subscribe to the observable and catch the response.

[</> code](https://github.com/microtrain/ionic-cms/commit/64e3eff7bb1726a4ab7b97071be6568481a765e4) Implement the ```getUsers()``` API call.

Opening the JS console in the dev tools panel then navigating to the users page in our app will now display a JSON object containing an array of users.

Make the uses list public so that it will be accessible by the view.

1. Create a public instance variable to hold the list of users. This will hold an Array of user objects.
2. Set the list of users the users instance variable. This will give the view access to the list of users.
3. Log the current state of the users instance.

[</> code](https://github.com/microtrain/ionic-cms/commit/a613fe7b1382ac84e13400aff2548603ad51ad37) Add the users data to a public variable.

At this point, the ```console.log()``` will show a delineated list of users.

Our view now has access to the public users instance. We can display a list of users in the view using [Angular's ngForOf directive](https://angular.io/api/common/NgForOf) to build an [Ionic list](https://ionicframework.com/docs/components/#lists). You can now remove the ```console.log()``` from UsesPage.

[</> code](https://github.com/microtrain/ionic-cms/commit/67a8b26843b56478bf9976b96248d9c072bb1dcb) Implement the users view.

### Add a Loader

Our data comes from a web API. This means any network latency can make a page load feel sluggish or even broken. Using a loader is a good way to ease the pain of a slow page load. 

1. Import LoadingController
2. Inject the LoadingController into the constructor
3. Create a space in memory to hold a loader (an instance variable)
4. Create a method and display a loader
5. Call the loaded when requesting user data
6. Dismiss the loader after the HTTP request has completed

[</> code](https://github.com/microtrain/ionic-cms/commit/600212a852488d9d6fc3afc86774564ab0004b0e) Add a loader.

[</> bug fix](https://github.com/microtrain/ionic-cms/commit/a407dfd23fb4e10e71ccfad0d963bd3b874dfb53) The previous commit was missing an import.

[</> bug fix](https://github.com/microtrain/ionic-cms/commit/ae46e812eaf1c0a5d5cf7301557fb3d130c0ab7d) Typing issues brought to the surface by the previous fix.

[</> code](https://github.com/microtrain/ionic-cms/commit/d8a6fe1a711ed7680ecd888bc0a6a673d45587ac) Remove ListPage, it was only used for demo purposes.


### Create UserPage and Display a Single User

Implement a page to display a single user.

1. Generate a user page
1. Add UserPage to AppModule
1. Add navigation between UsersPages and UserPage
1. Import the UserProvider (aka Service in Ancomaprisonsgular)
1. Import the User model
1. Declare a public user variable
1. Create a wrapper for the UserProvider.getUser()
1. Call the getUsers() wrapper
1. Build the view

```sh
ionic generate page user
```

[</> code](https://github.com/microtrain/ionic-cms/commit/fde3abc4087f6d0d751a65fa943f613e493dd965) Add UserPage to NgModule.entryComponents

[</> code](https://github.com/microtrain/ionic-cms/commit/710c9fb6628b8198babbe2d66174daefb0f5a73a) Provide navigation between UsersPage and UserPage.

[</> code](https://github.com/microtrain/ionic-cms/commit/1dc3dad3726a8b0249c9984a2f6f46ffd7176018) Rough UserPage implementation - API test via console.log() (steps 4-8)

[</> code](https://github.com/microtrain/ionic-cms/commit/915addc3d969546f02b0068ab2eb9d18721c8cd8) - Added basic user details.


### Generate CreateUserPage
Add the functionality to create a new user.

1. Generate UserCreatePage 
[</> code](https://github.com/microtrain/ionic-cms/commit/a81db5e707e32dfdfc68334b02c53254afac72aa)
1. Add UserCreatePage to AppModule 
[</> code](https://github.com/microtrain/ionic-cms/commit/9dddb33f65a721da210ab59ddf9597ec77cf4cb8)
1. Link from UsersPage to UserCreatePage
[</> code](https://github.com/microtrain/ionic-cms/commit/6dfaecf63e7971187eb85d5e475bdd9e6fcd6935)
1. Import the User model [</> code](https://github.com/microtrain/ionic-cms/commit/263c27657c8e7b03126747bd666795104d3b159c)
1. Import the UserProvider [</> code](https://github.com/microtrain/ionic-cms/commit/6dfaecf63e7971187eb85d5e475bdd9e6fcd6935)
1. Declare a public user variable instantiated as a new User object [</> code](https://github.com/microtrain/ionic-cms/commit/8488901ba5db6db8fc84ff3f4c44b7a0614090af)
1. Create a wrapper for the UserProvider.createUser() [</> code](https://github.com/microtrain/ionic-cms/commit/c8a41bfa78e96a3c13819461fb4074997cbe2421)
1. Implement UserProvider.createUser() [</> code](https://github.com/microtrain/ionic-cms/commit/4ec4d245698ae5a88260eff7af2d5edc95a421ce)
1. Build a basic user form and implement a form submit [</> code](https://github.com/microtrain/ionic-cms/commit/8365e49d4053069c284321e643eca20e4dd05866)
1. Redirect after submit [</> code](https://github.com/microtrain/ionic-cms/commit/a14c87d34a0bfcea56026219aecc57be6525b4bb)

```sh
ionic generate page user-create
```

## LAB - Edit and Delete Users

* Implement an edit users page.
* Add the ability to delete a user.
    * This may be its own page or a method built into another component.

[Next: ionic-cms](../05-IonicCMS/README.md)
