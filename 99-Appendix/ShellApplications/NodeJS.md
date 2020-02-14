# CLI Applications (shell scripts) in NodeJS
In this section, you will learn how to to automate repetitive tasks by creating a command-line application (aka - script, shell, CLI) using NodeJS. This application will run from the command line interface (CLI) and directly invoke OS level shell commands. 

## Exercise 1 - Scripting Repetitive Tasks
In a previous lesson, you learned the four commands for reloading a virtual-host configuration. While that may not seem too cumbersome when your not updating your site all that often; it gets a little annoying when your testing updates. We will write a script to reduce the burden of this task. A typical shell script is an arrangement or sequence of Linux commands wrapped in a control structure. In addition to Linux commands shell scripts may accept parameters, utilize control statements, variables, and functions.


**Requirements**

Write a shell script that will reduce the four commands for reloading a virtual host configuration and restarting a server on a Debian based LAMP stack to a single command.

In a previous lesson, we used the following four commands to reload a virtual-host configuration and restart the Apache webserver.

```sh
sudo a2dissite * && sudo service apache2 reload && sudo a2ensite * && sudo service apache2 restart
```

That single line equates to the following four lines.

```sh
sudo a2dissite *
sudo systemctl reload apache2
sudo a2ensite *
sudo systemctl reload apache2
```
Anding these statements together allows them to run in a single buffer. The following script will utilize both techniques.

[</> code](https://github.com/microtrain/node_reload_apache/commit/ef611663cfbfcf9c0750b9408649a11695398792) **Create a repository and initial commit**

On GitHub [create a repository](https://help.github.com/en/github/getting-started-with-github/create-a-repo) called *node_reload_apache*.

![Create a Repo](/img/bash/create_repo.png)

Clone the node_reload_apache repository onto your local development machine.

![Create a Repo](/img/bash/clone.png)


```sh
cd ~
git clone git@github.com:YOUR-GITHUB-USERNAME/node_reload_apache
```

[</> code](https://github.com/microtrain/node_reload_apache) **Proof of Concept**

I like to start with a simple proof of concept, this is working code provides either a starting or talking point. For some projects, a proof of concept code may represent a complete working solution but may not be considered the optimal solution.

Add *~/node_reload_apache* as a [new folder](https://code.visualstudio.com/docs/editor/multi-root-workspaces) in your VSC workspace and create a new file *re.js*.

```js
const { exec } = require("child_process");

//Disable the target site config(s)
exec(`sudo a2dissite * && sudo systemctl reload apache2 && sudo a2ensite * && systemctl reload apache2`, {cwd: '/etc/apache2/sites-available'}, (error, stdout, stderr) => {
    if (error) {
        console.log(`error: ${error.message}`);
        return;
    }
    if (stderr) {
        console.log(`stderr: ${stderr}`);
        return;
    }

    console.log(stdout);
});
```

Let's break that code down. NodeJS ships with a set of [core packages](https://nodejs.org/api/). To use a package you must first require that package using the `require()` function. Some packages are imported and set as a new object while others allow you call and use properties of the package. A case of the former would be the [File System](https://nodejs.org/api/fs.html) package. The line `var fs = require('fs');` would create a variable called `fs` into which we are loading an instance of the `fs` module. If you are familiar with object oriented programming, you might think of this as instantiating the `fs` class. All properties of the `fs` module are now available to your code via dot concatenation (ie,`fs.someProperty()`). For this program, we will access a single method from the `child_process` package. 

The following line says "make the `exec()` function available from the `child_process` package. At point we are able for call the `exec()` function by name."

```js
const { exec } = require("child_process");
``` 

Now we can take a look at the [method definition for `exec()`](https://nodejs.org/api/child_process.html#child_process_child_process_exec_command_options_callback). 

* The first argument <code>\`sudo a2dissite * && sudo systemctl reload apache2 && sudo a2ensite * && systemctl reload apache2\`</code> is the shell command to be executed. Note this uses backtick instead of single parenthesis.
* The second argument is an optional JSON object that allows us to pass options into the shell. In this case we are setting the current working directory to `/etc/apache2/sites-available`, this is the directory from which the first argument will execute.
* The third and final option is a callback function. This function deals with the output of the shell command. The callback expects three arguments. 
  * error - Returns an error object when an error is encountered.
  * stdout - Returns the normal output of the executed shell command.
  * stderr - Returns the error output of the executed shell command.

```js
exec(`sudo a2dissite * && sudo systemctl reload apache2 && sudo a2ensite * && systemctl reload apache2`, {cwd: '/etc/apache2/sites-available'}, (error, stdout, stderr) => {
});
```

Finally, we have the body of the callback. If `error` or `stderr` are not null, display that value and exit the program. Otherwise write the value of `stdout` back to the terminal.

The statement `if(error)` will evaluate to true if `error` does not have a value of `null`. Any value passed into `console.log()` is written to the terminal. In this case, `error` having a value other than `null` would mean an error object has been returned. `message` is a property of `error` and as such te statement <code>console.log(\`error: ${error.message}\`);</code> will write the value of the error message to `${error.message}`. This will result the word *error:* followed by the error message being written to the screen. The use of `${someVariable}` being used with the context of backticks <code>\`</code> is known as a [Template literal](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals), the injection of variables into otherwise static content. The `return` statement exits the program.
```js
    if (error) {
        console.log(`error: ${error.message}`);
        return;
    }
```

The statement `if(stderr)` will evaluate to true if `stderr` does not have a value of `null`. Rather than returning an object as described above, this returns a simple string which is injected into a template literal. Other than that, the above description applies.
```js
if (stderr) {
    console.log(`stderr: ${stderr}`);
    return;
}
```

If there are no errors, write the output of the shell command(s) back to the terminal. Some commands do not return any out put, in that case we will write `null` to the terminal. If you wanted to, you could test for `stdout` having a value and if it does not, you can write write a process completion message back to the terminal.
```js
console.log(stdout);
```

Now you can open a terminal and run your program. We will start by moving to the node_reload_apache folder located in our home directory. Once there, we will call `node` and pass the path to our script as an argument.
```sh
cd ~/node_reload_apache
node re.js
```

[</> code](https://github.com/microtrain/node_reload_apache/commit/eb822cd98b1c277561880ef62ebb5b0d1ba705de) Another way to call an application from the terminal is to make it executable. 
```sh
cd ~/node_reload_apache
chmod +x re.js
```

You now have two new way to call this file `source re.js` which tells the terminal to run the file as source code or you can say `./re.js` in which case `./` is shorthand for `source `.

```sh
cd ~/node_reload_apache
./re.js
```

If everything went according to plan you will have received an error.
```sh
./re.js: line 1: syntax error near unexpected token `('
./re.js: line 1: `const { exec } = require("child_process");'
```

When you call your script using node `node re.js` you are invoking the node interpreter and loading your script into it. Without the node command you will use the system default interpreter, in Ubuntu this is Dash. We can resolve this with a shebang statement. This tells the terminal for which interpreter you have written your script. Add the following as the first line of your script.

```sh
#!/usr/bin/env node
```

Now if you rerun the script you will execute with no errors.

```sh
cd ~/node_reload_apache
./re.js
```

[</> code](https://github.com/microtrain/node_reload_apache/commit/6ebacf8dffc06885d7eb3161ac84b924331549f5) Execute as an NPM package

Adding a package.json file will give you an NPM package. Setting the start script will allow you to execute the package using `npm start`. 

Create a file called package.json and add the following.

*package.json*
```json
{
    "scripts": {
        "start": "sudo node re.js"
    }
}
```

Now that you have an NPM package you can use NPM to run your code.

```sh
cd ~/node_reload_apache
./re.js
```

[</> code](https://github.com/microtrain/node_reload_apache/commit/6ebacf8dffc06885d7eb3161ac84b924331549f5) While the previous package.json example is enough for NPM to run your code the recommended to build a package.json file is to use `npm init`.

```sh
cd ~/node_reload_apache
npm init
```

NPM will ask you some questions, you may reply as follows.
```sh
package name: (node_reload_apache) 
version: (1.0.0) 0.0.1
entry point: (re.js) 
git repository: (https://github.com/microtrain/node_reload_apache.git) 
keywords: 
author: 
license: (ISC) MIT
About to write to /home/jason/node_reload_apache/package.json:

{
  "scripts": {
    "start": "sudo node re.js"
  },
  "name": "node_reload_apache",
  "description": "A NodeJS application for reloading Apache virtual hosts.",
  "version": "0.0.1",
  "main": "re.js",
  "repository": {
    "type": "git",
    "url": "git+https://github.com/microtrain/node_reload_apache.git"
  },
  "author": "",
  "license": "MIT",
  "bugs": {
    "url": "https://github.com/microtrain/node_reload_apache/issues"
  },
  "homepage": "https://github.com/microtrain/node_reload_apache#readme"
}

Is this OK? (yes) yes
```



## Exercise 2 - Passing Arguments into a Shell

[</> code](https://github.com/microtrain/node_reload_apache/commit/ddd7005639b6bb191c9e146eb82e29b598e26b05) Arguments can be used to tell the program what to target and/or how to function. An example of this is invoking this program using node `node re.js`. In this example we called a program named node and passed a relative path as the argument.

Node.js ships with access to an object called [process](https://nodejs.org/api/process.html). You can read read all arguments passed into your program by calling [process.argv](https://nodejs.org/api/process.html#process_process_argv).

Add `console.log(process.argv);` above the exec command in your JavaScript file.
```js
#!/usr/bin/env node
const { exec } = require("child_process");

console.log(process.argv);
```

Open a terminal and run your program.
```sh
cd ~/node_reload_apache
node re.js
```

Executing your program with no arguments will produce output similar to the following. This is an array containing a list of arguments. The first argument (array element 0) is the path to the interpreter being used for this shell. The second (array element 1), is a the absolute path of the shell that was just invoked.

```sh
[ '/usr/bin/node', '/home/dev/node_reload_apache/re.js' ]
```

Rerun the command, only this time pass the default virtual-host file as an argument. 
```sh
node re.js 000-default
```

Executing your program with arguments will produce output similar to the following. The first two elements are the same as above but now we have a third element (array element 2). This is the first argument passed by the user.  
```sh
[ '/usr/bin/node',
  '/home/jsnider/node_reload_apache/re.js',
  '000-default' ]
```

Replace `console.log(process.argv);` with the following.

```js
var targetSite = '*';
var args  = process.argv;

if(args[2]){
    targetSite = args[2];
}
```

Then change both `*` in the first argument of the `exec()` command to `${targetSite}`.

Your file should now read as follows.
```js
#!/usr/bin/env node
const { exec } = require("child_process");

var targetSite = '*';
var args  = process.argv;

if(args[2]){
    targetSite = args[2];
}

//Disable the target site config(s)
exec(`sudo a2dissite ${targetSite} && sudo systemctl reload apache2 && sudo a2ensite ${targetSite} && systemctl reload apache2`, {cwd: '/etc/apache2/sites-available'}, (error, stdout, stderr) => {
    if (error) {
        console.log(`error: ${error.message}`);
        return;
    }
    if (stderr) {
        console.log(`stderr: ${stderr}`);
        return;
    }

    console.log(stdout);
});
```

Let's break this down. 

The line `var targetSite = '*';` creates a default state which allows us to run our program without passing an argument. With no arguments passes <code>\`sudo a2dissite ${targetSite}\`</code> and <code>\`sudo a2dissite *\`</code> are equivalent commands.

The line `var args  = process.argv;` creates an array called args. An array is a variable containing multiple key-to-value pairs know as elements. An array element is access by passing the array key on a set of square brackets attached to the array's variable name. In this case, I can access the first user passed argument (array element 2) by calling `args[2]`. The line `if(args[2]){` is a test to see if `args[2]` has a value. If not, the body of the statement is ignored. If `args[2]` has a value then the line `targetSite = args[2];` will change the value of `targetSite` from `*` to the user supplied value; in our case, `000-default`. If `targetSite` is set to `*` then we will reload all site configurations otherwise, we will only reload a single site configuration.


