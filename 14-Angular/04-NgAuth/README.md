# NgAuth - Authentication via REST API

## Create an Angular App

This app will allow a user to login and out of your ExpressJS app using an Angular application that connects to the API.

Install the angular shell and check the installed version.

Create a new Angular project.
```sh
cd ~
ng new ng-auth
```

You will be asked two questions:
* Would you like to add Angular routing? (y/N) *Type the letter __y__ and press enter*
* Which stylesheet format would you like to use? *Depending on your options choose __Sass__ or __Scss__*

Start a dev server, this server will compile changes in real-time and provide live reload.
```sh
cd ng-auth
ng serve --open
```

In the browser return to *[http://localhost:4200](http://localhost:4200)* and you'll see the message *"Welcome to NgAuth!"*

## Create the components.

This project will require 3 components: login, logout, and register.

```sh
ng generate component login
ng generate component logout
ng generate component register
```

As with the APOD project each of these components will be created in their own directory each containing 4 files. The resulting structure will look something like this.
```
+-- app
|   +-- login
|   |   +-- login.component.html
|   |   +-- login.component.scss
|   |   +-- login.component.spec.ts
|   |   +-- login.component.ts
|   +-- logout
|   |   +-- logout.component.html
|   |   +-- logout.component.scss
|   |   +-- logout.component.spec.ts
|   |   +-- logout.component.ts
|   +-- register
|   |   +-- register.component.html
|   |   +-- register.component.scss
|   |   +-- register.component.spec.ts
|   |   +-- register.component.ts
```

Commit your changes
```
# Generate login, logout, and register components
git add .
git commit -a
```

## Routing

We will need to be able to route to each of our new components. To do this we will import each component and add them to our routing file.

*/src/app/app-routing.module.ts*
```ts
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LoginComponent } from './login/login.component';
import { LogoutComponent } from './logout/logout.component';
import { RegisterComponent } from './register/register.component';

const routes: Routes = [
  { path: '', redirectTo: '/login', pathMatch: 'full'},
  { path: 'login', component: LoginComponent },
  { path: 'logout', component: LogoutComponent },
  { path: 'register', component: RegisterComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
```

Remove most of the placeholder content from app.component.html leaving only the router-outlet tag.

*/src/app/component.html*
```html
<router-outlet></router-outlet>
```

Now routing to [http://localhost:4200](http://localhost:4200) will redirect to [http://localhost:4200/login](http://localhost:4200/login). From there you can navigate to [http://localhost:4200/logout](http://localhost:4200/logout) and [http://localhost:4200/register](http://localhost:4200/register) will display **"login works!"**, **"logout works!"**, and **"register works!"** respectively.

Commit your changes
```
# Route to the login, logout, and register components
git add .
git commit -a
```

## Users model

The only data we are working with is a user. To determine the fields our app will need to work with and create a user object (aka, schema or model).

*/src/app/models/user.ts*
```ts
export class User{
  email:string;
  username:string;
  first_name:string;
  last_name:string;
  password:string;
}
```

Commit your changes
```
# Add a user object
git add .
git commit -a
```

## Users service

Now that we have a data model we can use it to retrieve data from an API. For this, we will want to create a service.

```ts
ng generate service services/user
```

Once a service has been generated I like to add a test method. This is a simple method that does little more than a return a string. I'll connect this to a service and call the test method. If this returns a result I know I have everything wired up correctly. By making small changes and testing these changes, you will save yourself some debugging headaches. 

Add a test method to the generated service.

*/src/app/services/user.service.ts*
```ts
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor() { }

  test(): string{
    return 'success!';
  }
}
```

Wire the service up to the login component and call the test method. We will use a ```console.log()``` to call the test method from the constructor. 

*/src/app/login/login.component.ts*
```ts
import { Component, OnInit } from '@angular/core';
// 1. Import the service
import { UserService } from '../services/user.service';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  // 2. Inject the service into the constructor
  constructor(private userService: UserService) {

    // 3. Call the test method from the service
    console.log(this.userService.test());
  }

  ngOnInit() {}

}
```

Navigating to [http://localhost:4200](http://localhost:4200) and exploring the JS console will reveal the following.

![Error!](/img/ng/auth/cors_error.png)

### Updating CORS Policy

Although we have successfully connected our service to the login component. We are requesting resources ```Users``` from a different domain. CORS is industry standard for accessing web resources on different domains. It is a very important security concept implemented by web browers to prevent Javascript or CSS code from making requests against a different origin.

Since our app is acting as a client making and HTTP request to localhost:3000, we will start by adding a ```CORS Policy``` to *app.js*. This statement should be added above the whitelist *~/mean.example.com/app.js* around line ~78.

*~/mean.example.com/app.js*
```js
//Set up CORS
app.use(function(req, res, next) {
  res.header('Access-Control-Allow-Credentials', true);
  res.header("Access-Control-Allow-Origin", "*");
  res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
  res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept');
  if ('OPTIONS' == req.method) {
    res.send(200);
  } else {
    next();
  }
});
```
Stop and restart ```ng-serve --open```
Navigating to [http://localhost:4200](http://localhost:4200) and exploring the JS console will reveal the following.

![Success](/img/ng/auth/success.png)

Commit your changes
```
# Create and test
git add .
git commit -a
```


### Implement the service

Now that we have successfully connected our service to the login component. We can begin implementing the details.

Since our app is acting as a client making and HTTP request, we will start by adding the ```HttpClientModule``` to *app.module.ts*.


*/src/app/app.module.ts*
```ts
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
// 1. Import the app module
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { LogoutComponent } from './logout/logout.component';
import { RegisterComponent } from './register/register.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    LogoutComponent,
    RegisterComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    // 2. Add the module to the list of imports.
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }

```

Commit your changes
```
# Import HttpClientModule
git add .
git commit -a
```

Importing HttpClientModule at the AppModule level gives us access to HttpClient in the lower levels of the system. For our service provider to work we will need to import HttpClient and inject it into the constructor, import Observable from the RxJS library and finally, import the User model.

*/src/app/services/user.service.ts*
```ts
import { Injectable } from '@angular/core';
// 1. Import HttpClient
import { HttpClient } from '@angular/common/http';

// 2. Import Observable 
import { Observable } from 'rxjs';


// 3. Import User
import { User } from '../models/user';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(
    // 5. Inject HttpClient into the constructor
    private http:HttpClient
  ) { }

  test(): string{
    return 'success!';
  }
}
```

Once we have imported all the objects we will be working with, we can establish an HTTP connection.

*/src/app/services/user.service.ts*
```ts
  //Return an Observable array or User objects
  test(): Observable<User[]>{
    let url = 'http://localhost:3000/api/users'
    //Make a get request over HTTP
    return this.http.get<User[]>(url);
  }
```

Update the constructor so that it subscribes to the test method. 
*/src/app/login/login.component.ts*
```ts
  constructor(private userService: UserService) {
    this.userService.test().subscribe(
      (response)=>{
        console.log(response);
      }
    );
  }
```

For this test go the *~/mean.example.com/app.js* and turn off the whitelist. Start the stack and load [http://localhost:4200/login](http://localhost:4200/login). Check your JS console, if everything is working you will see something like the following. This tells us we can connect to the API at this point we can turn the whitelist login on and implement the authentication functionality.

![API Success](/img/ng/auth/api-success.png)

```sh
# Successful API connection
git add .
git commit -a
```

Now that we know we can connect to the API, let's convert our test logic to functional code. There are a few things we will need to do for our service.
1. Import HttpHeaders, this will allow us to POST JSON data.
2. Create a JSON header, this will be appended to our HTTP request.
3. Add URL as an instance variable.
4. Change test() to login() and accept a user object as an argument.
5. Expect a User object instead of an array of User objects.
6. Change from a GET to a POST request.
7. Pass the user object and the HTTP headers into the POST request.

*src/app/services/users.service.ts*
```ts
import { Injectable } from '@angular/core';
// 1. Import HttpHeaders, this will allow us to POST JSON data
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable } from 'rxjs';

import { User } from '../models/user';

// 2. Create a JSON header
const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class UserService {
  // 3. Add URL as an instance variable
  private url:string = 'http://localhost:3000/api/auth';

  constructor(
    private http:HttpClient
  ) { }

  // 4. Change test() to login() and accept a user object as an argument
  // 5. Expect a User object instead of an array of User objects
  // 6. Change from a GET to a POST request
  // 7. Pass the user object and the HTTP headers into the POST request
  login(user: User): Observable<User> {
    return this.http.post<User>(`${this.url}/login`, user, httpOptions);
  }
}
```

Now, a few tweaks to the LoginComponent and we can test a full post request. 
1. Import the user model
2. Instantiate a new user
3. Add a login method
4. Call the login method in the constructor

*/src/app/login/login.component.ts*
```ts
import { Component, OnInit } from '@angular/core';

import { UserService } from '../services/user.service';
// 1. Import the user model
import { User } from '../models/user';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  // 2. Instantiate a new user
  user:User = new User();

  // 4. Call the login method in the constructor
  constructor(private userService: UserService) {
    this.login();
  }

  ngOnInit() {}

  // 3. Add a login method
  login(): void{

    this.user.username = 'testuser5';
    this.user.password = 'test123';

    this.userService.login(this.user).subscribe(
      (response)=>{
        console.log(response);
      }
    );
  }

}
```

For this test go the *~/mean.example.com/app.js* and turn off the whitelist. Start the stack and load [http://localhost:4200/login](http://localhost:4200/login). Check your JS console, if everything is working you will see something like the following. This tells us we can connect to the API at this point we can turn the whitelist logic back on and implement the authentication functionality.

![Login Success](/img/ng/auth/login-success.png)


Now we are ready to build the login form. We will start by updating the component. We will remove the constructor's implementation as well as the hardcoded credentials from the ```login()``` method.

*/src/app/login/login.component.ts*
```ts
import { Component, OnInit } from '@angular/core';

import { UserService } from '../services/user.service';

import { User } from '../models/user';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  user:User = new User();

  // 1. Remove the login call from the constructor
  constructor(private userService: UserService) {}

  ngOnInit() {}

  login(): void{

    // 2. Remove the hardcoded credentials
    this.userService.login(this.user).subscribe(
      (response)=>{
        console.log(response);
      }
    );
  }

}
```

Now we can build the login form by completing the following tasks.

1. Import FormsModule to allow for two-way binding
2. Add a form to login.component.html
3. Style the form via login.component.scss 
4. Update the user service
5. Update the login component

*src/app/app.module.ts*
```ts
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
// 1. Import FormsModule 
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { LogoutComponent } from './logout/logout.component';
import { RegisterComponent } from './register/register.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    LogoutComponent,
    RegisterComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    // 2. Add FormsModule to the imports list
    FormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
```

*src/app/services/user.service*
```ts
import { Injectable } from '@angular/core';
// 1. Import HttpHeaders
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable } from 'rxjs';

// 2. Import the User object (model)
import { User } from '../models/user';

// 3. Create a JSON header to be attached to outbound post requests
const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class UserService {
  // 4. Set the domain portion of the url
  private url:string = 'http://localhost:3000/api/auth';

  constructor(
    private http:HttpClient
  ) { }

  // 5. Replace the test method with a working implementation of login.
  login(user: User): Observable<User> {
    return this.http.post<User>(`${this.url}/login`, user, httpOptions);
  }
}
```

*src/app/login/login.component.ts*
```ts
import { Component, OnInit } from '@angular/core';

import { UserService } from '../services/user.service';

// 1. Import the User object (model)
import { User } from '../models/user';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  // 2. Create a new instance of the User object
  user:User = new User();
  // 3. Instantiate an errors array
  error: any;

  // 4. Clear out the contructor login
  constructor(private userService: UserService) {}

  ngOnInit() {}

  // 5. Add a login method
  login(): void{

    this.userService.login(this.user).subscribe(
      (response:any)=>{
        console.log(response);

        if(response.success == false){
          this.error=true;
        }

      }
    );
  }

}
```

*src/app/login/login.component.html*
```html
<form (ngSubmit)="login()">

  <div *ngIf="error" class="alert-error">Invalid Credentials</div>

  <label>Username</label>
  <input [(ngModel)]="user.username" name="username">

  <label>Password</label>
  <input [(ngModel)]="user.password" name="password">

  <input type="submit">
</form>
```

If you provide submit valid credentials to the server you will receive a success 
message. 

![Success!](/img/ng/auth/success.png)

Despite successful authentication, you will not be able to create an active 
session. To do this your application needs to be served from the same domain.
We have been running Angular in development mode (aka, the dev environnement). 
This is OK for building applications but at some point, you need to do a 
production build using the `ng build` command. By default, this builds into the 
`dist` directory. We can do a build, make a few tweaks, then move the production
code to the dev environment or we can configure our build to do that for us.
 
Add the following lines to *angular.json*

You will be adding these lines to the options object of the architect object of 
the projects object.

*angular.json - projects > architect > options*. 

```json
"baseHref": "/ng-auth/",
"outputPath": "/home/dev/mean.example.com/public/ng-auth",
```

![angular.json](/img/auth/angular_json.png)

Now that you have updated the angular.json file you can run a production build.

```sh
ng build --prod
```

Navigating to [http://localhost:3000/ng-auth/login](http://localhost:3000/ng-auth/login)
will now allow you authenticate your credentials and create a session.

If you so choose, you can (1) build out the registration and logout components, (2) integrate ng-auth into mean stack's login endpoint, (3) point the login link to the Angular app, or (4) forget about this app altogether.

1. Use the knowledge gained in the previous lessons to build the remaining functionality.
1. Using the index.html file found in *~/mean.example.com/public/ng-auth* add an element called `app-root` to a target pug file. This may be login.pug. Once the element has been applied, link to the CSS and JS files as shown in index.html.
1. Change the link in layout.pug to point the ng-auth.
1. We will cover this again in Ionic, so there will another opportunity to review.




