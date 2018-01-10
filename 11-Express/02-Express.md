# Express

Express is a web application framework for NodeJS.

[Getting Started with Express](https://expressjs.com/)

Install the Express Generator

```sh
sudo npm install express-generator -g

```

Create an Express based website, we will use PUG as our template engine.

```sh
cd /var/www
express --view=pug mean.example.com
```
Open Atom and add _mean.example.com_ as a project folder. Then ```cd``` into the express directory and finsih the install.

```sh
cd mean*
npm install
```

Start a local web server.

```sh
npm start
```

Navigate to Then [http://localhost:3000/](http://localhost:3000/) to access your new app.

From Atom open *mean.example.com/routes/index.js* and change the following

```js
//change
{ title: 'Express'}
//to
{ title: 'Express', name: 'YOUR-NAME'}
```

From Atom navigate to *mean.example.com/views/index.pug* and change the following. Pleas note the indentation, indentation matters when it comes to Pug.

```js
//change
extends layout

block content
  h1= title
  p Welcome to #{title}
//to
extends layout

block content
  h1= title
  p Welcome to #{title}

  p My name is #{name}
```

From the same terminal in which your NodeJS server is running press [ctrl+c] then type ```sh npm start``` this will restart the server. Navigate to [http://localhost:3000/](http://localhost:3000/) and refresh the page.







## Additional Resources
* [Express](https://expressjs.com/)
