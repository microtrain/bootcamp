# Bootstrap

Bootstrap is a front end component library designed to allow for rapid front end development of responsive websites.

Let's start by creating a basic minimal Bootstrap layout that loads the Bootstrap assets from a CDN. Create the path and add the following _/var/www/bootstrap/index.html_.
```html
<DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap Demo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  </head>

  <body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
  </body>
</html>
```

Add some basic content at the top of the body.
```html
<p>Hello World, I'm a Bootstrap layout.</p>
```

Lets center the content by adding a container.
```html
<div class="container">
  <p>Hello World, I'm a Bootstrap layout.</p>
</div>
```

Grid layout

Add the following to the _.container_ div below the paragraph. View this in both full screen and in phone mode to see how various view ports change the display.
```html
<div class="row">
  <div class="col-md-4">Left Column</div>
  <div class="col-md-4">Center Column</div>
  <div class="col-md-4">Right Column</div>
</div>
```

* Add a navigation bar with a logo (just your name is fine)
* Add navigation links
* Add cards in a grid
* Add a jumbotron

> In 5.0+  The jumbotron component is removed in favor of utility classes like .bg-light for the background color and .p-* classes to control padding.
> Jumbotron is a lightweight, flexible component that can optionally extend the entire viewport to showcase key marketing messages on your site.
> Use [Jumbotron v4.6](https://getbootstrap.com/docs/4.6/components/jumbotron/)


## LAB - Personal Website

Add a _bootstrap_ directory to either /var/www or you GitHub Pages project and redesign the UI using bootstrap.


## Additional Resources
* [Bootstrap](https://getbootstrap.com/)

[Next: PHP](/09-PHP/README.md)
