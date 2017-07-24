# The Anatomy of a URL

[Uniform Resource Locators (URL)](https://tools.ietf.org/html/rfc1738) is an interface through which a user can communicate with a web page. In modern browsers this is accessed through the address bar. If you were to open a CLI based browser such as wget this would be passed as an argument into the command line..

Let's break this down by taking a look at [https://www.google.com/search?q=anatomy+of+a+URI#jump](https://www.google.com/search?q=anatomy+of+a+URI).

![The Anatomy of a URI](../img/url.png)

<table>
  <tr>
    <th>PROTOCOL</th>
    <th>DOMAIN</th>
    <th>PORT</th>
    <th>PATH</th>
    <th>QUERY STRING</th>
    <th>FRAGMENT</th>
  </tr>
  <tr>
    <td>https://</td>
    <td>www.google.com</td>
    <td>:443</td>
    <td>/search</td>
    <td>?q=anatomy+of+a+URL</td>
    <td>#jump</td>
  </tr>
</table>

Simply stated a website is a program accessed through using a series of web protocols. For example ````http://wwww.example.com```` would tell the broswer to go to the root of www.example.com (typically this is a file called index). Everything you see after that is a series of commands. Originally the web served static files so what I am calling commands was really just a  directory structure. For example ````http://wwww.example.com/blog/post/27```` is most likely requesting the 27th post from the websites blog. At one point in time this would have been a file named 27 in a directory called which would have been in a directory called blog. Today, this is most likely a stored in a data base and post is probably a script that has just been instructed to return a given row (in this case 27) from the database.


## GET and POST parameters

When dealing with web applications the most common types of requests are GET and POST. These types of requests the user to pass data to the server either through the URL (a GET request) or through a form submission (a POST request). Modern web platforms and programming languages will provide an interface for dealing with the data passed through either of these request types.

PHP provides access through the use of [superglobals](http://php.net/manual/en/language.variables.superglobals.php) ````$_GET['email']```` and ````$_POST['email']````. CakePHP and MVC framework written in PHP uses a [request class](https://book.cakephp.org/2.0/en/controllers/request-response.html) ````$this->request->params->named['email']```` and ````$this->request->data['email']````. If your running Express on top of Node.JS you'll use something like the following ````req.query.email```` (GET) ````req.body.email```` (POST).

It would be common to refer to these practices as retrieving GET parameters (params) and retrieving POST data.

## Additional Reading

* [The Difference Between URLs and URIs](https://danielmiessler.com/study/url-uri/#gs.IU_=BhI)
* [Uniform Resource Identifier (URI)](https://tools.ietf.org/html/rfc3986)
* [StackOverflow: Node.JS GET Params](https://stackoverflow.com/questions/6912584/how-to-get-get-query-string-variables-in-express-js-on-node-js)
* [StackOverflow: Node.JS POST Data](https://stackoverflow.com/questions/4295782/how-do-you-extract-post-data-in-node-js)
