# Next Steps

Let's add some navigation and the components for creating content.

## Navigation
Add some navigation to the app component.

*src/app/app.component.html*
```html
<nav>
  <button [routerLink]="['/users']">Users</button>
  <button [routerLink]="['/users/create']">New User</button>
  <button>Articles</button>
  <button>New Article</button>
</nav>

<router-outlet></router-outlet>
```

## ArticlesComponent

Together, we've added the components for managing users. Now we will take that knowledge and apply it towards managing content, in this case, articles.

Generate ArticlesComponent
```sh
ng generate component articles
```

Add ArticlesComponent to routing.
```js
import { ArticlesComponent }   from './articles/articles.component';

const routes: Routes = [
  { path: '', redirectTo: '/users', pathMatch: 'full' },
  { path: 'users', component: UsersComponent },
  { path: 'users/view/:id', component: UserViewComponent },
  { path: 'users/create', component: UserCreateComponent },
  { path: 'users/edit/:id', component: UserEditComponent },
  { path: 'articles', component: ArticlesComponent }
];
```
## Create full CRUD for the articles API

At this point we have created the articles component and added it to routing.

1. Finish implementing the ArticlesComponent details.
1. Create a Article Schema - _src/app/article.ts_
1. Create ArticleService - _src/app/article.service.ts_
1. Create and route ArticleView - _src/app/article-view/*_
1. Create and route ArticleCreate - _src/app/article-create/*_
1. Create and route ArticleEdit - _src/app/article-edit/*_

## Style the application

Style the application anyway you like.

## User Authentication

* Tweak the mean.example.com API to allow full authentication via the API.
* Either add authentication components and services to the exisitng APP
or create a specific angular app for authentication.

[Next: NgCMS](/14-Angular/06-NgCMS.md)
