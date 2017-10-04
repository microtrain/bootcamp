# HTML5

Hypertext Markup Language (HTML) is a system of elements and attributes that
defines the layout of a web page. This system uses markup tags to represent
elements
(````<p>This is a paragraph.</p>````) and
attributes (````<p style="color: blue;">This is a paragraph with blue text.</p>````)
to further describe these elements; to define the context of text and
objects on a page.

## [HTML Comments](https://www.w3.org/TR/html5/syntax.html#comments)
In programming, comments are strings of text that are not processed by a compiler or an interpretor. Comments are for human consumption and are used to help humans follow the flow of source code. Most languages will define their own special syntax for presenting a comment. In HTML, comments are wrapped in comment tags ````<!-- this is a comment -->````.

## The Markup
[HTML5](https://www.w3.org/TR/html5/)

````
<!DOCTYPE html>
<html>
    <head>
       <!-- meta data goes here -->
       <title><!-- Page Title --></title>
    </head>
    <body>
        <!-- layout and content goes here-->
    </body>
</html>
````

### Exercise 1 - Hello World, Getting Started With HTML 5

1. Create the file path */var/www/bootcamp/exercises/html/hello.html*.
2. Open a browser and navigate to [http://localhost/bootcamp/exercises/html/ex1.html](http://localhost/bootcamp/exercises/html/hello.html) (At this point you will see a blank page).
3. Now open Atom and add a new project folder; choose the path ````/var/www/bootcamp```` and drill down to the newly created ex1.html file.
4. Now open the file and paste the above mark markup into the file.
5. Change the title element to ````<title>Hello World</title>````
6. Add an ````h1```` element to the body of the page which also reads _Hello World_ ````<h1>Hello Wolrd</h1>````.  
7. Now refresh your browser and you will see the text _Hello World_.

The result will be as follows
````
<!DOCTYPE html>
<html>
    <head>
       <title>Hello World</title>
    </head>
    <body>
        <h1>Hello World</h1>
    </body>
</html>
````

### Exersice 2 - HTML Validation
Sometimes our pages do not display as we expect, this is often due to invalid HTML. You can check the validity of your HTML using the W3C Markup Validation Service.

1. Open a browser and go to the [W3C Markup Validation Service](https://validator.w3.org/).
2. Select the third tab _Validate by Direct Input_
3. Copy and paste your HTML5 document code into the window and click _Check_.

## Meta Data
Meta data is data about data. For a typical web page, the data is the content that falls between the head and body tags. Meta data helps to describe and classify that data and/or the functionality of your web page. Meta data can be an attribute of a single element or added to the ````head```` of a document in the form of a meta tag.

Best practices are things that ought to be done given there is not a good reason not to and provided their is not an alternative that better suits a given situation. If I had to pick three pieces of meta data that should always be implemented, they would be as follows.

* ````<html lang="en">```` - Defines the language of the web page. This would most likely be used by assistive technologies such as screen readers or an automated translator.
* ````<meta charset="UTF-8">```` - Defines the character set you are using so that there will be no confusion between your source code and the rendering engine. For a data driven web site you will want your websites encoding to match that of your database; UTF-8 is the most common encoding.
* ````<meta name="viewport" content="width=device-width, initial-scale=1.0">```` - Used by the browser to allow the developer of the site to declare how the site should be viewed across devices.

### Exersice 3 - Meta Data Best Practices
Update ex1.html so that
* The language is declared as _English_.
* The charset is declared as _UTF-8_.
* The view port is declared as _content="width=device-width, initial-scale=1.0_.

#### Notes
[Choosing a Language Tag](https://www.w3.org/International/questions/qa-choosing-language-tags)
[IANA Language Subtag Registry](http://www.iana.org/assignments/language-subtag-registry/language-subtag-registry)

## [HTML Elements](https://www.w3.org/TR/2011/WD-html5-20110525/elements.html)

HTML elements more commonly know as tags are bits of markup that provide semantic
meaning to text and objects. This markup is interpreted by outside programs (such
as browsers, bots, spiders, crawlers, etc) which will often act on your content
based on that contents markup. For example ````<h1>title</h1><h2>Sub Title</h2>```` tells
the program reading your page that _Sub Title_ belongs to _title_ and that
_title_ should be treated as title of the page (or all content until the next
````<h1>```` tag is encountered) while __Sub Title__ identifies the next block of
or all content until the next ````<h2>```` or ````<h1>```` tag is encountered.
The original goal of HTML was to provide a common format in which we could send
academic research papers over the wire. In short, HTML was designed to mimic a word
processor. The body of one of those documents may resemble the following. In
most cases your HTML elements will have both an opening and a closing tag. Elements
open with ````<[element]>```` and close with ````</[element]>```` the difference
here is ````<```` vs ````</````.

````
<h1>HTML Elements</h1>
<p>HTML elements more commonly know as tags are bits of markup...</p>
<h2>HTML Global Attributes</h2>
<p>Attributes bring your markup to life. Attributes allow for programming...</p>
<h3>Event Handler Attributes</h3>
<p>Event Handler Attributes (UI Events) allow a user to interact...</p>
<p>Here a list of...</p>
<ul>
    <li>Item one</li>
    <li>Item two</li>
    <li>Item three</li>
</ul>
<h2>Summary</h2>
<p>In summation...</p>
````
Lets review some of these tags.
* h1, h2, h3, h4, h5, h6 - HTML supports 6 header levels, these should always be nested.
* p - Identifies text as a paragraph.
* ul - Identifies an unorganized list. This will create a bulleted list. An
unorganized MUST contain one or more list items ````<li>````.
* ol - Identifies an organized list. This will create a numbered list. An
organized MUST contain one or more list items ````<li>````.
* li - A list item, represents an item in either an unorganized or organized list.
This MUST be wrapped in a ````<ul>```` or ````<li>```` element.
* div - Divs are block level elements that are used to represent divisions in an
HTML document. These are typically used to divide a page into sections. These may
be used for a logical page division or as anchor to apply style and attributes.
* a - An anchor tag. This is used to create links and is arguably the foundation
of the World Wide Web. An anchor tag becomes a link by adding a href [(Hypertext
REFerence)](https://www.w3schools.com/tags/att_href.asp) attribute ````<a href="https:\\www.example.com">Example</a>````.

### Exersice 4 - More Elements
Update hello.html as follows. I hope you type this out rather than copy and pasting the entire blob. Read up on character entities by following the links you will be embedding in the page.
````
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>World</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <h1>Hello World</h1>
    <h2>HTML Elements</h2>
    <p>
    To paraphrase the lesson text [...] For example &lt;h1&gt;h1&lt;h2&gt;title&lt;/h1&gt;... Notice the use of charatcer entities when wanting show the tags in HTML.
    </p>
    <h2>Character Entities</h2>
    <p>Since the keyboard does not have a &copy; key we need a way to reference this so we say &amp;copy;. Additionally, greater than and less than are interpreted as HTML tags. These are examples of symbols that we may want to display but will not be able to with out a work around. This is where character entities come into play. </p>
    <ul>
        <li><a href="https://stackoverflow.com/questions/1016080/why-are-html-character-entities-necessary">A Stack Overflow thread on the topic.</a></li>
        <li><a href="https://en.wikipedia.org/wiki/List_of_XML_and_HTML_character_entity_references">A Wikipedia artcile on the topic.</a></li>
        <li><a href="https://dev.w3.org/html5/html-author/charref">The W3C reference.</a></li>
    </ul>
    <h2>Summary</h2>
    <p>In summation...</p>
  </body>
</html>
````


#### Lab 1 - Your HTML Resume

[Create a repo on GitHub](https://help.github.com/articles/create-a-repo/) called resume.

Clone the repo into the top level of your Apache server */var/www*

From a command lin
````
cd /var/www/
git clone https://github.com/YOUR-USERNAME/resume
cd /var/www/resume
````

Add the path _/var/www/resume_ as a project in Atom. From Atom's navigation pane add a file named _index.html_ to the project and add the following markup.

````
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><!-- Your Name Here --></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <!-- Your Resume Here -->
  </body>
</html>
````

Commit your changes and push them to the repository.

Stage new files to be committed, in this case _index.html_.
````
git add .
````

Commit the files with a message and push them to master.
````
git commit -m 'Added basic HTML structure'
git push origin master
````

Using the knowledge you gained thus far create an HTML version of your resume. Be sure the apply your markup between the opening and closing body tags. You can see your changes by opening a browser and navigating to http://localhost/resume/index.html. Make incremental commits with relevant messages and push the changes to GitHub as you progress through this lab.

As you learn more, return to this project to add more content and style to your resume.

### [HTML Global Attributes](https://www.w3.org/TR/2011/WD-html5-20110525/elements.html#global-attributes)

Attributes bring your markup to life. Attributes allow for programming hooks, style and meta-data to be applied to your web page. While HTML has defined a number of standard attributes it allows for custom attributes to be defined.

#### Image Tag

When it comes to working with attributes, the image (img) element is a great place to start. Image is a self-closing tag. Self-closing tags do not require a closing tag because they do not contain any content, they only use attributes to mark content to the screen.

Image has two required attributes src and alt ````<img src="..." alt="...">````. Src tells the document where to find the image to be displayed while alt displays alternative text in case the image cannot be displayed. In most cases an attribute will always have a value, this is written as attribute="Some Value". This is often referred to as a key-value pair. The attribute or left side of the equation is the key and the right side of the equation is the value (conceptually speaking it's key="value").

Before you can add an image, you will need an image to link to. Lets use a Gravatar. Gravatar is a free service that allows a user to upload an avatar that will follow them from site to site by hashing the users email address into the name of a file. This is popular in the dev community and used by other services such as GitHub.

[Head over to Gravatar](https://en.gravatar.com/) and create a profile and use the provided URL, if you do not want to create a Gravatar account use the following URL.

* *https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm*

You would mark this up as:
````
<img src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm" alt="My Avatar">
````

## Exercise 5 - Add an Image

Create the path */var/www/bootcamp/exercises/html/iam.html*.

* Markup a valid HTML 5 template.
* The title tag should read *Hello I am YOUR-NAME*
* Add an H1 element to the body of the document.
  * The contents of this tag SHOULD read *Hello I am YOUR-NAME*
* Add an image element to below the H1 element.
  * The src attribute MUST point to a Gravatar image
  * The value of alt attribute SHOULD be YOUR-NAME


### Event Handler Attributes

Event Handler Attributes (UI Events) allow a user to interact with a web page. These interactions are commonly achieved through the use of an event listener. The W3C specification refers to these as [UI Events](https://www.w3.org/TR/uievents/). A common example is the __click event__ which corresponds to the ````onclick```` attribute. ````onclick```` serves as an event handler for JavaScript meaning it listens for a click event click event and executes the attributes value. For example ````<a onclick="alert('I was clicked!')">Click Me</a>```` would cause an alert declaring _"I was clicked!"_ to be displayed on the screen. When using frameworks such as Angular.js you will see custom attributes such as ````ng-click```` in which case Angular.js has custom listeners that are designed to listen specifically for the ````ng-```` prefix.
