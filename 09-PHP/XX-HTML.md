# HTML5

## Introduction
This unit will focus on the funedmentals of HTML and building a personal website aimed at personal branding.

## HTML
Hypertext Markup Language (HTML) is a system of elements and attributes that defines the layout of a web page. This system uses markup tags to represent elements (```<p>This is a paragraph.</p>```) and attributes (```<p style="color: blue;">This is a paragraph with blue text.</p>```) to further describe these elements; to define the context of text and objects on a page.

The offical HTML documentation is available from the [W3C](https://www.w3.org/TR/html/) this is the standards version of the documentation aimed at browser makers. The [MDN web docs](https://developer.mozilla.org/en-US/docs/Web/HTML) in my opinion is a better practical source of documentation.

## [HTML Elements](https://developer.mozilla.org/en-US/docs/Web/HTML/Element)
A typical web page is rendered an an HTML document. HTML documents are made up of HTML elements (aks tags). HTML has two types of elements; inline elements and block-level elements. An HTML element will typically have an opening and a closing tag. <[element]>Closing tags have a slash</[element]>.

### A Basic Web Page

The World Wide Web started off as a markup standard for sharing academic research over the internet. In those days you get by with just a few tags. In most cases you could think laying out a web page the same way you might write a college pager. A header, sub headers, paragraphs, images, links, bold, italic, lists and tables. Let's start by exploring a basic web page in the form of an academic paper.

Most HTML documents start with a header. Headers are marked up ```<h*>``` the * can be any value between *1-6* with **1** being the highest. ```<h1>``` opens a header while ```</h1>``` closes a header. Thus these are called opening and closing tags respectively. ```<h1>``` is generally accepted as a page title

#### Headers

Example headers
```html
<h1>This is a level 1 header.</h1>
<h2>This is a level 2 header.</h2>
<h3>This is a level 3 header.</h3>
<h4>This is a level 4 header.</h4>
<h5>This is a level 5 header.</h5>
<h6>This is a level 6 header.</h6>
```

#### Paragraphs

An example paragraph.
```html
<p>This is a paragraph, paragraphs have an opening and closing tags. Paragraphs are block level elements with margins on the top and bottom.</p>
```

#### [Images](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/img)

Images require special arributes. Adding an image tag does not place in image in your page. Rather it creates a refrence to an image and defines a space for that image. It is up to the browser to get the image and display as per the authors wishes.

An image has two required attributes **src** and **alt**. *src* is the URI of the image while *alt* holds a non graphical description.

```html
<img src="https://www.w3.org/html/logo/badge/html5-badge-h-css3-semantics.png" alt="The Semantic Web">
```

#### [Links](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/a)
Anchor *a* elements are used to create hyperlinks commonly called links. These are used to link documents together on the web.

An image has one required attribute **href**. This is the URL to any web resource to which you want to link the current document.

```html
<a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/a">The a tag (HTML Anchor Element)</a>
```

#### [Bold](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/strong)

The *strong* element is typcially rendered in boldfaced type as is the *b* element. The *b* element is considered irrelevent on today's web.

```html
<strong>details of strong importance</strong>
```

#### [Italic](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/em)
The *em* element is typcially rendered in italic type as is the *i* element. The *i* element is considered irrelevent on today's web.

```html
<em>emphasis placed here</em>
```

#### Lists

#### Tables

#### Example paper
```html
<h1>Dogs and Foxes</h1>
<p>The quick brown fox jumps over the lazy dog.</p>

<h2>The truth about dogs</h2>
<p>Some dogs are lazy and just lay around. You can learn more about dogs <a href="https://www.exmample.com/dogs">here</a></p>

<h3>More about dogs</h3>
<p>There are other dog facts that we are about to get into.</p>

<h2>The truth about foxes</h2>
<p>Many foxes are quick and like to jump.</p>

<h3>More about foxes</h3>
<p>There are other fox facts that we are about to get into. You can learn more about foxes <a href="https://www.exmample.com/foxes">here</a></p>
```

## [HTML Comments](https://www.w3.org/TR/html5/syntax.html#comments)
In programming, comments are strings of text that are not processed by a compiler or an interpretor. Comments are for human consumption and are used to help humans follow the flow of source code. Most languages will define their own special syntax for presenting a comment. In HTML, comments are wrapped in comment tags ```<!-- this is a comment -->```.

## The Markup
[HTML5](https://www.w3.org/TR/html5/)

```html
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
```

### Exercise 1 - Hello World, Getting Started With HTML 5

*The exercises in this section will focus on building a website personal web site tailored to developing a personal brand, building a portfolio, etc.*

1. [Create a repo on GitHub](https://help.github.com/articles/create-a-repo/) called _example.com_.
1.  Clone the repo into the top level of your Apache server */var/www*
  * From a command line

```sh
cd /var/www/
git clone https://github.com/YOUR-USERNAME/example.com/
cd /var/www/
```

1. From the VCS explorer add the path named _public/index.html_ to the  project.
1. Open a browser and navigate to [http://localhost/example.com/public/index.html](http://localhost/example.com/public/index.html) (At this point you will see a blank page).
1. Now open the file and paste the above mark markup into the file.
1. Change the title element to ```<title>Hello World</title>```
1. Add an ```h1``` element to the body of the page which also reads _Hello World_ ```<h1>Hello World</h1>```.  
1. Now refresh your browser and you will see the text _Hello World_.
1. Add a paragraph tag below the top level header that reads ```<p>Welcome to my web site.</p>```
1. Commit your changes and push to main.
Stage new files to be committed, in this case _public/public/index.html_.
```sh
git add .
```
Commit all files, you'll be asked for a commit message say something like *Initial page structure*.
```sh
git commit -a
```

Add a comment like _Added the initial home page._ then [esc] _:x_ [enter] to save. Then push your changes to main.
```sh
git push origin main
```

Now you can access your page through the following URL.
* [http://localhost/example.com/public/index.html](http://localhost/example.com/public/index.html)

For a simple site like this you can usally get away with the above URL, for a more complicated site however it's better to work through a domain name. I like to localize my domain names so that I can still get to the production site. I do this with the *loc* prefix so that *example.com* becomes *loc.example.com*.

```sh
cd /etc/apache2/sites-available
sudo vim example.com.conf
```

Add the following
```apache
<VirtualHost 127.0.0.30:80>

        ServerName loc.example.com

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/example.com/public

        # Allow an .htaccess file to ser site directives.
        <Directory /var/www/example.com/public/>
                AllowOverride All
        </Directory>

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```
Open your local hosts files
```sh
sudo vim /etc/hosts
```

Add the following line
```sh
127.0.0.30      loc.example.com
```

Load the configuration and restart the server
```sh
sudo a2ensite example.com && sudo service apache2 restart
```

Navigate to you new local new domain
* [http://loc.example.com](http://loc.example.com)


### Exersice 2 - HTML Validation
Sometimes our pages do not display as we expect, this is often due to invalid HTML. You can check the validity of your HTML using the W3C Markup Validation Service.

1. Open a browser and go to the [W3C Markup Validation Service](https://validator.w3.org/).
2. Select the third tab _Validate by Direct Input_
3. Copy and paste your HTML5 document code into the window and click _Check_.

## Meta Data
Meta data is data  data. For a typical web page, the data is the content that falls between the head and body tags. Meta data helps to describe and classify that data and/or the functionality of your web page. Meta data can be an attribute of a single element or added to the ```head``` of a document in the form of a meta tag.

Best practices are things that ought to be done given there is not a good reason not to and provided their is not an alternative that better suits a given situation. If I had to pick three pieces of meta data that should always be implemented, they would be as follows.

* ```<html lang="en">``` - Defines the language of the web page. This would most likely be used by assistive technologies such as screen readers or an automated translator.
* ```<meta charset="UTF-8">``` - Defines the character set you are using so that there will be no confusion between your source code and the rendering engine. For a data driven web site you will want your websites encoding to match that of your database; UTF-8 is the most common encoding.
* ```<meta name="viewport" content="width=device-width, initial-scale=1.0">``` - Used by the browser to allow the developer of the site to declare how the site should be viewed across devices.

### Exercise 3 - Meta Data Best Practices
Update ex1.html so that
* The language is declared as _English_.
  * Commit with the  message _Set the default langauge to English_
* The charset is declared as _UTF-8_.
  * Commit with the  message _Set the default encoding to utf-8_
* The view port is declared as _content="width=device-width, initial-scale=1.0_.
  * Commit with the  message _Added a responsive viewport_
* Push all changes to main

## [HTML Elements](https://www.w3.org/TR/2011/WD-html5-20110525/elements.html)

HTML elements more commonly know as tags are bits of markup that provide semantic meaning to text and objects. This markup is interpreted by outside programs (such as browsers, bots, spiders, crawlers, etc) which will often act on your content based on that contents markup. For example ```<h1>title</h1><h2>Sub Title</h2>``` tells the program reading your page that _Sub Title_ belongs to _title_ and that _title_ should be treated as title of the page (or all content until the next ```<h1>``` tag is encountered) while __Sub Title__ identifies the next block of or all content until the next ```<h2>``` or ```<h1>``` tag is encountered. The original goal of HTML was to provide a common format in which we could send academic research papers over the wire. In short, HTML was designed to mimic a word processor. The body of one of those documents may resemble the following. In most cases your HTML elements will have both an opening and a closing tag. Elements open with ```<[element]>``` and close with ```</[element]>``` the difference here is ```<``` vs ```</```.

```html
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
```
Lets review some of these tags.
* h1, h2, h3, h4, h5, h6 - HTML supports 6 header levels, these should always be nested.
* p - Identifies text as a paragraph.
* ul - Identifies an unorganized list. This will create a bulleted list. An
unorganized MUST contain one or more list items ```<li>```.
* ol - Identifies an organized list. This will create a numbered list. An
organized MUST contain one or more list items ```<li>```.
* li - A list item, represents an item in either an unorganized or organized list.
This MUST be wrapped in a ```<ul>``` or ```<li>``` element.
* div - Divs are block level elements that are used to represent divisions in an
HTML document. These are typically used to divide a page into sections. These may
be used for a logical page division or as anchor to apply style and attributes.
* a - An anchor tag. This is used to create links and is arguably the foundation
of the World Wide Web. An anchor tag becomes a link by adding a href [(Hypertext
REFerence)](https://www.w3schools.com/tags/att_href.asp) attribute ```<a href="https:\\www.">Example</a>```.

### Exersice 4 - More Elements
Update hello.html as follows. I hope you type this out rather than copy and pasting the entire blob. Read up on character entities by following the links you will be embedding in the page.
```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>World</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <h1>Hello World</h1>
    <p>Welcome to my web site.</p>
    <h2>HTML Elements</h2>
    <p>
    To paraphrase the lesson text [...] For example &lt;h1&gt;h1&lt;h2&gt;title&lt;/h1&gt;... Notice the use of character entities when wanting show the tags in HTML.
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
```

### [HTML Global Attributes](https://www.w3.org/TR/2011/WD-html5-20110525/elements.html#global-attributes)

Attributes bring your markup to life. Attributes allow for programming hooks, style and meta-data to be applied to your web page. While HTML has defined a number of standard attributes it allows for custom attributes to be defined.

### Image Tag

When it comes to working with attributes, the image (img) element is a great place to start. Image is a self-closing tag. Self-closing tags do not require a closing tag because they do not contain any content, they only use attributes to mark content to the screen.

Image has two required attributes src and alt ```<img src="..." alt="...">```. Src tells the document where to find the image to be displayed while alt displays alternative text in case the image cannot be displayed. In most cases an attribute will always have a value, this is written as attribute="Some Value". This is often referred to as a key-value pair. The attribute or left side of the equation is the key and the right side of the equation is the value (conceptually speaking it's key="value").

Before you can add an image, you will need an image to link to. Lets use a Gravatar. Gravatar is a free service that allows a user to upload an avatar that will follow them from site to site by hashing the users email address into the name of a file. This is popular in the dev community and used by other services such as GitHub.

[Head over to Gravatar](https://en.gravatar.com/) and create a profile and use the provided URL, if you do not want to create a Gravatar account use the following URL.

* *https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm*

You would mark this up as:
```html
<img src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm" alt="My Avatar">
```

### Exercise 5 - Add an Image

Create the path */var/www/example.com/public/index.html*.

* Markup a valid HTML 5 template.
* The title tag should read *Hello, I am YOUR-NAME*
* Add an H1 element to the body of the document.
  * The contents of this tag SHOULD read *Hello I am YOUR-NAME*
* Add an image element to below the H1 element.
  * The src attribute MUST point to a Gravatar image
  * The value of alt attribute SHOULD be YOUR-NAME

### The Style Attribute

Cascading Style Sheets (CSS) is a language for describing the style of an element. The style attribute in HTML allows you to add a CSS description to a single HTML element. Describing a font's color is a common use of CSS. In CSS we describe style using property's which are key to value pairs separated by a colon [key]:[value]. Using the color property will allow me to describe the font color of an element.

### Exercise 6 - Style an Element

Change the */var/www/example.com/public/index.html* so that:
* The font color of the top level header is orange.
* The image is presented as a circle.

```html
<h1 style="color: #ff9900;">Hello, I am YOUR-NAME</h1>
<img src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm" alt="My Avatar" style="border-radius: 50%;">
```

### The Class Attribute

Another way to apply a CSS definition to an HTML element is by by defining selectors in a CSS document. A CSS document can be in its own file or you can define a CSS document by adding a style element to the head of an HTML document. We will discuss CSS in detail in later, for now lets apply a quick example.

### Exercise 7 - Style an Element Using Classes

Change the */var/www/example.com/public/index.html* so that:
* The style tags are converted to CSS definitions in the head of the document.
* The style attributes are replaced with calls to the classes.

Add the following to the head element:
```css
<style>
    .header{
      color: #ff9900;
    }

    .img-circle{
      border-radius: 50%;
    }
</style>
```

Update the body of the document as follows:
```html
<h1 class="header">Hello, I am YOUR-NAME</h1>
<img src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm" alt="My Avatar" class="img-circle">
```

### The Title Attribute

In modern browsers, the title attribute provides a tooltip. Hovering your cursor over an element will show the contents of the title attribute.

### Exercise 8 - Add a Tooltip

Change the */var/www/example.com/public/index.html* so that:
* Hover over the image element MUST show your name in a tooltip.

Add the following attribute to the image element, where YOUR-NAME is _your name_:
```htm
title="YOUR-NAME"
```

### The ID Attribute

The _id_ attribute provides a unique identifier for a given HTML element. No two elements in a single document are permitted to have the same id. We will work with the id attribute in later lessons.


### Event Handler Attributes

Event Handler Attributes (UI Events) allow a user to interact with a web page. These interactions are commonly achieved through the use of an event listener. The W3C specification refers to these as [UI Events](https://www.w3.org/TR/uievents/). A common example is the __click event__ which corresponds to the ```onclick``` attribute. ```onclick``` serves as an event handler for JavaScript meaning it listens for a click event click event and executes the attributes value. For example ```<a onclick="alert('I was clicked!')">Click Me</a>``` would cause an alert declaring _"I was clicked!"_ to be displayed on the screen. When using frameworks such as Angular.js you will see custom attributes such as ```ng-click``` in which case Angular.js has custom listeners that are designed to listen specifically for the ```ng-``` prefix. We work with JavaScript in great detail in later lessons. For now, lets apply a quick example.

### Exercise 9 - A Little JavaScript

Change the */var/www/example.com/public/index.html* so that:
* Clicking a button on the page MUST change the color of the H1 tag to red.

Give the h1 element an id of header.
```html
<h1 id="header" class="header">
```

Add a button to the bottom of the page that uses the onclick attribute to invoke a line of JavaScript.
```html
<button onclick="document.getElementById('header').style="color: #ff0000;">Click Me</button>
```


### Exercise 10 - Navigation

Change */var/www/example.com/public/index.html* so that:
* All pages MUST link to each other

Create the following paths with and add the markup as desribed below.
* */var/www/example.com/public/resume.html*
* */var/www/example.com/public/contact.php*

*resume.html*
```html
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Resume</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       <h1>My Resume</h1>
    </body>
</html>
```

```html
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Contact</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       <h1>Contact</h1>
    </body>
</html>
```

Commit your changes with the message _Added a basic file structure_.

Create a nav element that links all of the pages togeather. Place this at the top of each of the three web pages.
```html
<nav>
    <a href="/">Home</a> | 
    <a href="resume.html">Resume</a> |
    <a href="contact.php">Contact</a>
</nav>
```

Commit your changes with the message _Added basic navigation_.

## Lab

Using the *resume.html* file create an HTML verision of your resume

## Additional Resources
* [MDN - HTML](https://developer.mozilla.org/en-US/docs/Web/HTML)
* [Introduction to HTML](https://developer.mozilla.org/en-US/docs/Learn/HTML/Introduction_to_HTML)
* [Choosing a Language Tag](https://www.w3.org/International/questions/qa-choosing-language-tags)
* [IANA Language Subtag Registry](http://www.iana.org/assignments/language-subtag-registry/language-subtag-registry)
* [Why Character Entities](https://stackoverflow.com/questions/1016080/why-are-html-character-entities-necessary)
* [XML and HTML Entieis](https://en.wikipedia.org/wiki/List_of_XML_and_HTML_character_entity_references])
* [The W3C Reference](https://dev.w3.org/html5/html-author/charref])
