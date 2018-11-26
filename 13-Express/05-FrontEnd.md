# Front End

In the next section we will build an Authentication App using JavaScript. Before we do that we need to do a little bit of setup. We will use Bootstrap and Font Awesome to layout our website, Make a few changes to our directory structure, configure Gulp, and clean a few things up.

## Integrate Bootstrap and Font Awesome

We will use Bootstrap to give us an out of the box responsive UI and prebuilt styles. This will allow us to better focus on building our application taking the website's build out of our head space. Font Awesome provides a robust icon library. Rather than installing these products we will access them over a CDN. 


### Basic Layout
[</> code](https://github.com/microtrain/mean.example.com/commit/xxx) For this commit we will replace the existing layout with something similar to [Bootstrap's starter template](https://getbootstrap.com/docs/4.1/getting-started/introduction/#starter-template). The difference will be [linking to Font Awesome](https://fontawesome.com/start) and converting the sample [HTML to Pug](https://html-to-pug.com/). Replace the code in *views/layouts.pug* with the following.

*views/layout.pug*
```js
doctype html
html
  head
    // Required meta tags
    meta(charset='utf-8')
    meta(name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no')
    // Bootstrap CSS
    link(rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous')
    // Font Awesome
    link(rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous')

    title= title
  body
    .container
      // Page Content - Express Default
      block content
    // Optional JavaScript
    // jQuery first, then Popper.js, then Bootstrap JS
    script(src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous')
    script(src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js' integrity='sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49' crossorigin='anonymous')
    script(src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js' integrity='sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy' crossorigin='anonymous')
```

Go to [http://localhost:3000](http://localhost:3000) and you will see something like the following. The biggest difference you'll notice is the lack of top margin.

![layout](/img/auth/layout.png)

### Navigation

Development will be a little easier if we can click a link to test our changes rather than manually entering the URL. We will add a few links to the layout. Rather than just throwing some raw links on the page we will use [Bootstrap's Navbar](https://getbootstrap.com/docs/4.0/components/navbar/). Navbar provides some out of the box branding which can include a site logo and title. To keep things simple, we will use [Font Awesome's Asterisk](https://fontawesome.com/icons/asterisk?style=solid) as our logo and MY API as our site name. We will start by adding the following four links to *views/layout.pug*.

* Home - */*
* Login - */auth*
* Logout - */auth/logout* 
* Register - */auth/#register*

*views/layout.pug*
```pug
//~line 14
// Header/Navigation
nav.navbar.navbar-expand-lg.navbar-light.bg-light
  .container
    a.navbar-brand(href='#') 
      // Use Font Awesome for a generic logo
      i.fas.fa-asterisk
      |&nbsp;MY API
    button.navbar-toggler(
      type='button' 
      data-toggle='collapse' 
      data-target='#navbarSupportedContent' 
      aria-controls='navbarSupportedContent' 
      aria-expanded='false' 
      aria-label='Toggle navigation'
    )
      span.navbar-toggler-icon
    #navbarSupportedContent.collapse.navbar-collapse
      ul.navbar-nav.ml-auto
        li.nav-item.active
          a.nav-link(href='/')
            | Home 
            span.sr-only (current)
        li.nav-item
          a.nav-link(href='/auth#register') Register
        li.nav-item
          a.nav-link(href='/auth') Login
        li.nav-item
          a.nav-link(href='/logout') Logout
```

Reload the webpage at [http://localhost:3000](http://localhost:3000) and depending on your viewport you will either see a navbar with horizontal links or a collapsed navigation.

## File Structure 

By default, ExpressJS stores CSS in a directory called *public/stylesheets*. We will change this to a webpack style structure in which all (S)CSS and JavaScript will be written to a top level directory called *src* (source) with the sub directories of *src/js* and *src/css*. The term source indicative of hand written source code. We will use a Gulp process to combine and minify source code into distribution package. The term distribution indicative of machine readable code that has been compiled from source. The distribution packages will be written to *public/dist* where they can be accessed by a web page. All front end assets are stored in the *public* directory. The *public* directory is not visible in the URL but anything inside that directory skips routing and is served like a traditional web request. For example *public/dist/css/main.css* would be accessed using *http://localhost:3000/dist/css/main.css where localhost:3000 is the domain name. If the domain is example.com then *public/dist/css/main.css* would be accessed using *http://example.com/dist/css/main.css*.

You can manually edit the file structure or you can use the commands listed below.

**Remove**
* public/stylesheets

**Create the following files and directories**
* src
* src/js
* src/js/main.js
* src/js/app.auth.js
* src/scss/main.scss
* src/scss/forms.scss
* dist
* dist/js
* dist/js/main.min.js
* dist/js/auth.app.min.js
* dist/css
* dist/css/main.min.css

You can create the src structure with the following command(s). We will use a Gulp process to add the files to our dist structure.

```sh
cd ~/mean.example.com
mkdir -p src/js && touch src/js/main.js src/js/auth.app.js && mkdir src/scss && touch src/scss/main.scss src/scss/forms.scss && mkdir -p public/dist/js && mkdir public/dist/css && rm -fR public/stylesheets
```

## Gulp

Install the following packages
```sh
npm install --save-dev gulp
npm install --save-dev gulp-watch
npm install --save-dev gulp-clean-css
npm install --save-dev gulp-uglify-es
npm install --save-dev gulp-rename
npm install --save-dev gulp-concat
npm install --save-dev merge-stream
npm install --save-dev gulp-sass
```

*gulpfile.js*
```js
var gulp = require('gulp');
var watch = require('gulp-watch');
var cleanCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify-es').default;
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var merge = require('merge-stream');
var scss = require('gulp-sass');

//Run a watcher by default
gulp.task('default', ['watch']);

//Compile all JS tasks
gulp.task('build-js', [
  'build-main-js',
  'build-auth-js'
]);

//Compile all CSS tasks
gulp.task('build-css', ['build-main-css']);

gulp.task('build-main-css', function(){

  var main = gulp.src([
    'src/scss/main.scss'
  ])
  . pipe(scss())
  . pipe(cleanCSS())
  . pipe(concat('main.min.css'))
  . pipe(gulp.dest('public/dist/css'));

  return merge(main);
});

gulp.task('build-main-js', function() {

  var authApp = gulp.src([
    'src/js/main.js',
  ])
  .pipe(concat('main.min.js'))
  .pipe(uglify())
  .pipe(gulp.dest('public/dist/js'));

  return merge(authApp);
});

gulp.task('build-auth-js', function() {

  var authApp = gulp.src([
    'src/js/auth.app.js',
  ])
  .pipe(concat('auth.app.min.js'))
  .pipe(uglify())
  .pipe(gulp.dest('public/dist/js'));

  return merge(authApp);
});

//Recompile SCSS/JS on save
gulp.task('watch', function(){
  gulp.watch('./src/scss/**/*.scss', ['build-css']);
  gulp.watch('./src/js/**/*.js', ['build-js']);
});
```

Now that we have installed gulp in our project we can finish building our dist structure with the following commands.
```sh
cd ~/mean.example.com
gulp build-js
gulp build-css
```