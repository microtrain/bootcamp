# Github Pages

GitHub provides a free hosting service called [GitHub Pages](https://pages.github.com/). This is a standard GitHub repository that is hosted as a website. This allows you to post static web content (HTML, CSS, JavaScript, images, videos, etc) to a repository and that content will be served as a live webpage. This is a front-end only service. The exercises in this section will focus on building a website personal web site tailored to developing a personal brand, building a portfolio, etc.

## Exercise 1 - Create your GitHub Pages Repository.
1. Login to github
1. Create a new repository 
    * Repository Name: **YOUR-GITHUB-USERNAME.github.io**
    * Description: *My GitHub Pages Site*. 
    * [x] Public
    * [x] Initialize this repository with a README
    * Add a license: MIT License
1. Clone the repository
```sh
cd /var/www
git clone git@github.com:YOUR-GITHUB-USERNAME/YOUR-GITHUB-USERNAME.github.io.git
cd YOUR-GITHUB-USERNAME.github.io
```
1. Add YOUR-GITHUB-USERNAME.github.io to your VSCode workspace.
1. Create the file index.html
1. Add the minimal template with your name as title content
```html
<!DOCTYPE html>
<html>
    <head>
       <title>Alan Smithee</title>
    </head>
    <body>
    </body>
</html>
```

### Commit you changes and push them to GitHub

```sh
git add .
git commit -a
```

VI will open an ask you to enter a commit message. 
1. Press the letter [i] to enter insert mode. 
1. Then type the message _Proof of concept version_. 
1. Press [esc] followed by [:x] and enter to save the commit message.

Push your changes to the master branch.

```sh
git push origin master
```
[]</> code(https://github.com/microtrain/microtrain.github.io/commit/eb9899ff31d1781498444289ab6561adb5b21bc2) Once you have committed and pushed your changes to master you will be ready to view your changes in both dev and production environments. Dev is aka local changes is where you do your work and/or preview you work prior to making it available to the public. Production is the live version of your website, code, project, etc.

1. Navigate to [http://localhost/YOUR-GITHUB-USERNAME.github.io/](http://localhost/YOUR-GITHUB-USERNAME.github.io/) to view your changes locally.
1. Navigate to [YOUR-GITHUB-USERNAME.github.io/](YOUR-GITHUB-USERNAME.github.io/) to view your changes in production.

### Summary 

In this section you learned how to
* launch a GitHub Pages site

## Exercise 2 - Getting Started

This portfolio site will start off with three pages.
* index.html - Your home page, an introduction.
* resume.html - An HTML based resume.
* contact.html - A form that will allow people to contact you.

We will start by adding navigation and and an header to our form. This version of your site might look a bit odd. Don't worry, we will add some CSS later, this will make it look a modern website.

[</> code](https://github.com/microtrain/microtrain.github.io/commit/4520f8ccfd4c091dd13beec77ed2ad9ccb263940) First add navigation to index.html.

```html
<nav>
  <ul>
    <li><a href="index.html">Home</a></li>
    <li><a href="resume.html">Resume</a></li>
    <li><a href="contact.html">Contact</a></li>
  </ul>
</nav>
```

[</> code](https://github.com/microtrain/microtrain.github.io/commit/1881d80c0638fd77bf0a64d7b7d8bd3c227ed75e) Make two copies of index.html and rename them to resume.html and contact.html. Preview your changes locally, clicking the links will not cause the page to change. Keep an eye on your browsers address bar, if this changes and the page displays no errors, your are ready to push to production. Commit your changes and push master. Go to the production version of you website and test your changes.

## Exercise 3 - HTML Validation
Sometimes our pages do not display as we expect, this is often due to invalid HTML. You can check the validity of your HTML using the W3C Markup Validation Service.

1. Open a browser and go to the [W3C Markup Validation Service](https://validator.w3.org/).
2. Select the third tab _Validate by URI_
3. Enter the address of your GitHub pages site and press the _Check_ button.

## Meta Data
Meta data is data about data. For a typical web page, the data is the content that falls between the opening and closing header tags. Meta data helps to describe and classify that data and/or the functionality of your web page. Meta data can be an attribute of a single element or added to the ```head``` of a document in the form of a meta tag.

Best practices are things that ought to be done given there is not a good reason not to and provided their is not an alternative that better suits a given situation. If I had to pick three pieces of meta data that should always be implemented, they would be as follows.

* ```<html lang="en">``` - Defines the language of the web page. This would most likely be used by assistive technologies such as screen readers or an automated translator.
* ```<meta charset="UTF-8">``` - Defines the character set you are using so that there will be no confusion between your source code and the rendering engine. For a data driven web site you will want your websites encoding to match that of your database; UTF-8 is the most common encoding.
* ```<meta name="viewport" content="width=device-width, initial-scale=1.0">``` - Used by the browser to allow the developer of the site to declare how the site should be viewed across devices.

### Exercise 4 - Meta Data Best Practices
[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/a9675d93f89d43f3a829db78597c616ba786cde0) Update all pages on your GitHub site so that
* The language is declared as _English_.
* The charset is declared as _UTF-8_.
* The view port is declared as _content="width=device-width, initial-scale=1.0_.

Commit all changes and push all changes to master

## [HTML Elements](https://www.w3.org/TR/2011/WD-html5-20110525/elements.html)

As stated in the previous lesson; HTML elements more commonly know as tags are bits of markup that provide semantic meaning to text and objects. This markup is interpreted by outside programs (such as browsers, bots, spiders, crawlers, etc) which will often act on your content based on that contents markup. For example ```<h1>title</h1><h2>Sub Title</h2>``` tells the program reading your page that _Sub Title_ belongs to _title_ and that _title_ should be treated as title of the page (or all content until the next ```<h1>``` tag is encountered) while __Sub Title__ identifies the next block of or all content until the next ```<h2>``` or ```<h1>``` tag is encountered. The original goal of HTML was to provide a common format in which we could send academic research papers over the wire. In short, HTML was designed to mimic a word processor. The body of one of those documents may resemble the following. In most cases your HTML elements will have both an opening and a closing tag. Elements open with ```<[element]>``` and close with ```</[element]>``` the difference here is ```<``` vs ```</```.

### Sample Markup

Just a quick review.

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
* ul - Identifies an unorganized list. This will create a bulleted list. An unorganized MUST contain one or more list items ```<li>```.
* ol - Identifies an organized list. This will create a numbered list. An organized MUST contain one or more list items ```<li>```.
* li - A list item, represents an item in either an unorganized or organized list. This MUST be wrapped in a ```<ul>``` or ```<li>``` element.
* div - Divisions are block level elements that are used to represent divisions in an HTML document. These are typically used to divide a page into sections. These may be used for a logical page division or as anchor to apply style and attributes.
* a - An anchor tag. This is used to create links and is arguably the foundation of the World Wide Web. An anchor tag becomes a link by adding a href [(Hypertext REFerence)](https://www.w3schools.com/tags/att_href.asp) attribute ```<a href="https:\\www.">Example</a>```.

### Sample Markup

Just a quick review

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

## [HTML Global Attributes](https://www.w3.org/TR/2011/WD-html5-20110525/elements.html#global-attributes)

Attributes bring your markup to life. Attributes allow for programming hooks, style and meta-data to be applied to your web page. While HTML has defined a number of standard attributes it allows for custom attributes to be defined. Attributes are key to value pair that can add additional semantics, style or functionality to a element. We learn more about attributes as needed.

### Image Tag

When it comes to working with attributes, the image (img) element is a great place to start. Image is a self-closing tag. Self-closing tags do not require a closing tag because they do not contain any content, they only use attributes to mark content to the screen.

Image has two required attributes src and alt ```<img src="..." alt="...">```. Src tells the document where to find the image to be displayed while alt displays alternative text in case the image cannot be displayed. In most cases an attribute will always have a value, this is written as attribute="Some Value". This is often referred to as a key-value pair. The attribute or left side of the equation is the key and the right side of the equation is the value (conceptually speaking it's key="value").

Before you can add an image, you will need an image to link to. Lets use a Gravatar. Gravatar is a free service that allows a user to upload an avatar that will follow them from site to site by hashing the users email address into the name of a file. This is popular in the dev community and used by other services such as GitHub.

[Gravatar](https://en.gravatar.com/) is a service that provides avatar hosting. For the shake of expedience we will use the default mystery man. Later, If you decide you would like to use this service [head over to Gravatar](https://en.gravatar.com/). Read more about [Gravatar URL settings and parameters](https://en.gravatar.com/site/implement/images/).

* *https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm&s=64*

You would mark this up as:
```html
<img src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm&s=64" alt="My Avatar">
```

### Exercise 5 - Introduce Yourself

[</> code](https://github.com/microtrain/microtrain.github.io/commit/edbc9749f53452564d6e99e8c12902574ac63f2d) Update index.html such that
* The title tag reads *Hello, I am YOUR-NAME*
* Add an H1 element to the body of the document.
  * The contents of this tag SHOULD read *Hello I am YOUR-NAME*
* Create a paragraph tag and say a few sentences about yourself.
* Add an image element to the paragraph tag above the text you just added.
  * The src attribute MUST point to a Gravatar image
  * The value of alt attribute SHOULD be YOUR-NAME

### The Style Attribute

Cascading Style Sheets (CSS) is a language for describing the style of an element. The style attribute in HTML allows you to add a CSS description to a single HTML element. Describing a font's color is a common use of CSS. In CSS we describe style using property's which are key to value pairs separated by a colon [key]:[value]. Using the color property will allow me to describe the font color of an element. We will do a deep dive on CSS late, for now we will give you what you need.

### Exercise 6 - Style an Element

This exercise introduces you to inline styles. Due to there blocking nature we will not use these in production. We will learn more about inline styles in latter lessons.

[</> code](https://github.com/microtrain/microtrain.github.io/commit/ca89eafcd0659bd5a3f98ee3561316b3641318bc) Change index.html such that 
* Text wraps around the image.
* The image provide some margin between itself the the text.
* The image is presented as a circle.

**CSS Attributes**

* border-radius: 50%; - Rounds the corners of a give element. A value of 50% makes a complete circle.
* float: right; - Floats an element to a given position. All surrounding content flows around that float.
* margin-right: 1em; - Provide 1em of margin to the right side of an element.

```html
<img style="border-radius: 50%; float: right; margin-right: 1em;" src="..." alt="...">
```

[Next: Contact Form](03-ContactForm.md)
