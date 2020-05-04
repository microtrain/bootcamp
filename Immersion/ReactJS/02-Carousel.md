## Exercise 2 - CAROUSEL

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
<p className="legend">Singapore</p>
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

When you’re ready to deploy to production, running ```npm run build``` will create an optimized build of your app in the ```build``` folder.

## Lab 2 - CAROUSEL
* Review ```<img src="/path" alt="name">``` in */src/App.js 
* Replace image source and legends with your own interest
* Add Title and Description to App page

[Next: Memory Game](03-MemoryGame.md)
