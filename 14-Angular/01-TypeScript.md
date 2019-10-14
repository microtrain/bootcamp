# TypeScript

## Introduction

TypeScript is a superset of JavaScript that adds strict typing and class 
decorators as a way to extend functionality to other components in a system. 
Browsers do not directly interpret TypeScript, rather, TypeScript is transpiled 
into JavaScript.

Install TypeScript
```sh
sudo npm install -g typescript
```

Create a TypeScript file.
```sh
vim ~/hello.ts
```

Add some TypeScript to the file. This simple example looks like JavaScript 
because it is JavaScript.
```ts
function msg(who) {
    return "Hello, " + who;
}

let who = "World";

document.body.innerHTML = msg(who);
```

Run the ```tsc``` command to transpile the TypeScript file to a JavaScript 
file.

```sh
tsc hello.ts
```

This will create a file called *~/hello.js*. Open that file and give it a look.
It should almost identical. This is an oversimplified example.
```sh
vim hello.js
```

Here is a better example. Writing in a class format is supported in ES6 but 
there is some concern about browser support. In the following example we:

* Create a class.
* Instantiate the class.
* Call a method from the class.

Change *~/hello.ts* to the following.

```ts
class Hello{

    sayHello():void {
        alert('hello');
    }
}

let hi = new Hello();

hi.sayHello();
```

If we transpile this code and view the results, we will see something very 
different.
```sh
tsc ~/hello.ts
```

Now if you open *~/hello.ts* you will see the following.
```js
var Hello = /** @class */ (function () {
    function Hello() {
    }
    Hello.prototype.sayHello = function () {
        alert('Hello');
    };
    return Hello;
}());
var hi = new Hello();
hi.sayHello();
```

As you can see, the class is converted to a closure and more closely resembles
the style of JavaScript we had written in previous lessons.

## Working with Types

TypeScript is a strongly typed version of JavaScript. In the previous example,
```:void``` is the return type we are assigning to the ```sayHello()``` method.
This type is void because are not returning anything, we are simply calling 
JavaScript's ```alert()``` function.

Now let's work with some types. We modify our class to say "hello" to a given 
entity. Instead of calling ```hi.sayHello();``` we will call 
```hi.sayHello(who);```. Where "who" is any *String* we pass into the method 
signature. In TypeScript, you assign return types to all methods, all arguments 
in a method signature, and all instance variables.

In the following example, a colon is used to denote the expected type.

```ts
class Hello{

    greeting:String = 'Hello'; 

    toWhom(who:String):String{
        return this.greeting + ' ' + who;
    }

    sayHello(who:String):void {
        alert(this.toWhom(who));
    }
}

let hi = new Hello();

hi.sayHello('World');
```

If we were to change  ```hi.sayHello('World');``` to ```hi.sayHello(42);``` we 
would get the following type error when we attempt to transpile the code. 

![type error](/img/ts/type-error.png)

This is the point of TypeScript; it transpiles to JavaScript. JavaScript is 
loosely typed. This makes make easy for programmers to miss little type 
differences which can lead to unexpected errors down the road. 

In summation, TypeScript is more a tool for developers to deliver higher quality 
JavaScript application. Angular aims to provide a high-quality development 
environment for developing single-page applications (SPA). TypeScript is a
part of this dev environment. 

In this lesson, we learned
* How to transpile TypeScript to JavaScript.
* What it means to work with types.

## Additional Resources

* [TypeScript](https://www.typescriptlang.org/)

[Next: NASA Apod](02-NgApod.md)
