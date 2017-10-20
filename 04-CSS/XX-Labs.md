## Lab 1 - Restyle All Pages

Apply the new theme to all pages under _/var/www/about_.

## Lab 2 - Add Response Classes

Add the following classes to main.scss update the style declarations so that redundant values are called as a variable. Apply these class to error and success messages produced after the form submit in contact.php.

````
.text-success {
  color: #3c763d;
}

.text-error {
  color: #8a6d3b;
}

.text-warning {
  color: #a94442;
}

.message {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
  color: #333;
}

.success {
  @extend .message;
  border-color: #3c763d;
  color: #3c763d;
}

.error {
  @extend .message;
  border-color: #8a6d3b;
  color: #8a6d3b;
}

.warning {
  @extend .message;
  border-color: #a94442;
  color: #a94442;
}
````
