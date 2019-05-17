# Ionic: Auth

For this lesson we will re-create Auth based on command run a CLI program called *ionicAuth*. The ionic command serves as both an alias for Angular's ```ng``` command and it's own progam as it adds some Ionic sugar on top of the Angular CLI.   

```sh
cd ~
ionic start ionicAuth blank
# Install the free Ionic Appflow SDK and connect your app? (Y/n) No
cd ionicAuth
ionic serve
```

```ionic serve``` works like ```ng serve``` in that it serve the application in a browser window. If your building in Ionic, I'm assuming your focus is mobile. Launching ```ionic serve``` with the labs argument will launch Ionic in a split mobile view. Terminate the current instance using [ctrl]+[c] and launch with the serve argument.
cd ionicAuth
```
ionic serve --lab
# Install @ionic/lab? Yes
```

You will be creating a three page app/ in Ionic.

* login
* logout
* register

Follow previous directions for ionicApod using and referring to components from ng-auth. Since this is our third time building this app and since Ionic is essentially Angular we will not dive into detail. Rather, we will build this on our own and review the build after the fact.

[Next: ionic-users](/04-IonicUsers/README.md)
