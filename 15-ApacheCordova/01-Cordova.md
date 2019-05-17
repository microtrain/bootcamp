# Apache Cordova and Android Studio
[Apache Cordova](https://cordova.apache.org/) is a free and open source environment that allows us to use web technologies to target multiple platforms with a single code base. This is used primarily for mobile development. While we are able to write the code using web technologies, we still need access to that platforms build environment. Cordova provides a mechanism to compile technology into native application code but it still needs the native environment to build and test that package. If you want to compile your application into an iOS app you will still need access to a MAC running the latest version of xCode. Android on the other hand can build on Windows, MAC or Linux as a result we will focus our build on Android. For the most part, anything you build in Cordova for Android should run on iOS save for the occasional tweaks.

[Android Studio](https://developer.android.com/studio/index.html) is the official IDE (Integrated Dev Environment) for building Andorid applicators, this provides everything you will need to build Android applications. There are however a few dependencies.

In this lesson we will install
* Apache Cordova
* Java
* Gradle
* Android studio
* A few 32 bit binaries.

## Install Apache Cordova

Cordova is built on top of Node; we will use npm to do a global install.

```sh
sudo npm install -g cordova
```

## Install the Java SDK
Android runs on top of Java (and Java compatible APIs) we will need to install Java so we can compile our web based build into Java, we will use OpenJDK.
```sh
sudo apt install openjdk-8-jdk
```
Now set the path using your favorite editor. In my case the path is at _/usr/lib/jvm/java-8-openjdk-amd64_ so I will add this lines 

Open your .bashrc file
```sh
vim ~/.bashrc
```

:q

and add the follolwing line to the end of the file. You can use [shift] + [g] to jump to the end of the file.
```sh
export JAVA_HOME=/usr/lib/jvm/java-8-openjdk-amd64
``` 

Once you have added the those lines, you will want to reload the file.
```sh
source ~/.bashrc
```
Then run ```java -version```, if eveything is working you will openJDK version >= 11.0.2.
```
java -version
```

Install additional 32 bit libraries

```sh
sudo apt install libc6:i386 libncurses5:i386 libstdc++6:i386 lib32z1 libbz2-1.0:i386
```

## Download and Unpack Gradle

```sh
cd ~/Downloads
wget https://services.gradle.org/distributions/gradle-5.4.1-bin.zip
sudo mkdir /opt/gradle
sudo unzip -d /opt/gradle gradle-5.4.1-bin.zip
```

### Add an Environmental Variable on Startup

Open the _.bashrc_ file

```sh
vim ~/.bashrc
```

add the following line above your JAVA export.

```sh
export PATH=$PATH:/opt/gradle/gradle-5.4.1/bin
```

### Restart environment
```sh
source ~/.bashrc
```

## Install the Android SDK

If you were to build an Android application from scratch, this is what you would use. Cordova needs access to the SDK for it's builds and we need access to the emulators. You will use Cordova to write the code, Cordova will use the Android SDK to build your applications and you will use Android Studio to build your emulators.

[Download Android Studio](https://developer.android.com/studio/index.html)

```sh
cd ~/Downloads
sudo tar xvzf android-studio-ide-*-linux.tar.gz -C /usr/local
```

Android studio also requires some environmental variables. Let's go ahead and add those by opening .bashrc

```sh
vim ~/.bashrc
```

and adding the following lines to the end of the file.
```sh
export ANDROID_HOME=/home/$USER/Android/Sdk
export PATH=${PATH}:$ANDROID_HOME/tools:$ANDROID_HOME/platform-tools
```

Your final .bashrc file should include the following
```sh
export PATH=$PATH:/opt/gradle/gradle-5.4.1/bin
export JAVA_HOME=/usr/lib/jvm/java-8-openjdk-amd64
export ANDROID_SDK_ROOT=/home/$USER/Android/Sdk
export PATH=${PATH}:$ANDROID_SDK_ROOT/tools:$ANDROID_SDK_ROOT/platform-tools
```

then restart the environemnt.
```sh
source ~/.bashrc
```

Now we can start Android Studio 
```sh
cd /usr/local/android-studio/bin
./studio.sh
```

Follow the prompts and keep choosing next.

_
At some point you will be asked to create or import a new project. This is required but we will not use it. When prompted to do so, go ahead and create a project.
Create a new project called Hello World
* Choose create with no activity
_

You should now have a running instance of  Android Studio. Add a desktop entry _Tools > Create desktop entry..._ and lock Android Studio to your launcher.  

Now it's time to create an (AVD (Android Virtual Device))[https://developer.android.com/studio/run/managing-avds.html]

Tools > AVD Manager
Click the _Create Virtual Device_ button
Choose Pixel 2
Click on the _x86 images_ tab and choose _Q x86_64 Andorid 9.+ (Google Play)_  (Download then choose if required)
Choose the default options from the AVD screen and click _Finish_
From the _Your Virtual Devices_ dialog click the green arrow beside our new device.

Allow yourself permissions to the emulator
```sh
sudo chown $USER:$USER /dev/kvm 
```

## Hello World

Now let's get started with Cordova. We will start with the classic Hello World example. We will create our Hello World application is a package called hello. This will create a starter package with a few lines of source code to get your started.

```sh
cd ~
cordova create hello com.example.hello HelloWorld

cd hello
```

Check your list of platforms

```sh
cordova platform ls
```

Add the Android platform to your project.

```sh
cordova platform add android
```

Build and Android package from source code.

```sh
cordova build android
```

Start the emulator

```sh
cordova emulate android
```

Close the emulator.

## Debugging with Logcat.
[Logcat](https://developer.android.com/studio/command-line/logcat.html) is the default android debugger, we can use this for tracking down issues in our web code. To do this we will want to add the [console plugin](https://cordova.apache.org/docs/en/latest/reference/cordova-plugin-console/) to our Cordova app.

```sh
cordova plugin add cordova-plugin-console
```

Start your emulator and in another terminal start logcat
```sh
cordova emulate android

adb logcat
```

Everything that happens in the emulator is logged. Logcat ```adb``` is installed with android studio and lets us read the logs in real time. In a new console, run the logcat command.
```sh
adb logcat
```
You'll notice straight away that this is far too verbose to be useful, so your will want to run it with filters. We will use the regex filter to only return messages that have contain the string _INFO:CONSOLE_. This will limit Logcat's output primarily to ```console.log()``` calls. Making it far less verbose and allowing us focus on messages that matter.

```sh
adb logcat ActivityManager:I Cam:V -e INFO:CONSOLE*
```

Camera Plugin
https://cordova.apache.org/docs/en/latest/reference/cordova-plugin-camera/


## Eratta

> **WARNING** 
> DO NOT proceed with the eratta section unless you are having issues with Java, Android Studio, or Cordova.

Oracle has recently discontiued JDK8 PPA if you have walked through the previous version of this lesson or have installed other versions of either Oracle's Java or OpenJDK and are having issues with Cordova you may need to unistall all versions of Java then install openjdk-8-jdk. It seems Cordova has issues finding OpenJDK 8 if other versions of Java are isntalled.

```sh
sudo apt-get remove openjdk*
sudo apt-get remove --auto-remove openjdk*
sudo apt-get purge openjdk*
sudo apt-get purge --auto-remove openjdk*
```

Then proceed to the begining of this lesson and follow the Java installation instructions.

## Additional Resources
[Use SQLite In Ionic 2 Instead Of Local Storage](https://www.thepolyglotdeveloper.com/2015/12/use-sqlite-in-ionic-2-instead-of-local-storage/)

[Next: Porting an App](02-PortingAnApp.md)
