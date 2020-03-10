For this lesson we use Ubuntu Linux, let's get started by installing Node.js. I like to use the latest LTS version, in this case it's 12.16.1

Open a terminal and run the following commands.
```sh
curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -
sudo apt-get install -y nodejs
```

Now we can create a project directory in our home folder. I'll call mine `nodeApp`
```sh
cd ~
mkdir nodeApp
```

Now I will add the new folder to my VSCode workspace. (File > Add Folder to Workspace). Right click on the dierctory and create a file called *index.js*

Let's strart by printing the output of a for loop.
```js
for (let i=0; i<10; i++){
console.log(i);
}
```

The `for()` function creates a loop. `let i = 0;` initiales a variable called `i`, `i<10` says if the value of `i` is less than ten, keep running the loop, `i++` is an incremeter that says every time the loop runs increase the value of `i` by one, and `console.log(i)` will writethe value of `i` back to the terminal.

We can run the code by returning the command-line, moving in the project folder by typing `cd nodeApp`    and we can execute the file using Node.js by typing `node index.js` the expected output in 0-9.

We can also use NPM to execute our script. Typing `npm init` ask you a few questions and create a package.json file based on the output.

For the sake of brevity we will just accept the defaults. Now open *package.json* and add the line `"start": "node index.js",`

Running ``npm start` will now execute the script.

The third way to execute the file is by setting executable flag on the file and calling the environemnt with a shebang statement.

Add a shebang statement to the top of index.js
```js
#!/usr/bin/env node
```

Switch to the comandline to add the executable flag to the *index.js* file.

```sh
chmod +x index.js
```

No you can execute the file by typing `./index.js`

`./` says execute the file using the environment defined by the shebang statement.
