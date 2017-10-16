# LESS and SASS

LESS and SASS CSS are the two leading preprocessors. A CSS preprocessor is a superset of CSS which means anything that is written in raw CSS will run under both LESS and SASS. LESS and SASS extends CSS with programming like capabilities; basically variables and limited control statements. This is adventurousness especially when building large front-end frameworks such [Bootstrap](http://getbootstrap.com/) or creating a product with a customizable theme. For example, Bootstrap has a common color for showing danger or errors _#a94442_. If we were to change that color globally we would have to track down every instance of the color and change it manually or we could make a single change to the variable that holds that color.


## [Less](http://lesscss.org/)

Install less, since less is written in Node.JS we will use npm.

````
sudo npm install -g less
````

Variables in less. Less denotes variable with an _@_ at symbol. Less files must have the _.less_ extension.

### Exercise 2 - Less Variables

Create the path _~/less/var.less_ and add the following lines.
````
@font-stack:    "Helvetica Neue",Helvetica,Arial,sans-serif;
@primary-color: #333;

body {
  font: 100% @font-stack;
  color: @primary-color;
}
````

Then run the less compiler against that file.
````
lessc ~/var/less/var.less
````

You will see the following output in the console.
````
body {
  font: 100% "Helvetica Neue",Helvetica,Arial,sans-serif;
  color: #333;
}
````


### [Sass](http://sass-lang.com/)

Install sass, since less is written in ruby we will use gem for the install. Start by installing ruby.

````
sudo apt-get install ruby
sudo su -c "gem install sass"
````
OR

````
sudo apt-get install ruby-sass
````

Variables in Sass. Sass denotes variables with a _$_ dollar sign. For these lessons we will use the newer SCSS syntax for writing our sass files. These files must have the _.scss_ extensions.

### Exercise 2 - Sass Variables

Create the path _~/scss/var.scss_ and add the following lines.
````
$font-stack:    "Helvetica Neue",Helvetica,Arial,sans-serif;
$primary-color: #333;

body {
  font: 100% $font-stack;
  color: $primary-color;
}
````

````
sass ~/scss/var.scss ~/scss/var.css
````
You will see the following output in the console.
````
body {
  font: 100% "Helvetica Neue",Helvetica,Arial,sans-serif;
  color: #333; }
````

### Exercise 3 - Live Reload / Watch a File

The down side to a preprocessor is the compilation step. This takes time and slows down development. We remedy this by creating a *watcher* this watches a target file for changes and rebuilds it's CSS version in the background. This is one less thing you need to think about which can help keep you in flow. Open a split console window and run the following command in one of the panels.

````
sass --watch ~/scss/var.scss:~/scss/var.css
````

You will see the following output
````
>>> Sass is watching for changes. Press Ctrl-C to stop.
  directory ~/scss
      write ~/scss/var.css
      write ~/scss/var.css.map

````

In the second panel open the scss file in vim, make a change and save it using [esc] then ````:x````; You'll notice a change in the first console window with the following output.

````
>>> Change detected to: var.scss
      write ~/scss/var.css
      write ~/scss/var.css.map

````

Open the file *~/scss/var.css* amd verify your changes.

## Exercise 3 - Implement sass in your project

Move */var/www/about/css/dist/main.css* to */var/www/about/css/src/main.scss*

````
mkdir -p /var/www/about/css/src
mv /var/www/about/css/dist/main.css /var/www/about/css/src/main.scss
````

Then compile the sass file

````
sass /var/www/about/css/src/main.scss /var/www/about/css/dist/main.css
````

## Mixins

Later we will learn about the Bootstrap framework. Bootstrap is among the most popular frameworks and as such it gets a lot of criticism. One of the those criticisms is the practice of calling mulitple class on a single element. The claim is that this can reduce load time. Earlier called multiple classes for the top nav ````class="top-nav clearfix"````. The idea here is reusing the clearfix class rather than rewriting it every time we want to use it. Rather that calling two classes we can define a mixin in SASS and reuse it as needed. Now if we need to update our clearfix logic, we can do it in one place and SASS will apply where needed.

## Exercise 4

Create a mix for clearfix by adding the following to the top of */var/www/about/css/src/main.scss*.
````
/* mixins */
/* clear floats */
@mixin clearfix() {
  &:after {
    content: "";
    display: table;
    clear: both;
  }
}
````

Then change the style declarations for to *.clearfix*, *.top-nav* and *#Footer* to the following.
````
.clearfix {
    @include clearfix();
}

nav.top-nav {
    text-align: center;
    background: #aaa;
    @include clearfix();
}

#Footer {
    background: #000;
    color: #fff;
    padding: 1em;
    margin: 0;
    @include clearfix();
}
````

## Extend/Inheritance
Another example of calling multiple classes is in the footer navigation.

````
<ul class="nav-inline pull-right" role="navigation">
````

Another method of reuse in SASS is *@extend* so ````.sample{@extend .example;}```` would apply the *.example*'s style declaration to *.sample*.

### Exercise 4
Remove the class declaration from the from the footer navigation element then add the following to the bottom of */var/www/about/css/src/main.scss*.
````
#Footer ul[role="navigation"] {
  @extend .nav-inline;
  @extend .pull-right;
}
````

Repeat this process for the navigation inside of *.top-nav*.

[SASS Reference](http://sass-lang.com/documentation/file.SASS_REFERENCE.html)
