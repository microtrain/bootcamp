# Events

Events allow a user to interact with a web page. Listeners are background processes that detect (listen for) the triggering of an event. One might say the web page listens for a click event.

Use this template for each of the following exercises.

```
<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Events</title>
  </head>
  <body>

<script>

</script>
  </body>
</html>
```

## Click Event

Add the following to the path */mtbc/js/events/onclick.html* and open to the corresponding file in your editor. In your browser navigate to *localhost.mtbc/js/events/onclick.html*. Add the following to the body tag of the document and refresh the page.

### Exercise 1 - Catch the Click
```html
<div id="demo"></div>
<button onclick="document.getElementById('demo').innerHTML = Date()">What time is it?</button>
```

The tag _div#demo_ loads with no content. The button's on click attribute is an event listener for a mouse click. The value of onclick is the code that will be executed when the click event is triggered.

### Exercise 2 - Refactor the Code

You can execute JavaScript directly in the HTML tag but this is considered bad practice. Let's Add some script tags and function that accepts the target element as an argument.

```html
<button onclick="showDate('demo');">What time is it?</button>
<script>
  function showDate(element) {
     document.getElementById(element).innerHTML = Date();
  }
</script>
```

This is looking pretty good but some circles even argue against using the HTML elements onclick attribute. Let's write a listener in JavaScript.

```html
<button id="time">What time is it?</button>
<script>
  function showDate(element) {
     document.getElementById(element).innerHTML = Date();
  }

  // Function to add event listener to button#time
  var btn = document.getElementById("time");
  btn.addEventListener("click", function(){
      showDate('demo');
  });
</script>
```

Now let's change this to an arrow function. Arrow functions use shorter syntax and do not bind *this*.

```html
<button id="time">What time is it?</button>
<script>
  function showDate(element) {
     document.getElementById(element).innerHTML = Date();
  }

  // Function to add event listener to button#time
  var btn = document.getElementById("time");
  btn.addEventListener("click", ()=>{
    showDate('demo');
  });
</script>
```

## Change Event

A change event listens for a change to a target element. Change events are typically used for picklists.

### Exercise 3 - Catch a Change

In your browser navigate to *mtbc/js/events/onchange.html* and open to corresponding file in your editor.

Add the following to the body tag of the document. Be sure to start the list with an empty option and refresh the page.

```html
<select id="options">
  <option>--Pick an Option--</option>
  <option value="a">A</option>
  <option value="b">B</option>
  <option value="c">C</option>
</select>
```

Add the following to the script tag.
```html
function setValue(element) {
   let option = document.getElementById('options').value;
   document.getElementById(element).innerHTML = option;
}

// Function to add event listener to button#time
var list = document.getElementById("options");
list.addEventListener("change", ()=>{
    setValue('demo')
});
```
## Intervals

While an interval is not technically an event, it does provide a trigger for an interaction to occur. In this case, we will use it with a click event to grow another form element on the screen.

In your browser navigate to *mtbc/js/events/interval.html* and open to the corresponding file in your editor. Add the following to the document and refresh the page. Be sure to read the comments and understand the reasoning behind each line of code.
```html

<style>
    #demo{
    background: #000;
    height: 50px;
    width: 50px;
    }
</style>

<div id="demo"></div>
<button id="GrowBtn">Grow</button>

<script>

</script>
```

Add the following to the script tags of the document and refresh the page.
```html

function Grower() {
  //Get current width of the target element
  this.width  = document.getElementById('demo').offsetWidth;

  //Set a counter to the current width
  this.num = this.width

  //Execute the counter on a set interval
  this.timer = setInterval(() => {
    //Increment the counter
    this.num++;

    //Add one pixel to the width of the target element
    document.getElementById('demo').style = 'width:' + this.num + 'px;';

    //After fifty iterations, kill the loop.
    if(this.num === this.width + 50){
      clearInterval(this.timer);
    }
  }, 1);
}

// Function to add event listener to button#time
var btn = document.getElementById("GrowBtn");
btn.addEventListener("click", function(){
  new Grower();
});
```

## Additional Resources
* [Arrow Functions for Beginners](https://codeburst.io/javascript-arrow-functions-for-beginners-926947fc0cdc)
* [Arrow Functions](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions)
* [Mastering the Module Pattern](https://toddmotto.com/mastering-the-module-pattern/)

[Next: Canvas](05-Canvas.md)
