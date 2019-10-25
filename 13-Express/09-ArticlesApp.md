# Lab - Articles App

Build an articles app using the knowledge acquired in the previous lessons.
* This will require 1 routing file and 3 views (app, index, view)
* This app MUST provide at least two non-API endpoints.
  * index - A view that displays all articles.
  * view - A view that displays a single article.
  * app - Provides a view for the articles app.
* The JavaScript app MUST provide full CRUD functionality.

We will get you started by providing an outline of the API and non-API routes You'll just need to implement the details.

*routes/api/articles.js*
```js
var express = require('express');
var router = express.Router();
var Articles = require('../../models/articles');

router.get('/', function(req, res, next) {});

router.get('/:articleId', function(req,res){});

router.post('/', function(req, res) {});

router.put('/', function(req, res){});

router.delete('/:articleId', function(req,res){});

module.exports = router;
```

*routes/articles.js*
```js
var express = require('express');
var router = express.Router();
var Articles = require('../models/articles');

router.get('/', function(req, res, next) {
  res.render('articles/index', { title: 'xxx' });
});

router.get('/:slug', function(req, res, next) {
  res.render('articles/view', { title: 'xxx' });
});

router.get('/cms', function(req, res, next) {
  res.render('articles/cms', { title: 'CMS' });
});

module.exports = router;
```

A starter template for the index view.

*views/articles/index.pug*
```pug
extends ../layout

block content
  h1 Blog
  for article in articles

    div.article
      a(href='articles/' +   article.slug)
        h2= article.title
        div!= article.description
```

A starter template for the view view.

*views/articles/view.pug*
```pug
extends ../layout
block content
  article
    h1= article.title
    div
      - var date = new Date(article.published).toISOString().slice(0, 19).replace('T', ' ');
      small Posted: #{date}
    div!= article.body
```

A stater template for the app view.

*views/articles/app.pug*
```pug
extends ../layout

block content

  h1 Content Management System

  div#app

  script(src='/dist/js/articles.app.min.js')
```

The JavaScript app will be nearly identical to the users app. The biggest difference will be the form fields.
