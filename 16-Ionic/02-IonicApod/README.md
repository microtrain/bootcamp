# Ionic: NASA - Astronomy Pic of the Day

For this lesson we will run a CLI program called *ionic*. The ionic command serves as both an alias for Angular's ```ng``` command and it's own progam as it adds some Ionic sugar on top of the Angualr CLI.   

```sh
cd ~
ionic start ionicApod blank
# Install the free Ionic Appflow SDK and connect your app? (Y/n) No
cd ionicApod
ionic serve
```

```ionic serve``` works like ```ng serve``` in that it serve the application in a browser window. If your building in Ionic, I'm assuming your focus is mobile. Launching ```ionic serve``` with the labs argument will launch Ionic in a split mobile view. Terminate the current instance using [ctrl]+[c] and launch with the serve argument.

```
ionic serve --lab
# Install @ionic/lab? Yes
```

Before we start building our app lets add the .editorconfig file.

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

Now that our IDE has been configured let start building the app by defining the Apod object.

*src/app/apod.ts*
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

Next, we will create the ApodService.

Open a new tab and create the apod service.

```sh
ionic generate service apod
```

*src/app/apod.service.ts*
```js
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Apod } from './apod';

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

```sh
ionic generate page apod
```

Update the routes array the app-routing module. Then remove the home directory *src/app/home* directory.

*app-routing.module.js*
```js
const routes: Routes = [
  { path: '', redirectTo: 'apod', pathMatch: 'full' },
  { path: 'apod', loadChildren: './apod/apod.module#ApodPageModule' },
  { path: 'apod/:date', loadChildren: './apod/apod.module#ApodPageModule' },
];
```

The Apod page will not change all that much from the Apod component in the ng-apod project. The main difference will be changing ```onInit()``` to ```ionViewWillEnter()```.

*src/app/apod/apod.page.ts*
```js
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

import { ApodService } from '../apod.service';
import { Apod } from '../apod';

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
*src/app/app.module.ts*
```ts
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { RouteReuseStrategy } from '@angular/router';
import { HttpClientModule } from '@angular/common/http';

import { IonicModule, IonicRouteStrategy } from '@ionic/angular';
import { SplashScreen } from '@ionic-native/splash-screen/ngx';
import { StatusBar } from '@ionic-native/status-bar/ngx';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';

import { NgApodConfig } from '../../../config/ng-apod.config';
import { ServiceWorkerModule } from '@angular/service-worker';
import { environment } from '../environments/environment';

@NgModule({
  declarations: [AppComponent],
  entryComponents: [],
  imports: [
    BrowserModule,
    IonicModule.forRoot(),
    AppRoutingModule,
    HttpClientModule,
    ServiceWorkerModule.register('ngsw-worker.js', { enabled: environment.production })
  ],
  providers: [
    StatusBar,
    SplashScreen,
    NgApodConfig,
    { provide: RouteReuseStrategy, useClass: IonicRouteStrategy }
  ],
  bootstrap: [AppComponent]
})
export class AppModule {}
```

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

[Next: ionic-auth](03-IonicAuth/README.md)
