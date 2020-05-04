## Exercise 5 - MINESWEEPER
Build an interactive Minesweeper game with ReactJS. Minesweeper is a classic board game that is aesthetically similar to tic-tac-toe.
This tutorial is designed for people who have followed the previous [Tic-Tac-Toe](04-TicTacToe.md) exercise and have an understanding of ReactJS.

Minesweeper game will have ***3 components***.
1. Game: The game component renders the board component.
2. Board: The board component renders a 8x8 board containing a total of 64 cells and 10 of the cells will contain mines.
3. Cell : The cell component renders a cell div that represents each square in the board.

Rules of the game
* The goal of the game is to find all the mines on the board.
* You reveal mines by clicking the cells, if you reveal a mine you loose.
* If you reveal a cell without mine it will show number of mines surrounding the cell.
* You can flag a field by right clicking it.
* You win the game if you are able to reveal all the cells that is not a mine or you have flagged all the cells that is a mine.

Set-up project
To keep our code fairly simple we will be ***building each component as classes without using constructors*** to avoid binding functions as much as we can.

```sh
npx create-react-app minesweeper
cd minesweeper
npm start
```

### Game component
The Game component stores the height and width of the board along with number of mines in its state which is later on passed as props to Board component.

Replace *src/index.js
```sh
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Board from './component/Board';
import './style.scss';

class Game extends React.Component {
  state = {
    height: 8,
    width: 8,
    mines: 10
  };

  render() {
    const { height, width, mines } = this.state;
    return (
      <div className="game">
        <Board height={height} width={width} mines={mines} />
      </div>
    );
  }
}

ReactDOM.render(<Game />, document.getElementById("root"));
```

replace */public/index.html
```sh
<div id="root"></div>
```

### Board component
This is the component where all the magic happens. In its basic form Board component maintains boardData state to hold the values of each cell, gameStatus state to distinguish if a game is in progress or won, mineCount state to keep a track of mines that remain to be found(flagged). 

It renders a section containing information on number of mines remaining & whether game has been won and the board itself.

Create */src/component/Board.js
```sh
class Board extends React.Component {
  state = {
    boardData: this.initBoardData(this.props.height, this.props.width, this.props.mines),
    gameStatus: false,
    mineCount: this.props.mines
  };
render() {
  return (
    <div className="board">
      <div className="game-info">
        <span className="info">
          mines: {this.state.mineCount}
        </span>
        <br />
        <span className="info">
          {this.state.gameStatus}
        </span>
      </div>
      { this.renderBoard(this.state.boardData)}
    </div>
    );
  }
}
// Type checking With PropTypes
Board.propTypes = {
  height: PropTypes.number,
  width: PropTypes.number,
  mines: PropTypes.number,
}
```

The ```initiBoard() function``` prepares the initial array containing the data for each cell. It can be divided into 3 functions: ```createEmptyArray(), plantMines() and getNeighbours()```.
```createEmptyArray()``` initializes a two dimensional array and each cell represented by two dimensional item ```data[x][y]``` which contains default values of different attributes.
```sh
createEmptyArray(height, width) {
let data = [];
for (let i = 0; i < height; i++) {
  data.push([]);
  for (let j = 0; j < width; j++) {
    data[i][j] = {
      x: i,
      y: j,
      isMine: false,
      neighbour: 0,
      isRevealed: false,
      isEmpty: false,
      isFlagged: false,
      };
    }
  }
  return data;
}
```

```plantMines()``` randomly plants 10 mines by randomly selecting cells as assigning the ```isMine``` key with true.
```sh
plantMines(data, height, width, mines) {
  let randomx, randomy, minesPlanted = 0;
  while (minesPlanted < mines) {
    randomx = this.getRandomNumber(width);
    randomy = this.getRandomNumber(height);
    if (!(data[randomx][randomy].isMine)) {
      data[randomx][randomy].isMine = true;
      minesPlanted++;
    }
  }
  return (data);
}
```


```getNeighbours()``` processes every cell which is not a mine, get its surrounding cells, calculate the number of surrounding cells that are mines and updates ```neighbour``` attribute of that cell with the total number of mines.

```sh
getNeighbours(data, height, width) {
let updatedData = data;
for (let i = 0; i < height; i++) {
  for (let j = 0; j < width; j++) {
    if (data[i][j].isMine !== true) {
      let mine = 0;
      const area = this.traverseBoard(data[i][j].x, data[i][j].y, data);
      area.map(value => {
        if (value.isMine) {
          mine++;
        }
      });
      if (mine === 0) {
        updatedData[i][j].isEmpty = true;
      }
      updatedData[i][j].neighbour = mine;
    }
  }
}
return (updatedData);
}
```

However, we will need some way to find the surrounding cells. Create a ```traverseBoard()``` method just to do that.
```sh
// looks for neighbouring cells and returns them
traverseBoard(x, y, data) {
  const el = [];
  //up
  if (x > 0) {
    el.push(data[x - 1][y]);
  } 
  //down
  if (x < this.props.height - 1) {
    el.push(data[x + 1][y]);
  }
  //left
  if (y > 0) {
    el.push(data[x][y - 1]);
  }
  //right
  if (y < this.props.width - 1) {
    el.push(data[x][y + 1]);
  }
  // top left
  if (x > 0 && y > 0) {
    el.push(data[x - 1][y - 1]);
  }
  // top right
  if (x > 0 && y < this.props.width - 1) {
    el.push(data[x - 1][y + 1]);
  }
  // bottom right
  if (x < this.props.height - 1 && y < this.props.width - 1) {
    el.push(data[x + 1][y + 1]);
  }
  // bottom left
  if (x < this.props.height - 1 && y > 0) {
    el.push(data[x + 1][y - 1]);
  }
  return el;
}
```
Our final `initBoardData` function looks like this.
```sh
initBoardData(height, width, mines) {
  let data = this.createEmptyArray(height, width);
  data = this.plantMines(data, height, width, mines);
  data = this.getNeighbours(data, height, width);
  
  return data;
}
```
### Rendering the board
The ```renderBoard``` function is self explanatory. It takes a two dimension array and loops through each item in the array and returns a Cell component for each item. Do not worry about the ```handleCellClick``` and ```handleContextMenu``` functions, we will get to them next.
```sh
renderBoard(data) {
  return data.map((datarow) => {
    return datarow.map((dataitem) => {
      return (
        <div 
          key={dataitem.x * datarow.length + dataitem.y}>
          <Cell
            onClick={() => this.handleCellClick(dataitem.x, dataitem.y)}
            cMenu={(e) => this.handleContextMenu(e, dataitem.x, dataitem.y)}
            value={dataitem}
          />
// This line of code adds a clearfix div after the last cell of each row.
          {(datarow[datarow.length - 1] === dataitem) ? <div className="clear" /> : ""}
        </div>
      );
    })
  });
}
```

### Handling Click Event
When a user clicks a cell we need to reveal the field to the user.
* If the cell clicked and is not empty, reveal the value of the field.
* If the cell field is a mine, game over.
* If the cell is empty, recursively reveal all the empty neighbouring fields.
* If the cell is already revealed or flagged don’t do anything.
```sh
handleCellClick(x, y) {
  // check if revealed. return if true.
  if (this.state.boardData[x][y].isRevealed ||    this.state.boardData[x][y].isFlagged) return null;
// check if mine. game over if true
  if (this.state.boardData[x][y].isMine) {
    this.setState({gameStatus: "You Lost."});
    this.revealBoard();
    alert("game over");
  }
  let updatedData = this.state.boardData;
  
  if (updatedData[x][y].isEmpty) {
   updatedData = this.revealEmpty(x, y, updatedData);
  }
if (this.getHidden(updatedData).length === this.props.mines) {
   this.setState({gameStatus: "You Win."});
   this.revealBoard();
   alert("You Win");
  }
  this.setState({
   boardData: updatedData,
   mineCount: this.props.mines -this.getFlags(updatedData).length,
   gameWon: win,
  });
}
```

The ```revealEmpty()``` function recursively reveals all the empty cells when a user clicks an empty cell.
```sh
revealEmpty(x, y, data) {
  let area = this.traverseBoard(x, y, data);
  area.map(value => {
    if (!value.isFlagged && !value.isRevealed && (value.isEmpty || !value.isMine)) {
      data[value.x][value.y].isRevealed = true;
      if (value.isEmpty) {
        this.revealEmpty(value.x, value.y, data);
      }
    }
  });
  return data;
}
```

### Flagging and Handling Right Click Event
We need to flag a cell as a possible mine when the user right clicks on a cell. To do this we add a ```handleContextMenu()``` function on the Board component and pass it down to Cell component to be used as ```onContextMenu``` attribute value. The cool thing is that we can pass down the ***right-click event*** down to the Cell component along with the handler function.

The ```andleContextMenu``` function
* Flags the cell if it’s not revealed and not already flagged.
* Removes the flag if its already flagged.
```sh
handleContextMenu(event, x, y) {
  event.preventDefault();  // prevents default behaviour (i.e. right click menu on browsers.)
  let updatedData = this.state.boardData;
  let mines = this.state.mineCount;
  let win = false;
  // check if already revealed
  if (updatedData[x][y].isRevealed) return;
  if (updatedData[x][y].isFlagged) {
    updatedData[x][y].isFlagged = false;
    mines++;
  } else {
    updatedData[x][y].isFlagged = true;
    mines--;
  }
  if (mines === 0) {
    const mineArray = this.getMines(updatedData);
    const FlagArray = this.getFlags(updatedData);
    if (JSON.stringify(mineArray) === JSON.stringify(FlagArray)) {
      this.revealBoard();
      alert("You Win");
    }
  }
  this.setState({
    boardData: updatedData,
    mineCount: mines,
    gameWon: win,
  });
}
```

Full Code */src/component/Board.js
```sh
import React from 'react';
import PropTypes from 'prop-types';
import Cell from './Cell';

export default class Board extends React.Component {
  state = {
    boardData: this.initBoardData(this.props.height, this.props.width, this.props.mines),
    gameStatus: "Game in progress",
    mineCount: this.props.mines,
  };

  /* Helper Functions */

  // get mines
  getMines(data) {
    let mineArray = [];

    data.map(datarow => {
      datarow.map((dataitem) => {
        if (dataitem.isMine) {
          mineArray.push(dataitem);
        }
      });
    });

    return mineArray;
  }

  // get Flags
  getFlags(data) {
    let mineArray = [];

    data.map(datarow => {
      datarow.map((dataitem) => {
        if (dataitem.isFlagged) {
          mineArray.push(dataitem);
        }
      });
    });

    return mineArray;
  }

  // get Hidden cells
  getHidden(data) {
    let mineArray = [];

    data.map(datarow => {
      datarow.map((dataitem) => {
        if (!dataitem.isRevealed) {
          mineArray.push(dataitem);
        }
      });
    });

    return mineArray;
  }

  // get random number given a dimension
  getRandomNumber(dimension) {
    // return Math.floor(Math.random() * dimension);
    return Math.floor((Math.random() * 1000) + 1) % dimension;
  }

  // Gets initial board data
  initBoardData(height, width, mines) {
    let data = this.createEmptyArray(height, width);
    data = this.plantMines(data, height, width, mines);
    data = this.getNeighbours(data, height, width);
    return data;
  }

  createEmptyArray(height, width) {
    let data = [];

    for (let i = 0; i < height; i++) {
      data.push([]);
      for (let j = 0; j < width; j++) {
        data[i][j] = {
          x: i,
          y: j,
          isMine: false,
          neighbour: 0,
          isRevealed: false,
          isEmpty: false,
          isFlagged: false,
        };
      }
    }
    return data;
  }

  // plant mines on the board
  plantMines(data, height, width, mines) {
    let randomx, randomy, minesPlanted = 0;

    while (minesPlanted < mines) {
      randomx = this.getRandomNumber(width);
      randomy = this.getRandomNumber(height);
      if (!(data[randomx][randomy].isMine)) {
        data[randomx][randomy].isMine = true;
        minesPlanted++;
      }
    }

    return (data);
  }

  // get number of neighbouring mines for each board cell
  getNeighbours(data, height, width) {
    let updatedData = data, index = 0;

    for (let i = 0; i < height; i++) {
      for (let j = 0; j < width; j++) {
        if (data[i][j].isMine !== true) {
          let mine = 0;
          const area = this.traverseBoard(data[i][j].x, data[i][j].y, data);
          area.map(value => {
            if (value.isMine) {
              mine++;
            }
          });
          if (mine === 0) {
            updatedData[i][j].isEmpty = true;
          }
          updatedData[i][j].neighbour = mine;
        }
      }
    }

    return (updatedData);
  };

  // looks for neighbouring cells and returns them
  traverseBoard(x, y, data) {
    const el = [];

    //up
    if (x > 0) {
      el.push(data[x - 1][y]);
    }

    //down
    if (x < this.props.height - 1) {
      el.push(data[x + 1][y]);
    }

    //left
    if (y > 0) {
      el.push(data[x][y - 1]);
    }

    //right
    if (y < this.props.width - 1) {
      el.push(data[x][y + 1]);
    }

    // top left
    if (x > 0 && y > 0) {
      el.push(data[x - 1][y - 1]);
    }

    // top right
    if (x > 0 && y < this.props.width - 1) {
      el.push(data[x - 1][y + 1]);
    }

    // bottom right
    if (x < this.props.height - 1 && y < this.props.width - 1) {
      el.push(data[x + 1][y + 1]);
    }

    // bottom left
    if (x < this.props.height - 1 && y > 0) {
      el.push(data[x + 1][y - 1]);
    }

    return el;
  }

  // reveals the whole board
  revealBoard() {
    let updatedData = this.state.boardData;
    updatedData.map((datarow) => {
      datarow.map((dataitem) => {
        dataitem.isRevealed = true;
      });
    });
    this.setState({
      boardData: updatedData
    })
  }

  /* reveal logic for empty cell */
  revealEmpty(x, y, data) {
    let area = this.traverseBoard(x, y, data);
    area.map(value => {
      if (!value.isFlagged && !value.isRevealed && (value.isEmpty || !value.isMine)) {
        data[value.x][value.y].isRevealed = true;
        if (value.isEmpty) {
          this.revealEmpty(value.x, value.y, data);
        }
      }
    });
    return data;

  }

  // Handle User Events

  handleCellClick(x, y) {

    // check if revealed. return if true.
    if (this.state.boardData[x][y].isRevealed || this.state.boardData[x][y].isFlagged) return null;

    // check if mine. game over if true
    if (this.state.boardData[x][y].isMine) {
      this.setState({ gameStatus: "You Lost." });
      this.revealBoard();
      alert("game over");
    }

    let updatedData = this.state.boardData;
    updatedData[x][y].isFlagged = false;
    updatedData[x][y].isRevealed = true;

    if (updatedData[x][y].isEmpty) {
      updatedData = this.revealEmpty(x, y, updatedData);
    }

    if (this.getHidden(updatedData).length === this.props.mines) {
      this.setState({ mineCount: 0, gameStatus: "You Win." });
      this.revealBoard();
      alert("You Win");
    }

    this.setState({
      boardData: updatedData,
      mineCount: this.props.mines - this.getFlags(updatedData).length,
    });
  }

  handleContextMenu(e, x, y) {
    e.preventDefault();
    let updatedData = this.state.boardData;
    let mines = this.state.mineCount;

    // check if already revealed
    if (updatedData[x][y].isRevealed) return;

    if (updatedData[x][y].isFlagged) {
      updatedData[x][y].isFlagged = false;
      mines++;
    } else {
      updatedData[x][y].isFlagged = true;
      mines--;
    }

    if (mines === 0) {
      const mineArray = this.getMines(updatedData);
      const FlagArray = this.getFlags(updatedData);
      if (JSON.stringify(mineArray) === JSON.stringify(FlagArray)) {
        this.setState({ mineCount: 0, gameStatus: "You Win." });
        this.revealBoard();
        alert("You Win");
      }
    }

    this.setState({
      boardData: updatedData,
      mineCount: mines,
    });
  }

  renderBoard(data) {
    return data.map((datarow) => {
      return datarow.map((dataitem) => {
        return (
          <div key={dataitem.x * datarow.length + dataitem.y}>
            <Cell
              onClick={() => this.handleCellClick(dataitem.x, dataitem.y)}
              cMenu={(e) => this.handleContextMenu(e, dataitem.x, dataitem.y)}
              value={dataitem}
            />
            {(datarow[datarow.length - 1] === dataitem) ? <div className="clear" /> : ""}
          </div>);
      })
    });

  }

  render() {
    return (
      <div className="board">
        <div className="game-info">
          <span className="info">Mines remaining: {this.state.mineCount}</span>
          <h1 className="info">{this.state.gameStatus}</h1>
        </div>
        {
          this.renderBoard(this.state.boardData)
        }
      </div>
    );
  }
}

Board.propTypes = {
  height: PropTypes.number,
  width: PropTypes.number,
  mines: PropTypes.number,
}
```

### Cell component
The Cell component renders each square. We use the getValue() method to determine a suitable value to be rendered by each cell.
* If the cell is not yet revealed we return a null value.
* If the cell is not revealed but is flagged by the user we return a flag(🚩).
* If the cell is revealed and is a mine we return a bomb(💣).
* If the cell is revealed we return the number of neighbour mines for that cell.
* If the cell is revealed and has zero mines in its neighbouring cells, we return a null value.

Create *src/component/Cell.js
```sh
import React from 'react';
import PropTypes from 'prop-types';

export default class Cell extends React.Component {
  getValue() {
    const { value } = this.props;

    if (!value.isRevealed) {
      return this.props.value.isFlagged ? "🚩" : null;
    }
    if (value.isMine) {
      return "💣";
    }
    if (value.neighbour === 0) {
      return null;
    }
    return value.neighbour;
  }

  render() {
    const { value, onClick, cMenu } = this.props;
    let className =
      "cell" +
      (value.isRevealed ? "" : " hidden") +
      (value.isMine ? " is-mine" : "") +
      (value.isFlagged ? " is-flag" : "");

    return (
      <div
        onClick={onClick}
        className={className}
        onContextMenu={cMenu}
      >
        {this.getValue()}
      </div>
    );
  }
}

const cellItemShape = {
    isRevealed: PropTypes.bool,
    isMine: PropTypes.bool,
    isFlagged: PropTypes.bool
}

Cell.propTypes = {
  value: PropTypes.objectOf(PropTypes.shape(cellItemShape)),
  onClick: PropTypes.func,
  cMenu: PropTypes.func
}
```



## Styling the App
```
npm install node-sass
```

Add the following styling */src/style.scss
```
*,
*:before,
*:after {
  box-sizing: border-box;
}
body {
  margin: 20px;
  padding: 0;
  font-family: sans-serif;
  background: #f4f4f4;
}

.clear {
  clear: both;
  content: "";
}

.game {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;

  .game-info {
    margin-bottom: 20px;
    background: #19a0d9;
    padding: 7px;
    text-align: center;
    color: #fff;
    min-height: 100px;
    border-radius: 7px;
    .info {
      display: block;
      margin-top: 15px;
    }
  }

  .board {
  }

  .cell {
    background: #7b7b7b;
    border: 1px solid #fff;
    float: left;
    line-height: 45px;
    height: 45px;
    text-align: center;
    width: 45px;
    cursor: pointer;
    border-radius: 5px;
    color: #fff;
    font-weight: 600;

    &:focus {
      outline: none;
    }
  }

  .hidden {
    background: #2e2829;
  }

  .is-flag,
  .is-mine {
    color: #fc543c;
  }
}
```

## Lab 5 - MINESWEEPER
Here are some ideas for improvements that you could make to the Minesweeper game which are listed in order of increasing difficulty:
* Change/Add Title, Description and Metadata to the game.
* Change style */src/style.scss and add your own color palette.
* Add a button to reload a game after a loss.
* Make it possible to “select skill level” to determine the size of the grid and the number of mines.

