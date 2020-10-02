## Exercise 4 - TIC TAC TOE
Using the ReactJS [Tic-Tac-Toe tutorial](https://reactjs.org/tutorial/tutorial.html) as a guide, we’ll build an interactive tic-tac-toe game with React.
 
This tutorial is designed for people who prefer to learn by doing. If you prefer learning concepts from the ground up, check out our [step-by-step guide](https://reactjs.org/docs/hello-world.html). You might find this tutorial and the guide complementary to each other.
 
To create the example project for this example, open command prompt, navigate to a convenient location, and run the command as shown below :
 
```sh
npx create-react-app tic-tac-toe
```
 
Navigate to the project folder and add the React Bootstrap Package to the project as shown below :
 
```sh
cd tic-tac-toe
npm i bootstrap-4-react
npm start
```
 
Create an empty repository called tic-tac-toe on GitHub and push your project to the new repository. Don't worry about the initial commit as ReactJS has taken care of this for you.
```sh
git remote add origin git@github.com:GITHUBUSERNAME/tic-tac-toe.git
git push origin main
```
Add the newly created app in VSCode, open the project folder and replace the placeholder content of *src/App.css with:
```sh
.col {
  padding: 0px;
  background: white;
  border: 1px solid rgb(65, 65, 65);
  height: 72px;
  cursor: pointer;
}
 
.marking {
  width: 100%;
  height: 100%;
  font-size: 40px;
  text-align: center;
  vertical-align: middle;
}
 
.marking-x {
  color: lightblue;
}
 
.marking-o {
  color: lightcoral;
}
 
.alert {
  margin-top: 20px;
  text-align: center;
  display: none;
}
 
.board {
  margin: 0 33%;
  max-width: 190px;
}
 
.container {
  text-align: center;
}
 
#ai {
  background: #d4edda;
}
 
#container {
  width: 600px;
  height: 500px;
}
```
open */public/index.html and replace contents of ```<body></body>```
```sh
<body>
        <div id="errors" style="
        background: #c00;
        color: #fff;
        display: none;
        margin: -20px -20px 20px;
        padding: 20px;
        white-space: pre-wrap;
      "></div>
      <div id="root"></div>
      <script>
      window.addEventListener('mousedown', function(e) {
        document.body.classList.add('mouse-navigation');
        document.body.classList.remove('kbd-navigation');
      });
      window.addEventListener('keydown', function(e) {
        if (e.keyCode === 9) {
          document.body.classList.add('kbd-navigation');
          document.body.classList.remove('mouse-navigation');
        }
      });
      window.addEventListener('click', function(e) {
        if (e.target.tagName === 'A' && e.target.getAttribute('href') === '#') {
          e.preventDefault();
        }
      });
      window.onerror = function(message, source, line, col, error) {
        var text = error ? error.stack || error : message + ' (at ' + source + ':' + line + ':' + col + ')';
        errors.textContent += text + '\n';
        errors.style.display = '';
      };
      console.error = (function(old) {
        return function error() {
          errors.textContent += Array.prototype.slice.call(arguments).join(' ') + '\n';
          errors.style.display = '';
          old.apply(this, arguments);
        }
      })(console.error);
      </script>
</body>      
``` 
open *src/index.js
Copy the [starter code](https://codepen.io/gaearon/pen/oWWQNa?editors=0010) below into *src/index.js, this is the base of what we’re building.
```sh
class Square extends React.Component {
  render() {
    return (
      <button className="square">
        {/* TODO */}
      </button>
    );
  }
}
 
class Board extends React.Component {
  renderSquare(i) {
    return <Square />;
  }
 
  render() {
    const status = 'Next player: X';
 
    return (
      <div>
        <div className="status">{status}</div>
        <div className="board-row">
          {this.renderSquare(0)}
          {this.renderSquare(1)}
          {this.renderSquare(2)}
        </div>
        <div className="board-row">
          {this.renderSquare(3)}
          {this.renderSquare(4)}
          {this.renderSquare(5)}
        </div>
        <div className="board-row">
          {this.renderSquare(6)}
          {this.renderSquare(7)}
          {this.renderSquare(8)}
        </div>
      </div>
    );
  }
}
 
class Game extends React.Component {
  render() {
    return (
      <div className="game">
        <div className="game-board">
          <Board />
        </div>
        <div className="game-info">
          <div>{/* status */}</div>
          <ol>{/* TODO */}</ol>
        </div>
      </div>
    );
  }
}
 
// ========================================
 
ReactDOM.render(
  <Game />,
  document.getElementById('root')
);
```
By inspecting the code, you’ll notice that we have three React components:
* Square
* Board
* Game

**Note** 
> The Square component renders a single <button> and the Board renders 9 squares. The Game component renders a board with placeholder values which we’ll modify later. There are currently no interactive components.
 
### Passing Data Through Props
We begin by passing some data from our ***Board component*** to our ***Square component***.
 
In Board’s ```renderSquare method```, change the code to pass a prop called ```value``` to the Square:
```sh
class Board extends React.Component {
  renderSquare(i) {
    return <Square value={i}/>;
  }
```
 
Change Square’s ```render``` method to show that value by replacing ```{/* TODO */}``` with ```{this.props.value}```:
```sh
class Square extends React.Component {
  render() {
    return (
      <button className="square">
        {this.props.value}
      </button>
    );
  }
}
```
Test everything is working by navigating to the pages you just created.
* [http://localhost:3001/](http://localhost:3001/)
* You should see a number in each square in the rendered output.
 
### Making an Interactive Component
Let’s fill the Square component with an “X” when we click it. First, change the ***button tag*** that is returned from the Square component’s ```render()``` function to this:
```sh
class Square extends React.Component {
  render() {
    return (
      <button className="square" onClick={function() { alert('click'); }}>
        {this.props.value}
      </button>
    );
  }
}
```
If you click on a Square now, you should see an alert in your browser.
 
To save typing and avoid the confusing behavior of this ```-alert```, we will use the ```arrow function syntax``` for event handlers here and further below:
```sh
class Square extends React.Component {
 render() {
   return (
     <button className="square" onClick={() => alert('click')}>
       {this.props.value}
     </button>
   );
 }
}
```
**Note**
> Notice how with ```onClick={() => alert('click')}```, we’re passing a function as the onClick prop. React will only call this function after a click. Forgetting () => and writing ```onClick={alert('click')}``` is a common mistake, and would fire the alert every time the component re-renders.
 
As a next step, we want the Square component to “remember” that it got clicked, and fill it with an “X” mark. To “remember” things, components use state.
 
First, we’ll add a ***constructor*** to the Square class to initialize the state:
```sh
class Square extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      value: null,
    };
  }
 
  render() {
    return (
      <button className="square" onClick={() => alert('click')}>
        {this.props.value}
      </button>
    );
  }
}
```
Now we’ll change the ***Square’s render*** method to display the current state’s value when clicked:
 
* Replace ```this.props.value``` with ```this.state.value``` inside the <button> tag.
* Replace the ```onClick={...}``` event handler with ```onClick={() => this.setState({value: 'X'})}```.
* Put the className and onClick props on separate lines for better readability.
 
After these changes, the <button> tag that is returned by the ***Square’s render*** method looks like this:
```sh
class Square extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      value: null,
    };
  }
 
  render() {
    return (
      <button
        className="square"
        onClick={() => this.setState({value: 'X'})}
      >
        {this.state.value}
      </button>
    );
  }
}
```

**Note**
> By calling this.setState from an onClick handler in the Square’s render method, we tell React to re-render that Square whenever its ```<button>``` is clicked. After the update, the Square’s this.state.value will be 'X', so we’ll see the X on the game board. If you click on any Square, an X should show up.
 
```
git status
git add .
git commit -am 'Interactive Component Rendered X'
```

## Completing the Game

We now have the basic building blocks for our tic-tac-toe game. To have a complete game, we now need to alternate placing “X”s and “O”s on the board, and we need a way to determine a winner.

### Lifting State Up
Currently, each ***Square component*** maintains the game’s state. To check for a winner, we’ll maintain the value of each of the 9 squares in one location.

The ***Board component*** can tell each Square what to display by passing a prop, just like we did when we passed a number to each Square.

*To collect data from multiple children, or to have two child components communicate with each other, you need to declare the shared state in their parent component instead. The parent component can pass the state back down to the children by using props; this keeps the child components in sync with each other and with the parent component.*

Lifting state into a parent component is common when React components are refactored — Adding a ***constructor*** to the Board and set the Board’s initial state to contain an array of 9 nulls corresponding to the 9 squares:

```sh
class Board extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      squares: Array(9).fill(null),
    };
  }

  renderSquare(i) {
    return <Square value={i} />;
  }
```
The Board’s renderSquare method currently looks like this:
```sh
  renderSquare(i) {
    return <Square value={i} />;
  }
```
In the beginning, we passed the value prop down from the Board to show numbers from 0 to 8 in every Square. In a different previous step, we replaced the numbers with an “X” mark determined by Square’s own state. This is why Square currently ignores the value prop passed to it by the Board.

We will now use the prop passing mechanism again. We will modify the Board to instruct each individual Square about its current value ('X', 'O', or null). We have already defined the squares array in the Board’s constructor, and we will modify the Board’s ***renderSquare*** method to read from it:

```sh
  renderSquare(i) {
    return <Square value={this.state.squares[i]} />;
  }
```
Each Square will now receive a value prop that will either be 'X', 'O', or null for empty squares.

Next, we need to change what happens when a Square is clicked. The Board component now maintains which squares are filled. We need to create a way for the Square to update the Board’s state. Since state is considered to be private to a component that defines it, we cannot update the Board’s state directly from Square.

Instead, we’ll pass down a function from the Board to the Square, and we’ll have Square call that function when a square is clicked. We’ll change the ***renderSquare*** method in Board to:
```sh
  renderSquare(i) {
    return (
      <Square
        value={this.state.squares[i]}
        onClick={() => this.handleClick(i)}
      />
    );
  }
```

**Note**
> We split the returned element into multiple lines for readability, and added parentheses so that JavaScript doesn’t insert a semicolon after return and break our code.

Now we’re passing down two props from Board to Square: ```value``` and ```onClick```. The ```onClick``` prop is a function that Square can call when clicked. We’ll make the following changes to ***Square class***:
* Replace ```this.state.value``` with ```this.props.value``` in Square’s render method
* Replace ```this.setState()``` with ```this.props.onClick()``` in Square’s render method
* Delete the ```constructor``` from Square because Square no longer keeps track of the game’s state

```sh
class Square extends React.Component {
  render() {
    return (
      <button
        className="square"
        onClick={() => this.props.onClick()}
      >
        {this.props.value}
      </button>
    );
  }
}
```
When a Square is clicked, the ```onClick``` function provided by the Board is called. Here’s a review of how this is achieved:

1. The ```onClick``` prop on the built-in DOM ```<button>``` component tells React to set up a click event listener.
2. When the button is clicked, React will call the ```onClick``` event handler that is defined in Square’s ```render()``` method.
3. This event handler calls ```this.props.onClick()```. The Square’s onClick prop was specified by the Board.
4. Since the Board passed ```onClick={() => this.handleClick(i)}``` to Square, the Square calls ```this.handleClick(i)``` when clicked.
5. We have not defined the ```handleClick()``` method yet, so our code crashes. If you click a square now, you should see a red error screen saying something like “this.handleClick is not a function”.

**Note**
> When we try to click a Square, we should get an error because we haven’t defined ```handleClick``` yet. We’ll now add ```handleClick``` to the ***Board class***:

```sh
class Board extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      squares: Array(9).fill(null),
    };
  }

  handleClick(i) {
    const squares = this.state.squares.slice();
    squares[i] = 'X';
    this.setState({squares: squares});
  }

  renderSquare(i) {
    return (
      <Square
        value={this.state.squares[i]}
        onClick={() => this.handleClick(i)}
      />
    );
  }

  render() {
    const status = 'Next player: X';

    return (
      <div>
        <div className="status">{status}</div>
        <div className="board-row">
          {this.renderSquare(0)}
          {this.renderSquare(1)}
          {this.renderSquare(2)}
        </div>
        <div className="board-row">
          {this.renderSquare(3)}
          {this.renderSquare(4)}
          {this.renderSquare(5)}
        </div>
        <div className="board-row">
          {this.renderSquare(6)}
          {this.renderSquare(7)}
          {this.renderSquare(8)}
        </div>
      </div>
    );
  }
}
```
**Note**
> After these changes, we’re again able to click on the Squares to fill them, the same as we had before. However, now the state is stored in the Board component instead of the individual Square components. When the Board’s state changes, the Square components re-render automatically. Keeping the state of all squares in the Board component will allow it to determine the winner in the future.

> Since the Square components no longer maintain state, the Square components receive values from the Board component and inform the Board component when they’re clicked. In React terms, the Square components are now controlled components. The Board has full control over them.

```
git status
git add .
git commit -am 'Added Controlled X State'
```

### Function Components
We’ll now change the Square to be a function component.

In React, function components are a simpler way to write components that only contain a render method and don’t have their own state. Instead of defining a class which extends React.Component, we can write a function that takes props as input and returns what should be rendered. Function components are less tedious to write than classes, and many components can be expressed this way.

Replace the ***Square class*** with this function:
```sh
function Square(props) {
  return (
    <button className="square" onClick={props.onClick}>
      {props.value}
    </button>
  );
}
```

**Note**
>When we modified the Square to be a function component, we also changed ```onClick={() => this.props.onClick()}``` to a shorter ```onClick={props.onClick}``` (note the lack of parentheses on both sides).

### Taking Turns
We now need to fix an obvious defect in our tic-tac-toe game: the “O”s cannot be marked on the board.

We’ll set the first move to be “X” by default. We can set this default by modifying the initial state in our Board constructor:

```sh
class Board extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      squares: Array(9).fill(null),
      xIsNext: true,
    };
  }
```
Each time a player moves, xIsNext (a boolean) will be flipped to determine which player goes next and the game’s state will be saved. We’ll update the Board’s handleClick function to flip the value of xIsNext:

```sh
  handleClick(i) {
    const squares = this.state.squares.slice();
    squares[i] = this.state.xIsNext ? 'X' : 'O';
    this.setState({
      squares: squares,
      xIsNext: !this.state.xIsNext,
    });
  }
```
**Note**
> With this change, “X”s and “O”s can take turns. Try it!

```
git status
git add .
git commit -am 'Changed X and O Render and Turn Status'
```

### Declaring a Winner

Now that we show which player’s turn is next, we should also show when the game is won and there are no more turns to make. Copy this helper function and paste it at the end of the file:
```sh
function calculateWinner(squares) {
  const lines = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6],
  ];
  for (let i = 0; i < lines.length; i++) {
    const [a, b, c] = lines[i];
    if (squares[a] && squares[a] === squares[b] && squares[a] === squares[c]) {
      return squares[a];
    }
  }
  return null;
}
```
**Note**
> Given an array of 9 squares, this function will check for a winner and return 'X', 'O', or null as appropriate.

We will call ```calculateWinner(squares)``` in the ***Board’s render*** function to check if a player has won. If a player has won, we can display text such as “Winner: X” or “Winner: O”. We’ll replace the status declaration in Board’s render function with this code:
```sh
  render() {
    const winner = calculateWinner(this.state.squares);
    let status;
    if (winner) {
      status = 'Winner: ' + winner;
    } else {
      status = 'Next player: ' + (this.state.xIsNext ? 'X' : 'O');
    }

    return (
      // the rest has not changed
```

We can now change the Board’s ```handleClick``` function to return early by ignoring a click if someone has won the game or if a Square is already filled:

**Note**
> ***Congratulations!*** You now have a working tic-tac-toe game. And you’ve just learned the basics of React too. So you’re probably the real winner here.

```
git status
git add .
git commit -an 'Completed Tic Tac Toe App'
git push origin main
```

## Lab 4 - TIC TAC TOE
Here are some ideas for improvements that you could make to the tic-tac-toe game which are listed in order of increasing difficulty:
* Change Title, Description and Style the App */src/App.css
* Make it possible to “go back in time” to the previous moves in the game.
* Bold the currently selected item in the move list.
* When someone wins, highlight the three squares that caused the win.

[Next: Minesweeper](05-Minesweeper.md)
