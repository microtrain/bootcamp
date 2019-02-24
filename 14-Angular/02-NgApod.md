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


Additional Resources

* [Tour of Heros](https://angular.io/docs/ts/latest/tutorial/)
* [Angular Docs](https://angular.io/docs)

[Next: Angular CMS](04-NgCMS/README.md)
