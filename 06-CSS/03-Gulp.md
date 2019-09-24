# Gulp

Gulp allows you to build workflows for optimizing your frontend assets. As with SASS you can create a watcher to auto build on save. GUlp offers additional feature such combining and minifying files. Since Gulp is a JavaScript package and the config file is written in JavaScript you can add any functionality you want.


Globally install Gulp

```sh
cd ~
sudo npm install -g gulp -save-dev
```

## Configure NPM for you local project
[</> code](https://github.com/microtrain/microtrain.github.io/commit/5d889b1b371d5f64ffad5f4b93fdb356dab7e044) Add a file named package.json to you GitHub Pages project. This must be added to the projects top level directory. Gulp is built in NodeJS and lives in the NPM ecosystem. You can run a series of NPM commands to initialize this project as an NPM project and install each dependency manually or you can use a prebuilt config file. The latter is the path we will take for this project. Add the following to your *package.json* file.


*/var/www/YOUR-GITHUB-USERNAME.github.io/package.json*
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
    "gulp": "^4.0.2",
    "gulp-clean-css": "^4.2.0",
    "gulp-concat": "^2.6.1",
    "gulp-rename": "^1.4.0",
    "gulp-sass": "^4.0.2",
    "gulp-uglify-es": "^1.0.4",
  }
}
```

### Install all Packages

By virtue of having a package.json file your project is an NPM project. At this point we have defined the project dependencies; now we need to install them. Run the following from the command line. 

```sh
cd /var/www/YOUR-GITHUB-USERNAME/github.io
npm install
```

### .gitignore

Git will stage every file it sees. There are cases in which you project requires files that you will never want to stage and commit. You can try to track these manually but that will inevitably fail. Add a file called .gitignore to your project and these files will not available for staging. Create a file called .gitignore in the top level of your project and add the following.

```git
node_modules
.gulp-scss-cache
.sass-cache
```

## gulpfile.js

Gulp is an ES6 (JavaScript) script designed for frontend compilations. These are typically written as small, single script programs.

*/var/www/YOUR-GITHUB-USERNAME/github.io/gulpfile.js*
```js

var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify-es').default;
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var scss = require('gulp-sass');

/**
 * Define the paths upon which the files to be *gulped* will resided.
 * # styles - the name of a collection (this can be anything you like)
 * # src - the files to be gulped, multiple paths would be listed inside of an 
 * array
 * # dest - the output location
 * 
 */
var paths = {
  styles: {
    src: 'src/scss/**.scss',
    dest: 'dist/css/',
  }
};

/**
 * Define our tasks using plain functions
 */
function buildCSS() {
  return gulp.src(paths.styles.src)
    .pipe(scss())
    .pipe(cleanCSS())
    // pass in options to the stream
    .pipe(rename({
      basename: 'main',
      suffix: '.min'
    }))
    .pipe(gulp.dest(paths.styles.dest));
}

/**
 * Define a list of tasks to be executed when `gulp watch` is executed.s
 */
function watch() {
  gulp.watch(paths.styles.src, buildCSS);
}

exports.buildCSS = buildCSS;
exports.watch = watch;

/**
 * Specify if tasks run in series or parallel using `gulp.series` and 
 * `gulp.parallel`
 */
var build = gulp.series(gulp.parallel(buildCSS));

/**
 * Create a list of tasks that can be ran manually
 * Running `gulp styles` fom the cli would execute the styles task
 */
gulp.task('build', build);

/**
 * Define default task that can be called by just running `gulp` from cli
 * this would be the same as running `gulp watch`
 */
gulp.task('default', watch);
```

Run any of the following commands to execute your Gulp script.

```sh
gulp
gulp watch
gulp buildCSS
```

Since we defined ```gulp watch``` as our NPM start up script you can use ```npm start``` execute the watcher.

```sh
npm start
```

[Next: CSS Layouts](04-CSSLayouts.md)
