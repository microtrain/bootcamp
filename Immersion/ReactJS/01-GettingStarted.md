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

When app creation is complete, you will see the following in your Terminal window
```sh
Created git commit.

Success! Created my-app at /home/dev/my-app
Inside that directory, you can run several commands:

  npm start
    Starts the development server.

  npm run build
    Bundles the app into static files for production.

  npm test
    Starts the test runner.

  npm run eject
    Removes this tool and copies build dependencies, configuration files
    and scripts into the app directory. If you do this, you can’t go back!

We suggest that you begin by typing:

  cd <project-name>
  npm start
  
Happy hacking!  
```
