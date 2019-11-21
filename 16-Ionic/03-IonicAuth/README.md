# Ionic: Auth

For this lesson, we will re-create the Auth program. We will use the CLI to create a package called *ionicAuth*. The `ionic` command is an alias Angular's `ng` command that adds some *Ionic sugar* on top of the Angular CLI. This app will use a blank template.

```sh
cd ~
ionic start ionicAuth blank
```
Choose Angular as your framework.
```sh
# Integrate your new app with Cordova to target native iOS and Android? (Y/n) No
Pick a framework! 😁

Please select the JavaScript framework to use for your new app. To bypass this
prompt next time, supply a value for the --type option.

? Framework: (Use arrow keys)
❯ Angular | https://angular.io 
  React   | https://reactjs.org 
```

```ionic serve``` works like ```ng serve``` in that it serves the application in a browser window http://localhost:8100.
Launching ```ionic serve``` with the labs argument will launch Ionic in a split mobile view. Terminate the current instance using [ctrl]+[c] and launch with the serve argument.
cd ionicAuth
```
ionic serve --lab
# Install @ionic/lab? Yes
```

You will be creating a three-page app/ in Ionic.
ionic generate page *name
* login
* logout
* register


Create an authentication route. 
ionic generate page login

After each page is generated be sure to update each supporting *.page.html, *.page.ts, *.module.ts
Import, Constructor, Routes and Model
users.ts

Follow previous directions for ionicApod using and referring to components from ng-auth. Since this is our third time building this app and since Ionic is essentially Angular we will not dive into detail. Rather, we will build this on our own and review the build after the fact.

[Next: ionic-users](../04-IonicUsers/README.md)
