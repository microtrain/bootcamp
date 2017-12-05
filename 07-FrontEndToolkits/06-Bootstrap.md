# Bootstrap

Bootstrap is a front end component library designed to allow for rapid front end development of responsive websites.

Lets start by creating a basic minimal Bootstrap layout that loads the Bootstrap assets from a CDN. Create the path and add the following _/var/www/bootstrap/index.html_.
````
<DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap Demo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>

  <body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
````

Add some basic content at the top of the body.
````
<p>Hello World, I'm a Bootstrap layout.</p>
````

Lets center the content by adding a container.
````
<div class="container">
  <p>Hello World, I'm a Bootstrap layout.</p>
</div>
````

Grid layout

Add the following to the _.container_ div below the paragraph. View this in both full screen and in phone mode to see how various view ports change the display.
````
<div class="row">
  <div class="col-md-4">Left Column</div>
  <div class="col-md-4">Center Column</div>
  <div class="col-md-4">Right Column</div>
</div>
````

Add a navigation bar with a logo (just your name is fine).

Add navigation links.

Add a fly out menu to a navigation link.

## LAB - Personal Website

Add a _bootstrap_ directory to your personal website and redesign the UI using bootstrap.

## LAB - Learn a front end library

Using the documentation [Material Design Light](https://getmdl.io/) (and Google) add an _mdl_ directory to your personal website and build an MDL version of your personal web site.

## Additional Resources
[Bootstrap](https://getbootstrap.com/)
### Udemy
[Learn Bootstrap 4 by Example](https://microtrain.udemy.com/learn-bootstrap-4-by-example)
