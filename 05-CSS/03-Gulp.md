# Gulp

Gulp allows you to build workflows for optimizing your frontend assets. As with SASS you can create a wathcer to auto build on save. GUlp offers additional feature such combining and minifing files. Since Gulp is a JavaScript package and the config file is written in JavaScript you can add any functionality you want.


Globally install Gulp

```sh
cd ~
sudo npm install -g gulp
```

## Confirue NPM for you local project
Add a package.json
package.json
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

```sh
cd /var/www/YOUR-GITHUB-USERNAME/github.io
npm install
```

### .gitignore

Create a .gitignore file


## gulpfile.js

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
  var full = gulp.src([
    'src/scss/main.scss'
  ])
  . pipe(scss())
  . pipe(concat('main.css'))
  . pipe(gulp.dest('dist/css'));

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