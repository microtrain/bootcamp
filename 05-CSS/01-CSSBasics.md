# CSS

Cascading Style Sheets (CSS) is a language that describes the style of a web page. CSS uses selectors and definitions to apply the these style descriptions or styles to a page.

Lets look at [CSS Zen Garden](http://www.csszengarden.com), click on the download example html file link and open the file in your browser. This is just a plain HTML file, now download the example CSS file and refresh the page. This is what you can do with a few CSS definition. Now go the the [design gallery](http://www.mezzoblue.com/zengarden/alldesigns/) each of these examples uses the came HTML file the only changes here are to the style definitions.

Selectors correspond to HTML elements, there attributes, decedents and and siblings.

## Common Selectors

These are the most common selectors. While there are many more

* Class Selector ```.danger``` - *(.) + (CLASS-NAME)*
* Tag Selector ```p``` - *(TAG-NAME)*
* ID Selector ```#mastHead``` - *(#) - (ID-NAME)*

```css
/* All paragraph elements have a blue font */
p{
  color: blue;
}

/* All paragraph elements with a class attribute of danger will have a red font */
p.danger{
  color: red;
}

/* All div elements with any child element that has with a class attribute of
danger will have a red font */
div > *.danger{
  color: red;
}

/* This will also work as described above */
div *.danger{
  color: red;
}

/* So will this */
div .danger{
  color: red;
}

/* You can apply a single description to multiple selectors with comma separation */
p,
.info,
div > *.info{
  color: blue;
}
```

## Specificity Rules

The following list from the weakest to stringest selectors when it comes to implementing css rules. Inline style trump all, while ```!important``` can force an override of a higher lower level selector; this should be used sparingly. 

* universal selector (*)
* element selector (h1, p, a)
* class selector  (.blue, .link, .content)
* attribute selector ([href], [target], [src])
* psuedo selector (:link, :hover, :visited)
* id selector (#firstName, #lastName, #phoneNumber)
* inline style (style="text-align: center;)




### Exercise 1

In your GitHub Pages project create a directory called *dist* and add the file *main.css*. To the document head in index.html use the ```link``` element to reference the stylesheet.

```html
<link rel="stylesheet" type="text/css" href="/dist/main.css">
```

```html
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>About Jason Snider</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <style>

          /* apply a natural box layout model to all elements, but allowing components to change */
          /* https://www.paulirish.com/2012/box-sizing-border-box-ftw/ */
          html {
              box-sizing: border-box;
              background: #efefef;
              height: 100%;
          }

          *,
          *:before,
          *:after {
              box-sizing: inherit;
          }

          body {
              font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
              margin: 0;
          }

          /* clear floats */
          /* https://www.w3schools.com/howto/howto_css_clearfix.asp */
          .clearfix:after {
              content: "";
              display: table;
              clear: both;
          }

          /* By default we want equal column heights */
          .row {
            display: flex;
          }

          /* All columns should float to the left */
          .col {
              float: left;
              padding: 1em;
              /* All columns should have the same height but allow for different widths */
              flex: 1 1 auto;
          }

          .pull-left {
              float: left;
          }

          .pull-right {
              float: right;
          }

          /* Center the test in the main nav bar */
          nav.top-nav {
              text-align: center;
              background: #aaa;
          }

          /* Reset list elements for navigation */
          ul.nav-inline {
              list-style: none;
          }

          ul.nav,
          ul.nav li,
          ul.nav-inline,
          ul.nav-inline li {
              margin: 0;
              padding: 0;
              border: 0;
              font-size: 100%;
              font: inherit;
              vertical-align: baseline;
          }

          ul.nav-inline li {
              display: inline-block;
          }

          /* Allow the div padding to control the first h1 element's top padding */
          h1:first-of-type {
              margin-top: 0;
          }

          /* style the anchor tags */
          nav.top-nav a,
          #Footer a {
              display: inline-block;
              text-align: center;
              padding: 8px 20px;
              text-decoration: none;
              color: #444;
              font-weight: bold;
          }

          #Footer a {
              color: #fff;
              padding: 0 0 0 1em;
              font-size: smaller;
          }

          /* the main content */
          #Wrapper {
              width: 1170px;
              margin: 0 auto;
          }

          /* The left and right columns will have the same width */
          #Sidebar {
              width: 340px;
              background: #cdcdcd;
          }

          /* The middle column will have a fixed width of the remainder of the wrapper */
          #Content {
              width: 830px;
              background: #fff;
          }

          #Footer {
              background: #000;
              color: #fff;
              padding: 1em;
              margin: 0;
          }

          #AboutMe {
            text-align: center;
          }

          #AboutMe > .header {
            display: block;
            font-weight: bold;
            color: #ff9900;
            margin: 0 0 1em;
          }

          .img-circle{
            border-radius: 50%;
          }

      </style>
  </head>

  <body>

      <div id="Wrapper">

          <nav class="top-nav clearfix">
              <a href="index.html" class="pull-left" href="/">Site Logo</a>
              <ul class="nav-inline pull-right" role="navigation">
                  <li><a href="index.html">Home</a></li>
                  <li><a href="contact.php">Contact</a></li>
              </ul>
          </nav>

          <div class="row clearfix">
              <div id="Content" class="col">
                  <h1>Hello World</h1>
                  <p>Welcome to my web site.</p>
              </div>
              <div id="Sidebar" class="col">
                <div id="AboutMe">
                  <div class="header">Hello, I am YOUR-NAME</div>
                  <img src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm" alt="My Avatar" class="img-circle">
                </div>
              </div>
          </div>

          <div id="Footer" class="clearfix">
              <small>&copy; 2017 - MyAwesomeSite.com</small>
              <ul class="nav-inline pull-right" role="navigation">
                  <li><a href="terms.html">Terms</a></li>
                  <li><a href="privacy.html">Privacy</a></li>
              </ul>
          </div>
      </div>

  </body>

</html>
```

## Linking to style sheets


### Exercise

Create the path */var/www/about/css/dist/main.css* and open that file in Atom. Copy the contents of the style element from index.html into the new file and replace the style element with a reference to the style sheet.

```html
<link rel="stylesheet" type="text/css" href="css/dist/main.css">
```

## Lab - Restyle All Pages

Apply the new theme to all pages under _/var/www/example.com/public_.

## Additional Resources
* [Specificity](https://developer.mozilla.org/en-US/docs/Web/CSS/Specificity)
* [CSS Tricks](https://css-tricks.com/)
* [MDN - CSS](https://developer.mozilla.org/en-US/docs/Web/CSS)
* [Why do navigation bars in HTML5 as lists?](https://stackoverflow.com/questions/36811224/why-do-navigation-bars-in-html5-as-lists)
* [Nav Element](http://w3c.github.io/html/sections.html#the-nav-element)
* [Bad Design vs. Good Design](https://www.interaction-design.org/literature/article/bad-design-vs-good-design-5-examples-we-can-learn-frombad-design-vs-good-design-5-examples-we-can-learn-from-130706)

### Udemy
* [Flexbox Tutorial](https://microtrain.udemy.com/flexbox-tutorial/)
