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

````ts
export class AppComponent {
  title = 'NASA APOD';
}
```


Additional Resources

* [Tour of Heros](https://angular.io/docs/ts/latest/tutorial/)
* [Angular Docs](https://angular.io/docs)

[Next: Angular CMS](04-NgCMS/README.md)
