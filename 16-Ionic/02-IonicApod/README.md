# Ionic: NASA - Astronomy Pic of the Day

```sh
cd ~
ionic start ionicApod blank
# Install the free Ionic Appflow SDK and connect your app? (Y/n) No
cd ionicApod
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
