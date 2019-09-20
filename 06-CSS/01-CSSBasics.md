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

The following list from the weakest to strongest selectors when it comes to implementing css rules. Inline style trump all, while ```!important``` can force an override of a higher lower level selector; this should be used sparingly. 

* universal selector (*)
* element selector (h1, p, a)
* class selector  (.blue, .link, .content)
* attribute selector ([href], [target], [src])
* pseudo selector (:link, :hover, :visited)
* id selector (#firstName, #lastName, #phoneNumber)
* inline style (style="text-align: center;)

```css
/* Make all font for all elements red */
* {
    color: red;
}

/* overrides * */
p, a {
    color: blue;
}

/* overrides p  */
p.green {
    color: green;
}

/* overrides *, a, p */
.indigo {
    color: indigo;
}

/* overrides a */
a[href="/"] {
    color: aquamarine;
}

/* overrides a */
a:link,
a:visited{
    color: maroon;
}

/* overrides a:link, a:visited */
a.indigo:link,
a.indigo:visited,{
    color: purple;
}

/* overrides everything */
#home{
    color: #efefef; 
}
```


### Add a Stylesheet

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/4176f6290178cdce30034c521f360c1100a4035a) In your GitHub Pages project create the directory path *dist/css* and add the file *main.css*. To the document head in index.html use the [```link```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/link) element to reference the stylesheet. 

```html
<link rel="stylesheet" type="text/css" href="./dist/css/main.css">
```

You can verify the file loads by checking networking tab in dev tools.

### Remove the Inline Styles

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/7f785b482d30531da730bb383c4c2bb17fef38e7) We will start by removing the inline style we added to our index.html file. We will start by adding an avatar class to our stylesheet.

**dist/css/main.css**
```css
.avatar {
  border-radius: 50%; 
  float: left; 
  margin-right: 1em;
}
```

### Reset the body element

Now we can start building a layout, we will start by resetting the body elements, adding a base font and then we will move on to navigation.

It's common practice to remove the default padding and margin from the body, add the following to main.css.
```css
body{
  padding: 0;
  margin: 0;
}
```

### Set a base font

Next we will add a base font. To assure consistency across all platforms we will pull a font from a font foundry, we will use [Google Fonts](https://fonts.google.com/) and use [Open Sans](https://fonts.google.com/specimen/Open+Sans). We will import the font style into our style sheet and use a universal selector to set all elements to this font by default.

```css
@import url('https://fonts.googleapis.com/css?family=Open+Sans');

* {
  font-family: 'Open Sans', sans-serif;
}
```

### Header and Navigation

No we are ready to tackle navigation, lets start by wrapping the ```nav``` elements in a ```header``` element. We will add a ```span``` element with a class of ```.logo``` outside of the ```nav``` with the navigation. We will align all navigation links horizontally and pull them to the top right corner of the screen.

```html
<header>
  <span class="logo">My WebSite</span>
  <nav>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="resume.html">Resume</a></li>
      <li><a href="contact.html">Contact</a></li>
    </ul>
  </nav>
</header>
```

```css
header {
  height: 50px;
  background: #000;
  color: #fff;
  padding: 0 .5rem 0 1rem;
}

header .logo{
  line-height: 50px;
  font-weight: bold;
}

nav {
  float: right;
}

nav ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

nav ul li{
  display: inline;
}

nav ul li a,
nav ul li a:link,
nav ul li a:visited{
  display: inline-block;
  padding: 0 .5rem;
  color: #fff;
  line-height: 50px;
  text-decoration: none;
}

nav ul li a:hover{
  background: #444;
}
```

### Main Content (set a landmark)

Add a ```main``` element and center the page content.

```html
<main>
  <h1>Hello,...
</main>
```

```css
main {
  /* Use a margin to center the page */
  margin: 0 auto;

  /* Set the width of the content */
  width: 960px;

  /* For smaller screens to not exceed the max screen width */
  max-width: 100%;
}
```

### Make it Responsive

Use dev tools to toggle the device toolbar (enter mobile testing mode) and choose the responsive option. Set the width to 960px and drag in and out crossing back and fourth over that 960px mark. Notice the padding, we loose all of padding under 960px meaning the text runs to the edge of the screen. Popular opinion is that makes for a better read if you can get some separation from the edge of the screen. You could use a media query and change the page width on a break point such as below. 

#### Add Gutters to Small Screens

```css
@media only screen and (max-width: 960px)  {
    main {
        max-width: 90%;
    }
}
```

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/a8d8884c747e1794e45cc55b4ef786a06fe00b55) Or you could set the default ```max-width``` to **90%** which is what we will do here.

```css
  /* For smaller screens to not exceed the max screen width */
  max-width: 90%;
```

#### Switch to Vertical Navigation on Small Devices

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/0ac63879c014f1c258be71e5e0f4535faf389ec9) It's common practice, on smaller screens, to change from a horizontal navigation in the header to a hidden vertical navigation that appears on a button press. We can do this by setting the nav display to none.

```css
@media only screen and (max-width: 960px)  {
    nav {
        nav {
            display:none;
        }
    }
}
```

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/60f60ab4f68f3125529c40363fef51135d849a7c) Add an anchor element to the ```header``` element right before the ```nav``` element. This will act as the control to toggle the menu on smaller screens. Give this element and ```id``` attribute with a value value of *toggleMenu*.

```html
<a id="toggleMenu">Menu<a>
```

Create a CSS selector for the toggleMenu attribute. This style will be similar to but set breakpoints opposite to that of ```nav``` meaning this will only appear on small

```css

#toggleMenu {
  display: none;
}

@media only screen and (max-width: 960px)  {

  #toggleMenu {
    display: block;
    float: right;
    line-height: 50px;
  }
  ...
```

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/c1d7817d7a356f4450b4d293467a428ce63e7ad8) We will cover JavaScript in great detail later, for now copy and paste the following into index.html right before the closing body tag.

```html
    <script>

      var toggleMenu = document.getElementById('toggleMenu');
      var nav = document.querySelector('nav');
      toggleMenu.addEventListener(
        'click',
        function(){
          if(nav.style.display=='block'){
            nav.style.display='none';
          }else{
            nav.style.display='block';
          }
        }
      );
    </script>
```

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/53cd932bba3279823f34b26b80794c08a4edd316) Now if you reload the page, move the width to less than 960px and press menu, you notice not much has changed. We will fix this by setting the nav to a block level component.

```css
@media only screen and (max-width: 960px)  {

  #toggleMenu {
    display: block;
    float: right;
    line-height: 50px;
  }

  nav {
      display: none;
      background: #000;
  }

  nav ul li a,
  nav ul li a:link,
  nav ul li a:visited{
    display: block;
    border-bottom: 1px solid #777;
  }
  
}
```

Reload the page and make sure the resolution in under 960px, press the Menu button. It's now more closely resembles a traditional fly out menu. Make the resolution small and you'll notice the position of the menu changes. To fix this you will absolutely position ```nav``` relative to ```header```.

Start by making assigning the relative position to the ```header``` element. Then assign an absolute position to the ```nav``` element. When an absolute element is the child a relative element the positioning of the absolute element is relative to that of it's parent.

```css
@media only screen and (max-width: 960px)  {

  header {
    position: relative;
  }

  nav {
    position: absolute;
    display: none;
    background: #000;
  }
  ...
```

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/1352f688889414017be500c793bdf971d4fe9d56) Next you will want to position the menu. By default the menu will want to position itself in the top left corner. If you were to think of a box as having four boundaries: top, left, right and bottom; then ```top```, ```left```, ```right```, ```bottom``` are commands that move the top left corner of a target element a set distance from the specified boundaries. In this case we will set top to ```50px``` this will allow it to clear the 50px height of the header element. By setting ```left``` and ```right``` to ```0``` you will stretch nav element to the width of the entire screen.

```css
@media only screen and (max-width: 960px)  {

  header {
    position: relative;
  }

  nav {
    position: absolute;
    display: none;
    background: #000;
    top: 50px;
    left: 0;
    right: 0;
  }
  ...
```


## Exercise - Restyle All Pages

Apply the new navigation to all pages.

## Additional Resources
* [Specificity](https://developer.mozilla.org/en-US/docs/Web/CSS/Specificity)
* [CSS Tricks](https://css-tricks.com/)
* [MDN - CSS](https://developer.mozilla.org/en-US/docs/Web/CSS)
* [Why do navigation bars in HTML5 as lists?](https://stackoverflow.com/questions/36811224/why-do-navigation-bars-in-html5-as-lists)
* [Nav Element](http://w3c.github.io/html/sections.html#the-nav-element)
* [Bad Design vs. Good Design](https://www.interaction-design.org/literature/article/bad-design-vs-good-design-5-examples-we-can-learn-frombad-design-vs-good-design-5-examples-we-can-learn-from-130706)

[Next: SASS](02-SASS.md)
