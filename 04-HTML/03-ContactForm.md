# Contact Form

Normally you would implement a contact form by implementing some backend code on your webserver. Since GitHub Pages does not allow you to execute server side (aka backend) code we will use a free service called Formspree. This will allow upto 1000 emails per month through our web form.

Head over to [Formspree](https://formspree.io/) and give it a test, you will be sent a confirmation email which you must confirm to continue using the product.


## Exercise 1

Add the file thanks.html (this should be a copy of contact.html) to your GitHub Pages site. Add a header and message thanking the user for contacting you.

## Exercise 2

```html
<form action="https://formspree.io/YOUREMAIL@EXAMPLE.COM"
      method="POST">
    <input type="hidden" name="_subject" value="New submission!">
    <input type="text" name="name">
    <input type="email" name="_replyto">
    <textarea name="message" placeholder="Your message"></textarea>
    <input type="text" name="_gotcha" style="display:none">
    <input type="hidden" name="_next" value="//YOUR-GITHUB-USERNAME.github.io/thanks.html">
    <input type="submit" value="Send">
</form>
```