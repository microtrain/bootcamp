# Gulp

Gulp allows you to build workflows for optimizing your frontend assets. As with SASS you can create a wathcer to auto build on save. GUlp offers additional feature such combining and minifing files. Since Gulp is a JavaScript package and the config file is written in JavaScript you can add any functionality you want.


Globally install Gulp

```sh
cd ~
sudo npm install -g gulp
```

## Confirue NPM for you local project
Add a file named package.json to you GitHub Pages project. This must be added to the projects top level directory. Gulp is built in NodeJS and lives in the NPM ecosystem. You run a series of NPM commands to initialize you project as an NPM project and intall each dependency manually or you can use a prebuilt config file. The latter is the path we will take for this project. Add the following to you package.json file.

```json
{
  "name": "YOUR-GITHUB-USERNAME.github.io",
  "version": "0.0.0",
  "private": true,
  "scripts": {
    "start": "gulp watch"
  },
  "dependencies": {},
  "devDependencies": {
    "gulp": "^3.9.1",
    "gulp-clean-css": "^3.9.2",
    "gulp-concat": "^2.6.1",
    "gulp-rename": "^1.2.2",
    "gulp-scss": "^1.4.0",
    "gulp-uglify": "^3.0.0",
    "gulp-watch": "^5.0.0",
    "merge-stream": "^1.0.1"
  }
}
```

### Install all Packages

By virtue of having a package.json file your project is an NPM project. At this point we have deinfed the project dependencies; now we need to install them. Run the following from the command line. 

```sh
cd /var/www/YOUR-GITHUB-USERNAME/github.io
npm install
```

### .gitignore

Git will stage every file it sees. There are cases in which you project requres files that you will never want to stage and commit. You can try to track these manually but that will inevitably fail. Add a file called .gitignore to your project and these files will not available for staging. Create a file called .gitignore in the top level of your project and add the following.

```git
node_modules
.gulp-scss-cache
.sass-cache
```

## gulpfile.js

Gulp is an ES6 (JavaScript) script designed for frontend compilations. These are typically written as small, single script programs.

```js
var gulp = require('gulp');
var watch = require('gulp-watch');
var cleanCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var merge = require('merge-stream');
var scss = require('gulp-scss');

gulp.task('default', ['watch']);

gulp.task('build-css', function(){
  //Create an unminified version
  var full = gulp.src([
    'src/scss/main.scss'
  ])
  . pipe(scss())
  . pipe(concat('main.css'))
  . pipe(gulp.dest('dist/css'));

  //Create a minified version
  var min = gulp.src([
    'src/scss/main.scss'
  ])
  . pipe(scss())
  . pipe(cleanCSS())
  . pipe(concat('main.min.css'))
  . pipe(gulp.dest('dist/css'));

  return merge(full, min);
});

gulp.task('watch', function(){
  gulp.watch('./public/src/scss/**/*.scss', ['build-css']);
});
```

Run any of the following commands execute your Gulp script.

```sh
gulp
gulp watch
gulp build-css
```

Since we defined ```gulp watch``` as our NPM start up script you can use ```npm start``` execute the watcher.

```sh
npm start
```

[Next: CSS Layouts](04-CSSLayouts.md)
