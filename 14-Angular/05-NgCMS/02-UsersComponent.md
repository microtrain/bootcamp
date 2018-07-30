# Users Component

We know we want to display a list of users, so let's start by creating a users component.

Create the users component
```sh
ng generate component users
```

Bring the users component into scope, to do this we will replace the contents of *src/app/users/app.component.html* with the following.

*src/app/users/app.component.html*
```js
<app-users></app-users>
```

At this point navigating to [https://localhost:4200](https://localhost:4200) should resolve a page stating "users works!".

**Commit your changes** with the message *Generated the users component*.

```sh
git add .
git commit -a
```

[Next: Schemas and Services](./03-SchemasAndServices.md)
