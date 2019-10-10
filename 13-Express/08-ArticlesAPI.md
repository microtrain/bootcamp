# Lab - Articles API

Build an articles API using the knowledge acquired in the previous lessons. 

## Create a Model
We will start with an articles model. Our model will provide all the fields that are common to a web page.
* title - The title of the article.
* slug - A slug of the title; converted to lower case with all special chars removed or converted to a hyphen.
* body - The article.
* keywords - Metadata, This is not much-used search engines these days but it can provide some value.
* description - Metadata, a ~25 word summary of the article.
* published - The date the article is to go live. This will allow articles to be written in advance of the intended publication date.
* created - When the article was created.
* modified - When the article was last modified.

Use NPM to install a slug package.
```sh
npm install slug --save
```

Our model will 
* enforce the aforementioned schema
* automatically create a slug if one does not already exist
* automatically set the created and modified dates

```js
var mongoose = require('mongoose');
var Schema = mongoose.Schema;
var slug = require('slug');

//Create a schema
var Articles = new Schema({
  title: {
    type: String,
    required: [true, 'A title is required']
  },
  slug: {
    type: String,
    required: [true, 'A slug is required'],
    unique: true
  },
  description: String,
  keywords: String,
  body: String,
  published: {
    type: Date
  },
  created: {
    type: Date,
    default: Date.now
  },
  modified: {
    type: Date
  }
});

//Auto set the slug prior to validation
Articles.pre('validate', function(next){

  //Do not overwrite the slug if it already exists
  if(this.slug==undefined){
    if(this.title){
      this.slug = slug(this.title).toLowerCase();
    }
  }

  //If no published date has been provided use the current date
  if(this.published==undefined){
    this.modified = new Date().toISOString();
  }

  this.modified = new Date().toISOString();

  next();
});
  
module.exports = mongoose.model('Articles', Articles);
```

## Create the API
* This API MUST provide full CRUD logic.
* This API MUST allow a new article to be created using the HTTP POST method.
* This API MUST allow all articles for which the published date is in the past to be returned using the HTTP GET method.
* This API MUST allow one article for which the published date is in the past to be returned by passing a slug using the HTTP GET method.
* This API MUST allow one article to be edited using the HTTP PUT method.
* This API MUST allow one article to be deleted using the HTTP DELETE method.

[Next: Articles App](09-ArticlesApp.md)
