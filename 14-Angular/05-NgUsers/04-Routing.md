# Routing

Routing allows the URL to control the flow of the site.

The following will generate the file *src/app/app-routing.module.ts*.
> **DO NOT RUN THE FOLLOWING COMMAND** unless you have verified the file *src/app/app-routing.module.ts* to be missing.

```sh
ng generate module app-routing --flat --module=app
```

Update *src/app/app-routing.module.ts* with the following.

*src/app/app-routing.module.ts*
```js
import { NgModule }             from '@angular/core';

// 1. Routing Libraries
import { RouterModule, Routes } from '@angular/router';

// 2. Import the UserComponent
import { UsersComponent }   from './users/users.component';

// 3. Declare your routes
const routes: Routes = [
  // 4. The default route
  { path: '', redirectTo: '/users', pathMatch: 'full' },
  // 5. Map /users to the UsersComponent
  { path: 'users', component: UsersComponent }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
```

Update *src/app/app.component.html* with the following. This will provide an injection point for all components that accessible via routes.

```html
<router-outlet></router-outlet>
```

**Commit your changes** with the message *Implemented basic routing*.

```sh
git add .
git commit -a
```

[Next: User View Component](05-UserViewComponent.md)
