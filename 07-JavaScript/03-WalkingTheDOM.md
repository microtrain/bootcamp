# Walking the DOM

The Document Object Model (DOM) is an API  that treats markup languages (xml, xhtml, html, ect) as a tree structures. A easier way to think of this might be as an interface that allows a programmer to access tags and the attributes of tags. Later we will learn about jQuery; a library for querying the DOM (among other things). First we will learn basic manipulation using straight JavaScript.

In the previous lesson we used ```document.getElementById();``` this method queries the DOM for an element with a matching id. There are many similar methods.

## [Collection Live vs Static (not live)](https://www.w3.org/TR/dom/#concept-collection)

<blockquote>
  A collection is an object that represents a lists of DOM nodes. A collection can be either live or static. Unless otherwise stated, a collection must be live.<sup>1</sup>
</blockquote>
<blockquote>
  If a collection is live, then the attributes and methods on that object must operate on the actual underlying data, not a snapshot of the data.<sup>1</sup>
</blockquote>
<blockquote>
  When a collection is created, a filter and a root are associated with it.<sup>1</sup>
</blockquote>
<blockquote>
  The collection then represents a view of the subtree rooted at the collection's root, containing only nodes that match the given filter. The view is linear. In the absence of specific requirements to the contrary, the nodes within the collection must be sorted in tree order. <sup>1</sup>

</blockquote>

## By ID

*document.getElementById(id_string)*

Return a element object.

Create the path *mtbc/js/dom/by_id.html*, then open the source file in your editor. Add the following lines to the script tags then refresh the page and note the changes.

```js
var elem = document.getElementById("a"); // Get the elements
elem.style = 'color: #FF0000;'; // change color to red
```

## By Tag

*document.getElementsByTagName(tag_name)*

Return a live HTMLCollection (an array of matching elements).

The tag_name is "div", "span", "p", etc. Navigate to *mtbc/js/dom/by_tag_name.html*, then open the source file in your editor. Add the following lines to the script tags then refresh the page and note the changes.

```js
var list = document.getElementsByTagName('blockquote'); // get all p elements
list[0].style = 'color: #FF0000;';
```

## By Class

*document.getElementsByClassName("class_values")*

Return a live HTMLCollection.

The class_values can be multiple classes separated by space. For example: "a b" and it'll get elements, where each element is in both class “a” and “b”. Navigate to *mtbc/js/dom/by_class_name.html*, then open the source file in your editor. Add the following lines to the script tags then refresh the page and note the changes.

```js
// get all elements of class a
var list = document.getElementsByClassName('b');

// Make it red
list[0].style = 'color: #FF0000;';

// get all elements of class a b
var list2 = document.getElementsByClassName('a b');

//Make them bold and apply the color from list[0]
list2[0].style = 'font-weight: bold; color:' + list[0].style.color;
```

## By Name

*document.getElementsByName("name_value")*
Return a live HTMLCollection, of all elements that have the name="name_value" attribute and value pair.

Navigate to *mtbc/js/dom/dom/by_name.html*, then open the source file in your editor. Add the following lines to the script tags then refresh the page and note the changes.

```js
//Get all elements with a name of a
var list = document.getElementsByName('a');

//Loop through all of the matching elements
for (var i=0; i<list.length; i++) {
  //Make them red
  list[i].style = 'color: #FF0000;';
}
```


## By CSS Selector

*document.querySelector(css_selector)*

Return a non-live HTMLCollection, of the first element that match the CSS selector css_selector. The css_selector is a string of CSS syntax, and can be several selectors separated by comma.

Navigate to *mtbc/js/dom/by_css_selector.html*, then open the source file in your editor. Add the following lines to the script tags then refresh the page and note the changes.

```js
//Find the element with an id of bold
var bold = document.querySelector('#bold');

//Make it bold
bold.style = 'font-weight: bold;';

//Find all elements with a class of blue
var blues = document.querySelectorAll('.blue');

//Loop through all of the matching elements
for (var i=0; i<blues.length; i++) {
  //Make them blue
  blues[i].style = 'color: #0000FF;';
}
```

## Additional Resources  
* <sup>1</sup>[Collections](https://www.w3.org/TR/dom/#concept-collection)

[Next: Events](04-Events.md)