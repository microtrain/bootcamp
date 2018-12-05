# HTML Resume

Using MicroTrain's preferred [resume template](../img/ResumeTemplate.pdf) as a model create an HTML resume. This template has been preloaded with skills you will learn in this course. For now do not worry about centered text, columns and left/right justifications. We will deal with all of that in CSS. For now We will  build a top down version of your resume. Starting with your name in an ```h1``` tag. You might consider putting your contact information in a ```div``` using an HTML Entities, DEC or Hex values.

>**Reminder:** This will be on the public web, do not add any details you do not want to have posted to the web. You might consider showing only your city and links to LinkedIn and GitHub

```html
<h1>First Name Last Name</h1>
<div>
  <a href="..." target="_blank" rel="noopener">LinkedIn</a>
  &#x25CF;
  Some City, IL
</div>
```

You will follow that up with your desired job title in an ```h2``` tag then a paragraph ```p``` containing a breif summary, then a list ```ul``` of one or two highlights. Core Competencies is an ```h3``` followed by two bulleted list ```ul``` (just keep them stacked for now). Certifications / Technical Proficiencies will be an ```h2``` followed by another bulleted list (CSS will make this no look like a list). Professional Experience is back to an ```h2``` and each job starts with an ```h3```. From here try to figure out those tags for yourself.

## Lab - HTML Resume

Create an HTML version of your resume for your GitHub Pages site. Commit your changes and push them to master.

## Lab 2 - Semantic Meaning

Use HTML5 sectioning tags such as ```main``` and ```section``` to segment your resume into logical sections. This will help better communicate your resumes structure and provide additional support for CSS. 
* Wrap the entire resume in ```main```.
  * You may choose to wrap the resume in an ```article``` tag and place that inside of main.
* Start a ```section``` before an ```h*``` end the section before the next ```h*``` tag of the same level. 

## Additional Resources
* [UTF-8 Geometric Shapes](https://www.w3schools.com/charsets/ref_utf_geometric.asp)
* [Using HTML sections and outlines](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/Using_HTML_sections_and_outlines)
* [How to Use The HTML5 Sectioning Elements](http://blog.teamtreehouse.com/use-html5-sectioning-elements)
* [HTML5 Resume: Jared Pearce](https://codepen.io/jaredpearce/pen/iBdxb)

[Next: MetaData](05-MetaData.md)
