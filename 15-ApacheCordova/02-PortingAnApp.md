# Porting an App

While we are building for mobile, spinning up an emulator for each little change can be a time suck. I recommend adding the browser platform in addition to any mobile platforms you will be using. The brower will allow for faster testing on non-native features.

```sh
cd ~
cordova create apod com.example.apod Apod

cordova platform add browser
cordova browser run
```

At this point the browser will pop open running the default Cordova application. You may now add you mobile platforms. We will use Android.

```
cordova platform add android
cordova run android
```

## Port over the jQuery version of NASA Apod

Copy the dist directory and the HTML from either the jQuery or Vanilla version of your APOD project.

Find the path *~/apod/www* copy your dist directory to this path. Then replace the index.html file with the one from your APOD project. The run Cordova.

```sh
cordova run browser
```


## Port over the Angular version of NASA Apod


## Homework

* Port over the vanilla drawing app
* Update the drawing app so that it registers touch events in addition to/instead of mosue events.

[Next: Ionic](/16-Ionic/README.md)
