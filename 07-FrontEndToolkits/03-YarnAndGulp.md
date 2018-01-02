# Yarn and Gulp

[Yarn](https://yarnpkg.com/en/) is a package manager for the web. It is similar to something like NPM, Composer, PIP, etc.

```sh
sudo npm install yarn --global
cd /var/www/bootstrap
yarn init
```

[Gulp](https://gulpjs.com/) is a toolkit for automating workflows and tasks.
```sh
sudo npm install --global gulp-cli
npm install --save-dev gulp@next
```

Create the file *gulpfile.js* and add the following.
```js
var gulp = require('gulp');

gulp.task('default', defaultTask);

function defaultTask(done) {
  // place code for your default task here
  done();
}
```

## Additional Resources

* [Yarn](https://yarnpkg.com/en/)
* [Gulp](https://gulpjs.com/)
