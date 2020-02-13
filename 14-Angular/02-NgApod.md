# NASA - Astronomy Picture of the Day

## Create an Angular App

This app will allow a user to view a random APOD via NASA's REST API.

Install the angular shell and check the installed version.

```sh
sudo npm install -g @angular/cli
ng version
```

Your Angular version should be 7.3.3 or higher.
```sh
Angular CLI: 7.3.3
Node: 10.14.1
OS: linux x64
```

[</> Code](https://github.com/microtrain/ng-apod/commit/c006f06a81ccb512631723bcaa30b9feb9f84b30) Create a new Angular project.
```sh
cd ~
ng new ng-apod
```

You will be asked two questions:
* Would you like to add Angular routing? (y/N) *Type the letter __y__ and press enter*
* Which stylesheet format would you like to use? *Depending on your options choose __Sass__ or __Scss__*

Start a dev server, this server will compile changes in real-time and provides live reload.
```sh
cd ng-apod
ng serve --open
```
If your browser did not automatically open, open a browser an navigate to *[http://localhost:4200](http://localhost:4200)* Open VSC and add *~/ng-apod* as a project folder.

Note the *src* directory this is the directory that runs the local web server, the *app* directory is the location of your application code. Open the file */src/index.html*, this is a template. All the code executed from within */src/app* is injected into the ```app-root``` tags of this page. Inside the *app* directory, the main files focus is on *app.component.html*, *app.component.css*, and *app.component.ts*.

* *app.component.html* - An HTML template for use by a component.
* *app.component.scss* - Style definitions for use by a component.
* *app.component.ts* - In Angular, code is broken down into components; the business logic of your app.

There is no need to commit your changes, Angular automatically creates the first commit. You can verify this by running ```git status```

```sh
git status
```

## Change the Application's Title

[</> Code](https://github.com/microtrain/ng-apod/commit/93b11d4e6f6d81888597eb93accb23c445e7dee8) Open *src/app/app.component.ts* and change the value of the ```title``` variable. In Angular every *.html* file has a corresponding *.ts*. The .ts file would execute in the same way as any JavaScript called that is called at the bottom of a normal .html page.

```ts
export class AppComponent {
  title = 'NASA APOD';
}
```

Commit your change
```sh
# Changed the page title
git add .
git commit -a
```

In the browser return to *[http://localhost:4200](http://localhost:4200)* and you'll see the message *"Welcome to APOD!"*

Now open the file */src/app/app.component.html* and take note of the double curly braces ```{{ title }}``` double curly braces in an Angular template allows for interpolation (the injection of a variable into the HTML page). Public instance variables and methods set in the corresponding ```.ts``` file will be available for injection in the template.

```html
<h1>
    Welcome to {{ title }}!
</h1>
```

## Understanding component.ts file

The *component.ts* files start with an import. The import looks for a given class from a given file location. The file path will either be relative or assume the node_modules directory. The example below assumes the file location to be *node_modules/@angular/core* and for some mechanism within *node_modules/@angular/core* to export the class *Component*


### Imports
```ts
import { Component } from '@angular/core';
```

You may also import from a file's relative to the current file. This example would look for *some-file* in the same directory as the file your calling from. Note the preceding ```./```.

```ts
import { SomeClass } from './some-file';
```

This example would look for *some-file* two directories above file your calling from. Note the preceding ```../../```.

```ts
import { SomeClass } from '../../some-file';
```

As a final example would look for *some-file* one directory and one directory down above file your calling from. Note the preceding ```../models/```.

```ts
import { SomeClass } from '../models/some-file';
```

### Decorators

[Decorators](https://www.typescriptlang.org/docs/handbook/decorators.html) allow additional properties to be applied to TypeScript/ES6 classes. 

All components have a component decorator. A component decorator is where we create the relationship between components, styles, and templates.

```ts
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
```

### Classes
All Angular components export a class. This class contains the business logic that powers a given component. This logic affects the _*.component.html_ file that is defined by _templateUrl_ in the component decorator.

```ts
export class AppComponent {
  //A public variable available for interpolation
  title:string = 'NASA APOD';

  //A private variable not available for interpolation
  private temp:string;;

  //A public method accessible from the HTML file
  setTemp(val): void{
    this.temp = val;
  }

  //A private method not accessible from the HTML file
  private process(): boolean{
    let x:boolean=false;
    if(this.temp == 'sunshine'){
      x=true;
    }
    return x;
  }
}
```

## The Apod component

[</> code](https://github.com/microtrain/ng-apod/commit/93b11d4e6f6d81888597eb93accb23c445e7dee8) Reusable components based on the single responsibility principle are the basis for Angular. Ideally, a component is a self-contained unit of executable code focused on a single task. We will create an Apod component geared towards displaying a given result from the APOD API. We will create our first component using the Angular CLI. This command will create a directory with four files and modify the *app.module.ts* file.

```sh
ng generate component apod
```

The output will be as follows.

![Create 4 files](/img/ng/gen-component.png)

We created a component called apod consisting of four files. These files will be written to a new directory *src/app/apod*

* apod.component.html - All HTML for a given component.
* apod.component.ts - The business logic that controls a components HTML file. 
* apod.component.scss - All styles that are unique to a given component.
* apod.component.spec.ts - Provides a unit testing for a given component.

Commit your changes
```
# Generate an Apod component
git add .
git commit -a
```

## Routing

[</> code](https://github.com/microtrain/ng-apod/commit/f621008cbb4d477b826bbf605d5190f9442c213b) We want our Apod component to load by default when we start the app. To do this we will utilize routing. The file *app-routing.module.ts* controls routing and was created for us when we generated the application shell. On creation, the file is as follows.

*src/app/app-routing.module.ts*
```ts
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
```

To create a route you will need to import the component you want to route to, add the path that will trigger a give route, and in our case redirect an empty route to a defined route.

```ts
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

// 1. import the component to which you want to redirect.
import { ApodComponent } from './apod/apod.component';

const routes: Routes = [
  //3. redirect an empty route to a given path
  { path: '', redirectTo: '/apod', pathMatch: 'full'},
  // 2. Define the path that will load a given component
  { path: 'apod', component: ApodComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
```

The app component always loads and the app loads into a given selector in *app.component.html*. Routes always load into a selector called *router-outlet* which was created when we generated the app. Open *app.component.html* and remove everything except for the router-outlet selector.

*src/app/app.component.html*
```html
<router-outlet></router-outlet>
```

At this point navigating to *[http://localhost:4200](http://localhost:4200)* will load the following page.
![Apod Works](/img/ng/apod-works.png)

Commit your changes
```sh
# Add apod routing
git add .
git commit -a
```

## Model the Apod data
[</> code](https://github.com/microtrain/ng-apod/commit/f621008cbb4d477b826bbf605d5190f9442c213b) TypeScript is all about data types. We are getting a data object back from the API and we will use that to create a data object. This data object will be of type Apod, for this to work we will need to define the properties of the Apod object. You can get all of the fields in the data object by making a curl request to the  endpoint or checking the API documentation.

```sh
curl https://api.nasa.gov/planetary/apod?api_key=xxxxx
```

Once you know what the data looks like you can build a model. All of the APOD can be defined as strings. 

While not required I would create a directory called models and place my *apod.ts* file in that directory.`
*src/app/models/apod.ts*
```ts
export class Apod {
  copyright:string;
  date:string;
  explanation:string;
  hdurl:string;
  media_type:string;
  service_version:string;
  title:string;
  url:string;
}
```

Commit your changes
```sh
# Add an Apod model
git add .
git commit -a
```

## Create a service
[</> code](https://github.com/microtrain/ng-apod/commit/f621008cbb4d477b826bbf605d5190f9442c213b) In Angular, data is accessed through service providers (a service). Services are used as a data access layer. This is where you will make a call to an API or a database. Your components will never interact directly with a data source; the interaction is done by the service. Since we are dealing with an API I will add my service to a directory called api. We will do this using the Angular CLI.

```sh
ng generate service api/apod
```

The output will be as follows.

![Generate a Service](/img/ng/gen-service.png)

We created a service called apod which created two files. These files will be written to a new directory *src/app/api*

* apod.service.ts - The service.
* apod.service.spec.ts - Provides unit testing for the service. 

The generate service is as follows.

*apod.service.ts*
```ts
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ApodService {

  constructor() { }
}
```

```sh
# Add an apod service
git add .
git commit -a
```

## Connect to the service

[</> code](https://github.com/microtrain/ng-apod/commit/f621008cbb4d477b826bbf605d5190f9442c213b) We have created a service, the next thing we will want to do is connect to it. I like to create create a simple method and connect to the service before implementing the details pf the service. This will make debugging the implementation details easier as I know the issue does not lie in connecting to the service. We will start by creating a method called ```getApod()``` that returns *Hello World*.

A method signature in Angular/TypeScript is as follows.
* method name - getApod
* arguments - ()
* return type - :string

```ts
  getApod(): string{
    return 'Hello World';
  }
```

Place the method inside ApodService class. 

*src/app/api/apod.service.ts*
```ts
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ApodService {

  constructor() { }

  getApod(): string{
    return 'Hello World';
  }

}
```

To connect the service to the component we will need to

* Import the service ```import { ApodComponent } from './apod/apod.component';```
* Inject the service into the constructor ```constructor(private apodService: ApodService) { }```
* Call the method getApod method from ```ngOnInit()```

The resulting component will be as follows.
*src/app/apod/apod.component.ts
```ts
import { Component, OnInit } from '@angular/core';

import { ApodService } from '../api/apod.service';

@Component({
  selector: 'app-apod',
  templateUrl: './apod.component.html',
  styleUrls: ['./apod.component.scss']
})
export class ApodComponent implements OnInit {

  constructor(private apodService: ApodService) { }

  ngOnInit() {
    console.log(this.apodService.getApod());
  }

}
```

At this point navigating *[http://localhost:4200](http://localhost:4200)* and pressing f12 will show Hello World in the console. 

![Hello World](/img/ng/hello-world.png)

```sh
# Connect the service and run a simple test
git add .
git commit -a
```

## Secure your NASA key

[</> code](https://github.com/microtrain/ng-apod/commit/a0ca4c099c8f5d85973f7c2260a0ffd99a650392) Again, never push an API key to a public repository. To do this we will create a .ts file with an export class from which we will export the key as a property of the class.

*~/config/ng-apod.config.ts*
```ts
export class NgApodConfig {
  key:string = 'xxxxx';
}
```

To use the key. we will need to add it to the providers' list in our app module.

* Import the config ```import { NgApodConfig } from '../../config/ng-apod.config';```
* List the config class as a provider ```providers: [NgApodConfig],```

*src/app.module.ts*
```ts
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ApodComponent } from './apod/apod.component';

// Relative import from the current directory to your PC's file system
import { NgApodConfig } from '../../config/ng-apod.config';

@NgModule({
  declarations: [
    AppComponent,
    ApodComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule
  ],
  providers: [
    NgApodConfig //Add as a provider
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
```

### Call the config file

We will then need to call the config file from our apod service.

* Import the service ```import { NgApodConfig } from '../../../config/ng-apod.config';```
* Inject the service into the constructor ```constructor(private ngApodConfig: NgApodConfig) { }```
* Access the key property from the NgApodConfig class ```return this.ngApodConfig.key;```

```ts
import { Injectable } from '@angular/core';

import { NgApodConfig } from '../../../config/ng-apod.config';

@Injectable({
  providedIn: 'root'
})
export class ApodService {

  constructor(private ngApodConfig: NgApodConfig) { }

  getApod(): string{
    return this.ngApodConfig.key;
  }

}
```

At this point navigating *[http://localhost:4200](http://localhost:4200)* and pressing f12 will show 'YOUR-API-KEY=XXXX' in the console. 

![Log the key](/img/ng/log-key.png)

```sh
# Connect the config file and run a simple test
git add .
git commit -a
```

## Connect to the API

[</> code](https://github.com/microtrain/ng-apod/commit/7702cc40f7d963a90ad25919ef3fd8895d831e6e) We are ready to connect to the API. The following steps are required to make this work.

* Make an HTTP connection
* Create an observable data stream
* Subscribe to the data stream
* Log the results

We will start by importing some HTTP libraries. The first library, HttpClientModule will be imported in to the app module.

*src/app.module.ts*
```ts
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

//Import HttpClientModule
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ApodComponent } from './apod/apod.component';

import { NgApodConfig } from '../../config/ng-apod.config';

@NgModule({
  declarations: [
    AppComponent,
    ApodComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule //import HttpClientModule
  ],
  providers: [
    NgApodConfig
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
```

The second and third libraries HttpClient and Observable will be imported into the apod service. HttpClient will be injected into the constructor and used in the ```getApod()``` method to make a GET request. ```getApod()``` will return an Observable stream that we can subscribe to from a component. In addition to the  libraries, we will import the Apod model. This will allow our Observable to be of type Apod. Without the Apod model, our observable could be of type any.

*src/api/apod.service.ts*
```ts
import { Injectable } from '@angular/core';
//Import HttpClient
import { HttpClient } from '@angular/common/http';

//Import Observable
import { Observable } from 'rxjs';

//Import Apod
import { Apod } from '../models/apod';

import { NgApodConfig } from '../../../config/ng-apod.config';

@Injectable({
  providedIn: 'root'
})
export class ApodService {

  private url:string

  constructor(
    private http: HttpClient,
    private ngApodConfig: NgApodConfig
  ) {
    this.url=`https://api.nasa.gov/planetary/apod?api_key=${this.ngApodConfig.key}`;
  }

  //Return an Observable Apod model
  getApod(): Observable<Apod>{
    //Make a get request over HTTP
    return this.http.get<Apod>(this.url);
  }

}
```

Finally, we will update ngOnInit() so that it subscribes to the ```getApod()``` method in the service.

*src/app/apod/apod.component.ts*
```ts
import { Component, OnInit } from '@angular/core';

import { ApodService } from '../api/apod.service';

@Component({
  selector: 'app-apod',
  templateUrl: './apod.component.html',
  styleUrls: ['./apod.component.scss']
})
export class ApodComponent implements OnInit {

  constructor(private apodService: ApodService) { }

  ngOnInit() {
    this.apodService.getApod().subscribe(
      (response:any)=>{
        console.log(response);
      }
    );
  }

}
```

At this point navigating *[http://localhost:4200](http://localhost:4200)* and pressing f12 will show 'NASA-API-JSON-Data' in the console. 

![API Request](/img/ng/api-request.png)

```sh
# Make an API request
git add .
git commit -a
```

## Refactor the component

[</> code](https://github.com/microtrain/ng-apod/commit/7702cc40f7d963a90ad25919ef3fd8895d831e6e) Refactor the component and load the results into an instance variable.

* Import the Apod model.
* Create the instance variable ```apod:Apod```.
* Move the ngOnInit() logic to a new method.
* Change the ```console.log()``` to a setter ```this.apod=response;```

*src/app/apod/apod.component.ts*
```ts
import { Component, OnInit } from '@angular/core';

import { ApodService } from '../api/apod.service';
import { Apod } from '../models/apod';

@Component({
  selector: 'app-apod',
  templateUrl: './apod.component.html',
  styleUrls: ['./apod.component.scss']
})
export class ApodComponent implements OnInit {

  apod:Apod;

  constructor(private apodService: ApodService) { }

  ngOnInit() {
    this.getApod();
  }

  getApod(): void{
    this.apodService.getApod().subscribe(
      (response:any)=>{
        this.apod = response;
      }
    );
  }

}
```

## Create a route to a given date

[</> code](https://github.com/microtrain/ng-apod/commit/7702cc40f7d963a90ad25919ef3fd8895d831e6e) Now that we can return today's APOD we will want to be able to provide a date. We will use a parameterized route to pass a date to the API. 


We will start by modifying the method signature of ```ApodService.getApod()``` to accept a date string. That date string will then be passed into the API call. 

*src/app/api/apod.service.ts*
```ts
getApod(date:string): Observable<Apod>{
  return this.http.get<Apod>(`${this.url}&date=${date}`);
}
```

Next we will focus on the apod component. We will start by passing the current date into the ```getApod()``` method.

*src/app/apod/apod.component.ts*
```ts
  getApod(): void{
    let date = new Date().toISOString().slice(0,10);

    this.apodService.getApod(date).subscribe(
      (response:any)=>{
        this.apod = response;
      }
    );

  }
```

At this point navigating *[http://localhost:4200](http://localhost:4200)* and pressing f12 will show 'NASA-API-JSON-Current-Date' in the Network 'apod?api-key=' console. 

Commit your changes
```sh
# Pass the current date to the API
git add .
git commit -a
```

[</> code](https://github.com/microtrain/ng-apod/commit/7702cc40f7d963a90ad25919ef3fd8895d831e6e) Now that the API can accept a date, we will use routing to pass a date to the API. Starting in the app routing module add a parameterized route ```{ path: 'apod/:date', component: ApodComponent }``` to the routes array. This will allow us to pass a date into the URL.
*src/app/app-routing.module.ts*
```ts
const routes: Routes = [
  { path: '', redirectTo: '/apod', pathMatch: 'full'},
  { path: 'apod', component: ApodComponent },
  { path: 'apod/:date', component: ApodComponent }
];
```

Now we will want to subscribe to the URL, this will make a new API call every time the URL changes. This will require the following steps.
* Import ActivatedRoute
* Inject ActivatedRoute into the constructor
* Subscribe to parameterized route
* Replace the current date with an updated method signature
* Log the results to the JS console

**
```ts
import { Component, OnInit } from '@angular/core';
//1. Import ActivatedRoute
import { ActivatedRoute } from '@angular/router';
import { ApodService } from '../api/apod.service';
import { Apod } from '../models/apod';

@Component({
  selector: 'app-apod',
  templateUrl: './apod.component.html',
  styleUrls: ['./apod.component.scss']
})
export class ApodComponent implements OnInit {

  apod:Apod;

  constructor(
    private apodService: ApodService,
    //2. Inject ActivatedRoute into the constructor
    private router: ActivatedRoute
  ) { }

  ngOnInit() {
    //3. Subscribe to parameterized route
    this.router.params.subscribe((params) => {
      this.getApod(params['date']);
    });
  }

  //4. Replace the current date with an updated method signature
  getApod(date:string): void{

    this.apodService.getApod(date).subscribe(
      (response:any)=>{
        this.apod = response;

        //5. Log the results to the JS console
        console.log(response);
      }
    );

  }

}
```

Navigate to [http://localhost:4200/apod/2019-02-24](http://localhost:4200/apod/2019-02-24) and check the JS console for a json object. Change the date in the URL and observe the changes in the JS console.

Commit your changes
```sh
# Accept the date from the URL
git add .
git commit -a
```
[</> code](https://github.com/microtrain/ng-apod/commit/2a56d6d87bee367de8da1a316b58d0ecfb8248cd) Now we will want the user to be able to multiple APODs. We will do this by providing a random date button in the applications UI. To accomplish this we will pass a random date into the routerLink attribute attached to the button. We will create a random date every time a new APOD loads, that date will be made accessible to the view. 

* Create date as an instance variable
* Create a method that returns a random date
* Update this.date on each API call
* Log this.date to the JS console

```ts
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ApodService } from '../api/apod.service';
import { Apod } from '../models/apod';

@Component({
  selector: 'app-apod',
  templateUrl: './apod.component.html',
  styleUrls: ['./apod.component.scss']
})
export class ApodComponent implements OnInit {

  apod:Apod;
  //1. Create date as an instance variable
  date:string;

  constructor(
    private apodService: ApodService,
    private router: ActivatedRoute
  ) { }

  ngOnInit() {
    this.router.params.subscribe((params) => {
      this.getApod(params['date']);
    });
  }

  getApod(date:string): void{

    this.apodService.getApod(date).subscribe(
      (response:any)=>{
        this.apod = response;
        //3.  Update this.date on each API call
        this.date = this.randomDate(new Date(1995,5,16), new Date());
        //4. Log this.date to the JS console
        console.log(this.date);
      }
    );

  }

  //2. Create a method that returns a random date
  randomDate(start, end): string{
    let date = new Date(
      start.getTime() + Math.random() *
        (end.getTime() - start.getTime())
    );

    return new Date(date).toISOString().slice(0,10);
  }

}
```

At this point, if you were to ```console.log(this.apod)``` without passing a date into the URL you'll get an error. Inspecting this error will reveal that the date has been set to undefined before passing it to the API. You can correct this in either the component or the service.

*src/app/apod/apod.component.ts*
```ts
getApod(date:string): void{

  //If the date is falsy, use today's date
  if(!date){
    date = new Date().toISOString().slice(0,10);
  }

  this.apodService.getApod(date).subscribe(
    (response:any)=>{
      this.apod = response;
      this.date = this.randomDate(new Date(1995,5,16), new Date());
      console.log(this.apod);
    }
  );

}
```

Commit your changes
```sh
# Create a random date for each successful APOD
git add .
git commit -a
```

## Build the initial view

[</> code](https://github.com/microtrain/ng-apod/commit/f4d197b6b679b398200d54e698859a6b4b29e3cd) Now we can start building our view. At this point interpolating apod.title into an h1 tag will display the APOD's title.

```html
<h1>{{ apod.title }}</h1>
```

However, the JS console will reveal an error stating apod.title is undefined.
![Undefined Title](/img/ng/undefined-title.png)

This is because of the asynchronous nature of JavaScript, the application is trying to build the view before the data is available (that's when it throws the error). Since we are subscribing to the data from an observable stream the application rebuilds the view when the data comes into scope. To prevent the undefined errors we can check for the existence of the data before trying to build the view. We can do this by Angular's if directive ```*ngIf="apod"``` to a containing element. Since 

```html
<main *ngIf="apod">
  <h1>{{ apod.title }}</h1>
</main>
```

```html
<main *ngIf="apod">

  <h1>{{ apod.title }}</h1>

  <!-- 
    Placing square brackets around an attribute creates a data binding. 
    Anything inside of the double quotes after the equals sign
    be treated as executable code.
  -->
  <img [src]="apod.url" [alt]="apod.title">

  <div>
    <!-- 
      Only select images have a copyright, if apod.copyright is 
      empty we will not attempt to show it
    -->
    <span *ngIf="apod.copyright">&copy; {{ apod.copyright }} </span>
    {{ apod.date }}
  </div>

  <p>{{ apod.explanation }}</p>

</main>
```


Commit your changes
```sh
# Display images and text descriptions
git add .
git commit -a
```

### SafePipe

[</> code](https://github.com/microtrain/ng-apod/commit/f4d197b6b679b398200d54e698859a6b4b29e3cd) At this point we can display images but not video. We can use the media_type attribute to determine if we need to call ```img``` or ```iframe```. Navigate to [http://localhost:4200/apod/2013-06-06](http://localhost:4200/apod/2013-06-06) and you will see a missing/broken image. That is because the APOD for this date is a YouTube video and YouTube videos are displayed in an ```iframe```.

```html
<main *ngIf="apod">

  <h1>{{ apod.title }}</h1>

  <!-- Only show the image element if the media_type is set to image -->
  <img *ngIf="apod.media_type==='image'" [src]="apod.url" [alt]="apod.title">

  <!-- Display and embed the YouTube video if the media_type is set to video -->
  <iframe *ngIf="apod.media_type==='video'" [src]="apod.url" frameborder="0" allowfullscreen></iframe>

  <div>
    <span *ngIf="apod.copyright">&copy; {{ apod.copyright }} </span>
    {{ apod.date }}
  </div>

  <p>{{ apod.explanation }}</p>

</main>
```

Now instead of a broken image tag, we have an empty block where the video would normally be. Our JS console shows a new error regarding unsafe resources.

![Undefined Title](/img/ng/unsafe.png)

Since iframes execute third party code they are generally considered unsafe, therefore Angular wants you to whitelist such sources before using them. You can read more about this feature by looking up the [DomSanitzer](https://angular.io/api/platform-browser/DomSanitizer). In short, you can write a [custom pipe](https://medium.com/@swarnakishore/angular-safe-pipe-implementation-to-bypass-domsanitizer-stripping-out-content-c1bf0f1cc36b) that will allow you to bypass the security settings. Fortunately, this has already been done for us, it is called [safe-pipe](https://www.npmjs.com/package/safe-pipe) and we can install it from NPM.

```sh
npm install --save safe-pipe
```

When you install a pipe you must import that pipe from your app module.

*src/app/app.module.ts*
```ts
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ApodComponent } from './apod/apod.component';

//Import the pipe from node_modules
import { SafePipeModule } from 'safe-pipe';

import { NgApodConfig } from '../../config/ng-apod.config';

@NgModule({
  declarations: [
    AppComponent,
    ApodComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    SafePipeModule //Add the pipe to your list of imports
  ],
  providers: [
    NgApodConfig
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
```

Now simply piping the results of apod.url into the safe pipe will allow the video to display.
```html
<iframe *ngIf="apod.media_type==='video'" [src]="apod.url | safe: 'resourceUrl'" frameborder="0" allowfullscreen></iframe>
```

Commit your changes
```sh
# Add SafePipe for YouTube embeds
git add .
git commit -a
```


## Add a random button
[</> code](https://github.com/microtrain/ng-apod/commit/e2da3484bfdaa46a73b6d5eb3b47035cc2d58809) To wrap-up our functionality we will add the Random button to our page. Will do this by binding routerLink to a button. At this point pressing the random button will load a new APOD.

```html
<button *ngIf="date" [routerLink]="['/apod', this.date]">Random</button>
```

Commit your changes
```sh
# Add the Random button
git add .
git commit -a
```

## Style the app

[</> code](https://github.com/microtrain/ng-apod/commit/3e4d5e228f6708ba83569a7f9645dc77479c63b7) Start by wrapping the ```iframe``` in a div with an id of video. Then adding ```class="copy"``` to the copyright span.

*src/app/apod/apod.component.html*
```html
<div id="video" *ngIf="apod.media_type==='video'">
  <iframe [src]="apod.url | safe: 'resourceUrl'" frameborder="0" allowfullscreen></iframe>
</div>

<div>
  <span *ngIf="apod.copyright" class="copy">&copy; {{ apod.copyright }} </span>
  {{ apod.date }}
</div>
```

Update the scss file with the following.

*src/app/apod/apod.component.scss*
```scss
@import url('https://fonts.googleapis.com/css?family=Orbitron');
@import url('https://fonts.googleapis.com/css?family=Roboto');

*{
  font-family: 'Orbitron', sans-serif;
}

p {
  font-family: 'Roboto', sans-serif;
  font-size: 1.3rem;
}

main{
  width: 800px;
  max-width: 100%;
  margin: 0 auto;
}

img{
  width: 100%;
  max-width: 100%;
}

button {
  width: 100%;
  display: block;
  background: #ff1493;
  border: none;
  border-radius: 4px;
  font-size: 1.5rem;
  padding: 1rem 0;
  text-align: center;
  color: #fff;
  cursor: pointer;
  font-weight: bold;
}

.copy{
  font-weight: bold;
  margin: 1rem 0;
}

#video {
	position: relative;
	padding-bottom: 56.25%;
	padding-top: 25px;
	height: 0;
}

iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}
```

Commit your changes
```sh
# Style the app
git add .
git commit -a
```

## Build a production package

[</> code](https://github.com/microtrain/ng-apod/commit/2a50006ba0489c102a7cf4829830d77ae5f09a03) Find the file *src/angular.json* and follow the JSON objects the tree until you get to your build options *project > architect > build > options*.

Update your build options as follows.

* add a new option ```"baseHref": "/ng-apod/",```
* change the outputPath ```"outputPath": "/var/www/ng-apod",```

Changing the output path will allow the build process to write the distribution package to any directory you want. You could write this into the webroot of an existing project or simply write it to the webroot of your local server as demonstrated below. 

```json
"options": {
  "baseHref": "/ng-apod/",
  "outputPath": "/var/www/ng-apod",
  "..."
}
```

Now use the Angular CLI to build a production package.

```sh
ng build --prod
```

Navigating to [http://localhost/ng-apod](http://localhost/ng-apod) will show a working application.


Commit your changes
```sh
# Build a production package
git add .
git commit -a
```

## Add deep links

[</> code](https://github.com/microtrain/ng-apod/commit/06eb8b4a9994a012982263d7d1c1e7b3cd678c7c) As I said, navigating to [http://localhost/ng-apod](http://localhost/ng-apod) will show a working application. Clicking on the Random button will show a random APOD. Refreshing the URL will show a Page Not Found error. The question now is why does it stop working? This is because Apache is looking for a file structure. When you navigate to */ng-apod* the server loads */ng-apod/index.html* which in turn loads the Angular application. Clicking the Random button changes the URL, the app detects the change in URL and reads in the date params. This all happens in JavaScript once the Angular application is up and running, the page never reloads, thus it does not make a new HTTP request. Once I reload the page, the browser requests /ng-apod/apod/2013-06-06 and since this is a full HTTP request Apache tries to resolve the full path looking for an index.html file under a directory called 2013-06-06. This bypasses /ng-apod/index.html meaning the Angular app never has a chance to load. We can resolve this by adding the concept of HashStrategy to our routes. Instead of /ng-apod/apod/2013-06-06 we will route to /ng-apod/#/apod/2013-06-06. The server cannot read the hashtag or anything after it, this means we can deep link into the app and always load /ng-apd/index.html. The good news we can do this with only two lines of code.

* ```import { LocationStrategy, HashLocationStrategy } from '@angular/common';```
* Add the following declaration to your providers list ```{ provide: LocationStrategy, useClass: HashLocationStrategy }```

*src/app.module.ts*
```ts
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
//Import LocationStrategy, HashLocationStrategy
import { LocationStrategy, HashLocationStrategy } from '@angular/common';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ApodComponent } from './apod/apod.component';

import { SafePipeModule } from 'safe-pipe';

import { NgApodConfig } from '../../config/ng-apod.config';

@NgModule({
  declarations: [
    AppComponent,
    ApodComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    SafePipeModule
  ],
  providers: [
    NgApodConfig,
    //Update your providers list
    { provide: LocationStrategy, useClass: HashLocationStrategy }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
```

Rebuild the production app

```sh
ng build --prod
```

Now you will be able to deep link onto your app [http://localhost/ng-apod/#/apod/2010-07-07](http://localhost/ng-apod/#/apod/2010-07-07).

Commit your changes
```sh
# Add hash strategy to your routing
git add .
git commit -a
```

## Progress Web App (PWA)

[</> code](https://github.com/microtrain/ng-apod/commit/fcb68b8cfd524a3122d57517216d576b1cb20310) A Progressive Web App (PWA) is an HTML5 application that can be installed on a mobile device without requiring the use of an app store. There are three core requirements for a PWA: a manifest file

   

https://angular.io/guide/service-worker-getting-started


```sh
ng add @angular/pwa
```

Update *manifest.webmanifest* previously manifest.json

*src/manifest.webmanifest*
```json
  "name": "NASA APOD",
  "short_name": "NASA",
  "theme_color": "#1976d2",
  "background_color": "#fafafa",
  "display": "standalone",
  "scope": "/ng-apod/",
  "start_url": "index.html",
```


Add Apple Touch Icons

The PWA tool we just ran creates a few icons and creates a manifest that will load these icons where applicable. Sadly, Safari does not yet support loading icons from a manifest. If you want your PWA to load the proper icon on IOS then you will need to add a few ```apple-touch-icon``` tags to the head of your HTML document. You could create new icons, each perfectly sized to every apple device, or you ballpark it and scale down using the images we have. Either option is fine in my opinion. I recommend the following thread [Is there any need for the 6 different apple-touch icons when just one will work?](https://github.com/h5bp/html5-boilerplate/issues/1367). Builder offers a free [App Image Generator](https://www.pwabuilder.com/imageGenerator) should you want to create every possible icon for all devices. I recommend running the at least once and exam the assets to get a real feel for all the different devices out there.

Place the following in the head of *src/index.html*

*src/index.html*
```html
  <!-- iPhone(first generation or 2G), iPhone 3G, iPhone 3GS -->
  <link rel="apple-touch-icon" sizes="57x57" href="assets/icons/icon-72x72.png">
  <!-- iPad and iPad mini @1x -->
  <link rel="apple-touch-icon" sizes="76x76" href="assets/icons/icon-96x96.png">
  <!-- iPhone 4, iPhone 4s, iPhone 5, iPhone 5c, iPhone 5s, iPhone 6, iPhone 6s, iPhone 7, iPhone 7s, iPhone8 -->
  <link rel="apple-touch-icon" sizes="120x120" href="assets/icons/icon-128x128.png">
  <!-- iPad and iPad mini @2x -->
  <link rel="apple-touch-icon" sizes="152x152" href="assets/icons/icon-192x192.png">
  <!-- iPad Pro -->
  <link rel="apple-touch-icon" sizes="167x167" href="assets/icons/icon-192x192.png">
  <!-- iPhone X, iPhone 8 Plus, iPhone 7 Plus, iPhone 6s Plus, iPhone 6 Plus -->
  <link rel="apple-touch-icon" sizes="180x180" href="assets/icons/icon-192x192.png">
```

Finally, change the title tag in the head of the HTML document to match the name element.

*src/index.html*
```html
  <title>NASA Apod</title>
```

With your mobile device and laptop on the same WIFI network. Run ```ifconfig``` to get your IP Address. From your device navigate to your laptops IP Address and click on the ng-apod folder.

* On Android, you will be prompted to install the PWA.
* On IOS you can install a PWA by tapping the share icon followed by "Add to Home Screen".
* Once the PWA is installed it will behave like a normal app.

Technically this app is running in offline mode meaning you do not need a connection to the server but you will need an Internet connection to complete the API requests.

Commit your changes
```sh
# Package the app as a PWA
git add .
git commit -a
```

## Summary

In this section you 
* Learned the basics of Angular
* Built an Angular application that interacts with an API
* Packaged and Launched a PWA

## Additional Resources

* [Tour of Heros](https://angular.io/docs/ts/latest/tutorial/)
* [Angular Docs](https://angular.io/docs)

[Next: Tour of Heroes](03-TourOfHeroes.md)
