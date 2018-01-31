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

## Implement UsersPage

1. Import the UserProvider (aka Service in Angular)
2. Import the User schema/model
3. Declare users as an Array containing user objects
4. Inject the UserProvider
5. Create a wrapper for the users provider
6. call the getUsers() wrapper

```js
import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';

//1. Import the UserProvider (aka Service in Angular)
import { UserProvider } from '../../providers/user/user';

//2. Import the User schema/model
import { User } from '../../models/user';

/**
 * Generated class for the UsersPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-users',
  templateUrl: 'users.html',
})
export class UsersPage {


  //3. Declare users as an Array containing user objects
  users: User[];

  constructor(
    public navCtrl: NavController,
    public navParams: NavParams,
    //4. Inject the UserProvider
    private userProvider: UserProvider
  ) {
  }

  ionViewDidLoad() {
    //6. call the getUsers() wrapper
    this.getUsers();
    this.userProvider.getUser();
    this.userProvider.editUser();
    this.userProvider.createUser();
    this.userProvider.deleteUser();
  }

  //5. Create a wrapper for the users provider
  getUsers(): void {
    this.userProvider.getUsers().subscribe(
      (response) => {
        this.users = response.users,
        console.log(this.users)
      }
    );
  }

}

```

## Add a Loader

1. Import LoadingController
2. Create a space in memory to hold a loader
3. Inject the LoadingController
4. Build and display a loader on instaniation
5. Dismiss the loader after the Http Request has completed

```js
import { Component } from '@angular/core';
//1. Import LoadingController
import { IonicPage, NavController, NavParams, LoadingController } from 'ionic-angular';

import { UserProvider } from '../../providers/user/user';

import { User } from '../../models/user';

/**
 * Generated class for the UsersPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-users',
  templateUrl: 'users.html',
})
export class UsersPage {

  public users: User;
  //2. Create a space in memory to hold a loader
  private loader: any;

  constructor(
    public navCtrl: NavController,
    public navParams: NavParams,
    private userProvider: UserProvider,
    //3. Inject the LoadingController
    public loadingCtrl: LoadingController
  ) {
    //4. Build and display a loader on instaniation
    this.loader = this.loadingCtrl.create({
      content: 'Loading...',
    });

    this.loader.present();
  }

  public ionViewDidLoad() {
    this.getUsers();
    this.userProvider.getUser();
    this.userProvider.editUser();
    this.userProvider.createUser();
    this.userProvider.deleteUser();
  }


  public getUsers(): void {
    this.userProvider.getUsers().subscribe(
      (response) => {
        this.users = response.users,
        console.log(this.users),
        //5. Dismiss the loader after the Http Request has completed
        this.loader.dismiss()
      }
    );
  }

}
```

## Lab

Complete the users UI and implement all API methods of the UserProvider.



### Connect to the UserPage

Create UserPage
```sh
ionic generate page user
```

*pages/users/users.ts*
```js
import { Component } from '@angular/core';

import { IonicPage, NavController, NavParams, LoadingController } from 'ionic-angular';

import { UserProvider } from '../../providers/user/user';

import { User } from '../../models/user';
//1. Import UserPage
import { UserPage } from '../user/user';

@IonicPage()
@Component({
  selector: 'page-users',
  templateUrl: 'users.html',
})
export class UsersPage {

  public users: User;

  //2. Pass the Userpage object into view
  public toUser = UserPage;

  private loader: any;

  constructor(
    public navCtrl: NavController,
    public navParams: NavParams,
    private userProvider: UserProvider,
    //3. Inject the LoadingController
    public loadingCtrl: LoadingController
  ) {
    //4. Build and display a loader on instaniation
    this.loader = this.loadingCtrl.create({
      content: 'Loading...',
    });

    this.loader.present();
  }

  public ionViewDidLoad() {
    this.getUsers();
    this.userProvider.getUser();
    this.userProvider.editUser();
    this.userProvider.createUser();
    this.userProvider.deleteUser();
  }


  public getUsers(): void {
    this.userProvider.getUsers().subscribe(
      (response) => {
        this.users = response.users,
        console.log(this.users),
        //5. Dismiss the loader after the Http Request has completed
        this.loader.dismiss()
      }
    );
  }

}
```

*pages/users/users.html*
```html
<ion-content padding>
  <ion-list *ngIf="users">
    <button ion-item *ngFor="let user of users" [navPush]="toUserDetail" [navParams]="user._id">
      {{user.username}}
    </button>
  </ion-list>
</ion-content>
```







