# CSS

Cascading Style Sheets (CSS) is a language that describes the style of a web page. CSS uses selectors and definitions to apply the these so called style descriptions or styles to a page.

Selectors correspond to HTML elements, there attributes, decedents and and siblings.

## Common Selectors

These are the most common selectors. While there are many more

* Class Selector ````.danger```` - *(.) + (CLASS-NAME)*
* Tag Selector ````p```` - *(TAG-NAME)*
* ID Selector ````#mastHead```` - *(#) - (ID-NAME)*

````
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
````

# Layout

````
<html lang="en">
<html>
    <head>
       <meta charset="UTF-8">
       <title>About Jason Snider</title>
       <meta name="viewport" content="width=device-width, initial-scale=1.0">

       <style>

         /* apply a natural box layout model to all elements, but allowing components to change */
         /* https://www.paulirish.com/2012/box-sizing-border-box-ftw/ */
         html {
           box-sizing: border-box;
         }

         *, *:before, *:after {
           box-sizing: inherit;
         }

         body{
           font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
         }

         /* clear floats */
         /* https://www.w3schools.com/howto/howto_css_clearfix.asp */
         .clearfix:after{
             content: "";
             display: table;
             clear: both;
         }

         /* the main content */
         .wrapper{
           width: 1170px;
           margin: 0 auto;
         }

         /* All columns should float to the left */
         .col {
             float: left;
             min-height: 300px;
             padding: 1em;
         }

         /* The left and right columns will have the same width */
         .left,
         .right {
           width: 220px;
           background: #cdcdcd;
         }

         /* The middle column will have a fixed width of the remainder of the wrapper */
         .middle {
           width: 730px;
         }


         /* Center the test in the main nav bar */
         nav.top-nav{
           text-align: center;
           background: #ededed;
         }

         /* style the anchor tags */
         nav.top-nav a{
           display: inline-block;
           text-align: center;
           padding: 8px 20px;
           text-decoration: none;
           color: #444;
           font-weight: bold;
         }

       </style>
    </head>
    <body>

      <div class="wrapper">

        <nav class="top-nav">
            <a href="index.html">Home</a>
            <a href="about.html">About</a>
            <a href="contact.php">Contact</a>
        </nav>

        <div class="row">
          <div class="col left"></div>
          <div class="col middle">
            <h1>Hello World</h1>
            <p>Welcome to my web site.</p>
          </div>
          <div class="col right"></div>
        </div>

      </div>

    </body>
</html>
````
