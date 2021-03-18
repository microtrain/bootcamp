# Porting an App

While we are building for mobile, spinning up an emulator for each little change can be a time suck. I recommend adding the browser platform in addition to any mobile platforms you will be using. The browser will allow for faster testing on non-native features.

```sh
cd ~
cordova create apod com.example.apod Apod
cd apod

cordova platform add browser
cordova run browser
```

At this point, the browser will pop open running the default Cordova application. You may now add your mobile platforms. We will use Android.

```
cordova platform add android
cordova run android
```

#If Error! Failed to install the following Android SDK packages as some licenses have not been... 
> ```yes | ~/Android/Sdk/tools/bin/sdkmanager --licenses``` 

## Port over the jQuery version of NASA Apod

Copy the dist directory and the HTML from either the jQuery or Vanilla version of your APOD project.

Find the path *~/apod/www* copy your dist directory to this path. Then replace the index.html file with the one from your APOD project. The run Cordova.

```sh
cordova run android
```

Each Cordova project has a build path for each platform, note the following path *~/apod/platforms/android/app/build/outputs/apk/debug/app-debug.apk*. The directory */apod/platforms* is a directory that contains a list of platforms, in this case, android. After that, it's a matter of finding the package. In this case, it's an .apk file.


## Port over the Angular version of NASA Apod

Porting an Angular app is similar to porting a native app. At this point, understanding how each of your apps works is more important than understanding Cordova's platform. Refer to the build of your NgApod project. This will be a distribution directory containing an index.html file and any assets that are required for the application. Place the index.html file directly under *~/apod/www* and place the assets relative to how they are called by the Angular application.

```sh
cordova run android
```

## Homework

* Port over the vanilla drawing app
* Update the drawing app so that it registers touch events in addition to/instead of mouse events.

[Next: Ionic](/16-Ionic/README.md)
