# [Ionic](https://ionicframework.com/)

* [Sign up](https://dashboard.ionicjs.com/signup) for Ionic Pro.
* Choose the free kickstarter plan.
* Go to the [Geetting Started](https://ionicframework.com/getting-started) guide.
* Install Ionic and create your first app

```sh
npm install -g ionic
ionic start myApp tabs
```

* Review the file structure and draw comaprisons to Angualar.
* Exit this program and create the CMS app
```
ionic start ionic-cms sidemenu
```

Create a users page and wire it into navigation.
```sh
ionic generate page users
```

```sh
ionic generate provider user
```
Stub out the user provider with the soon to be used methods.

Create a models dirctory and user model *models/user.ts*

Implement the ```getUsers()``` method.

Wire up the users page.

## Lab

Complete the users UI and implement all API methods of the UserProvider.


