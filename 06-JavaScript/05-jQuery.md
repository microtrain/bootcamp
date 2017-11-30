# [jQuery](https://jquery.com/)

According to the jQuery website "jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API that works across a multitude of browsers. With a combination of versatility and extensibility, jQuery has changed the way that millions of people write JavaScript."<sup>[1]</sup>.

*Why we really use it*

* Cross browser compatibility.
* Simply DOM manipulation.
* Nicely encapsulates AJAX functionality.
* A good eco-system, lots of third party plugins.
  * A requirement for Bootstrap.

jQuery allows you to simply manipulate the DOM by calling CSS selectors. This is a little more consitent than the native [_querySelector_](https://stackoverflow.com/questions/11503534/jquery-vs-document-queryselectorall). Legacy browsers do not support _querySelector()_ but that is less of a problem now-a-days.

````
// When an element with the id of _colorChanger_ is clicked apply a red font to all _paragraphs_
$( "#colorChanger" ).on( "click", function( event ) {
  $('p').attr('style', 'color: #ff9900');
});

// When an element with the id of _colorChanger_ is clicked apply a red font to all _paragraphs_ with a class of _.red_
$( "#colorChanger" ).on( "click", function( event ) {
  $('p.red').attr('style', 'color: #ff9900');
});

// When an element with the id of _colorChanger_ is clicked apply a red font to all _elements_ with a class of _.red_
$( "#colorChanger" ).on( "click", function( event ) {
  $('.red').attr('style', 'color: #ff9900');
});
````

````
//Show an AJAX example
````
## Exercise - NASA API

* Get an [API KEY from NASA](https://api.nasa.gov/index.html#getting-started) by filling out the form and checking your email.
* Create the path _/var/www/nasa_.
  * Create _nasa_ as a GitHub project.
* Create the following directory structure
  * _/var/www/nasa/index.html_
  * _/var/www/nasa/src/css/main.css_
  * _/var/www/nasa/src/js/main.js_

Create a basic HTML structure and add it to _index.html_. For this example, lets use NPM and those types of tools???
````
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>NASA - Planet of the Day</title>
    <script src="/src/css/main.css"></script>
  </head>
  <body>

    <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"></script>
    <script src="/src/js/main.js"></script>
  </body>
</html>
````

````
var url = "https://api.nasa.gov/planetary/apod?api_key=YOUR_API_KEY";

$.ajax({
  url: url,
  success: function(result){
    console.log(result);
  }
});
````

## LAB - NASA API in Vanilla JS

Using the jQuery based code from the previous example as a guide, create the same functionality using vanilla JS. This will give you experience in writing AJAX logic using both jQuery and Vanilla JS.


## Lab
Recreate the draw program using jQuery

## Udemy Modules
[Up and Running with jQuery](https://microtrain.udemy.com/up-and-running-with-jquery/learn/v4/overview)

## Additional Resources
* [jQuery](https://jquery.com/)
* [jQuery vs document.querySelectorAll](https://stackoverflow.com/questions/11503534/jquery-vs-document-queryselectorall)
