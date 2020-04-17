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
"baseHref": "/ionicUsers/",
"outputPath": "/home/dev/mean.example.com/public/ionicUsers",
```

![angular.json](/img/ionic/angular.json.png)

Now that you have updated the angular.json file you can run a production build.

```sh
ionic build
```

> Those changes only apply if you are running the `ionic build` command. If you are running `ionic serve` remove `baseHref` and revert `outputPath` back to `www`.

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

### Logout

[</> Code](https://github.com/microtrain/ionicUsers/commit/29c9b187dbc9a054affc0f729058596fd73e6c5a)

Provide a simple logout with a fall back to allow the user to retry the logout should the logout fail.

[</> Code](https://github.com/microtrain/ionicUsers/commit/77a0d41bda23be4dfb7ff6c2a245427d934517ab) Clean up

Missed a `console.log()`

### Register

[</> Code](https://github.com/microtrain/ionicUsers/commit/db72e3b65196532f75dce65753271cb6d1f49a18) Build a registration form

[</> Code](https://github.com/microtrain/ionicUsers/commit/20144ce1850416d5f9a5e7f1f45931d736bf97e4) Process user input

## User Management

### All Users

[</> Code](https://github.com/microtrain/ionicUsers/commit/95a8c441c1473d8431d62162d2d5b607f8e9c585) Build a view for all users


### A Single User
[</> Code](https://github.com/microtrain/ionicUsers/commit/7b293ee36ecb62368a1d90e0663165845f829b0c) Generate the user page
```sh
ionic generate page user
```

[</> Code](https://github.com/microtrain/ionicUsers/commit/5b71d0c10a98738dae3f120264ab6a61ca9ce9dc) Allow parameters to be passed into the user view

[</> Code](https://github.com/microtrain/ionicUsers/commit/6ed1f4b0920ae4fca423c0a4cef255f0a58e56da) Add `getUser()` to the users service

This commit has a syntax error, see the following commit.

[</> Code](https://github.com/microtrain/ionicUsers/commit/522307276b9e34e7b6a21d02f0cef619d1de2388) Errata

[</> Code](https://github.com/microtrain/ionicUsers/commit/95a8c441c1473d8431d62162d2d5b607f8e9c585) Add a `getUser()` wrapper to the user page

[</> Code](https://github.com/microtrain/ionicUsers/commit/c02bc9eaf7b316abb0bb2988b4e348a6936da689) Build a view for a single user

[</> Code](https://github.com/microtrain/ionicUsers/commit/1df1afb1f951c7762277e9f3f05ec785ffbb9197) Deprecated CSS attributes
In you console, you may see an error similar to the following, read the the 
entire error, it will tell you what to do. 

```sh
[DEPRECATED][CSS] Ionic CSS attributes are deprecated.
```

[</> Code](https://github.com/microtrain/ionicUsers/commit/1df1afb1f951c7762277e9f3f05ec785ffbb9197) Add users to the side menu


## LAB - Edit and Delete Users
* [</> Code](https://github.com/microtrain/ionicUsers/commit/5db75fa341242c264ec522b187fd103fdd666922) Implement an edit users page.
* [</> Code](https://github.com/microtrain/ionicUsers/commit/a0aa5b28525d567c1898b67481e525db86b9a639) Add the ability to delete a user.
    * This may be its own page or a method built into another component.
* [</> Code](https://github.com/microtrain/ionicUsers/commit/7e3d5ee18377e2402838cdc18abff4eab75e4011) Either create a user page or assume all users are created using the 
registration form. I will leave this up to you.

[Next: ionicCMS](../04-IonicCMS/README.md)
