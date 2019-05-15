# [jQuery](https://jquery.com/)

According to the jQuery website "jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API that works across a multitude of browsers. With a combination of versatility and extensibility, jQuery has changed the way that millions of people write JavaScript."<sup>[1]</sup>.

*Why we really use it*

* Cross browser compatibility.
* Simply DOM manipulation.
* Nicely encapsulates AJAX functionality.
* A good eco-system, lots of third party plugins.
  * A requirement for Bootstrap.

jQuery allows you to simply manipulate the DOM by calling CSS selectors. This is a little more consistent than the native [_querySelector_](https://stackoverflow.com/questions/11503534/jquery-vs-document-queryselectorall). Legacy browsers do not support _querySelector()_ but that is less of a problem now-a-days.

```js
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
```

```js
//Show an AJAX example
```
## Exercise - NASA API

* Get an [API KEY from NASA](https://api.nasa.gov/index.html#getting-started) by filling out the form and checking your email.
* Clone the html-starter project to */var/www*
* Rename the project to *nasa*
* Add the remotes from your newly created GitHub Project.
* Install your NPM dependencies
* Install normalize.css (NPM)
* Install JQuery (NPM)
* Add normalize.css and jQuery to your Gulp file
* Start your watcher

Create a basic HTML structure and add it to _index.html_.
```html
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>NASA - Astronomy Picture of the Day
  </title>
    <link rel="stylesheet" href="./dist/css/main.css">
  </head>
  <body>
    
    <script src="./dist/js/main.js"></script>
  </body>
</html>
```

Let's create an object (in the form of a closure) called apod (Astronomy Picture of the Day). We will make an AJAX call to the API which will return a JSON string, this is what we will use to build the program. We will test our API access by returning the result of the AJAX request to a console log. Press [F12] and find the console tab in your browsers developer tools.

Add the following to _src/js/main.js_.
```js
var apod = {
    // Application Constructor
    init: function() {

        var url = "https://api.nasa.gov/planetary/apod?api_key=YOUR-KEY-HERE";

        $.ajax({
            url: url
        }).done(function(result){
          console.log(result);
        }).fail(function(result){
          console.log(result);
        });
    },
};

apod.init();
```

and add the follow to _src/scss/main.scss_.
```css
body {
  padding: 0;
  margin: 0;
}

main {
  width: 720px;
  margin: 0 auto;
}

#apodImg {
  max-width: 100%
}

div[id^=apod] {
  padding: .6rem 0;
  font-size: 20px;
}

/* https://alistapart.com/article/creating-intrinsic-ratios-for-video */
/* 9/16 = 56.2 */
#apodVideo {
	position: relative;
	padding-bottom: 56.25%; /* 16:9 */
	padding-top: 25px;
	height: 0;
}

iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}
```

If everything worked you will see results similar to the following.
![results](/img/jquery/results.png)

In looking at the JSON data you'll notice a date field. By default only pull today's picture, looking at the query parameters section in the [API documentation](https://api.nasa.gov/api.html#apod) I see I can pass a date in the form of _YYYY-MM-DDD_ as an additional GET parameter. To make things interesting lets add pass a random date every time we call the API.

Add a random date function to the apod object. A good place to start would be [MDN's date documentation](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date). A qucik Google search will return [this gist](https://gist.github.com/miguelmota/5b67e03845d840c949c4) which provides us a good randomizer for an unformatted date in between a given start and date. This is important because the date cannot be greater than today or less that the first apod _June 16, 1995_.

```js
//Create a random date
randomDate: function(start, end) {
  //Randomize the date https://gist.github.com/miguelmota/5b67e03845d840c949c4
  let date = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));

  //Format the date
  let d = date.getDate();
  let m = date.getMonth() + 1; //In JS months start at 0
  let y = date.getFullYear();

  //Change the maonth and day strings so that they match the documented format.
  if(m < 10){
    m = '0'+m
  }

  if(d < 10){
    d = '0'+d
  }

  return `${y}-${m}-${d}`;
},
```

Update the init() method as follows.
```js
let date = this.randomDate(new Date(1995, 5, 16), new Date());
var url = "https://api.nasa.gov/planetary/apod?api_key=YOUR-DATA-DOT-GOV-API-KEY&date=" + date;
```

Now when you refresh the page you will see different JSON strings.

At this point your JS should resemble the following.
```js
var apod = {
    //Create a random date
    randomDate: function(start, end) {
      //Randomize the date https://gist.github.com/miguelmota/5b67e03845d840c949c4
      let date = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));

      //Format the date
      let d = date.getDate();
      let m = date.getMonth() + 1; //In JS months start at 0
      let y = date.getFullYear();

      //Change the maonth and day strings so that they match the documented format.
      if(m < 10){
        m = '0'+m
      }

      if(d < 10){
        m = '0'+d
      }

      return `${y}-${m}-${d}`;
    },

    // Application Constructor
    init: function() {
        let date = this.randomDate(new Date(1995, 5, 16), new Date());
        var url = "https://api.nasa.gov/planetary/apod?api_key=YOUR-DATA-DOT-GOV-API-KEY&date=" + date;

        $.ajax({
            url: url
        }).done(function(result){
          $("#apodImg").attr("src", result.url);
          $("#apodCopyright").text("Copyright: " + result.copyright);
          $("#apodDate").text("Date: " + date);
          $("#apodDesc").text(result.explanation);
        }).fail(function(data){
          console.log(data);
        });
    },
};
```

Now it's time to build the UI. We will start by deciding what we want to show on the page. For this exercise we will use the _result.url_ (to show the image), _result.copyright_ to give proper attribution, _result.date_, _apodTitle_ and _result.explanation_.

Replace the success callback in your AJAX call with the following. This assumes the DOM has an element for each of the following ids.
* [.attr()](http://api.jquery.com/attr/)
* [.text()](http://api.jquery.com/text/)
```js
.done(function(result){
  $("#apodTitle").text(result.title);
  $("#apodImg").attr("src", result.url).attr('alt', result.title);
  $("#apodCopyright").text("Copyright: " + result.copyright);
  $("#apodDate").text("Date: " + date);
  $("#apodDesc").text(result.explanation);
}).
```

Update _index.html_ with the following.
```html
<h1 id="apodTitle"></h1>
<img id="apodImg">
<div id="apodCopyright"></div>
<div id="apodDate"></div>
<div id="apodDesc"></div>
```

Hard code the date _6/6/2013_ as follows and you will notice there is no image. That is because the picture of the day for this date is a video. In this situation we will want to tell our program how to render a video.
```js
let date = new Date(2013,6,6);//new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
```

If we refer to the JSON string produced by the API we see that there is a _media_type_ field. We can use this to tell our application how to handle the url.

```js
//If the media type is video hide the image elements and display a video.
if(result.media_type === 'video') {
  $("#apodImg").hide();
  $("#apodVideo > iframe").attr("src", result.url).show();
}else{
  $("#apodVideo").hide();
  $("#apodImg").attr("src", result.url).attr('alt', result.title).show();
}
```

Add the following markup either above or below _apodImg__. Refer to the CSS to see how the video class helps us properly size a video.
```html
<div class="video" id="apodVideo">
  <iframe frameborder="0" allowfullscreen></iframe>
</div>
```

##  Single Responsibility Principle

The Single Responsibility Principle is the notion that a class, module, method, etc should only be responsible for one thing. For instance a method called _writeName()_ might be expected to write a name to something. If the method were written as follows, it would be a good example of single responsibility.
```js
writeName(name) {
  $('#firstName').text(name);
}
```

If however, I were to write the following
```js
writeName(id) {
  let db = new DB{'user': 'root', 'password':'1234', 'db':'crm'});
  let results = db.sql('SELECT `name` FROM `contacts` WHERE contact.id=' + id);
  $('#firstName').text(results.name);
}
```
it would be a bad example of single responsibility in that the _writeName()_ method is now responsible for
* Connecting to a database
* Executing a query to to find the name of the desired user.
* Then writing the users name to the DOM.
And we have not even mentioned error handling yet.

As you can see based on a few comments, trying to d o to much on a single method can get out of hand pretty quickly.
```js
writeName(id) {
  let db = new DB{'user': 'root', 'password':'1234', 'db':'crm'});
  //If you cannot connect the the DB
  //Create an error message
  //Figure out the best way to present that error to the user
  ////that would probably have something todo with calling a messaging object or else you'll have even more responsibility in this method
  let results = db.sql('SELECT `name` FROM `contacts` WHERE contact.id=' + id);
  //rinse and repeat
  $('#firstName').text(results.name);
}
```

In our current implementation we are asking a lot of out _init()_ method.

* It makes an AJAX request
* Processes the results
* Deals with errors (kind of)
* Rebuilds the DOM on success
* It initializes the page onload
* Rebuilds the page onclick

My original intent for the _init()_ method was to build the page onload. It's sole responsibility then should be to call the methods required to make that happen.

Straight away I see at least to new methods that get me object closer to SRP.
* _buildDOM()_
* _getRequest()_

```js
//Injects the results of the API call into the DOM
buildDOM: function(result) {
  $("#apodTitle").text(result.title);

  if(result.media_type === 'video') {
    $("#apodImage").hide();
    $("#apodVideo > iframe").attr("src", result.url).show();
  }else{
    $("#apodVideo").hide();
    $("#apodImg").attr("src", result.url).attr('alt', result.title).show();
  }

  $("#apodCopyright").text("Copyright: " + result.copyright);
  $("#apodDate").text("Date: " + result.date);
  $("#apodDesc").text(result.explanation);
},

//Executes an AJAX call to an API.
getRequest: function() {
  let _this = this;
  let date = this.randomDate(new Date(1995, 5, 16), new Date());
  let url = "https://api.nasa.gov/planetary/apod?api_key=YOUR-DATA-DOT-GOV-API-KEY&date=" + date;
  $.ajax({
      url: url
  }).done(function(result){
      _this.buildDOM(result);
  }).fail(function(result){
    console.log(result);
  });
},

// Initialization method.
init: function() {
  this.getRequest();
},
```

This may cause my execution to change as follows. You could also call _apod.gerRequest()_ onload or call _apod.init()_ on click. This is a simple example so the _init()_ method may make a little less sense, in a more complex example the page load would likely have different responsibilities than the click event. In this case one might argue that calling a set of responsibilities in an _init()_ method violates SRP and that these methods should be called individually in a script and I could not argue. At some point you have to make a decision and go with it.

```js
apod.init();

/* https://learn.jquery.com/using-jquery-core/document-ready/ */
$(function() {
    $('#btnRandApod').on('click',function(){
      apod.getRequest();
    });
});
```

## Lab 1 - SRP
Our code now has a pretty good break down, but I see a couple of more things that could be generalized. Review the code and see if you can break some methods down a little further.

## LAB 2 - Convert to Vanilla JS
NASA API in Vanilla JS
* Create the GitHUb project apod-vanilla.
* Clone html-stater or your existing apod project.
* Rewrite the project without the use of jQuery.

Using the jQuery based code from the previous example as a guide, create the same functionality using vanilla JS. This will give you experience in writing AJAX logic using both jQuery and Vanilla JS.

## Lab 3 - Port to jQuery
Create the project draw-jquery.
Recreate the draw program using jQuery


## Additional Resources
* [jQuery](https://jquery.com/)
* [jQuery vs document.querySelectorAll](https://stackoverflow.com/questions/11503534/jquery-vs-document-queryselectorall)
* [Creating Intrinsic Ratios for Video](https://alistapart.com/article/creating-intrinsic-ratios-for-video)
* [JavaScript Object Basics](https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Objects/Basics)

[Next: Front End Toolkits](/08-FrontEndToolkits/README.md)
