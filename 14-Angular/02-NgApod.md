# NASA - Astronomy Picture of the Day

## Create an Angular App

This app will allow a user to login and out of your ExpressJS app using an Angular application that connects to the API.

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

Create a new Angular project.
```sh
cd ~
ng new ng-apod
```

You will be asked two questions:
* Would you like to add Angular routing? (y/N) *Type the letter __y__ and press enter*
* Which stylesheet format would you like to use? *Depending on you options choose __Sass__ or __Scss__*

Start a dev server, this serve will compile changes in real time and live reload.
```sh
cd ng-apod
ng serve --open
```
If your browser did not automatically open, open a browser an navigate to *[http://localhost:4200](http://localhost:4200)* Open VSC and add *~/ng-apod* as a project folder.

Note the *src* directory this is the directory that runs the local webserver, the *app* directory is the location of your application code. Open the file */src/index.html*, this is an template. All the code executed from with in */src/app* is injected into the ```app-root``` tags of this page. Inside *app* the main files to focus on are *app.component.html*, *app.component.css*, and *app.component.ts*.

* *app.component.html* - An HTML template for use by a component.
* *app.component.scss* - Style definitions for use by a component.
* *app.component.ts* - In Angular, code is broken down into components; the business logic of your app.

## Change the Application's Title

Open *src/app/app.component.ts* and change the value of the ```title``` variable. In Angular every *.html* file has a corresponding *.ts*. The *.ts* file would execute like the JavaScript called at the bottom of a normal *.html* page.

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

The *component.ts* files start with an import. The import looks for a given class from a given file location. The file path will either be relative or assume the node_modules directory. The example below assumes the file location to be *node_modules/@angular/core* and for some mechanism within core to export the class *Component*


### Imports
```ts
import { Component } from '@angular/core';
```

You may also import from file relative to the current file. This example would look for *some-file* in the same directory as the file your calling from. Note the preceding ```./```.

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

All components have a component decorator _component decorator_ is where we create the relationship between components, styles and templates.

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

  //A public method accessible from the html file
  setTemp(val): void{
    this.temp = val;
  }

  //A private method not accessible from the html file
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

Reusable components based on the single responsibility principle are the basis for Angular. Ideally, a component is a self contained unit of executable code focused on a single task. We will create an Apod component geared towards displaying a given result from the APOD API. We will create our first component using the Angular CLI. This command will create a directory with four files and modify the *app.module.ts* file.

```sh
ng generate component apod
```

The output will be as follows.
![Create 4 files](/img/ng/gen-component.png)

We created a component called apod consisting of four files. These files will be written to a new directory *src/app/apod*

* apod.component.html - All HTML for a given component.
* apod.component.ts - The business logic that controls a components html file. 
* apod.component.scss - All styles that are unique to a given component.
* apod.component.spec.ts - Provides a unit testing for a given component.

Commit your changes
```
# Generate an Apod component
git add .
git commit -a
```

## Routing

We want our Apod component to load by default when we start the app. To do this we will utilize routing. The file *app-routing.module.ts* controls routing and was created for us when we generated the application shell. On creation the file is as follows.

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

The app component always loads and the app loads in to a given selector in *app.component.html*. Routes always load into a selector called *router-outlet* which was created when we generated the app. Open *app.component.html* and remove everything with the exception of the router-outlet selector.

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
TypeScript is all about data types. We are getting a data object back from the API and we will use that to create a data object. This data object will be of type Apod, for this to work we will need to define the properties of the Apod object. You can get all of the fields in the data object by making a curl request to the  endpoint or checking the API documentation.

```sh
curl https://api.nasa.gov/planetary/apod?api_key=xxxxx
```

Once you know what the data looks like you can build a model. All of the APOD can can be defined as strings. 

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
# Add a Apod model
git add .
git commit -a
```

## Create a service
In Angular, data is accessed through service providers (a service). Services are used asa data access layer. This is where you will make a call to an API or a databases. Your components will never interact directly with a datasource; interaction is the job of the service. Since we are dealing with an API I will add my service to a directory called api. We will do this using the Angular CLI.

```sh
ng generate service api/apod
```

The output will be as follows.
![Apod Works](/img/ng/apod-works.png)

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

We have created a service, the next thing we will want to do is connect to it. I like to create create a simple method and connect to the service prior to implementing the details. This will make debugging the implementation details easier as I know the issue does not lie in connecting to the service. We will start by creating a method called ```getApod()``` that returns *Hello World*.

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

*src/api/apod.service.ts*
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

To connect the service to the the component we will need to

* Import the service ```import { ApodComponent } from './apod/apod.component';```
* Inject the service into the constructor ```constructor(private apodService: ApodService) { }```
* Call the method getApod method from ```ngOnInit()```

The resulting component will be as follows.
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

Again, never push an API key to a public repository. To do this we will create a .ts file with and export class from which we will export the key as a property of the class.

*~/config/ng-apod.config.ts*
```ts
export class NgApodConfig {
  key:string = 'xxxxx';
}
```

In order to use the key we will need to add it to the providers list in our app module.

* Import the config ```import { NgApodConfig } from '../../../config/ng-apod.config';```
* List the config class as a provider ```providers: [NgApodConfig],```

```ts
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ApodComponent } from './apod/apod.component';

// Relative import from the current directory to your PC's file system
import { NgApodConfig } from '../../../config/ng-apod.config';

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

## Call the config file

We will then need to call the config file from our apod service.

* Import the service ```import { NgApodConfig } from '../../../../config/ng-apod.config';```
* Inject the service into the constructor ```constructor(private ngApodConfig: NgApodConfig) { }```
* Access the key property from the NgApodConfig class ```return this.ngApodConfig.key;```

```ts
import { Injectable } from '@angular/core';

import { NgApodConfig } from '../../../../config/ng-apod.config';

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

At this point navigating *[http://localhost:4200](http://localhost:4200)* and pressing f12 will show Hello World in the console. 

![Log the key](/img/ng/log-key.png)

```sh
# Connect the config file and run a simple test
git add .
git commit -a
```

## Connect to the API

We are ready to connect to the API. The following steps are required to make this work.

* Make an HTTP connection
* Create an observable data stream
* Subscribe to the data stream
* Log the results

We will start by importing some HTTP libraries. The first library HttpClientModule, will be imported in to the app module.

*src/app.module.ts*
```ts
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

//Import HttpClientModule
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ApodComponent } from './apod/apod.component';

import { NgApodConfig } from '../../../config/ng-apod.config';

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

The second and third libraries HttpClient and Observable, will be imported in to the apod service. HttpClient will be injected into constructor and used in the ```getApod()``` method to make a GET request. ```getApod()``` will return an Observable stream that we can subscribe to from a component. In addition to the  libraries we will import the Apod model. This will allow our Observable to be of type Apod. Without the Apod model our observable could be of type any.

*src/api/apod.service.ts*
```ts
import { Injectable } from '@angular/core';
//Import HttpClient
import { HttpClient } from '@angular/common/http';

//Import Observable
import { Observable } from 'rxjs';

//Import Apod
import { Apod } from '../models/apod';

import { NgApodConfig } from '../../../../config/ng-apod.config';

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

At this point navigating *[http://localhost:4200](http://localhost:4200)* and pressing f12 will show Hello World in the console. 

![API Request](/img/ng/api-request.png)

```sh
# Make an API request
git add .
git commit -a
```

## Refactor the component

Refactor the component and load the results into an instance variable.

* Import the Apod model.
* Create the instance variable ```apod:Apod```.
* Move the ngOnInit() logic to it's own method.
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

## Route to a given date

Now that we can return the today's APOD we will want to be able to provide a date. We will use a parameterized route to pass to pass a date to the API. 


We will start by modifying the method signature of ```ApodService.getApod()``` to accept a date string. That date string will then be passed into the API call. 

*src/app/api/apod.service.ts*
```ts
getApod(date:string): Observable<Apod>{
  return this.http.get<Apod>(`${this.url}&date=${date}`);
}
```

Next we will focus on the apod component. We will start by passing the current date into the ```getApod()``` method.

*src/app/apod/apod.service.ts*
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

Commit your changes
```sh
# Pass the current date to the API
git add .
git commit -a
```

Now that the API can accept a date, we will use routing to pass a date to the API. Starting in app routing module add a parameterized route ```{ path: 'apod/:date', component: ApodComponent }``` to the routes array. This will allow us to pass a date into the URL.
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
Finally we will want the  the user to be able to multiple APODs. We will do this by providing a random date button in the applications UI. To accomplish this we will pass a random date into the a routerLink attached to the button. We will create a random date every time a new APOD loads and make that date available to the view. 

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







## Build the initial view





Additional Resources

* [Tour of Heros](https://angular.io/docs/ts/latest/tutorial/)
* [Angular Docs](https://angular.io/docs)

[Next: Angular CMS](04-NgCMS/README.md)
