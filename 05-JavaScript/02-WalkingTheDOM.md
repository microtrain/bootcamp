# Walking the DOM

The Document Object Model (DOM) is an API  that treats markup languages (xml, xhtml, html, ect) as a tree structures. A easier way to think of this might be as an interface that allows a programmer to access tags and the attributes of tags. Later we will learn about jQuery; a library for querying the DOM (among other things). First we will learn basic manipulation using straight JavaScript.

In the previous lesson we used ````document.getElementById();```` this method queries the DOM for an element with a matching id. There are many similar methods.

## By ID

_document.getElementById(id_string)_

````
Return a element object. Returns null if not found.
var elem = document.getElementById("abc");
elem.style.color="red"; // change color to red
````

## By Tag

document.getElementsByTagName(tag_name)

Return a live HTMLCollection.

The tag_name is "div", "span", "p", etc.

var list = document.getElementsByTagName("p"); // get all p elements

list.length; // show number of items

list[0].style.color = "red"; // make the first one red

## By Class

document.getElementsByClassName("class_values")

Return a live HTMLCollection.

The class_values can be multiple classes separated by space. For example: "aa bb", and it'll get elements, where each element is in both class “aa” and “bb”.

// get element of class abc

var list = document.getElementsByClassName("abc");

list[0].style.color = "red"; // make the first one red

## By Name

document.getElementsByName("name_value")

Return a live HTMLCollection, of all elements that have the name="name_value" attribute and value pair.


## By CSS Selector

document.querySelector(css_selector)

Return a non-live HTMLCollection, of the first element that match the CSS selector css_selector. The css_selector is a string of CSS syntax, and can be several selectors separated by comma.

document.querySelectorAll(css_selector)

Return a non-live HTMLCollection, of elements that match the CSS selector css_selector. The css_selector is a string of CSS syntax, and can be several selectors separated by comma.
