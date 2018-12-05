# NASA - Astronomy Picture of the Day

## Create the Application Shell.

This app will allows a user to connect to the NASA Apod API.

Install the angular shell

```sh
sudo npm install -g @angular/cli
cd ~
ng new ng-apod
cd ng-apod
ng serve --open
```

If your browser did not automatically open, open a browser an navigate to *[http://localhost:4200](http://localhost:4200)* Open VSC and add *~/ng-apod* as a project folder.

Note the *src* directory this is the directory that runs the local webserver, the *app* directory is the location of your application code. Open the file */src/index.html*, this is an template. All the code executed from with in */src/app* is injected into the ```app-root``` tags of this page. Inside *app* the main files to focus on are *app.component.html*, *app.component.css*, and *app.component.ts*.

* *app.component.html* - An HTML template for use by a component.
* *app.component.css* - Style definitions for use by a component.
* *app.component.ts* - In Angular, code is broken down into components; the business logic of your app.

### Change the application's title

Open *src/app/app.component.ts* and change

```ts
//Change
export class AppComponent {
  title = 'app';
}

//to
export class AppComponent {
  title = 'Astronomy Picture of the Day';
}
```

In the browser return to *[http://localhost:4200](http://localhost:4200)* and you'll see the message *"Welcome to Astronomy Picture of the Day!"*

Now open the file */src/app/app.component.html* and take note of the double curly braces ```{{ title }}``` double curly braces in an Angular template allows for variable injection. Instance variables set in the corresponding ```.ts``` file will be available for injection in the template.
```html
<h1>
    Welcome to {{ title }}!
</h1>

```
The _component decorator_ is where we create the relationship between components, styles and templates.
```ts
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
```

## Labs

* Create an app that works with the NASA API.

Additional Resources

* [Tour of Heros](https://angular.io/docs/ts/latest/tutorial/).
    * Try creating an API to work with the Tour of Heros application
* [Angular Docs](https://angular.io/docs).

[Next: Angular CMS](04-NgCMS/README.md)
