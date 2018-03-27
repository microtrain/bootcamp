# HTML5

## Introduction
This unit will focus on the funedmentals of HTML and building a personal website aimed at personal branding.

## HTML
Hypertext Markup Language (HTML) is a system of elements and attributes that defines the layout of a web page. This system uses markup tags to represent elements (```<p>This is a paragraph.</p>```) and attributes (```<p style="color: blue;">This is a paragraph with blue text.</p>```) to further describe these elements; to define the context of text and objects on a page.

The offical HTML documentation is available from the [W3C](https://www.w3.org/TR/html/) this is the standards version of the documentation aimed at browser makers. The [MDN web docs](https://developer.mozilla.org/en-US/docs/Web/HTML) in my opinion is a better practical source of documentation.

## [HTML Elements](https://developer.mozilla.org/en-US/docs/Web/HTML/Element)
A typical web page is rendered an an HTML document. HTML documents are made up of HTML elements (aks tags). HTML has two types of elements; inline elements and block-level elements. An HTML element will typically have an opening and a closing tag. <[element]>Closing tags have a slash</[element]>.

### A Basic Web Page

The World Wide Web started off as a markup standard for sharing academic research over the internet. In those days you get by with just a few tags. In most cases you can think about laying out a webpage in the same way you might layout a college paper. A headers, sub headers, paragraphs, images, links, bold, italic, lists and tables. Let's start by exploring a basic web page in the form of an academic paper.

Most HTML documents start with a header. Headers are marked up ```<h*>``` the * can be any value between *1-6* with **1** being the highest. ```<h1>``` opens a header while ```</h1>``` closes a header. Thus these are called opening and closing tags respectively. ```<h1>``` is generally accepted as a page title

#### [Headers](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/Heading_Elements)

Headers are used for creating sections on a web page. A typical webpage only has a single **h1** tag which servers as a page or article title. Eveything under the **h1** tag should be in some way related to that title. **h2** is the first sub-heading and creates a sub-section under **h1**. Likewise **h3** creates a sub section under **h2** and this repeates all the way down to **h6**. A second **h2** tag creates a new sub section that should be related to **h1** but not necessarily to the first **h2** element. This same notion holds true for all tags all the way down to **h6**.

```html
<h1>This is a level 1 header.</h1>
<h2>This is a level 2 header.</h2>
<h3>This is a level 3 header.</h3>
<h4>This is a level 4 header.</h4>
<h5>This is a level 5 header.</h5>
<h6>This is a level 6 header.</h6>
```

#### Paragraphs

As it's name suggests a paragraph element holds a pargraph. In the academic paper on or many paragraphs may appear under a single header.

```html
<p>This is a paragraph, paragraphs have an opening and closing tags. Paragraphs are block level elements with margins on the top and bottom.</p>
```

#### [Images](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/img)

The image element **img** is used to reference an image. Moderen graphical browsers display these as a part of the webpage. Adding an image tag does not place in image in your page. Rather it creates a refrence to an image and may define a space for that image. It is up to the browser to get the image and display as per the authors wishes. 

An image has two required attributes **src** and **alt**. **src** is the URI of the image while **alt** holds a non graphical description.

```html
<img src="https://www.w3.org/html/logo/badge/html5-badge-h-css3-semantics.png" alt="The Semantic Web">
```

#### [Links](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/a)

Anchor **a** elements are used to create hyperlinks commonly called links. These are used to link documents together on the web.

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

[Ordered](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/ol) **ol** and [unordered](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/ul) **ul** present a list of items in a numeric or bulleted format. Each item in a list must be represented as a [list item](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/li) element **li**. 

```html
<ol>
  <li>list item number 1</li>
  <li>list item number 2</li>
</ol>

<ul>
  <li>first bulleted item</li>
  <li>second bulleted item</li>
</ul>
```

#### [Tables](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/table)

A table represents tabular data, think of a simple spreadsheet.

```html
<table>
  <thead>
    <tr>
      <th>Element</th>
      <th>Display</th>
      <th>Style</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>div</td>
      <td>block</td>
      <tdh>none</td>
    </tr>
    <tr>
      <td>span</td>
      <td>inline</td>
      <td>none</td>
    </tr>
    <tr>
      <td>p</td>
      <td>block</td>
      <td>
        margin-top: 1em;
        margin-bottom: 1em;
      </td>
    </tr>
    <tr>
      <td>a</td>
      <td>inline</td>
      <td>
        color: (internal value);<br>
        text-decoration: underline;<br>
        cursor: auto;<br>
      </td>
    </tr>
  </tbody>
</table>
```

#### [HTML Comments](https://www.w3.org/TR/html5/syntax.html#comments)
In programming, comments are strings of text that are not processed by a compiler or an interpretor. Comments are for human consumption and are used to help humans follow the flow of source code. Most languages will define their own special syntax for presenting a comment. In HTML, comments are wrapped in comment tags ```<!-- this is a comment -->```.

#### Content Example

The following would appear inside the body tags.

```html
<h1>HTML5 </h1>
<p>HTML5 adds semantics, ARIA and multimedia support to the HTML specification.</p>

<h2>Semantics</h2>

<p>New elements such as <em>article, header, footer, nav, section, aside</em> allow screen readers to better understand your pages layout. This make the web a better place for people with vision problems.</p>

<ul>
  <li><strong>article</strong> - a self contained composition.</li>
  <li><strong>header</strong> - introductory content for a given section.</li>
  <li><strong>footer</strong> - genenrally contains meta data for a given section. </li>
  <li><strong>nav</strong> - provides navigation links for a website/page.</li>
  <li><strong>section</strong> - a stand alone section similar to **div**.</li>
  <li><strong>aside</strong> - indirectly related to the main content.</li>
</ul>

<h2>ARIA</h2>
<p><a href="https://www.w3.org/TR/html-aria/">ARIA</a> allows developer to specify page landmarks by assigning roles to specific elements. Much like semantic elements these landmarks mak it easier for screen reader to understand a webpage.</p>

<h2>Multimedia</h2>
<p>New elements such as <em>audio, video and canvas</em> add built in support for audio, video, gamming and web applications.</p>

<h3>Audio</h3>
<p>The <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/audio">audio</a> element embeds audio into a webpage without the use of akward embed or object elements.</p>

<h3>Video</h3>
<p>The <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/video">video</a> elements embeds video into a webpage without the use of akward embed or object elements.</p>

<h3>Canvas</h3>
<p>The <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/canvas">canvas</a> element allocates a section of the page as JavaScript application. Here you can create games, interactive applications or visual effects. Prior to canvas we were forced to use plugins or other non-standard methods such as Flash, SilverLight, ActiveX, Java Applets, etc.</p>

<h2>Element Details</h2>
<p>This section describes a number of default attributes associated with various HTML tags.</p>
<table>
  <thead>
    <tr>
      <th>Element</th>
      <th>Display</th>
      <th>Style</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>div</td>
      <td>block</td>
      <tdh>none</td>
    </tr>
    <tr>
      <td>span</td>
      <td>inline</td>
      <td>none</td>
    </tr>
    <tr>
      <td>p</td>
      <td>block</td>
      <td>
        margin-top: 1em;
        margin-bottom: 1em;
      </td>
    </tr>
    <tr>
      <td>a</td>
      <td>inline</td>
      <td>
        color: (internal value);<br>
        text-decoration: underline;<br>
        cursor: auto;<br>
      </td>
    </tr>
  </tbody>
</table>
```

#### Minimal Template
The following represents the minimal template for a valid [HTML5](https://www.w3.org/TR/html5/) document.

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

#### Exercise 1 - Display a Basic Page

Complete the following task, after each task commit your chagnes to Git. When all tasks are complete push all chagnes to the mtbc project on GitHub.

[</> code](https://github.com/stack-x/mtbc/commit/2dc5f0bbfa21a50da6026b0c131d5c4594dbc37a) Create the path */var/www/mtbc/html/basic.html* and paste the above template into the file. Then navigate to [http://localhost/mtbc/html/basic.html](http://localhost/mtbc/html/basic.html) and note the tab in the browser.

[</> code](https://github.com/stack-x/mtbc/commit/b0c50d3d23a7177cd6a942997375a032d1c2af6c) The **title** element is on of the few required elements and will be displayed in the browser tab. Change the value of the **title** element to *HTML5* and refresh the page.

[</> code](https://github.com/stack-x/mtbc/commit/09f64186264b2ca11039d2ab6995c50926676b23) Finally add the page content from the example above.

##### Summary

In this exercise you leanred how to
* build a baisc web page (HTML)
* update a page title (HTML)
* view local changes in a browser (Dev) 


## Additional Resources
* [MDN - HTML](https://developer.mozilla.org/en-US/docs/Web/HTML)
* [Introduction to HTML](https://developer.mozilla.org/en-US/docs/Learn/HTML/Introduction_to_HTML)
* [HTML5 Doctor](http://html5doctor.com/)
* [Choosing a Language Tag](https://www.w3.org/International/questions/qa-choosing-language-tags)
* [IANA Language Subtag Registry](http://www.iana.org/assignments/language-subtag-registry/language-subtag-registry)
* [Why Character Entities](https://stackoverflow.com/questions/1016080/why-are-html-character-entities-necessary)
* [XML and HTML Entieis](https://en.wikipedia.org/wiki/List_of_XML_and_HTML_character_entity_references])
* [The W3C Reference](https://dev.w3.org/html5/html-author/charref])
