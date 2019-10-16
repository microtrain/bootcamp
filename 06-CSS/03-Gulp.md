# Gulp

Gulp allows you to build workflows for optimizing your frontend assets. As with SASS, you can create a watcher to auto-build on save. Gulp offers additional features such as combining and minifying files. Since Gulp is a JavaScript package and the config file is written in JavaScript you can add any functionality you want.


Globally install Gulp

```sh
cd ~
sudo npm install -g gulp -save-dev
```

## Configure NPM for your local project
[</> code](https://github.com/microtrain/microtrain.github.io/commit/b401f28f4539db6c7286bb0081855649c371736f) Add a file named package.json to your GitHub Pages project. This must be added to the project's top-level directory. Gulp is built in NodeJS and lives in the NPM ecosystem. You can run a series of NPM commands to initialize this project as an NPM project and install each dependency manually or you can use a prebuilt config file. The latter is the path we will take for this project. Add the following to your *package.json* file.


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

Commit your changes and push to master.

### Install all Packages

By adding a package.json file, your project becomes an NPM project. At this 
point we have defined the project dependencies; now we need to install them. 
Run the following from the command line. DO NOT commit until you have added a 
*.gitignore* file.

```sh
cd /var/www/YOUR-GITHUB-USERNAME/github.io
npm install
```

#### .gitignore

Git will stage every file it sees. A quick status check will show you everything 
Git has access to. This will show you tracked and untracked files.
Untracked files are brand new files for which git does not have history. 
When git tracks a file, git is tracking that file's history. History starts
on the first commit. Before you can commit a file, it must be staged for commit. 
You can stage a file for commit by adding it to the list of tracked files
```git add [FILE_NAME]```.

```sh
git status
```

A quick status check will show something like the following. Your results will
likely vary and that's OK. The thing to focus on is the *node_modules/* 
directory.

![Untracked Files](/img/git/untracked.png)


There are cases in which your project requires files that you will never want to 
stage and commit. You can try to track these manually but that will inevitably 
fail. In our case, *node_modules/* is a directory maintained by NPM. This could 
contain thousands of files and millions of lines of supporting code for our 
project. This is managed by NPM and we do not want to push these to our 
repository. We reference what we need in our *package.json* file, then we 
can ignore the *node_modules* directory. 


[</> code](https://github.com/microtrain/microtrain.github.io/commit/4963f8b4722a4379e680bf7702e24cee85877ee3) 
Add a file called *.gitignore* to your project and these files will not available 
for staging. Create a file called *.gitignore* in the top level of your project 
and add the following. Sass will create caching directories as a general rule
you will never want to push cache or temp files to your repository. We will go
ahead and ignore these now to prevent future confusion. 

> Ignore as much as you can upfront. Aa quick Google search will reveal pre 
> gitignore files that many projects use as a template.


Create the file .gitignore and add the following.

*/var/www/YOUR-GITHUB-USERNAME/github.io/.gitignore*
```sh
node_modules
.gulp-scss-cache
.sass-cache
```

Running ```git status``` for a second time will yield results similar to the 
following. Again, results will vary. The details to focus on are the omission 
of *node_modules/* and the addition of *.gitigore*.

![Untracked Files](/img/git/untracked2.png)

At point you can add files to tracking, commit your changes and push to master.

## gulpfile.js

[</> code](https://github.com/microtrain/microtrain.github.io/commit/134b619fad09caa723ed25215266e00c8a5e69ac) Gulp is an ES6 (JavaScript) script designed for frontend compilations (aka - 
front-end tooling, automating workflows, etc.). These are 
typically written as small, single script programs.

*/var/www/YOUR-GITHUB-USERNAME/github.io/gulpfile.js*
```js
var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify-es').default;
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var scss = require('gulp-sass');

/**
 * Define the paths upon which the files to be *gulped* will reside.
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
 * Define a list of tasks to be executed when `gulp watch` is executed.
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
 * Create a list of tasks that can be run manually
 * Running `gulp build` from the CLI would execute the build task
 */
gulp.task('build', build);

/**
 * Define default task that can be called by just running `gulp` from the CLI
 * this would be the same as running `gulp watch`
 */
gulp.task('default', watch);
```

[</> code](https://github.com/microtrain/microtrain.github.io/commit/4ce0737782e4cfb7c219b37887f7ea8467d32742) 
The gulpfile is written to scan a course directory, convert all SASS to CSS and 
write the output to a file called *main.min.css*. To do this we will need to 
rename the path *dist/css/main.css* to *src/scss/main.scss*.

[</> code](https://github.com/microtrain/microtrain.github.io/commit/014cecf4f0d0666b4c1f72aadab0f781279b410b)
Run the following command to execute your Gulp script.

```sh
gulp buildCSS
```

[</> code](https://github.com/microtrain/microtrain.github.io/commit/24a233f5efa0e397ace02d30ae28eef2b226ebdb)
Now we will need to change our CSS ref from *./dist/css/main.css* to *./dist/css/main.min.css*.


### Gulp Watch
```gulp.watch()``` is a process that watches a given set of files for changes.
If any changes are detected in that set of files ```gulp.watch()``` will execute
a set of given commands. In our case we created a task called ```buildCSS()```
which is called any time ```gulp..watch()``` detects a change.

```buildCSS()``` converts all of the SASS in the */src/scss* directory to css
and writes the output to *dist/src/main.min.css*. We can initiate the watcher in
a few different ways.

By calling it directly, this executes the ```watch()``` task from our gulpfile.
```sh
gulp watch
```

By calling gulp with no params. In our gulp file we defined a ```default()```,
This task is the default task and gets called running gulp with no params.

```sh
gulp
```

By calling ```npm start```. Since we defined ```gulp watch``` under *scripts > 
start* in our *package.json* calling ```npm start``` execute the watcher.
```sh
npm start
```

[Next: CSS Layouts](04-CSSLayouts.md)
