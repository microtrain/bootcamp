# Canvas

The ```canvas``` element was introduced in HTML5, it can be used to draw graphics via JavaScript. This can be used for many purposes including games, visualizations, charts, graphs, etc.

Create a GitHub project called draw.
* Use the [HTML Starter package](https://github.com/microtrain/html-starter) from GitHub.
* Add your new GItHub project as the origin remote.
* Add a canvas tag to the body.
* Change the README file.
```html
<canvas id="canvas" height="600px" width="800px"></canvas>
```

Then you will need to write some JavaScript, for the sake of brevity we will add this directly to the HTML using ```script``` tags.

Start by defining a canvas, this tells JavaScript which element to use as the canvas. This MUST always be a ```canvas``` element.
```html
<script>
  var canvas = document.getElementById('canvas');
</script>
```

Then add a context, we will start with the 2D context. A canvas may have only one context so everything you draw gets merged into a single bitmap. Once drawn it is a ll a single image. When the canvas was created it was stored in the object we named ```canvas``` to apply a fill color access the [```getContext()```](https://developer.mozilla.org/en-US/docs/Web/API/HTMLCanvasElement/getContext) method of the ```canvas``` object.
```html
<script>
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');
</script>
```

We will start by drawing a rectangle, the first thing you will want to do is choose a fill color for your rectangle. Let's choose this at random. When the context was created it was stored in the object we named ```ctx``` to apply a fill color access the [```fillStyle```](https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/fillStyle) property of the ```ctx``` object.

```html
<script>
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');
  ctx.fillStyle = '#' + Math.floor(Math.random()*16777215).toString(16);
</script>
```

Finally, we will access the [```fillRect()```](https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/fillRect) of our ```ctx``` object.

```js
<script>
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');
  ctx.fillStyle = '#' + Math.floor(Math.random()*16777215).toString(16);
  ctx.fillRect(10, 10, 100, 100);
</script>
```

Save the follow to _/var/www/mtbc/draw/rand.html_. We will use [```Math.random()```](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/random) to draw a square in a random location in the canvas. We will set this to be 100 pixels shy of the canvas height and width so that the box will always appear in range. Navigate to [http://localhost/mtbc/draw/rand.html](http://localhost/mtbc/draw/rand.html) and refresh the screen a few times to watch the box move.

```html
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
```

### Add a circle
[CanvasRenderingContext2D.arc()](https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/arc) is the method used for drawing a circle. For a rectangle the x,y coordinates represent the the top left corner of a the rectangle for a circle x,y represents the center of a circle. Where the third and fourth arguments of fillRect represent the height and width the third and fourth arguments represent the start and ending point of the arc to be drawn, for a complete circle you will always start at 0 and end at tau or pi^2 (2*pi).

Add the following to the bottom of the script tags in your _/var/www/mtbc/draw/rand.html_ file and refresh the page.
```js
//Create a circle
ctx.beginPath();
ctx.arc(230, 400, 83, 0, 2 * Math.PI);
ctx.stroke();
```

## Drawing Program

For this exercise we will create a drawing program. This will allow the user to choose shapes and colors then they will be able to drop images onto the canvas.

Create the paths
* _/var/www/draw/program.html_
* _/var/www/draw/src/js/main.js_
* _/var/www/draw/src/css/main.css_

Add the following to program.html. In this exercise we load [Normailize.css](https://necolas.github.io/normalize.css/) to maintain consistency across browsers.

```html
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
```

Add the following to _/var/www/draw/src/js/main.js_
```js
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
```

Add the following to _/var/www/draw/src/css/main.css_.
```css
html {
  font-family: sans-serif;
}

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

nav ul li span,
nav ul li button {
  display: block;
  padding: 1em;
  text-align: center;
}

nav ul li button {
  width: 100%;
}
```

Navigate to [http://localhost/draw/program.html](http://localhost/draw/program.html) and you'll see a canvas beside a space for a side nav. The canvas will have two rectangles.

In order to be able to draw a we will need to know where our cursor is on the canvas. Let's start by tracking our mouse movements adding an [event listener](https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener) to the canvas. The listener will will trigger functionality every time the pixel position changes by a pixel. We will use [Element.getBoundingClientRect()](https://developer.mozilla.org/en-US/docs/Web/API/Element/getBoundingClientRect) to get the position of the cursor.

```js
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
```

As you move your mouse around the canvas you'll notice the x,y cords now appear in your sidebar.

### Refactoring

So far all of our code has been written out in the global name space which means the data also lives in the global name space. It is considered good practice to restrict access to you program data and methods (functions) to a non-global scope. For this we will use a
(closure)[https://developer.mozilla.org/en-US/docs/Web/JavaScript/Closures]. To me more precise we will use a [closure that emulates private data](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Closures#Emulating_private_methods_with_closures).

Replace your JavaScript with the following closure.
```js
var draw = (function() {

  //Get the height and width of the main we will use this set canvas to the full
  //size of the main element.
  var mWidth = document.querySelector('main').offsetWidth,
    mHeight = document.querySelector('main').offsetHeight,

    //Create the canvas
    canvas = document.createElement("canvas"),

    //Create the context
    ctx = canvas.getContext("2d"),

    //Create the initial bounding rectangle
    rect = canvas.getBoundingClientRect(),

    //current x,y position
    x=0,
    y=0;

  return {
    //Set the x,y coords based on current event data
    setXY: function(evt) {
      x = (evt.clientX - rect.left) - canvas.offsetLeft;
      y = (evt.clientY - rect.top) - canvas.offsetTop;
    },

    //Write the x,y coods to the target div
    writeXY: function() {
      document.getElementById('trackX').innerHTML = 'X: ' + x;
      document.getElementById('trackY').innerHTML = 'Y: ' + y;
    },

    //Draw a rectangle
    drawRect: function() {
      //Draw some sample rectangles
      ctx.fillStyle = "rgb(200,0,0)";
      ctx.fillRect (10, 10, 55, 50);
    },

    getCanvas: function(){
      return canvas;
    },

    //Initialize the object, this must be called before anything else
    init: function() {
      canvas.width = mWidth;
      canvas.height = mHeight;
      document.querySelector('main').appendChild(canvas);

    }
  };

})();

//Initialize draw
draw.init();

//Add a mousemove listener to the canvas
//When the mouse reports a change of position use the event data to
//set and report the x,y position on the mouse.
draw.getCanvas().addEventListener('mousemove', function(evt) {
  draw.setXY(evt);
  draw.writeXY();
}, false);

//draw a sample rectangle
draw.drawRect();
```

The previous code creates a draw object which will love on the global name space. The advantage is that the objects data and methods are encapsulated within the closure so they are protected from manipulation from any code that might share a common property name. For example, ```x``` might be a variable name in a third party library you have included in your project, the value of that libraries x could interfere (or collide) with the value of your programs x. Encapsulating as draw.x reduces the chance of collision; treating this a private property protects this even further. You could further protect the draw method by creating a namespace. Reversing your domain name is a common practice for namespacing. The real goal is to try and create something that is as unique as possible, a domain name you own should accomplish this, but it is not required. For the sake of this exercise we will forgo the use of a namespace.
```js
var com.example.app = com.example.app || {};  
com.example.app.draw = (function() {});
```

So far we have created a draw object which creates a canvas, draws a rectangle and reports any mouse movement that occurs on the canvas. It's time to let the user decide what to draw. We will start by removing the command to draw the red rectangle.

Remove the following from your JavaScript
```js
//draw a sample rectangle
draw.drawRect();
```

In order to draw a rectangle we need to know the x,y coordinates of the top left corner as well as the desired height and width. The ```mousemove``` event tells us where we are on the canvas but we need to know where the user wants to draw the triangle and how big they want it. We can figure this out by using two more events ```mousedown``` and ```mouseup```. This will give us the starting and ending points of a mouse drag. ```mousedown``` gives us the starting x,y coordinates or x1,y1. ```mouseup``` gives us the ending x,y coordinates or x2,y2. from tis we can calculate the height and width as _width=x2-x1_ and _h=y2-y1_

We will start by adding variables for x1,y1,x2,y2.

Change
```js
//current x,y position
x=0,
y=0;
```

to
```js
//current x,y
x=0,
y=0,

//starting x,y
x1=0,
y1=0,

//ending x,y
x2=0,
y2=0;
```

Update the drawRect() method as follows.
```js
drawRect: function(x,y,h,w) {

  //Start by using random fill colors.
  ctx.fillStyle = '#'+Math.floor(Math.random()*16777215).toString(16);

  ctx.fillRect (x1,y1,(x2-x1),(y2-y1));

}
```

Now we need to add two methods to set the starting and ending coordinates. Add the following bellow the writeXY() function. In OOP this kind of method is typically referred to a setter. In that the purpose of this method is to set/change the value of a property, typically a private property.
```js
setStart: function() {
  x1=x;
  y1=y;
},

setEnd: function() {
  x2=x;
  y2=y;
},
```

That covers the draw object's implementation details for drawing a rectangle, now all that is left is for us to allow our user to draw the rectangle. We will start by adding a ```mousdown``` listener to the canvas. When this event is triggered we simply call the ```setStart()``` method to record the starting position, this defines the top left corner of the triangle. Add the following to the end of your JavaScript.
```js
//Set the starting position
draw.getCanvas().addEventListener('mousedown', function() {
  draw.setStart();
}, false);

```

To get the ending position we add a ```mouseup``` listener to the canvas and call the ```setEnd()``` method. At this point x1,y1,x2 and y2 are all set, this all we need to draw the rectangle, so we will also call the ```drawRect()``` function. Add the following to the end of your JavaScript.
```js
draw.getCanvas().addEventListener('mouseup', function() {
  draw.setEnd();
  draw.drawRect();
}, false);
```

At this point your JavaScript should read as follows.
```js
var draw = (function() {

  //Get the height and width of the main we will use this set canvas to the full
  //size of the main element.
  var mWidth = document.querySelector('main').offsetWidth,
    mHeight = document.querySelector('main').offsetHeight,

    //Create the canvas
    canvas = document.createElement("canvas"),

    //Create the context
    ctx = canvas.getContext("2d"),

    //Create the initial bounding rectangle
    rect = canvas.getBoundingClientRect(),

    //current x,y position
    x=0,
    y=0,

    //starting x,y
    x1=0,
    y1=0,

    //ending x,y
    x2=0,
    y2=0;

  return {
    //Set the x,y coords based on current event data
    setXY: function(evt) {
      x = (evt.clientX - rect.left) - canvas.offsetLeft;
      y = (evt.clientY - rect.top) - canvas.offsetTop;
    },

    //Write the x,y coods to the target div
    writeXY: function() {
      document.getElementById('trackX').innerHTML = 'X: ' + x;
      document.getElementById('trackY').innerHTML = 'Y: ' + y;
    },

    //Set the x1,y1
    setStart: function() {
      x1=x;
      y1=y;
    },

    //Set the x2,y2
    setEnd: function() {
      x2=x;
      y2=y;
    },

    //Draw a rectangle
    drawRect: function() {
      //Start by using random fill colors.
      ctx.fillStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
      ctx.fillRect (x1,y1,(x2-x1),(y2-y1));
    },

    getCanvas: function(){
      return canvas;
    },

    //Initialize the object, this must be called before anything else
    init: function() {
      canvas.width = mWidth;
      canvas.height = mHeight;
      document.querySelector('main').appendChild(canvas);

    }
  };

})();

//Initialize draw
draw.init();

//Add a mousemove listener to the canvas
//When the mouse reports a change of position use the event data to
//set and report the x,y position on the mouse.
draw.getCanvas().addEventListener('mousemove', function(evt) {
  draw.setXY(evt);
  draw.writeXY();
}, false);

//Add a mousedown listener to the canvas
//Set the starting position
draw.getCanvas().addEventListener('mousedown', function() {
  draw.setStart();
}, false);

//Add a mouseup listener to the canvas
//Set the end position and draw the rectangle
draw.getCanvas().addEventListener('mouseup', function() {
  draw.setEnd();
  draw.drawRect();
}, false);
```

At some point we want to draw shapes other than a rectangle. Let's start by creating a button that allows to choose a rectangle then we can add more buttons for more shapes. Let's by adding a rectangle button to the navigation list. We will give this button an id of _btnRect_.
```html
<li><button id="btnRect">Rectangle</button></li>
```

We will need to two things to make this work (1) wire the button up to an ```onclick``` event listener and (2) wire that ```onclick``` event up draw object so that the object knows what to do. Let's start by adding a shape variable as a private property of the draw object.

Let's change
```js
//ending x,y
x2=0,
y2=0;
```

to
```js
//ending x,y
x2=0,
y2=0,

//What shape are we drawing?
shape='';
```

Now we will need a setter, add the following below the setEnd() method.
```js
//Sets the shape to be drawn
setShape: function(shp) {
  shape = shp;
},
```

Now add a listener to the bottom of the JavaScript file. This is listen for a ```click``` on _btnRect_.
```js
document.getElementById('btnRect').addEventListener('click',function(){
    draw.setShape('rectangle');
}, false);
```

Now that we have set the shape, we need it to cause an effect in the draw object. Add the following below the ```setShape()``` method.
```js
draw: function() {
  if(shape==='rectangle')
  {
    this.drawRect();
  } else {
    alert('Please choose a shape');
  }
},
```

and replace the call to ```draw.drawRect()``` in the  ```mouseup``` listener with ```draw.draw()``` as follows.
```js
draw.getCanvas().addEventListener('mouseup', function() {
  draw.setEnd();
  draw.draw();
}, false);
```

Since drawing on the canvas can change the underlying grid it is a good practice to reset the grid before the next item is drawn on the canvas. This is easily achieved using ```ctx.restore()``` and ```ctx.save()```. The most efficient way to implement this is by adding it to the draw method, that way all future shapes will automatically perform these tasks. You can read more about save and restore [here](https://html5.litten.com/understanding-save-and-restore-for-the-canvas-context/).
```js
//Draws the selected shape
draw: function() {
  ctx.restore();
  if(shape==='rectangle')
  {
    this.drawRect();
  } else {
    alert('Please choose a shape');
  }
  ctx.save();
},
```

Now we want to add more shapes, let's start with a [line](https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/lineTo). To begin drawing a line you need to begin a path, set x1,y1 and x2,y2, then call the stroke method to draw the line. Which looks like the following.
```js
ctx.beginPath();
ctx.moveTo(x1, y1);
ctx.lineTo(x2, y2);
ctx.stroke();
```

We will start by creating a drawLine() method and adding it to our draw method add the following below the ```draw()``` method.
```js
//Draw a line
drawLine: function() {
  //Start by using random fill colors.
  ctx.strokeStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
  ctx.beginPath();
  ctx.moveTo(x1, y1);
  ctx.lineTo(x2, y2);
  ctx.stroke();
},
```

and change the draw method as follows.
```js
//Draws the selected shape
draw: function() {
  ctx.restore();
  if(shape==='rectangle')
  {
    this.drawRect();
  } else if(shape==='line') {
    this.drawLine();
  } else {
    alert('Please choose a shape');
  }
  ctx.save();
},
```

Add a line button the the nav list.
```html
<li><button id="btnLine">Line</button></li>
```

Then a listener for the click event.
```js
document.getElementById('btnLine').addEventListener('click',function(){
    draw.setShape('line');
}, false);
```

Repeat the previous steps but in the context of drawing a circle. The ```drawCircle()``` will simply create an ```alert()``` stating it doesn't do anything. At this point your JavaScript should read as follows.
```js
var draw = (function() {

  //Get the height and width of the main we will use this set canvas to the full
  //size of the main element.
  var mWidth = document.querySelector('main').offsetWidth,
    mHeight = document.querySelector('main').offsetHeight,

    //Create the canvas
    canvas = document.createElement("canvas"),

    //Create the context
    ctx = canvas.getContext("2d"),

    //Create the initial bounding rectangle
    rect = canvas.getBoundingClientRect(),

    //current x,y position
    x=0,
    y=0,

    //starting x,y
    x1=0,
    y1=0,

    //ending x,y
    x2=0,
    y2=0,

    //What shape are we drawing?
    shape='';

  return {
    //Set the x,y coords based on current event data
    setXY: function(evt) {
      x = (evt.clientX - rect.left) - canvas.offsetLeft;
      y = (evt.clientY - rect.top) - canvas.offsetTop;
    },

    //Write the x,y coods to the target div
    writeXY: function() {
      document.getElementById('trackX').innerHTML = 'X: ' + x;
      document.getElementById('trackY').innerHTML = 'Y: ' + y;
    },

    //Set the x1,y1
    setStart: function() {
      x1=x;
      y1=y;
    },

    //Set the x2,y2
    setEnd: function() {
      x2=x;
      y2=y;
    },

    //Sets the shape to be drawn
    setShape: function(shp) {
      shape = shp;
    },

    //Draws the selected shape
    draw: function() {
      ctx.restore();
      if(shape==='rectangle')
      {
        this.drawRect();
      } else if( shape==='line' ) {
        this.drawLine();
      } else if( shape==='circle' ) {
        this.drawCircle();
      } else {
        alert('Please choose a shape');
      }
      ctx.save();
    },


    //Draw a circle
    drawCircle: function() {
      alert('I don\'t do anything yet.');
    },

    //Draw a line
    drawLine: function() {
      //Start by using random fill colors.
      ctx.strokeStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
      ctx.beginPath();
      ctx.moveTo(x1, y1);
      ctx.lineTo(x2, y2);
      ctx.stroke();
    },

    //Draw a rectangle
    drawRect: function() {
      //Start by using random fill colors.
      ctx.fillStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
      ctx.fillRect (x1,y1,(x2-x1),(y2-y1));
    },

    getCanvas: function(){
      return canvas;
    },

    //Initialize the object, this must be called before anything else
    init: function() {
      canvas.width = mWidth;
      canvas.height = mHeight;
      document.querySelector('main').appendChild(canvas);

    }
  };

})();

//Initialize draw
draw.init();

//Add a mousemove listener to the canvas
//When the mouse reports a change of position use the event data to
//set and report the x,y position on the mouse.
draw.getCanvas().addEventListener('mousemove', function(evt) {
  draw.setXY(evt);
  draw.writeXY();
}, false);

//Add a mousedown listener to the canvas
//Set the starting position
draw.getCanvas().addEventListener('mousedown', function() {
  draw.setStart();
}, false);

//Add a mouseup listener to the canvas
//Set the end position and draw the rectangle
draw.getCanvas().addEventListener('mouseup', function() {
  draw.setEnd();
  draw.draw();
}, false);

document.getElementById('btnRect').addEventListener('click', function(){
    draw.setShape('rectangle');
}, false);

document.getElementById('btnLine').addEventListener('click', function(){
    draw.setShape('line');
}, false);

document.getElementById('btnCircle').addEventListener('click', function(){
    draw.setShape('circle');
}, false);

```

and the HTML
```html
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
            <li><span id="trackX"></span></li>
            <li><span id="trackY"></span></li>
            <li><button id="btnRect">Rectangle</button></li>
            <li><button id="btnLine">Line</button></li>
            <li><button id="btnCircle">Circle</button></li>
          </ul>
        </nav>
        <main></main>
      </div>
      <script src="src/js/main.js"></script>
    </body>
</html>
```

We have everything we need to draw a [circle](https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/arc) which in this context is a 360 degree arc. Our starting x,y position (x1, y1) represents the center of the circle our stopping point (x2,y2) rests on the circumference of the circle. With these two points we can use Pythagoreans theorem A<sup>2</sup> + B<sup>2</sup> = C<sup>2</sup> to calculate the radius of the circle.

In code this might look like.
```js
let a = (x1-x2)
let b = (y1-y2)
let radius = Math.sqrt( a*a + b*b );
```

I think the first three arguments in the ```arc()``` method are pretty clear _x,y,radius_. _x,y_ defines the center of the circle and of course _radius_ is what we just calculated. That leaves us with _startAngle_ and _endAngle_. Since we are drawing a complete circle the angle will always start where it ends. This is represented as 0 and 2 times pi ```2*Math.PI```.

Update your ```drawCircle()``` method to the following.
```js
//Draw a circle
drawCircle: function() {

  ctx.strokeStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
  ctx.fillStyle = '#'+Math.floor(Math.random()*16777215).toString(16);

  let a = (x1-x2)
  let b = (y1-y2)
  let radius = Math.sqrt( a*a + b*b );

  ctx.beginPath();
  ctx.arc(x1, y1, radius, 0, 2*Math.PI);
  ctx.stroke();
  ctx.fill();
},
```

### Drawing Paths

We will define a path as a line the follows your cursor during a _mousedown_ (drag) event. There is no context method for this so we will need to create one. How would we define this in code? We start by understanding what it is we want to do.

1. Select a shape called _path_ this will tell the object that we want to draw a path.
1. On _mousedown_ we will start drawing.
1. On _mouseup_ we will stop drawing.
1. Between the _mouseup_ and _mousedown_ we will draw a line every time the mouse reports a move event.
  1. This line will connect the previously reported coordinates to the current coordinates.
    * OR you could say we a drawing a one pixel by one pixel line everytime the mouse moves by one pixel in any direction.

We will start by adding a new button and listener for drawing the path.

The button
```html
<li><button id="btnPath">Path</button></li>
```

and the listener.
```js
document.getElementById('btnPath').addEventListener('click', function(){
    draw.setShape('path');
}, false);
```

As in the previous example we will add a ```drawPath()``` method and add ```drawPath()``` to the draw method.

_drawPath()_
```js
drawPath: function() {
  alert('I don\'t do anything yet.');
},
```

_draw()_
```js
//Draws the selected shape
draw: function() {
  ctx.restore();
  if(shape==='rectangle')
  {
    this.drawRect();
  } else if( shape==='line' ) {
    this.drawLine();
  } else if( shape==='circle' ) {
    this.drawCircle();
  } else {
    alert('Please choose a shape');
  }
  ctx.save();
},
```

At this point, for all previous draw* methods we would complete our implementation details by hooking a few context methods and we would be done with it. For this method to work we need to track the previous x,y state and draw on _mousemove_ instead of _mouseup_ which means we also need to capture a drawing state (we will call that _isDrawing_).

Lets start with by tracking the previous coordinates, we will call these lx,ly (short hand for _last x_ and _last y_).

Add the following variables to as private properties.
```js
//Tracks the last x,y state
lx = false,
ly = false,
```

Update your setXY() method so that it updates lx,ly.
```js
//Set the x,y coords based on current event data
setXY: function(evt) {

  //Track the last x,y position before setting the current position.
  lx=x;
  ly=y;

  //Set the current x,y position
  x = (evt.clientX - rect.left) - canvas.offsetLeft;
  y = (evt.clientY - rect.top) - canvas.offsetTop;
},
```

Now we need to call the draw method from our _mousemove_ listener but only if we have chosen to draw a path. This means we need to expose the private _path_ property through a public api we will call this _getShape()_.
```js
getShape: function() {
  return shape;
},
```

Now that the draw object has a way to report its shape we can use that call the _draw()_ method from the _mousemove_ listener.
```js
draw.getCanvas().addEventListener('mousemove', function(evt) {
  draw.setXY(evt);
  draw.writeXY();
  if(draw.getShape()=='path') {
    draw.draw();
  }
}, false);
```

Now lets implement our _drawPath()_ method. This is almost identical to the _drawLine()_ method. Instead of drawing from x1,y1 to x2,y2 we will draw from lx,ly to x,y.  
```js
drawPath: function() {
  //Start by using random fill colors.
  ctx.strokeStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
  ctx.beginPath();
  ctx.moveTo(lx, ly);
  ctx.lineTo(x, y);
  ctx.stroke();
},
```

Now choosing the path shape and mousing over the canvas will start drawing with out a mouse click. We want a drag to define weather or not the mouse movement should draw we will do this by capturing a state called _isDrawing_.

Add the a  _isDrawing_ variable as a private property.
```js
isDrawing=false;
```

Now we will create a setter and getter to allow us access through a public interface.
```js
setIsDrawing: function(bool) {
  isDrawing = bool;
},

getIsDrawing: function() {
  return isDrawing;
},
```

Now that we have an accessible _isDrawing_ property that we can be toggled from true to false we can use this with our _mousedown_ and _mouseup_ events to control the when and how the path is drawn.
```js
draw.getCanvas().addEventListener('mousemove', function(evt) {
  draw.setXY(evt);
  draw.writeXY();
  if(draw.getShape()=='path' && draw.getIsDrawing()===true) {
    draw.draw();
  }
}, false);
```

At this point your JavaScript should appear as follows.
```js
var draw = (function() {

  //Get the height and width of the main we will use this set canvas to the full
  //size of the main element.
  var mWidth = document.querySelector('main').offsetWidth,
    mHeight = document.querySelector('main').offsetHeight,

    //Create the canvas
    canvas = document.createElement("canvas"),

    //Create the context
    ctx = canvas.getContext("2d"),

    //Create the initial bounding rectangle
    rect = canvas.getBoundingClientRect(),

    //current x,y position
    x=0,
    y=0,

    //starting x,y
    x1=0,
    y1=0,

    //ending x,y
    x2=0,
    y2=0,

    //Tracks the last x,y state
    lx = false,
    ly = false,

    //What shape are we drawing?
    shape='',

    //Are we drawimg a path?
    isDrawing=false;

  return {

    //Set the x,y coords based on current event data
    setXY: function(evt) {

      //Track last x,y position before setting the current posiiton.
      lx=x;
      ly=y;

      //Set the current x,y position
      x = (evt.clientX - rect.left) - canvas.offsetLeft;
      y = (evt.clientY - rect.top) - canvas.offsetTop;
    },

    //Write the x,y coods to the target div
    writeXY: function() {
      document.getElementById('trackX').innerHTML = 'X: ' + x;
      document.getElementById('trackY').innerHTML = 'Y: ' + y;
    },

    //Set the x1,y1
    setStart: function() {
      x1=x;
      y1=y;
    },

    //Set the x2,y2
    setEnd: function() {
      x2=x;
      y2=y;
    },

    //Sets the shape to be drawn
    setShape: function(shp) {
      shape = shp;
    },

    getShape: function() {
      return shape;
    },

    setIsDrawing: function(bool) {
      isDrawing = bool;
    },

    getIsDrawing: function() {
      return isDrawing;
    },

    //Draws the selected shape
    draw: function() {
      ctx.restore();
      if(shape==='rectangle')
      {
        this.drawRect();
      } else if( shape==='line' ) {
        this.drawLine();
      } else if( shape==='path' ) {
        this.drawPath();
      } else if( shape==='circle' ) {
        this.drawCircle();
      } else {
        alert('Please choose a shape');
      }
      ctx.save();
    },

    //Draw a circle
    drawCircle: function() {

      ctx.strokeStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
      ctx.fillStyle = '#'+Math.floor(Math.random()*16777215).toString(16);

      let a = (x1-x2)
      let b = (y1-y2)
      let radius = Math.sqrt( a*a + b*b );

      ctx.beginPath();
      ctx.arc(x1, y1, radius, 0, 2*Math.PI);
      ctx.stroke();
      ctx.fill();
    },

    //Draw a line
    drawLine: function() {
      //Start by using random fill colors.
      ctx.strokeStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
      ctx.beginPath();
      ctx.moveTo(x1, y1);
      ctx.lineTo(x2, y2);
      ctx.stroke();
    },


    drawPath: function() {
      //console.log({x1:x,y1:y,x2:x2,y2:y2});
      //Start by using random fill colors.
      ctx.strokeStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
      ctx.beginPath();
      ctx.moveTo(lx, ly);
      ctx.lineTo(x, y);
      ctx.stroke();
    },

    //Draw a rectangle
    drawRect: function() {
      //Start by using random fill colors.
      ctx.fillStyle = '#'+Math.floor(Math.random()*16777215).toString(16);
      ctx.fillRect (x1,y1,(x2-x1),(y2-y1));
    },

    getCanvas: function(){
      return canvas;
    },

    //Initialize the object, this must be called before anything else
    init: function() {
      canvas.width = mWidth;
      canvas.height = mHeight;
      document.querySelector('main').appendChild(canvas);

    }
  };

})();

//Initialize draw
draw.init();

//Add a mousemove listener to the canvas
//When the mouse reports a change of position use the event data to
//set and report the x,y position on the mouse.
draw.getCanvas().addEventListener('mousemove', function(evt) {
  draw.setXY(evt);
  draw.writeXY();
  if(draw.getShape()=='path' && draw.getIsDrawing()===true) {
    draw.draw();
  }
}, false);

//Add a mousedown listener to the canvas
//Set the starting position
draw.getCanvas().addEventListener('mousedown', function() {
  draw.setStart();
  draw.setIsDrawing(true);
}, false);

//Add a mouseup listener to the canvas
//Set the end position and draw the rectangle
draw.getCanvas().addEventListener('mouseup', function() {
  draw.setEnd();
  draw.draw();
  draw.setIsDrawing(false);
}, false);

document.getElementById('btnRect').addEventListener('click', function(){
    draw.setShape('rectangle');
}, false);

document.getElementById('btnLine').addEventListener('click', function(){
    draw.setShape('line');
}, false);

document.getElementById('btnCircle').addEventListener('click', function(){
    draw.setShape('circle');
}, false);

document.getElementById('btnPath').addEventListener('click', function(){
    draw.setShape('path');
}, false);
```

your HTML should read as follows
```html
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
            <li><span id="trackX"></span></li>
            <li><span id="trackY"></span></li>
            <li><button id="btnRect">Rectangle</button></li>
            <li><button id="btnLine">Line</button></li>
            <li><button id="btnCircle">Circle</button></li>
            <li><button id="btnPath">Path</button></li>
          </ul>
        </nav>
        <main></main>
      </div>
      <script src="src/js/main.js"></script>
    </body>
</html>
```
and your CSS
```css
html {
  font-family: sans-serif;
}

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

nav ul li span,
nav ul li button {
  display: block;
  padding: 1em;
  text-align: center;
}

nav ul li button {
  width: 90%;
  margin: 0 auto;
}
```

## LAB
Now that you can add basic shapes to the canvas lets work on the colors.
* Add color pickers that will allow the user to select the stroke and fill colors for various objects they are using.
  * Hint: HTML5 has a built in form element that spawns a color picker.
* Can you figure out how to draw a triangle?
* A value of 0 should load the the _trackX_ and _trackY_ divs when at page render.

## Additional Resources
* [Canvas API](https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API)
* [Understanding save() and restore() for the Canvas Context](https://html5.litten.com/understanding-save-and-restore-for-the-canvas-context/)
* [Random Hex Color Code Generator in JavaScript](https://www.paulirish.com/2009/random-hex-color-code-snippets/)
* [Number.toString() - it's not what you think](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toString#Description)
### Khan Academy
* [Radius, diameter, circumference & π](https://www.khanacademy.org/math/basic-geo/basic-geo-area-and-perimeter/area-circumference-circle/v/circles-radius-diameter-and-circumference)
* [Pythagorean Theorem](https://www.khanacademy.org/math/basic-geo/basic-geometry-pythagorean-theorem/geo-pythagorean-theorem/v/the-pythagorean-theorem)


[Next: Game](06-Game.md)
