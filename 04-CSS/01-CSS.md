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

## Layouts

* display (inline|block|inline-block|none)
* float
* flex
* clear
* width
* height
* display-box
* margin
* padding
