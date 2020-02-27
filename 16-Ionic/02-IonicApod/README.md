# Ionic: NASA - Astronomy Pic of the Day

For this lesson, we will run a CLI program called *ionic*. The ionic command 
wraps Angular's ```ng``` command with additional functionality. Ionic runs on 
top of the AngularCLI.   

```sh
cd ~
ionic start ionicApod blank
```
You will be asked to choose a version; **CHOOSE ANGULAR**.

![Choose a Version](/img/ionic/apod/choose_version.png)

If the installation was successful you will see some instructions for the 
*Next Steps*.

![Choose a Version](/img/ionic/apod/next_steps.png)

We are only concerned with the first two steps. The last two steps are links to 
documentation; I will post those in the additional resources section.

```sh
cd ionicApod
ionic serve
```

```ionic serve``` works like ```ng serve``` in that it serves the application in 
a browser window. If your building in Ionic, I'm assuming your focus is mobile. 
Launching ```ionic serve``` with the labs argument will launch Ionic in a split 
mobile view. Terminate the current instance using [ctrl]+[c] and launch with the 
serve argument.

```
npm i @ionic/lab
ionic lab
```

Before we start building our app lets add the `.editorconfig` file. We will 
start by adding 

*.editorconfig*
```sh
# EditorConfig helps developers define and maintain consistent coding styles between different editors and IDEs
# editorconfig.org

root = true

[*]
indent_style = space
indent_size = 2

# We recommend you to keep these unchanged
end_of_line = lf
charset = utf-8
trim_trailing_whitespace = true
insert_final_newline = true

[*.md]
trim_trailing_whitespace = false
```

Now that our IDE has been configured let start building the app by defining the 
Apod object.

*src/app/apod.model.ts*
```js
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

At this point, VERIFY you still have your config file from the `ng-apod`
lesson. This should be under `~/config/ng-apod.config.ts`. If YOU DO NOT have 
this file and directory, you can create them now.

```sh
cd ~
mkdir config && touch config/ng-apod.config.ts
gedit config/ng-apod.config.ts
```

Add the following lines to the file. Be sure to replace `xxxxx` with the
API key that was provided to you during the first APOD project.

```ts
export class NgApodConfig {
  key:string = 'xxxxx';
}
```

Next, we will create the ApodService.

Open a new terminal tab and create the apod service.

```sh
ionic generate service apod
```
As in NgApod the `ApodService` will need to perform the following tasks.

1. Connect to an API over HTTP
2. Return results in the form of an Observable
3. Use the Apod data Model
4. Load an API key from a configuration file

The code will be almost identical to that of the `ApodService` from the 
`ng-apod` project.

*src/app/apod.service.ts*
```js
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Apod } from './apod.model';

import { NgApodConfig } from '../../../config/ng-apod.config';

@Injectable({
  providedIn: 'root'
})
export class ApodService {

  private url:string;

  constructor(
    private http:HttpClient,
    private ngApodConfig: NgApodConfig
  ){
    this.url=`https://api.nasa.gov/planetary/apod?api_key=${this.ngApodConfig.key}`;
  }

  getApod(date:string): Observable<Apod>{
    return this.http.get<Apod>(`${this.url}&date=${date}`);
  }
}
```

Since we are importing `HttpClient` and `NgConfig` into the service be sure to 
add this as an import to *app.module.ts*.

Add the following line to the top of the file.
```ts
import { HttpClientModule } from '@angular/common/http';
import { NgApodConfig } from '../../../config/ng-apod.config';
```

Update the imports array as follows.
```ts
imports: [
  BrowserModule,
  IonicModule.forRoot(),
  AppRoutingModule,
  HttpClientModule
],
```

Update the providers array as follows.
```ts
providers: [
  StatusBar,
  SplashScreen,
  NgApodConfig,
  { provide: RouteReuseStrategy, useClass: IonicRouteStrategy }
],
```

Now we will generate an apod page. This equates to generating a component in 
Angular.

```sh
ionic generate page apod
```

Update the routes array in the app-routing module. Replace the `routes` constant 
with the following snippet. 

*app-routing.module.ts*
```js
const routes: Routes = [
  { path: '', redirectTo: 'apod', pathMatch: 'full' },
  { path: 'apod', loadChildren: './apod/apod.module#ApodPageModule' },
  { path: 'apod/:date', loadChildren: './apod/apod.module#ApodPageModule' },
];
```

`ApodPage` will not change all that much from `ApodComponent` in the 
ng-apod project. The main difference will be changing ```onInit()``` to 
```ionViewWillEnter()```.

*src/app/apod/apod.page.ts*
```js
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

import { ApodService } from '../apod.service';
import { Apod } from '../apod.model';

@Component({
  selector: 'app-apod',
  templateUrl: './apod.page.html',
  styleUrls: ['./apod.page.scss'],
})
export class ApodPage {

  apod: Apod;
  date: string;

  constructor(
    private apodService: ApodService,
    private route: ActivatedRoute
  ) {}

  ionViewWillEnter() {
    this.route.params.subscribe(
      (params)=>{
        if(params['date']){
          this.getApod(params['date']);
        }else{
          this.getApod(new Date().toISOString().slice(0, 10));
        }
      }
    );
  }
  
  randomDate(start, end){

    let date = new Date(
      start.getTime() + Math.random() * (end.getTime() - start.getTime())
    );

    return new Date(
      (date.getTime() - date.getTimezoneOffset()*60000)
    ).toISOString().slice(0, 10);
  }

  getApod(date:string):void {
    this.apodService.getApod(date)
      .subscribe((result:any) => {

        this.apod = result;

        this.date = this.randomDate(
          new Date(1995,5,16),
          new Date()
        );

      });
  }

}
```

Install the SafePipeModule from NPM
```sh
npm install safe-pipe --save
```

In the ng-apod project declared `safe-pipe` in out `AppModule`. In addition to 
`AppModule`, Ionic uses page level modules for granular control. Declare safe 
pipe as follows (Replace the entire file with the following). 

*src/app/apod.module.ts*
```ts
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';

import { IonicModule } from '@ionic/angular';

import { ApodPage } from './apod.page';

import { SafePipeModule } from 'safe-pipe';

const routes: Routes = [
  {
    path: '',
    component: ApodPage
  }
];

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    SafePipeModule,
    RouterModule.forChild(routes)
  ],
  declarations: [ApodPage]
})
export class ApodPageModule {}
```

Finally, we can implement the UI.

*src/app/apod/apod.page.html*
```html
<ion-header>
  <ion-toolbar>
    <ion-title *ngIf="apod">{{ apod.title }}</ion-title>
  </ion-toolbar>
</ion-header>

<ion-content>

  <ion-card *ngIf="apod"> 
    <ion-button style="margin:0;" expand="full" size="large" [routerLink]="['/apod', date]">Random</ion-button>
    <ion-img *ngIf="apod.media_type=='image'" [src]="apod.url" alt="{{ apod.title }}"></ion-img>
    <div id="apodVideo" *ngIf="apod.media_type=='video'">
      <iframe [src]="apod.url | safe: 'resourceUrl'" frameborder="0" allowfullscreen></iframe>
    </div>
    <ion-card-header>
      <ion-card-subtitle>
        <span *ngIf="apod.copyright">&copy; {{  apod.copyright }},</span>
        {{ apod.date | date }}
      </ion-card-subtitle>
      <ion-card-title>{{ apod.title }}</ion-card-title>
    </ion-card-header>
    <ion-card-content>
      {{ apod.explanation }}
    </ion-card-content>
  </ion-card>
</ion-content>
```

## Additional Recourses
* https://ion.link/scaffolding-docs
* https://ion.link/running-docs

[Next: ionicUsers](../03-IonicUsers/README.md)
