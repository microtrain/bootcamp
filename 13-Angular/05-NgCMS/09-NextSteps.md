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
ng generate component posts
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
## Create full CRUD for the posts API

At this point we have created the posts component and added it to routing.

1. Finish implementing the PostsComponent details.
1. Create a Post Schema - _src/app/post.ts_
1. Create a PostService - _src/app/post.service.ts_
1. Create and route PostView - _src/app/post-view/*_
1. Create and route PostCreate - _src/app/post-create/*_
1. Create and route PostEdit - _src/app/post-edit/*_
