# Contact Form

Traditionally, forms have been the most common way to collect data from a user. A form submission is the simplest way to post data to a server. This section will start with a simple POST request and end with complex processing.

Form tags ```<form></form>``` are used for creating forms in HTML. Every form should have at least two attributes _action_ and _method_.

* action - the web address to which the form data will be sent.
* method - the type of request the form should make (probably GET or POST).

## [Form Elements](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form)

While HTML has a slew of form elements you can mostly get by with just a few. 

* [input](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input) - uses the type attribute morph into various fields.
  * [text](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/text) - covers single line input fields
  * [date](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date) - provides a date picker
  * [hidden](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/hidden) - a hidden field
  * [checkbox](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/checkbox) - provides checkboxes
  * [radio](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/radio) - provides a radio option
  * [file](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file) - upload files to the server
  * [button](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/button) - provides a submit button
* [textarea](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea) - a large field for entering multiline text.
* [select](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/select) - Provide a picklist.
* [label](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/label) - Provides a label for a given element.

Label elements use the [for attribute](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/label#Attributes) to associate a label to given form field. The form field requires an **id** attribute with a value that matches that of a given **for** attribute. While visually there is no advantage to using **for** and **id** it helps screen readers communicate to visually impared users. 

> Never omit form labels. If you want to hide use ```display:none;``` in CSS. This will hide it from the UI while keeping it visable to screen readers.

**Additional Form Fields Attributes**
* name - provides a data key to the form element. This is the name of the field passed in the payload (required).
* type - defines the type on input field (input fields only) (required).
* value - allows you to prepopulate the value of an input field (optional).
* checked - auto checks a checkbox (optional).
* selected - pre-selects a picklist option (optional).

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
Normally you would implement a contact form by implementing some backend code on your webserver. Since GitHub Pages does not allow you to execute server side (aka backend) code we will use a free service called Formspree. This will allow upto 1000 emails per month through our web form. Head over to [Formspree](https://formspree.io/) and give it a test, you will be sent a confirmation email which you must confirm to continue using the product.

> By adding your email address to this form you are making it publicly available(or you could say potentially increasing it's public exposure). If this is an issue for you create an email account for soley for this purpose or even a service such a [https://www.mailinator.com/](https://www.mailinator.com/). *If you choose the latter be aware that these inboxes are temporary and public.*


## Exercise 1 - Basic Form

When building a contact form think about what information you need. This will be a simple form so we will only ask for a few things: name, email and a message. This gives us a total of three form fields.

[</> code](https://github.com/jasonsnider/jasonsnider.github.io/commit/bd95f614abb50427158958e259fe69ddd32280a5) Open *contact.html* and add opening and closing ```form``` tags.
```html
<form action="https://formspree.io/YOUREMAIL@EXAMPLE.COM" method="POST"></form>
```

[</> code]() Collect the name of the person contacting you. We use N/name as the label content, for, id, and name values. Note the div tags, they are not required but they will help us later when we go to style the form.


```html
<div>
  <label for="name">Name</label>
  <input id="name" type="text" name="name">
</div>
```

[</> code]() Collect the email of the person contacting you. We use E/email as the label content, for and id values but we will change the name to _replyTo this will allow us to access Formsprees relpyTo feature of setting the replyTo address to the user supplied value. 

```html
<div>
  <label for="email">Email</label>
  <input id="email" type="text" name="_replyto">  
</div>
```

[</> code]() We will create a label and a text area to collect the mesage from the peron contacting us.
```html
<div>
  <label for="message">Message</label>
  <textarea id="message" name="message"></textarea>
</div>
```

[</> code]() We will create a hidden form field with the name of _subject. This will aceess another feature for dealing with the email subject. We will make this a hidden field so that we can control what it looks like in our inbox.
```html
<div>
  <input type="hidden" name="_subject" value="New submission!">
</div>
```

[</> code]() Finally, we will add a submit button.
```html
<input type="submit" value="Send">
```


Add the file thanks.html (this should be a copy of contact.html) to your GitHub Pages site. Add a header and message thanking the user for contacting you.

## Exercise 2

Add the file thanks.html.


    <input type="hidden" name="_next" value="//YOUR-GITHUB-USERNAME.github.io/thanks.html">
    <input type="text" name="_gotcha" style="display:none">



* [Creating Accessible Forms](https://webaim.org/techniques/forms/controls)