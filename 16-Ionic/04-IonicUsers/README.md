# Users App

In this lesson we will begin building an application for user management. Since this is our third time building this app and since Ionic is essentially Angular we will not dive into detail. Rather, we will build this on our own and review the build after the fact. You may use the following as a reference, but I would really like to see each of you come up with a unique application.

```sh
ionic start ionicUsers sidemenu
git remote add origin git@github.com:GITHUBUSERNAME/ionicUsers.git
git push origin master
ionic serve --lab
# Answer yes to install Ionic lab
```
## Add the Authentication logic from the ionicAuth app

```sh
ionic generate service auth
ionic generate page login
ionic generate page login
ionic generate page regsiter
```
For each of these files, copy the content from the ioncAuth project.

## Create a users page and wire it into navigation.

1. Import the UserProvider (aka Service in Angular)
2. Declare users as an Array containing user objects
3. Inject the UserProvider
4. Create a wrapper for the users provider
5. call the getUsers() wrapper

```sh
ionic generate page users
```

[</> code](https://github.com/microtrain/ionic-cms/commit/e596528a24bc6e432fc634808fc378756610a3f0)
Declare UsersPage in app.module.ts

[</>  code](https://github.com/microtrain/ionic-cms/commit/52c30d29da7b72ffa6920aa95ae50900bbad07f5)
Add the UserPage to your side menu.

Create a data provider to connect to the users API.

```sh
ionic generate provider user
```

UserProvider will give us access to a users API. We will create a getUsers() method that will return a list of users; this is the goal of UsersPage. To allow UsersPage to access UserProvider we will need to import and inject it into UsersPage.

[</> code](https://github.com/microtrain/ionic-cms/commit/708980c169ca58a8e6b76a3aa036430ab361c3e7) Import the UserProvider and inject it into UserPage.

At this point your application should crash when attempting to access the UsersPage. This is because the data provider (UserProvider) is a calling HttpClient but HttpClientModule is not getting loaded. To resolve this issue we will load it into app.module.ts.

[</> code](https://github.com/microtrain/ionic-cms/commit/f71c37d378356286e1430d57af46163965bef089) Add HttpClientModule

It's always good to build one piece at a time. We want to make sure the connection between our provider and controller (UsersPage) is working. While we may not yet be ready to implement each provider method it's a good practice to make sure we've accounted for everything we will need to work with the API. In this case we will be dealing with basic CRUD (Create, Read, Update, Delete) logic. This tranlates in to
* get a user ```getUser()```
* get many users ```getUsers()```
* create a user ```createUser()```
* update a user ```updateUser()```
* delete a user ```deleteUser()```

[</> code](https://github.com/microtrain/ionic-cms/commit/7101ff4bb7163d3e6a7781317bae6502208f775a) Stub out the user provider with the soon to be used methods. Start with a having each method execute simple ```console.log()```.

We will want to create a user data object, other paradigms may refer to this as a model or a schema. For the sake of argument we will call it a model. For now we will just define the class. Create a models dirctory and user model *models/user/user.ts*

[</> code](https://github.com/microtrain/ionic-cms/commit/2a47fa9797f86e22e163dc101e926534b343d8bd) Stub a User object.

[</> code](https://github.com/microtrain/ionic-cms/commit/635f989e910a2aa409d78b190855753bd5d3b41e) Import the User object (model) into UserProvider.

Before we begining implementing UserProvider against the API lets create a wrapper in out UserPage and test the connection to the provider. To do this we will create a private method that calls the ```getUsers()``` method in UserProvider. We will call that method from the UserPage constructor. Opening the JS console in the dev tools panel then navigationg to the users page in our app will now display "Get Users". At this point we know we have a good connection and we can focus on implementing the ```getUsers()``` logic.

[</> code](https://github.com/microtrain/ionic-cms/commit/2bc571d53cc0fc4a29fb1ed5d63cbb8e278301c5) Implement a basic wrapper for ```getUsers()```.

Now that we have a basic connection between UserProvider and UserPage we will want to implement an API call against ```UserProvider.getUsers()```. This will require the following steps.
1. Import Observable from rxjs
1. Set the base URL inside of UserProvider
1. Create an Observable of type User and implement the get logic
1. Subscribe to the observable and catch the response.

[</> code](https://github.com/microtrain/ionic-cms/commit/64e3eff7bb1726a4ab7b97071be6568481a765e4) Implement the ```getUsers()``` API call.

Opening the JS console in the dev tools panel then navigating to the users page in our app will now display a JSON object containing a an Array of users.

Make the uses list public so that it will be accessible by the view.

1. Create a public instance variable to hold the list of users. This will hold an Array of user objects.
2. Set the list of users the users instance variable. This will give view access to the list of users.
3. Log the current state of the users instance.

[</> code](https://github.com/microtrain/ionic-cms/commit/a613fe7b1382ac84e13400aff2548603ad51ad37) Add the users data to a public variable.

At this point the ```console.log()``` will show a delineated list of users.

Our view now has access to the public users instance. We can display display a list of users in the view using [Angular's ngForOf directive](https://angular.io/api/common/NgForOf) to build an [Ionic list](https://ionicframework.com/docs/components/#lists). You can now remove the ```console.log()``` from UsesPage.

[</> code](https://github.com/microtrain/ionic-cms/commit/67a8b26843b56478bf9976b96248d9c072bb1dcb) Implement the users view.

### Add a Loader

Our data comes from a web API. This means any network latency can make a page load feel sluggish or even broken. Using a loader is a good way to ease the pain ofa slow page load. 

1. Import LoadingController
2. Inject the LoadingController into the constructor
3. Create a space in memory to hold a loader (an instance variable)
4. Create a method and display a loader
5. Call the loaded when requesting user data
6. Dismiss the loader after the HTTP request has completed

[</> code](https://github.com/microtrain/ionic-cms/commit/600212a852488d9d6fc3afc86774564ab0004b0e) Add a loader.

[</> bug fix](https://github.com/microtrain/ionic-cms/commit/a407dfd23fb4e10e71ccfad0d963bd3b874dfb53) The previous commit was missing an import.

[</> bug fix](https://github.com/microtrain/ionic-cms/commit/ae46e812eaf1c0a5d5cf7301557fb3d130c0ab7d) Typing issues brought to the surface byt the previous fix.

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
    * This may be it's own page or a method built into another component.

[Next: ionic-cms](../05-IonicCMS/README.md)
