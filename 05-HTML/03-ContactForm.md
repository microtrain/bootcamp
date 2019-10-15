# Contact Form

Forms are one of the most common ways to collect data from a user. Submitting a 
form is one of the simplest ways to post data to a server. This lesson will 
start with a simple POST request and end with complex processing.

The ```form``` element ```<form></form>``` is used for creating forms in HTML. 
Every ```form``` should have at least two attributes ```action``` and 
```method```.

* ```action``` - the web address to which the form data will be sent.
* ```method``` - the type of request the form should make (probably GET or 
POST).

## [Form Elements](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form)

While HTML has a slew of form elements, you can mostly get by with just a few. 

* [```input```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input) - uses the type attribute morph into various fields.
  * [```text```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/text) - covers single line input fields
  * [```date```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date) - provides a date picker
  * [```hidden```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/hidden) - a hidden field
  * [```checkbox```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/checkbox) - provides checkboxes
  * [```radio```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/radio) - provides a radio option
  * [```file```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file) - upload files to the server
  * [```button```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/button) - provides a submit button
* [```textarea```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea) - a large field for entering multiline text.
* [```select```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/select) - Provide a picklist.
* [```label```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/label) - Provides a label for a given element.

Label elements use the [```for```](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/label#Attributes) attribute to associate a label to a corresponding form field. The form field requires an ```id``` attribute with a value that matches that 
of a given ```for``` attribute. While visually there is no advantage to using ```for``` and ```id``` it helps screen 
readers communicate to visually impaired users. 

> Never omit form labels. If you want to hide use ```display:none;``` in CSS. This will hide it from the UI while keeping it visible to screen readers.

**Additional Form Fields Attributes**
* ```name``` - provides a data key to the form element. This is the name of the field passed in the payload (required).
* ```type``` - defines the type on an ```input``` field (input fields only) (required).
* ```value``` - allows you to prepopulate the value of an input field (optional).
* ```checked``` - auto checks a checkbox (optional).
* ```selected``` - pre-selects a picklist option (optional).

[<i class="fa fa-codepen" aria-hidden="true"></i>CodePen Demo](https://codepen.io/jasonsnider/pen/MVQYqM) **Accessible Form Examples**
```html
<!-- Plain text input -->
<div>
  <em>Sample plain text entry</em>
  <label for="name">Name</label>
  <input id="name" name="name" type="text">
</div>
<!-- Datepicker -->
<label for="date">Date</label>
<input id="date" name="date" type="date">

<!-- Textarea -->
<label for="description">Description</label>
<textarea id="description" name="description"></textarea>

<!-- Picklist-->
<label for="pickOne">Choose an option</label>
<select id="pickOne" name="pickone">
  <option>Please Choose an Option</option>
  <option value="option1">Option 1</option>
  <option value="option2" selected>Option 2</option>
  <option value="option3">Option 3</option>
</select>

<!-- Radio Options -->
<fieldset>
  <legend>Choose yes or No</legend>

  <label for="r1">Yes</label>
  <input id="r1" name="yn" value="y" type="radio">

  <label for="r2">No</label>
  <input id="r2" name="yn" value="n" type="radio">
</fieldset>

<!-- Checkbox Options -->
<fieldset>
  <legend>Choose all that apply</legend>
  <label for="c1">Option 1</label>
  <input id="c1" name="all" value="0" type="checkbox">

  <label for="c2">Option 2</label>
  <input id="c2" name="all" value="1" type="checkbox">
</fieldset>

<!-- Form Buttons -->
<input type="submit" name="submit" value="Submit">
<input type="reset" name="reset" value="Reset">
```

## Formspree
Normally you would implement a contact form by implementing some back end code on your webserver. Since GitHub Pages does not allow you to execute server-side (aka back end) code we will use a free service called Formspree. This will allow up to 1000 emails per month through our web form. Head over to [Formspree](https://formspree.io/) and give it a test, you will be sent a confirmation email which you must confirm to continue using the product.

> By adding your email address to this form you are making it publicly available(or you could say potentially increasing its public exposure). If this is an issue for you, you can create an email account solely for this purpose. Alternatively, you could choose a service such a [https://www.mailinator.com/](https://www.mailinator.com/). *If you choose the latter, be aware that these inboxes are temporary and public.*


## Exercise 1 - Basic Form

When building a contact form think about what information you need. This will be a simple form so we will only ask for a few things: name, email and a message. This gives us a total of three form fields.

[</> code](https://github.com/microtrain/microtrain.github.io/commit/3cbd8fe96310fce03587f5809c8aa95e798ae679) Open *contact.html* and add opening and closing ```form``` tags.
```html
<form action="https://formspree.io/YOUREMAIL@EXAMPLE.COM" method="POST"></form>
```

[</> code](https://github.com/microtrain/microtrain.github.io/commit/151012337f237d8dd3bc95f3f8604dbd64dcbc57) Collect the name of the person contacting you. We use N/name as the label content, for, id, and name values. Note the div tags, they are not required but they will help us later when we go to style the form.


```html
<div>
  <label for="name">Name</label>
  <input id="name" type="text" name="name">
</div>
```

[</> code](https://github.com/microtrain/microtrain.github.io/commit/57c689d5cd557bc20b4419b9fb532a1cafbe27dc) Collect the email of the person contacting you. We use E/email as the label content, for and id values but we will change the name to _replyTo this will allow us to access Formspree's relpyTo feature of setting the replyTo address to the user supplied value. 

```html
<div>
  <label for="email">Email</label>
  <input id="email" type="text" name="_replyto">  
</div>
```

[</> code](https://github.com/microtrain/microtrain.github.io/commit/686962cfc1dff5f7d36fc8aa06d51583e974efff) We will create a label and a text area to collect the message from the person contacting us.
```html
<div>
  <label for="message">Message</label>
  <textarea id="message" name="message"></textarea>
</div>
```

[</> code](https://github.com/microtrain/microtrain.github.io/commit/47346c24fe699a610caf7826acf668082318c7d4) We will create a hidden form field with the ```name``` of _subject. This will access another feature for dealing with the email subject. We will make this a hidden field so that we can control what it looks like in our inbox. We will put this at the top of the form. That way if you decide you want the user to control the subject line all you will need to do is change the type to from ```hidden``` to ```text``` and the field will already be in a logical location.
```html
<div>
  <input type="hidden" name="_subject" value="New submission!">
</div>
```

[</> code](https://github.com/microtrain/microtrain.github.io/commit/649cb8fad274e0e882f2c457f21d123c89ec8631) Finally, we will add a submit button.
```html
<div>
  <input type="submit" value="Send">
</div>
```


Add the file *thanks.html* (this should be a copy of contact.html) to your 
GitHub Pages site. Add a header and message thanking the user for contacting you.

## Exercise 2 - Thank You

[</> code](https://github.com/microtrain/microtrain.github.io/commit/f6709fa1160bea5422b2b57a00fed7db6213dc66) Make a copy of the file resume.html and name it *thanks.html*. Change the title to say "Thank You" and add a nice massage for the user. You could copy any page, I only chose resume because it had the least amount of code to remove.

[</> code](https://github.com/microtrain/microtrain.github.io/commit/fc6f187148f64a86976948d745c28efcf8abc799) Add a hidden field to your form and set the name to ```_next``` add a value attribute the points to the thanks.html page on your GitHub pages site. This uses another special feature of Formspree that sends the user to a target page after the form has been submitted. You could add this anywhere between the form tags. Since there is no chance I'll ever bring this to the surface, I will add it to the very end of the form.

```html
<input type="hidden" name="_next" value="//YOUR-GITHUB-USERNAME.github.io/thanks.html">
```

## Exercise 3 - Captcha and Honeypots
Completely Automated Public Turing (Captcha) is any test that would be trivial for a human to solve but difficult if not impossible for a computer to solve. We use these to reduce spam and wasted resources by attempting to filter out robots (or non-human traffic) all Formspree forms provide captcha by default.

In the same way, ```_subject``` and ```_next``` send commands to Formspree; ```_gotcha``` functions in a similar fashion. This is another special feature of Formspree that rejects any form for which the honeypot is not empty. This is a second layer on top of Captcha making it redundant. We only demonstrate this to show another technique for dealing with spam.

> Any bot that is is aware of Formspree has likely been updated to account for the ```_gotcha``` name field. Also, this method may trip up screen readers or accessibility tools. For those reasons, we will not add it to our form but I will still show you an example.

```html
<input type="text" name="_gotcha" style="display:none">
```

Why does the ```_gotcha``` example use ```style="display:none"``` instead ```type="hidden"```? When bots see a hidden field they assume they should leave it alone. Hiding it with CSS means the bot wouldn't understand it's not supposed to be hidden. At this point, we are playing a game of whack-a-mole. This uses an inline style that a bot could easily be written to interpret. Our response would be to move this to an external style sheet. Of course, a good bot writer would also be able to detect that. We would then have another round of back and fourth. Each round would eliminate less sophisticated bots but there would always someone defeating this. In other words, this solution is far weaker than a captcha, so just use a captcha.

## Summary
In this lesson, you learned how to
* create a web form
* interact with a third-party service

## Additional Resources
* [Creating Accessible Forms](https://webaim.org/techniques/forms/controls)

[Next: Resume](04-Resume.md)
