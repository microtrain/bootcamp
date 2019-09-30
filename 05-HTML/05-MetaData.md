# MetaData

MetaData comes in many forms from the ```meta``` elements in the the document head to microdata and aria attributes applied directly to your HTML tags or even in a separate text file.

> This section serves as an overview of metadata, there is no code to apply in this lesson.

## HTML

### Improve SEO with ```<meta>```

Search Engine Optimization (SEO) is the practice of improving your site compatibility with a search engine which in theory, should help to increase your traffic. Metadata is one ingredient. We will start with the classics, *description* and *keywords*. When writing a site description you're looking to sum up a page in 25 words or less. The *description* MUST be relevant to the content on the page. The same idea applies to keywords; 25 keywords or less. Keywords are delimited by commas and may be single words or short phrases that are relevant to the page in question. Google will penalize you if you try to cheat. In both cases we will use the meta tag with the name and description attributes.

The name attribute denotes the type of metadata while the content attribute contains the description, keywords, etc.

```html
<meta name="description" content="The best thing about hello world is the greeting">
<meta name="keywords" content="hello, world, hello world">
```

### MicroData

A search engine is the most common classifier of web pages. Typically, web pages are classified using seed data against a machine learning type of algo. Some of these are very good while others are not. Applying a micro data schema to your pages markup can help these algos better classify your data. Typically these will be waited against some sort of AI as a means of fraud detection. For instance, Google will likely honor meta data so long as it doesn't think you you are trying to game the system, if it detects something of that sort, it may de-index your site.

A good example would be a [job posting](http://schema.org/JobPosting). If I'm posing job ads I would want to apply this schema assuming other services are interested in pull in job ads and making use of its data.  

### Aria

Accessible Rich Internet Applications (ARIA) is a standard for helping a web page work with a screen reader. You saw a sample of this earlier with ```role="navigation"```.  

## .txt

### [robots.txt](http://www.robotstxt.org/) 

robots.txt is a file that sits in your sites root directory. This tells allows you to provide a set of preferences to well behaved search engines. At the very least you should allow all bots until you have a reason not to. Bad bots will ignore this so trying to keep those out using a robots.txt file is pointless, keep it simple and assume all bots are good. This will prevent you from making mistakes that block the good bots.

### Exercise
Create the path */var/www/robots.txt* and add the following lines.
```
User-agent: *
Disallow:
```

### [humnas.txt](http://humanstxt.org/) 
humans.txt is a file that gives credit to the sites creators. While it is not required it's a nice touch and if they solve the spam problem they will give you a way to submit your site to there directory, which is a link back so that is always good.

humans.txt requires a tag in the head plus the text file with all of the content

```html
<link rel="author" href="humans.txt" />
```

```yml
/* TEAM */
Your title: Your name.
Site: email, link to a contact form, etc.
Twitter: your Twitter username.
Location: City, Country.

/* THANKS */
Name: name or url

/* SITE */
Last update: YYYY/MM/DD
Standards: HTML5, CSS3,..
Components: Modernizr, jQuery, etc.
Software: Software used for the development
```

### [security.txt](https://securitytxt.org/) 

security.txt lets security researchers know how to get hold of you should an issue be found.

## Images

[favicon.ico](https://en.wikipedia.org/wiki/Favicon) This is the image that appears in the browser tab beside the title. This is found in your websites root directory.

[browserconfig.xml](https://msdn.microsoft.com/library/dn455106.aspx) For creating custome tiles in windows.

```xml
<?xml version="1.0" encoding="utf-8"?>
<!-- Please read: https://msdn.microsoft.com/en-us/library/ie/dn455106.aspx -->
<browserconfig>
    <msapplication>
        <tile>
            <square70x70logo src="tile.png"/>
            <square150x150logo src="tile.png"/>
            <wide310x150logo src="tile-wide.png"/>
            <square310x310logo src="tile.png"/>
        </tile>
    </msapplication>
</browserconfig>
```

* tile.png
* tile-wide.png
* icon.png

[manifest.json](https://developer.mozilla.org/en-US/docs/Web/Manifest)

```json
{
    "icons": [{
        "src": "icon.png",
        "sizes": "192x192",
        "type": "image/png"
    }],
    "start_url": "/"
}
```

## Additional Resources
* [What’s in the head? Metadata in HTML](https://developer.mozilla.org/en-US/docs/Learn/HTML/Introduction_to_HTML/The_head_metadata_in_HTML)
* [Steps to a Google-friendly site](https://support.google.com/webmasters/answer/40349?hl=en)
* [The Beginner's Guide to SEO](https://moz.com/beginners-guide-to-seo)
* [How to write meta descriptions for SEO](https://searchenginewatch.com/2016/05/26/how-to-write-meta-descriptions-for-seo-with-good-and-bad-examples/)
* [Getting started with schema.org using Microdata](http://schema.org/docs/gs.html)
* [WAI-ARIA Overview](https://www.w3.org/WAI/intro/aria)

[Next: CSS](/06-CSS/README.md)
