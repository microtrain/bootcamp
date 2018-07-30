# User Edit Component

```sh
ng generate component user-edit
```

*app-routing.module.ts*
```js
...
import { UserEditComponent }   from './user-edit/user-edit.component';

const routes: Routes = [
  { path: '', redirectTo: '/users', pathMatch: 'full' },
  { path: 'users', component: UsersComponent },
  { path: 'users/view/:id', component: UserViewComponent },
  { path: 'users/create', component: UserCreateComponent },
  { path: 'users/edit/:id', component: UserEditComponent }
];
...
```

Navigate to [http://localhost:4200/users/edit/5a5e285039084a199e4515f9](http://localhost:4200/users/edit/1) you will see a that says user-edit works!

**Commit your changes** with the message *Generated and routed UserEditView*.

```sh
git add .
git commit src
```

Add an ```editUser()``` method to *users.service.ts*.

*users.service.ts*
```js
editUser (user: User): Observable<User> {
  return this.http.post<User>(this.url + '/edit',user, httpOptions);
}
```

*user-view/user-edit.component.ts*
```js
import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from "@angular/router";
import { ActivatedRoute } from '@angular/router';

import { UserService } from '../user.service';
import { User } from '../user';

@Component({
  selector: 'app-user-edit',
  templateUrl: './user-edit.component.html',
  styleUrls: ['./user-edit.component.scss']
})
export class UserEditComponent implements OnInit {

  user: User;
  errors: Array<any> = [];
  errorMessage: string;

  constructor(
    private userService: UserService,
    private route: ActivatedRoute,
    private router: Router

  ) { }

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    this.getUser(id);
  }

  getUser(id): void {
    this.userService.getUser(id).subscribe(
      user => this.user = user.user
    );
  }

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
    this.userService.editUser(this.user).subscribe(
      (response) => {
        this.response(response)
      }
    );
  }

}
```

*user-view/user-edit.component.html*
```html
<h1 *ngIf="user">Edit {{user.first_name}} {{user.last_name}}</h1>

<form *ngIf="user" (ngSubmit)="onSubmit()" #editUser="ngForm">
  <div *ngIf="errorMessage" class="alert error">{{errorMessage}}</div>

  <input [(ngModel)]="user._id" type="hidden" id="_id" [ngModelOptions]="{standalone: true}">

  <div>
    <label for="username">Username</label>
    <input [(ngModel)]="user.username" type="text" id="username" [ngModelOptions]="{standalone: true}">
    <div class="error" *ngIf="errors.username">{{errors.username.message}}</div>
  </div>

  <div>
    <label for="email">Email</label>
    <input [(ngModel)]="user.email" type="text" id="email" [ngModelOptions]="{standalone: true}">
    <div class="error" *ngIf="errors.email">{{errors.email.message}}</div>
  </div>

  <div>
    <label for="first_name">First Name</label>
    <input [(ngModel)]="user.first_name" type="text" name="first_name" id="first_name" [ngModelOptions]="{standalone: true}">
    <div class="error" *ngIf="errors.first_name">{{errors.first_name.message}}</div>
  </div>

  <div>
    <label for="last_name">Last Name</label>
    <input [(ngModel)]="user.last_name" type="text" id="last_name" [ngModelOptions]="{standalone: true}">
    <div class="error" *ngIf="errors.last_name">{{errors.last_name.message}}</div>
  </div>
  <button type="submit">Submit</button>

</form>
```
**Commit your changes** with the message *Added the ability to edit a user.

```sh
git add .
git commit src
```
[Next: Delete User](08-DeleteAUser.md)
