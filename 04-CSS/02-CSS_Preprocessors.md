# LESS and SASS

LESS and SASS CSS are the two leading preprocessors. A CSS preprocessor is a superset of CSS which means anything that is written in raw CSS will run under both LESS and SASS. LESS and SASS extends CSS with programming like capabilities; basically variables and limited control statements. This is adventurousness especially when building large front-end frameworks such [Bootstrap](http://getbootstrap.com/) or creating a product with a customizable theme. For example, Bootstrap has a common color for showing danger or errors _#a94442_. If we were to change that color globally we would have to track down every instance of the color and change it manually or we could make a single change to the variable that holds that color.


## [Less](http://lesscss.org/)

Install less, since less is written in Node.JS we will use npm.

````
sudo npm install -g less
````

Variables in less. Less denotes variable with an _@_ at symbol. Less files must have the _.less_ extension.

### Exercise 1 - Less Variables

Create the path _/var/www/mtbc/ex*/less/var.less_ and add the following lines.
````
@font-stack:    Helvetica, sans-serif;
@primary-color: #333;

body {
  font: 100% @font-stack;
  color: @primary-color;
}
````

Then run the less compiler against that file.
````
lessc /var/www/mtbc/ex*/less/var.less
````

You will see the following output in the console.
````
body {
  font: 100% Helvetica, sans-serif;
  color: #333;
}
````


### [Sass](http://sass-lang.com/)

Install sass, since less is written in ruby we will use gem for the install. Start by installing ruby.

````
sudo apt-get install ruby
sudo su -c "gem install sass"
````

Variables in Sass. Sass denotes variables with a _$_ dollar sign. For these lessons we will use the newer SCSS syntax for writing our sass files. These files must have the _.scss_ extensions.

### Exercise 1 - Sass Variables

Create the path _/var/www/mtbc/ex*/less/var.scss_ and add the following lines.
````
$font-stack:    Helvetica, sans-serif;
$primary-color: #333;

body {
  font: 100% $font-stack;
  color: $primary-color;
}
````

You will see the following output in the console.
````
body {
  font: 100% Helvetica, sans-serif;
  color: #333; }
````
