# User View Component

Now we want to view a single user.

Create the user view component
```sh
ng generate component user-view
```

Bring the users component into scope, to do this we will replace the contents of *src/app/user-view/user-view.component.html* with the following.

Add the user-view component to the routing module.
*src/app/app-routing.module.ts*
```js
...
import { UserViewComponent }   from './user-view/user-view.component';
...
const routes: Routes = [
  { path: '', redirectTo: '/users', pathMatch: 'full' },
  { path: 'users', component: UsersComponent },
  { path: 'users/view/:id', component: UserViewComponent }
];
...
```

Now add a ```routerLink``` to your list of users. Use commas to concatenate strings and variables. Update *users/users.component.html* with the following.

*users/users.component.html*
```html
<h1>Users</h1>
<ul *ngIf="users">
  <li *ngFor="let user of users">
    <a [routerLink]="['/users/view/', user._id]">{{user.username}}</a>
  </li>
</ul>
```

The list of users is now clickable, clicking on a user will return a view that says "user-view works!".

**Commit your changes** with the message *Generated and routed UserViewComponent*.

```sh
git add .
git commit -a
```

Add ```getUser()``` method the ```UserService``` this method will expect _id_ as an argument.

*src/app/user.service.ts*
```js
getUser(id: string): Observable<User> {
  return this.http.get<User>(this.url + `/view/${id}`);
}
```

Import ActivatedRoute in UserViewComponent then inject into the component via constructor injection. This will allow us to pull the id parameter out of the URL.

Create a local ```getUser()``` method that will expect _id_ as an argument. This will serve as a wrapper for ```UserService.getUser()```.

Call ```this.getUser()``` from ```ngInit()``` use ActivatedRoute to create the _id_ that will be passed into ```this.getUser()```.

*user-view/user-view.component.ts*
```js
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

import { UserService } from '../user.service';
import { User } from '../user';

@Component({
  selector: 'app-user-view',
  templateUrl: './user-view.component.html',
  styleUrls: ['./user-view.component.scss']
})
export class UserViewComponent implements OnInit {

  user: User;

  constructor(
    private route: ActivatedRoute,
    private userService: UserService
  ) { }

  ngOnInit() {
    const id = this.route.snapshot.paramMap.get('id');
    this.getUser(id);
  }

  getUser(id): void {
    this.userService.getUser(id).subscribe(
      (response) => {
        this.user = response.user
      }
    );
  }
}
```

Update *user-view/user-view.component.html* to show the details of a single user. Use ```*ngIf``` to make sure the user obejct is populated before calling it into the view.

*user-view/user-view.component.html*
```html
<div *ngIf="user">
  <h1>{{user.first_name}} {{user.last_name}}</h1>
  <div><strong>Username:</strong> {{user.username}}</div>
  <div><strong>Email:</strong> {{user.email}}</div>
  <button>Edit</button>
  <button>Delete</button>
</div>
```

**Commit your changes** with the message *Implemented a user view*.

```sh
git add .
git commit -a
```
[Next: Create User](06-UserCreateComponent.md)
