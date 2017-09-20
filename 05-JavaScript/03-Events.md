# Events

Events allow a user to interact with a web page. Listeners are used to detect an event being triggered. One might say the web page listens for a click event.


## Onclick

In your browser navigate to http://localhost/mtbc/exercises/javascript/events/onclick.html and open to corresponding file in your editor. Add the following to the body tag of the document and refresh the page.

````
<div id="demo"></div>
<button onclick="document.getElementById('demo').innerHTML = Date()">The time is?</button>
````

The tag _div#demo_ loads with no content. The button's on click attribute is an event listener for a mouse click. The value of onclick is the code that will be executed when the click event is triggered.

### Refactor

````
<div id="demo"></div>
<button onclick="Module.publicMethod();">The time is?</button>
<script>

var Module = (function (event) {

  var privateMethod = function () {
    return Date();
  };

  return {

  publicMethod: function () {
     document.querySelector('#demo').innerHtml = Module.privateMethod();
  }

};
})();

</script>
````




## Additional Reading
[Mastering the Module Pattern](https://toddmotto.com/mastering-the-module-pattern/)
