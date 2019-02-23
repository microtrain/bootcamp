# Delete a User

Update *user.service.ts*
```js
deleteUser (id: string): Observable<User> {
  return this.http.delete<User>(`${this.url}/${id}`);
}
```

Import Router so that we can redirect after a delete.

*user-view/user-view.component.ts*
```js
...
//1. import router
import { Router } from '@angular/router';
...
//2. inject router into the constructor
constructor(
  private usersService: UsersService,
  private router: Router,
  private route: ActivatedRoute
) { }
  
...
//3. Implement the deleteUser() method
deleteUser(id: string): void {
  if(confirm("Are you sure to delete " + this.user.user.username)) {
    this.usersService.deleteUser(id).subscribe(
      ()=>{this.router.navigate(['/users'])}
    );
  }
}
```

Update the delete button
*user-view/user-view.component.html*
```html
<button [routerLink]="['/users/edit/', user._id]">Edit</button>
<button (click)="deleteUser(user._id)">Delete</button>
```

**Commit your changes** with the message *Added the ability to delete a user*.

```sh
git add .
git commit -a
```
[Next: NextSteps](09-NextSteps.md)
