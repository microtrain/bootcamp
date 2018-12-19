# [JavaScript Control Structures](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Control_flow_and_error_handling)

Programming is little more that reading data and piecing together statements that take action on that data. Every language will have it's own set of control structures. For most languages a given set of control structures will be almost identical. In the Bash and PHP lessons we learned a few control structures most of which exist in JavaScript. While the syntax may be a little different, the logic remains the same.

## Exercise - If, Else If, Else

Create the following path */var/www/mtbc/js/if_else.html* and open it VSC. Then add the following lines.

```html
<script>

//Initialize your variables
var label = null;
var color = null;
var GET = {};

//parse the GET params out of the URL
if(document.location.toString().indexOf('?') !== -1) {
    var query = document.location
       .toString()
       // get the query string
       .replace(/^.*?\?/, '')
       // and remove any existing hash string (thanks, @vrijdenker)
       .replace(/#.*$/, '')
       .split('&');

    //split each element into key value pairs such that 
    // element 0 is the key and elemet 1 is the value
    for(var i=0, l=query.length; i<l; i++) {
       var kv = decodeURIComponent(query[i]).split('=');
       GET[kv[0]] = kv[1];
    }
}

//Check for get parameters
if(GET['color'] !== 'undefined'){
    color = `#${GET['color']}`;
}

//Can we name the color by it's hex value
if(color == "#ff0000") {
  label = "red";
} else if(color == "#00ff00") {
  label = "green";
} else if(color == "#0000ff") {
  label = "blue";
} else {
  label = "unknown";
}

//Output the data
document.write(`<div style="color:${color}">The color is ${label}</div>`);

</script>
```

Now open a browser and navigate to https://localhost/js/if_else.html and you will see the message _The color is unknown_. Now add the following string to the end of the URL [_?color=ff0000_](https://localhost/js/if_else.html?color=ff0000). Now your message will read _The color is red_ and it will be written in red font. That string you added to the end of the URL is know as a [query string](https://en.wikipedia.org/wiki/Query_string). A query string allows you to pass arguments into a URL. A query string consists of the query string Identifier (a question mark) _?_ and a series of key to value pairs that are separated by an ampersand (_&_). In our example the the _key is color_ color_ and the _value is ff0000_. If you wanted to submit a query of a first and last name that might look like _?first=bob&last=smith_ where first and last are your keys (aka your GET params) bob and smith are your values.

Now let's take a close look at the code. Initializing your variables is a [good practice](https://stackoverflow.com/questions/30955639/is-it-necessary-to-initialize-declare-variable-in-php).

```js
//Initialize your variables
var label = null;
var color = null;
```

JavaScript does not have a ```$_GET``` super global like PHP so we will build one by parsing out the URL
```js
//parse the GET params out of the URL
if(document.location.toString().indexOf('?') !== -1) {
    var query = document.location
       .toString()
       // get the query string
       .replace(/^.*?\?/, '')
       // and remove any existing hash string (thanks, @vrijdenker)
       .replace(/#.*$/, '')
       .split('&');

    for(var i=0, l=query.length; i<l; i++) {
       var aux = decodeURIComponent(query[i]).split('=');
       GET[aux[0]] = aux[1];
    }
}
```


_If GET['color'] is defined then the set the variable color to the value of GET['color']_
```js
//Check for get parameters
if(!empty($_GET['color'])){ //This is a control statement
    //This is the body of the statement
    color = `#${GET['color']}`; //ES^ String literal
}
```

The user has submitted a hex value in the form of a get parameter. Do we know what to the call that hex value? If the answer is yes set the value of _label_ to that color. Otherwise set the value of _label_ to _Unknown_. Or you could say _if the hex value is red then say it is red; otherwise if it green then say it is green; otherwise if it blue then say it is blue; otherwise say unknown_.
```js
//Can we name the color by it's hex value
if(color == "#ff0000") {
  label = "red";
} else if(color == "#00ff00") {
  label = "green";
} else if(color == "#0000ff") {
  label = "blue";
} else {
  label = "unknown";
}
```

Finally we will print some output back to the screen. This time we will wrap the output in some HTML and give it a little style by setting the font color to that of the user input.

```js
document.write(`<div style="color:${color}">The color is ${label}</div>`);
```

## Exercise - For Loop

Add the following to the path _/var/www/mtbc/js/for.html_.
```js
<script>
var items = [
  'for',
  'do...while',
  'for...in',
  'for...of'
];

var msg = 'JavaScript supports ' + items.length + ' types of loop.';

var li = '';
for(i=0; i<items.length; i++){
  li += `<li>${items[i]}</li>`;
}

msg += `<ul>${li}</ul>`;

document.write(msg);
</script>
```

## Exercise - For...in Loop

Add the following to the path _/var/www/mtbc/js/forin.html_.
```html
<script>
var items = {
  0:'for',
  1:'do...while',
  2:'for...in',
  3:'for...of'
};

var msg = 'JavaScript supports ' + Object.keys(items).length + ' types of loop.';

var li = '';
for(var item in items){
  li += `<li>${items[item]}</li>`;
}

msg += `<ul>${li}</ul>`;

document.write(msg);
</script>
```

## Exercise - For...of Loop

Add the following to the path _/var/www/mtbc/js/forof.html_.
```html
<script>
var items = [
  'for',
  'do...while',
  'for...in',
  'for...of'
];

var msg = 'JavaScript supports ' + items.length + ' types of loop.';

var li = '';
for(var item of items){
  li += `<li>${item}</li>`;
}

msg += `<ul>${li}</ul>`;

document.write(msg);
</script>
```

## Exercise  - While Loop

```html
<script>
var items = [
  'for',
  'do...while',
  'for...in',
  'for...of'
];

var msg = 'JavaScript supports ' + items.length + ' types of loop.';
var i=0;
var li = '';
while(i < items.length){
  li += `<li>${items[i]}</li>`;
  i++;
}

msg += `<ul>${li}</ul>`;

document.write(msg);
</script>
```

## Exercise - Do...While

Add the following to the path _/var/www/mtbc/js/do_while.php_.
```html
<script>
var items = [
  'for',
  'do...while statement',
  'labeled statement',
  'break statement',
  'continue statement',
  'for...in statement',
  'for...of statement'
];

var msg = 'JavaScript supports ' + items.length + ' types of loop.';
var i=0;
var li = '';
do {
  li += `<li>${items[i]}</li>`;
  i++;
} while (i < items.length)

msg += `<ul>${li}</ul>`;

document.write(msg);
</script>
```

## Exercise - Switch Statement

```html
<script>

var color = null;
var GET = {};

//parse the GET params out of the URL
if(document.location.toString().indexOf('?') !== -1) {
    var query = document.location
       .toString()
       // get the query string
       .replace(/^.*?\?/, '')
       // and remove any existing hash string (thanks, @vrijdenker)
       .replace(/#.*$/, '')
       .split('&');

    for(var i=0, l=query.length; i<l; i++) {
       var aux = decodeURIComponent(query[i]).split('=');
       GET[aux[0]] = aux[1];
    }
}

//Check for get parameters
if(GET['color'] !== 'undefined'){
    color = `#${GET['color']}`;
}

switch (color) {
  case '#ff9900':
    label = "red";
    break;
  case '#00ff00':
    label = "green";
    break;
  case '#0000ff':
    label = "blue";
    break;
  default:
    label = "unknown";
    break;
}
                                      
//Output the data
document.write(`<div style="color:${color}">The color is ${label}</div>`);
                     
</script>
```

## Additional Resources
* [Control Flow and Error Handling](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Control_flow_and_error_handling)
* [Loops and iteration](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Loops_and_iteration)
* [Switch](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/switch)

[Next: WalkingTheDom](03-WalkingTheDOM.md)
