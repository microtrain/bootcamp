## Lab 1 - Your HTML Resume

From Atom's navigation pane add a file named _resume.html_ to the about project and add the following markup.

````
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><!-- Your Name Here --></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <!-- Your Resume Here -->
  </body>
</html>
````

Commit your changes and push them to the repository.

Stage new files to be committed, in this case _index.html_.
````
git add .
````

Commit the files with a message and push them to master.
````
git commit -m 'Added basic HTML structure'
git push origin master
````

Using the knowledge you gained thus far create an HTML version of your resume. Be sure the apply your markup between the opening and closing body tags. You can see your changes by opening a browser and navigating to *http://localhost/about/resume.html*. Make incremental commits with relevant messages and push the changes to GitHub as you progress through this lab.

As you learn more, return to this project to add more content and style to your resume.

## Lab 2 - Your About Me Page

Building off of the exercises in this section build out *http://localhost/about/index.html* so that it shows an avatar and tells a little about yourself. Link this to your GitHub and LinkedIn profiles. Commit changes accordingly.

## LAB 3 - Contact Form
Modify _/var/www/about/contact.php_ so that:
* Add a form field for entering URLs.
* Add notEmpty validation for subject.
* Add notEmpty validation for message.
* Add a validation method for detecting a valid URL and add that to the URL field.
* Update the email and URL validation method to return true when the input passes validation OR when the field is empty.
* This MUST reject an empty or an invalid email (Required and valid).
* This MUST allow an empty URL but reject an invalid one (Not required but valid if not empty).

## LAB 4 - Submit the Contact Form with Mailgun
Using */var/www/about/test.php* as a reference modify */var/www/about/contact.php* and/or */var/www/about/processContactForm.php* so that:

* If validation passes it sends you an email with the contents of the form.
