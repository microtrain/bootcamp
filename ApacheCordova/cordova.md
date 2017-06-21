# Apache Cordova
We will be using Apache Cordova to build a hybrid web and mobile application. Our mobile application. In order to build for mobile we need to be able to emulate that environment. let's start with Android; in addition to Cordova we will need to install Java, Gradle, the Android SDK and few 32 bit binaries.

## Install Apache Cordova

Cordova is built on top of Nodejs so the install is just a call to npm.

````
sudo npm install -g cordova
````

## Install the JavaSDK
Since Android runs on top of Java (and Java compatible APIs) we will need to install Java so we can compile our web based build into Java. We will use Oracle's JDK for this (there are rumors that Google will switch future build to Open-JDK).

Start by adding Oracle's PPA.

````
sudo add-apt-repository ppa:webupd8team/java
````

Update your apt repos list
````
sudo apt-get update
````

Install the JDK
````
sudo apt-get install oracle-java8-installer
````

Choose the desired installation
Run the command ````sudo update-alternatives --config java```` and chose from the resulting menu, which should be similar to the following. In this case, I selected option 0 _auto mode_

````
  Selection    Path                                     Priority   Status
------------------------------------------------------------
  0            /usr/lib/jvm/java-8-oracle/jre/bin/java   1081      auto mode
* 1            /usr/lib/jvm/java-8-oracle/jre/bin/java   1081      manual mode
````

You will need to set your JAVA_HOME Environment Variable (so that running programs can  find Java). To do this you will need to find your Java path; do this with the following command (the result of which will contain your Java path).

````
sudo update-alternatives --config java
````

Now set the path using your favorite editor. In my case the path is at _/usr/lib/jvm/java-8-oracle/jre/bin/java_ so I will add this line ````JAVA_HOME="/usr/lib/jvm/java-8-oracle/jre/bin/java"```` to the environment file.

````
sudo vim /etc/environment
````

Once you have added the that line, you will want to reload the file.
````
source /etc/environment
````

## Install Gradle
In short Gradle is a the build system used by Android. Stack Overflow has a [more detailed answer](https://stackoverflow.com/questions/16754643/what-is-gradle-in-android-studio). You can install this using Apt, but the Ubuntu repos are a little behind on this one, so it's better to install it manually.

### Download and Unpack Gradle

`````
cd ~/Downloads
wget https://services.gradle.org/distributions/gradle-3.4.1-bin.zip

sudo mkdir /opt/gradle
sudo unzip -d /opt/gradle gradle-3.4.1-bin.zip
````

### Add an Environmental Variable on Startup
````
vim ~/.bashrc
````

add the following line

````
export PATH=$PATH:/opt/gradle/gradle-3.4.1/bin
````

### Restart .bashrc
````. ~/.bashrc````

## Install the Android SDK
If you were to build an Android application from scratch, this is what you would use. Cordova needs access to the SDK for it's builds and we need access to the emualtors. You will use Cordova to write the code, but you will used Android Studio to build you emulators.

Download Android Studio

https://developer.android.com/studio/index.html

cd ~/Downloads
````sudo unzip android-studio-ide-162.3934792-linux.zip -d /usr/local````

cd /usr/local/android-studio/bin
````./studio.sh````

Install with the standard features

Install additional 32 bit libraries
````sudo apt-get install libc6:i386 libncurses5:i386 libstdc++6:i386 lib32z1 libbz2-1.0:i386````

Create a new project called Hello World
- Choose create with no activity

Go to Tools and choose _create a desktop entry_

````vim ~/bashrc````

add the following lines

````
export ANDROID_HOME=/home/jason/Android/Sdk
export PATH=${PATH}:$ANDROID_HOME/tools:$ANDROID_HOME/platform-tools
````

reload the bashrc file
````
. ~/.bashrc
````

## Hello World
Now let's get started with Cordova. We will start with the classic Hello World example. We will create our Hello World application is a package called hello.

````
cd ~
cordova create hello com.example.hello HelloWorld

cd hello
cordova platform add android
````

Check your list of platforms

````
cordova platform ls
````

Open Android studio and create an AVD (this is an emulator)

Tools > Android > AVD Manager
Click Create Virtual Device
Choose Nexus 5C
Download Nougat (if required)
Choose Nougat as your system image

use "Software" in the Emulated Performance Graphics option, in the AVD settings

Start an emulator.

````
cordova platform add android
cordova build android
cordova emulate android
````

````
cordova platform add browser
cordova build browser
cordova emulate browser
````
