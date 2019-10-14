# Chapter 14: Angular

Angular is a reactive, front-end MVC framework based on components, services, routing, and code generation.

As defined by Wikipedia, "Reactive Programming is an asynchronous programming paradigm concerned with data streams and the propagation of change.". When programming in a synchronous environment your application will begin execution, request data from a data source (a database, API, etc), and halt execution while it waits for the data. Once the data is delivered the program will resume execution until the next data call. With reactive programming, the program does not halt the execution. The program will continue to execute anything that is not dependent on the data. Rather than making a direct request to the data, you will create a data stream and subscribe to that data. The program will execute, even build the UI around the data it does not yet have. Once the subscription is fulfilled any parts of the program that is dependent upon that data will execute.

Front-end MVC refers to a client-side application that uses the Model, View, Controller paradigm. In the case of Angular a model correlates to a service, a view correlates to the .html/.css segments of a component. and the controller correlates the .ts segment of the component.

A component provides the UI and business logic (or as I like to say a component makes up an action). A component is made up of a .html and .css|scss|sass|less which provides the UI and a .ts file which provides the business logic for a given UI.

In Angular, a service interacts with a data source, typically an API (though this could also interact with local storage, a front-end database, or something to effect. This serves a wrapper to a data source that you will access from a component. A component would interact with a service, never directly with a data source.

As a toolkit, Angular makes it easy to build web, mobile, or desktop applications using web technology. Angular combines TypeScript, design patterns and auto-bundling (think automated gulp) to compile, transpile and package front end assets in real-time. Angular is a CLI based application that runs a dev server on port 4200. Once you're satisfied with your project it can be packaged into a distribution package consisting of HTML, CSS, and JavaScript.

In this chapter, we will

* Learn the basics of TypeScript.
* Port the NASA APOD application Angular.
* Complete Angular's Tour of Heroes (TOH) tutorial.
* Build a front-end CMS consisting of three apps
  * ng-auth
  * ng-users
  * ng-cms
* Build and package PWA

The goals of this chapter is to provide the student with a working knowledge of Angular and produce an Angular application that can be used with our REST API from the previous chapter; thus completing the MEAN stack.

[Next: TypeScript](01-TypeScript.md)
