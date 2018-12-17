# SASS

SASS is a a CSS preprocessor is a superset of CSS which means all CSS syntax is considered valid _.scss_ it's a superset because because it extends CSS with programming like capabilities; variables and limited control statements. This is advantageous especially when building large front-end frameworks such [Bootstrap](http://getbootstrap.com/) or creating a product with a customizable theme. For example, Bootstrap has a default shade of red _#dc3545_ <sup>1</sup>. If we were to change that color globally we would have to track down every instance of the color and change it manually or we could make a single change to the variable that holds that color.

### Install [Sass](http://sass-lang.com/)

Install ruby-sass via apt.

```sh
sudo apt-get install ruby-sass
```

Variables in Sass. Sass denotes variables with a _$_ dollar sign. For these lessons we will use the newer SCSS syntax for writing our sass files. These files must have the _.scss_ extensions.

### Exercise 1 - Sass Variables

Create the paths */var/www/mtbc/scss/index.html* and */var/www/mtbc/scss/main.scss* and add the following to *index.html*,

```html
<!DOCTYPE html>
<html>
    <head>
       <title>SASS DEMO</title>
       <link href="./main.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <h1>SASS DEMO</h1>

        <h2>FOUR COLUMN GRID</h2>
        <div class="row">
          <div class="col">ONE</div>
          <div class="col">TWO</div>
          <div class="col">THREE</div>
          <div class="col">FOUR</div>
        </div>
        <div class="row">
          <div class="col">FIVE</div>
          <div class="col">SIX</div>
          <div class="col">SEVEN</div>
          <div class="col">EIGHT</div>
        </div>

        <h2>TEXT CLASSES</h2>
        <div class="text-success">Success Text</div>
        <div class="text-error">Error Text</div>
        <div class="text-warning">Warning Text</div>

        <h2>MESSAGE CLASSES</h2>
        <div class="message">Default Message</div>
        <div class="message-success">Success Message</div>
        <div class="message-error">Error Message</div>
        <div class="message-warning">Warning Message</div>

    </body>
</html>
```

Load the page [https://localhost/mtbc/sass](https://localhost/mtbc/sass). Then add the following the to *main.scss*

```scss
/* variables */

$primary-font-stack: "Helvetica Neue",Helvetica,Arial,sans-serif;
$primary-color: #333;

/* universal settings */

* {
  box-sizing: border-box;
}

body {
  font: 100% $primary-font-stack;
  color: $primary-color;

  margin: 0 auto;
  padding: 0;
  width: 1170px;
}

```

Compilation is the next step. From the command line we will compile sass into css.

```sh
sass /var/www/mtbc/scss/main.scss /var/www/mtbc/scss/main.css
```

This will create the file main.css which is a compiled version of your scss file.

```css
* {
  box-sizing: border-box;
}

body {
  font: 100% "Helvetica Neue",Helvetica,Arial,sans-serif;
  color: #333; 
  
  margin: 0 auto;
  padding: 0;
  width: 1170px;
}
```

### Exercise 2 - Live Reload / Watch a File

The downside to a preprocessor is the compilation step. This takes time and slows down development. We remedy this by creating a *watcher* this watches a target file for changes and rebuilds it's CSS version in the background. This is one less thing you need to think about which can help keep you in flow. Open a split console window and run the following command in one of the panels.

```sh
sass --watch /var/www/mtbc/scss/main.scss:/var/www/mtbc/scss/main.css
```

You will see the following output
```sh
>>> Sass is watching for changes. Press Ctrl-C to stop.
  directory ~/scss
      write ~/scss/main.css
      write ~/scss/main.css.map

```

In the second panel open the scss file in vim, make a change and save it using [esc] then ```:x```; You'll notice a change in the first console window with the following output.

```sh
>>> Change detected to: main.scss
      write ~/scss/main.css
      write ~/scss/main.css.map

```

Open the file */var/www/mtbc/scss/main.css* and verify your changes.

## Mixins

Later we will learn about the Bootstrap framework. Bootstrap is among the most popular frameworks and as such it gets a lot of criticism. One of the those criticisms is the practice of calling mulitple class on a single element. The claim is that this can increase load time. For example styling a button in Bootstrap often looks as follows ```class="btn btn-default btn-xs"```. The idea is the it would be faster to combine all of those classes into a single definition in which case something like ```class="btn-default-xs"``` would load faster. In native CSS this would mean having a lot of duplicate code. SASS allows us to reuse style deifintions, meaning we can write them once a call them as many times as we need to. This means we can globally chane an entire style sheet by changing only one line of code. Rather that calling multiple classes we can define mixins and extend base classes making all of our code reusable..

### Clearfix

I have always viewed ```.clearfix``` as a containment element for any number of floats. Meaning if you apply clearfix to a parent element any child element, that is has a float property, cannot escape the parent element.  ```.clearfix``` is a common hack used by front end developers to solve the problem of using floats in a way they were never intended to be used<sup>2</sup>.

* [CodePen](https://codepen.io/jasonsnider/pen/QmJqbb) Floating grid without a clearfix
* [CodePen](https://codepen.io/jasonsnider/pen/vRQeKv) Floating grid with clearfix


## Exercise 3

Create a ```.clearfix``` mixin by adding the following to the top of *main.scss*.
```scss
/* mixins */
/* clear floats */
@mixin clearfix() {
  &:after {
    content: "";
    display: table;
    clear: both;
  }
}
```

Then you can create two classes applying ```clearfix()``` to both classes. We will go ahead and add a column class. We will discuss columns in greater detail in later lessons. For now we will use to demo other concepts.

```scss
/* Utility Classes */

.clearfix {
  @include clearfix();
}

/** Rows and Columns */
.row {
  @include clearfix();
}

.col {
  float: left;
  width: 25%;
  padding: .5rem;

  /* debug */
  border: 1px solid #990000;
  background: #fff;
}
```

## Extend/Inheritance
Other examples of calling multiple classes is in the footer navigation as well as the #Content and #Sidebar divs.

```html
<ul class="nav-inline pull-right" role="navigation">
```

Another method of reuse in SASS is *@extend* so ```.sample{@extend .example;}``` would apply the *.example*'s style declaration to *.sample*.

## Exercise 4 - Add Response Classes (Quick Lab 15 minutes)

Add the following classes to main.scss update the style declarations so that redundant values are called as variables.

```scss
.text-success {
  color: #3c763d;
}

.text-error {
  color: #8a6d3b;
}

.text-warning {
  color: #a94442;
}

.message {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
  color: #333;
}

.success {
  @extend .message;
  border-color: #3c763d;
  color: #3c763d;
}

.error {
  @extend .message;
  border-color: #8a6d3b;
  color: #8a6d3b;
}

.warning {
  @extend .message;
  border-color: #a94442;
  color: #a94442;
}
```

## Exercise 5 - Implement sass in your project

Move *dist/css/main.css* to *src/scss/main.scss*

```sh
cd /var/www/YOUR-GITHUB-USERNAME.github.io
mkdir -p src/scss
mv dist/css/main.css src/scss/main.scss
```

Then compile the sass file

```sh
sass src/scss/main.scss dist/css/main.css
```

## Additional Resources
* [SASS Reference](http://sass-lang.com/documentation/file.SASS_REFERENCE.html)
* [MDN CSS Clear](https://developer.mozilla.org/en-US/docs/Web/CSS/clear)

## References
1. [bootstrap/scss/_variables.scss](https://github.com/twbs/bootstrap/blob/v4-dev/scss/_variables.scss)
1. [What Does the Clearfix Class Do in CSS?](https://stackoverflow.com/questions/9543541/what-does-the-clearfix-class-do-in-css)

[Next: Gulp](03-Gulp.md)
