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

## Udemy Modules
[Up and Running with jQuery](https://microtrain.udemy.com/up-and-running-with-jquery/learn/v4/overview)

## Additional Resources
* [jQuery](https://jquery.com/)
* [jQuery vs document.querySelectorAll](https://stackoverflow.com/questions/11503534/jquery-vs-document-queryselectorall)
