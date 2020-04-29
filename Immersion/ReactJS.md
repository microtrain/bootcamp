# [ReactJS](https://reactjs.org/)

ReactJS is considered as an open-source JavaScript library rather than a framework. It is mainly used for building amazing user interfaces with a great focus on rendering performance. In MVC(Model View Controller) architecture, React is more dependent on “V”.<br />

ReactJS quickly gained a good reputation when it was launched first. It was built with the aim of resolving issues in JavaScript frameworks related to efficient rendering of large datasets.<sup>[1]</sup>.

*Top 3 reasons to use it*

* SEO Effective
* Components in ReactJS
* Great efficiency.

Search engines find it difficult to read JavaScript heavy applications even after having improvements in that area. So this is one of the big issues that come with JavaScript frameworks.
But ReactJS has beaten up this. You can easily run ReactJS on the server and the virtual DOM will be rendered then which further return to the browser as a regular web page. No hard tricks are required for this.
PolymerJS and Shadow DOM has already created a lot of buzzes which are typically used to create customizable elements, self-contained elements that you can easily import into your project.

But ReactJS makes you able to create your own components which you can later combine, reuse or nest your core content. So it doesn’t make use of Shadow DOM or PolymerJS.
ReactJS creates its own virtual DOM where your components actually live. It takes care of all the changes to made in the DOM and updates in the DOM tree also. This makes it a flexible approach to gain a good performance. Hence, it discards costly DOM operations and regularly makes updates efficiently.

## Getting Started with ReactJS
* Make sure you have a recent version of Node.js installed.```node -v```
* You’ll need to have Node >= 8.10 and npm >= 5.6 on your machine
* Follow the installation instructions to make a new project

```sh
npx create-react-app my-app
cd my-app
npm start
```
If you receive a warning Something is already running on Port 3000, Would you like to run the app on another port instead?
Type YES (Y/no) to launch my-app in the browser on another port instead [localhost:3001](http://localhost:3001/)

Create React App doesn’t handle backend logic or databases; it just creates a frontend build pipeline, so you can use it with any backend you want. Under the hood, it uses Babel and webpack, but you don’t need to know anything about them.

When you’re ready to deploy to production, running ```npm run build``` will create an optimized build of your app in the build folder.


## Exercise 1 - CAROUSEL

This is a simple responsive Carousel loading images from third-party sites and generating thumbnails automatically. We will use React Responsive Carousel package which you need to first install and using Carousel component available in package we design our carousel.

To create the example project for this example, open command prompt, navigate to a convenient location, and run the command as shown below :

```sh
npx create-react-app carousel
```
Now navigate to the project folder and add the React Responsive Carousel package to the project as shown below :

```sh
cd carousel
npm i react-responsive-carousel
```
Replace the placeholder content of App.js with given below content :

*/src/App.js
```sh
import React from 'react';
import { Carousel } from 'react-responsive-carousel';
import "react-responsive-carousel/lib/styles/carousel.min.css";

let styles = {
    margin: 'auto',
    width: '500px'
  };
  
function App() {
  return (
<div style={styles}>
<Carousel>
<div>
<img src="https://res.klook.com/image/upload/fl_lossy.progressive,q_65/c_fill,w_480,h_384/cities/jrfyzvgzvhs1iylduuhj.jpg" alt="Hong Kong" />
<p className="legend">Hong Kong</p>
</div>
<div>
<img src="https://res.klook.com/image/upload/fl_lossy.progressive,q_65/c_fill,w_480,h_384/cities/c1cklkyp6ms02tougufx.webp" alt="Singapore"/>
<p className="legend"></p>
</div>
<div>
<img src="https://res.klook.com/image/upload/fl_lossy.progressive,q_65/c_fill,w_480,h_384/cities/e8fnw35p6zgusq218foj.webp" alt="Japan"/>
<p className="legend">Japan</p>
</div>
<div>
<img src="https://res.klook.com/image/upload/fl_lossy.progressive,q_65/c_fill,w_480,h_384/cities/liw377az16sxmp9a6ylg.webp" alt="Las Vegas"/>
<p className="legend">Las Vegas</p>
</div>
</Carousel>
</div>
  );
}

export default App;
 
```
In the second line import example, we are doing the same as line one, but here we are referencing a package name. This is the common pattern in React for referencing a specific component from package.

In the third line import example, we see that we importing a CSS file.

In this < Carousel >...< Carousel / > component above, we can see that we are pulling in images. We also see the use of HTML elements in our React code. This is possible thanks to a library called [JSX](https://reactjs.org/docs/jsx-in-depth.html), which lets us write HTML markup directly in our JavaScript.});

```sh
npm start
```
If you receive a warning Something is already running on Port 3000, Would you like to run the app on another port instead?
Type YES (Y/no) to launch my-app in the browser on another port instead [localhost:3001](http://localhost:3001/)




