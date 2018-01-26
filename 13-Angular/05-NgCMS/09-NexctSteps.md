# Next Steps

*src/app/app.component.html*
```html
<nav>
  <button [routerLink]="['/users']">Users</button>
  <button [routerLink]="['/users/create']">New User</button>
  <button>Posts</button>
  <button>New Post</button>
</nav>

<router-outlet></router-outlet>
```
