# Canvas

The ````canvas```` element was introduced in HTML5, it can be used to draw graphics via JavaScript. This can be used for many purposes including games, visualizations, charts, graphs, etc.


Start by adding a canvas tag to a basic HTML template.
````
<canvas id="canvas" height="600px" width="800px"></canvas>
````

Then you will need to write some JavaScript, for the sake of brevity we will add this directly to the HTML using ````script```` tags.

Start by defining a canvas, this tells JavaScript which element to use as the canvas. This MUST always be a ````canvas```` element.
````
<script>
  var canvas = document.getElementById('canvas');
</script>
````

Then add a context, we will start with the 2D context. A canvas may have only one context so everything you draw gets merged into a single bitmap. Once drawn it is a ll a single image. When the canvas was created it was stored in the object we named ````canvas```` to apply a fill color access the [````getContext()````](https://developer.mozilla.org/en-US/docs/Web/API/HTMLCanvasElement/getContext) method of the ````canvas```` object.
````
<script>
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');
</script>
````

We will start by drawing a rectangle, the first thing you will want to do is choose a fill color for your rectangle. Let's choose this at random. When the context was created it was stored in the object we named ````ctx```` to apply a fill color access the [````fillStyle````](https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/fillStyle) property of the ````ctx```` object.

````
<script>
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');
  ctx.fillStyle = '#' + Math.floor(Math.random()*16777215).toString(16);
</script>
````

Finally, we will access the (````fillRect()````)[https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/fillRect] of our ````ctx```` object.

````
<script>
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');
  ctx.fillStyle = '#' + Math.floor(Math.random()*16777215).toString(16);
  ctx.fillRect(10, 10, 100, 100);
</script>
````

Save the follow to _/var/www/draw/rand.html_. We will use [````Math.random()````](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/random) to draw a square in a random location in the canvas. We will set this to be 100 pixels shy of the canvas height and width so that the box will always appear in range. Navigate to [http://localhost/draw/rand.html](http://localhost/draw/rand.html) and refresh the screen a few times to watch the box move.

````
<!DOCTYPE html>
<html lang="en">
    <head>
       <meta charset="UTF-8">
       <title>Hello World</title>
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

      <canvas id="canvas" height="600px" width="800px"></canvas>

      <script>

        //Plot a random x
        var x = Math.random() * 700;

        //Plot a random y
        var y = Math.random() * 500;

        //Initialize the canvas
        var canvas = document.getElementById('canvas');

        //create a context
        var ctx = canvas.getContext('2d');

        //Create a random color
        ctx.fillStyle = '#' + Math.floor(Math.random()*16777215).toString(16);

        //Create the rectangle
        ctx.fillRect(x, y, 100, 100);

      </script>
    </body>
</html>
````

### Add a circle
[CanvasRenderingContext2D.arc()](https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/arc) is the method used for drawing a circle. For a rectangle the x,y coordinates represent the the top left corner of a the rectangle for a circle x,y represents the center of a circle. Where the third and fourth arguments of fillRect represent the height and width the third and fourth arguments represent the start and ending point of the arc to be drawn, for a complete circle you will always start at 0 and end at tau or pi^2 (2*pi).

Add the following to the bottom of the script tags in your _/var/www/draw/rand.html_ file and refresh the page.
````
//Create a circle
ctx.beginPath();
ctx.arc(230, 400, 83, 0, 2 * Math.PI);
ctx.stroke();
````

## Drawing Program

For this exercise we will create a drawing program. This will allow the user to choose shapes and colors then they will be able to drop images onto the canvas.

Create the paths
* _/var/www/draw/program.html_
* _/var/www/draw/src/js/main.js_
* _/var/www/draw/src/css/main.css_

Add the following to program.html. In this exercise we load [Normailize.css](https://necolas.github.io/normalize.css/) to maintain consistency across browsers.

````
<!DOCTYPE html>
<html lang="en">
    <head>
       <meta charset="UTF-8">
       <title>Draw</title>
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
       <link rel="stylesheet" href="src/css/main.css">
    </head>
    <body>
      <div class="wrapper">
        <nav>
          <ul>
            <li id="trackX"></li>
            <li id="trackY"></li>
          </ul>
        </nav>
        <main></main>
      </div>
      <script src="src/js/main.js"></script>
    </body>
</html>
````

Add the following to _/var/www/draw/src/js/main.js_
````
//Get the height and width of the main we will use this set canvas to the full
//size of the main element.
var mWidth = document.querySelector('main').offsetWidth;
var mHeight = document.querySelector('main').offsetHeight;

//Create the canvas
var canvas = document.createElement("canvas");
canvas.width = mWidth;
canvas.height = mHeight;
document.querySelector('main').appendChild(canvas);

//Create the context
var ctx = canvas.getContext("2d");

//Draw some sample rectangles
ctx.fillStyle = "rgb(200,0,0)";
ctx.fillRect (10, 10, 55, 50);

ctx.fillStyle = "rgba(0, 0, 200, 0.5)";
ctx.fillRect (30, 30, 55, 50);
````

Add the following to _/var/www/draw/src/css/main.css_.
````
.wrapper {
  display: flex;
}

nav {
  flex: 0 0 300px;
  background: #ccc;
  min-height: 100vh;
}

main {
  flex: 1;
}

nav ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

nav ul li {
  padding: 0;
  margin: 0;
}
````

Naviagte to [http://localhost/draw/program.html](http://localhost/draw/program.html) and you'll see a canvas beside a space for a side nav. The canvas will have two rectangles.

In order to be able to draw a we will need to know where our cursor is on the canvas. Let's start by tracking our mouse movements adding an [event listener](https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener) to the canvas. The listener will will trigger functionality every time the pixel position changes by a pixel. We will use [Element.getBoundingClientRect()](https://developer.mozilla.org/en-US/docs/Web/API/Element/getBoundingClientRect) to get the position of the cursor.

````
//Track the x,y position
canvas.addEventListener('mousemove', function(evt) {

  //Calculate the x,y cords.
  var rect = canvas.getBoundingClientRect();
  let x = evt.clientX - rect.left;
  let y = evt.clientY - rect.top;

  //Write the cords back the UI.
  document.getElementById('trackX').innerHTML = 'X: ' + x;
  document.getElementById('trackY').innerHTML = 'Y: ' + y;

}, false);
````

As you move your mouse around the canvas you'll notice the x,y cords now appear in your sidebar.

### Refactoring

So far all of our code has been written out in the global name space which means the data also lives in the global name space. It is considered good practice to restrict access to you program data and methods (functions) to a non-global scope. For this we will use a
(closure)[https://developer.mozilla.org/en-US/docs/Web/JavaScript/Closures]. To me more precise we will use a [closure that emulates private data](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Closures#Emulating_private_methods_with_closures).

Replace
````
var draw = (function() {

  //// This section emulates a public API

  //Get the height and width of the main we will use this set canvas to the full
  //size of the main element.
  var mWidth = document.querySelector('main').offsetWidth;
  var mHeight = document.querySelector('main').offsetHeight;

  //Create the canvas
  var canvas = document.createElement("canvas");

  //Create the context
  var ctx = canvas.getContext("2d");

  //// This section emulates a public API
  return {
    writeXY: function(x,y) {
      document.getElementById('trackX').innerHTML = 'X: ' + x;
      document.getElementById('trackY').innerHTML = 'Y: ' + y;
    },

    // Builds the initial canvas and context
    init: function() {

      canvas.width = mWidth;
      canvas.height = mHeight;
      document.querySelector('main').appendChild(canvas);

    },

    drawRect: function() {
      //Draw some sample rectangles
      ctx.fillStyle = "rgb(200,0,0)";
      ctx.fillRect (10, 10, 55, 50);

      ctx.fillStyle = "rgba(0, 0, 200, 0.5)";
      ctx.fillRect (30, 30, 55, 50);
    },

    //Grants public access to the initialized canvas
    getCanvas: function(){
      return canvas;
    }
  };

})();

draw.init();

var canvas = draw.getCanvas();

//Track the x,y position
canvas.addEventListener('mousemove', function(evt) {
  //Calculate the x,y cords.
  let rect = canvas.getBoundingClientRect();
  let x = evt.clientX - rect.left;
  let y = evt.clientY - rect.top;
  draw.writeXY(x,y);
}, false);
````

## Additional Resources
* [Canvas API](https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API)
* [Radius, diameter, circumference & π](https://www.khanacademy.org/math/basic-geo/basic-geo-area-and-perimeter/area-circumference-circle/v/circles-radius-diameter-and-circumference)
* [Pythagorean Theorem](https://www.khanacademy.org/math/basic-geo/basic-geometry-pythagorean-theorem/geo-pythagorean-theorem/v/the-pythagorean-theorem)

## Additional Reading
* [Random Hex Color Code Generator in JavaScript](https://www.paulirish.com/2009/random-hex-color-code-snippets/)
