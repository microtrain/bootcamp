# Next Steps

## Navigation
Add some navigation to the app component.

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

## PostsComponent

Generate PostsComponent
```sh
ng generate component users
```

Add PostsComponent to routing.
```js
import { PostsComponent }   from './posts/posts.component';

const routes: Routes = [
  { path: '', redirectTo: '/users', pathMatch: 'full' },
  { path: 'users', component: UsersComponent },
  { path: 'users/view/:id', component: UserViewComponent },
  { path: 'users/create', component: UserCreateComponent },
  { path: 'users/edit/:id', component: UserEditComponent },
  { path: 'posts', component: PostsComponent }
];
```

