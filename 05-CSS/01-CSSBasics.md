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

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/4176f6290178cdce30034c521f360c1100a4035a) In your GitHub Pages project create a directory called *dist* and add the file *main.css*. To the document head in index.html use the [```link```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/link) element to reference the stylesheet. 

```html
<link rel="stylesheet" type="text/css" href="./dist/main.css">
```

You can verify the file loads by checking networking tab in dev tools.

### Remove the Inline Styles

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/7f785b482d30531da730bb383c4c2bb17fef38e7) We will start by removing the inlie style we added to our index.html file. We will start by adding an avatar class to our stylesheet.

**dist/main.css**
```css
.avatar {
  border-radius: 50%; 
  float: left; 
  margin-right: 1em;
}
```

### Reset the body element

Now we can start buildinga layout, we will start by reseting the body elements, adding a base font and then we will move on to navigation.

It's common practice to remove the defualt padding and margin from the body, add the following to main.css.
```css
body{
  padding: 0;
  margin: 0;
}
```

### Set a base font

Next we will add a base font. To assure consitancey across all platforms we will pull a font from a font foundary, we will use [Google Fonts](https://fonts.google.com/) and use [Open Sans](https://fonts.google.com/specimen/Open+Sans). We will import the font style into our style sheet and use a universal selector to set all elements to this font by default.

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
  padding: 0 .5rm 0 1em;
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
  padding: 0 .5em;
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

  /* For samller screens to not exceed the max screen width */
  max-width: 100%;
}
```

### Make it Responsive

Use dev tools to toggle the device toolbar (enter mobile testing mode) and choose the responsive option. Set the width to 960px and drag in and out crossing back and fourth over that 960px mark. Notice the padding, we loose all of i under 960px, we can use a media query to set a break telling the page to add a gutter below a certian page width.

```css
@media only screen and (max-width: 600px)  {
    main {
        padding: 0 1em;
    }
}
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
