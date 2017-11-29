# Bootstrap

Bootstrap is a front end component library designed to allow for rapid front end development of responsive websites.

## Additional Resources
[Bootstrap](https://getbootstrap.com/)
### Udemy
[Learn Bootstrap 4 by Example](https://microtrain.udemy.com/learn-bootstrap-4-by-example)

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

## LAB

Add a _bootsrap_ branch to you personal website and rebuild using bootstrap. If you prefer Bootstrap to your native code then create a branch called _vanilla_ to backup that work. Push that branch to GitHub and merge Bootstrap into your master branch (should you so desire).
