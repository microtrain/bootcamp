# User Create Component

We need to be able to add new users to the system. We will create a web form that will make a post request to the users API.

```sh
ng generate component user-create
```

Add a route

```js
...
import { UserCreateComponent }   from './user-create/user-create.component';
...
const routes: Routes = [
  { path: '', redirectTo: '/users', pathMatch: 'full' },
  { path: 'users', component: UsersComponent },
  { path: 'users/view/:id', component: UserViewComponent },
  { path: 'users/create', component: UserCreateComponent }
];
...
```

Navigate to [http://localhost:4200/users/create](http://localhost:4200/users/create) and you'll see the message "user-create works!"

**Commit your changes** with the message *Generated and routed UserCreateComponent*.

```sh
git add .
git commit -a
```

Since we are creating a user we will want to work with NgForms. Import the FormsModule into AppModule then import NgForm into the user-create component.

*app.module.js*

```js
...
import { FormsModule }   from '@angular/forms';
...

  ...
  imports: [
    ...
    FormsModule
  ]
  ...

```

**Commit your changes** with the message *Imported FormsModule*.

```sh
git add .
git commit -a
```

*users.service.ts*
```js
  createUser (user: User): Observable<User> {
    return this.http.post<User>(this.url, user, httpOptions);
  }
```

*user-create/user-create.component.ts*
```js
import { NgForm } from '@angular/forms';
```

*user-create/user-create.component.ts*
```js
import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from "@angular/router";

import { UsersService } from '../users.service';
import { User } from '../user';

@Component({
  selector: 'app-user-create',
  templateUrl: './user-create.component.html',
  styleUrls: ['./user-create.component.scss']
})
export class UserCreateComponent implements OnInit {

  user = new User();
  errors: Array<any> = [];
  errorMessage: string;

  constructor(
    private usersService: UsersService,
    private router: Router
  ) { }

  ngOnInit(): void{}

  response(response): void{
    if(response.success===false){
      this.errors = response.error.errors;
      this.errorMessage = response.error.message;
    }

    if(response.success===true){
      this.router.navigate(['/users/view/', response.user._id]);
    }
  }

  onSubmit(): void {
    this.usersService.createUser(this.user).subscribe(
      (response) => {
        this.response(response)
      }
    );
  }
}

```

Then add a form to the user-create view. We want will bind the form the ngSubmit.

*user-create/user-create.component.html*
```html
<h1>Create a New User</h1>

<form (ngSubmit)="onSubmit()" #createUser="ngForm">
  
  <div *ngIf="errorMessage">{{errorMessage}}</div>
  
  <div>
    <label for="username">Username</label>
    <input [(ngModel)]="user.username" type="text" name="username" id="username">
    <div *ngIf="errors.username">{{errors.username.message}}</div>
  </div>

  <div>
    <label for="email">Email</label>
    <input [(ngModel)]="user.email" type="text" name="email" id="email">
    <div *ngIf="errors.email">{{errors.email.message}}</div>
  </div>

  <div>
    <label for="first_name">First Name</label>
    <input [(ngModel)]="user.first_name" type="text" name="first_name" name="first_name" id="first_name">
  </div>

  <div>
    <label for="last_name">Last Name</label>
    <input [(ngModel)]="user.last_name" type="text" name="last_name" id="last_name">
  </div>
  
  <button type="submit">Submit</button>

</form>
```

**Commit your changes** with the message *Added the ability to create a user*.

```sh
git add .
git commit -a
```

[Next: Edit User](07-UserEditComponent.md)
