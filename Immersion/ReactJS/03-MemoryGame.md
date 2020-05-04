## Exercise 3 - MEMORY GAME

This application puts your memory to the test. You are presented with multiple images of celebrities. The images get shuffled every-time they are clicked. You CAN NOT click on any image more than once or else your score resets to zero. The main objective is to get the highest score as possible.

To create the example project for this example, open command prompt, navigate to a convenient location, and run the command as shown below :

```sh
npx create-react-app memory-game
```
Replace the placeholder content of App.js with given below content :
*/src/App.js

```sh
import React, { Component } from "react";
import CharacterCard from "./CharacterCard";
import Wrapper from "./Wrapper";
import Navbar from "./Navbar";
import Jumbotron from "./Jumbotron";
import characters from "./characters.json";
import "./App.css";

class App extends Component {
  state = {
    characters,
    highScore: 0,
    currentScore: 0,
    Clicked: false
  };

  handleClick = id => {
    this.shuffleArray();
    this.handleScore(id);
    console.log(this.state.timesClicked);
  };

  handleScore = id => {
    this.state.characters.forEach(element => {
      if (id === element.id && element.clicked === false) {
        element.clicked = true;
        this.setState({ Clicked: false });
        this.handleIncrement();
      } else if (id === element.id && element.clicked === true) {
        if (this.state.currentScore > this.state.highScore) {
          this.setState({ highScore: this.state.currentScore });
        }
        this.setState({ currentScore: 0 });
        this.setState({ Clicked: true });
        this.state.characters.forEach(element => (element.clicked = false));
        console.log(this.state.characters);
      }
    });
  };

  shuffleArray = () => {
    // Shuffle array of objects
    const shuffledArr = this.shuffle(this.state.characters);
    // Setting 'shuffledArr' as the new state
    this.setState({ shuffledArr });
  };

  // handleIncrement increments this.state.currentScore by 1
  handleIncrement = () => {
    // Using setState method to update component's state
    this.setState({ currentScore: this.state.currentScore + 1 });
  };

  // Function that takes an array as a parameter and shuffles it
  shuffle = array => {
    var currentIndex = array.length,
      temporaryValue,
      randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {
      // Pick a remaining element...
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;

      // And swap it with the current element.
      temporaryValue = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex] = temporaryValue;
    }
    return array;
  };

  render() {
    return (
      <Wrapper>
        <Navbar
          currentScore={this.state.currentScore}
          highScore={this.state.highScore}
        />
        <Jumbotron />
        {this.state.characters.map(character => (
          <CharacterCard
            Clicked={this.state.Clicked}
            handleClick={this.handleClick}
            id={character.id}
            key={character.id}
            name={character.name}
            image={character.image}
            occupation={character.occupation}
          />
        ))}
      </Wrapper>
    );
  }
}

export default App;
```

Create the file: */src/CharacterCard.js
```sh
import React from "react";
 
function CharacterCard(props) {
    return (
        <div className={"card " + (props.Clicked ? "animate" : "")} onClick={() => props.handleClick( props.id)} >  
            <div className="img-container">
                <img alt={props.name} src={props.image} />
            </div>
            <div className="img-content">
                <ul>
                    <li>
                        <strong>Name:</strong>{props.name}
                    </li>
                    <li>
                        <strong>Occupation: </strong>{props.occupation}
                    </li>
                </ul>
            </div>
        </div >
    )
}
 
export default CharacterCard;
```

Create the file: */src/Jumbotron.js

```sh
import React from "react";
 
function Jumbotron(props) {
  return (
    <div className="jumbotron jumbotron-fluid">
      <div className="container">{props.children}
        <p className="lead">Get points by clicking on an image but don't click on any more than once!</p>
      </div>
    </div>
  )
}

export default Jumbotron;

```

Create the file: */src/Wrapper.js

```sh
import React from "react";
 
function Wrapper(props){
    return <div className="wrapper">{props.children}</div>
}
 
export default Wrapper;
```

Create the file: */Navbar.js
```sh
import React from "react";
 
function Navbar(props) {
    return (
        <header className="container-fluid fixed-top" >
            <div className="row">
                <h1 className="col-sm-8">Celebrity Memory Game</h1>
                <nav className="col-sm-4">
                    <p>Score: <span>{props.currentScore}</span></p>
                    <p>Top Score: <span>{props.highScore}</span> </p>
                    {props.children}
                </nav>
            </div>
        </header>        
    )
}
 
export default Navbar;
```

Replace the placeholder content of App.css:*/src/App.css
```sh
.wrapper {
  height: 100%;
  display: flex;
  flex-flow: row wrap;
  justify-content: space-around;
  align-content: flex-start;
  overflow: auto;
}

header {
  padding: 10px 0;
  background-color: red;
  margin-bottom: 5px;
  box-shadow: 0 3px 6px #999, 0 3px 6px #999;
  color: white;
  width: 100%;
}

header h1 {
  font-size: 30px;
  margin: 0;
}

header nav {
  display: flex;
  justify-content: flex-end;
}

header p {
  font-weight: bold;
  padding: 0 10px;
  margin: 0;
}

.jumbotron {
  display: flex;
  align-items: center;
  background: linear-gradient(to left top, blue, red) center center fixed;
  background-size: cover;
  color: #ffffff;
  height: 50px;
  text-shadow: 0.25px 0.25px 0.25px #000000;
  width: 100%;
}

.jumbotron p {
  text-align: center;
  margin: 0 0 20px;
  font-weight: bold;
  font-size: 1.5rem;
}

@media only screen and (max-width: 700px) {
  .jumbotron {
    margin-top: 120px;
  }
}

@media only screen and (max-width: 600px) {
  .jumbotron {
    margin-top: 110px;
  }
  .jumbotron p {
    margin: 0;
    font-size: 15px;
  }
}

.card {
  background: #fff;
  border: 5px solid #fff;
  border-radius: 2px;
  margin: 40px 20px;
  position: relative;
  height: 300px;
  width: 250px;
  box-shadow: 0 3px 6px #999, 0 3px 6px #999;
  transition: box-shadow 0.1s ease-in-out;
  text-align: left;
}

.card:hover {
  box-shadow: 0 12px 24px #999, 0 12px 24px #999;
  height: 300px;
  width: 250;
}

.card>.img-container {
  height: 80%;
  overflow: hidden;
  text-align: center;
}

.card>.img-container>img {
  width: 80%
}

.card>.content {
  padding-left: 1rem;
  padding-right: 1rem;
  font-size: 15px;
  background: #6CADDC;
}

.card>.img-content>ul {
  list-style-type: none;
}

.animate {
  animation: shake 0.5s;
}

@media only screen and (max-width: 600px) {
  .card:hover {
    height: 300px;
    width: 250px;
    box-shadow: 0 3px 6px #999, 0 3px 6px #999;
  }
}

```

Create a file: */src/characters.json
```sh
[
    {
        "id": 1,
        "clicked" : false,
        "name": "Angelina Jolie Voight",
        "image": "http://beauty-around.com/images/sampledata/Hollywood_Actress/1Anjelina-Jolie.jpg",
        "occupation": "Actress, Director"
      },
      {
        "id": 2,
        "clicked" : false,
        "name": "Charlize Theron",
        "image": "http://beauty-around.com/images/sampledata/Hollywood_Actress/2sharliz.jpg",
        "occupation": "Model, Actress"
      },
      {
        "id": 3,
        "clicked" : false,
        "name": "Jessica Alba",
        "image": "http://beauty-around.com/images/sampledata/Hollywood_Actress/3Alba.jpg",
        "occupation": "Model, Actress"
      },
      {
        "id": 4,
        "clicked" : false,
        "name": "Megan Denise Fox",
        "image": "http://beauty-around.com/images/sampledata/Hollywood_Actress/4Megan_Fox.jpg",
        "occupation": "Model, Actress"
      },
      {
        "id": 5,
        "clicked" : false,
        "name": "Keira Knightley",
        "image": "http://beauty-around.com/images/sampledata/Hollywood_Actress/6Keira_Knightley.jpg",
        "occupation": "Actress"
      },
      {
        "id": 6,
        "clicked" : false,
        "name": "Nina Dobrev",
        "image": "http://beauty-around.com/images/sampledata/Hollywood_Actress/8nina_Dobrev.jpg",
        "occupation": "Actress"
      },
      {
        "id": 7,
        "clicked" : false,
        "name": "Maria Bellucci",
        "image": "http://beauty-around.com/images/sampledata/Hollywood_Actress/9Monica.jpg",
        "occupation": "Model, Actress"
      },
      {
        "id": 8,
        "clicked" : false,
        "name": "Justin Bieber",
        "image": "https://www.justinbiebermusic.com/sites/g/files/aaj9851/f/styles/suzuki_breakpoints_image_mobile-lg_sq/public/release/201911/54cf62caa0575670d3cc5a7cf7183aa77e471681.jpg",
        "occupation": "Singer"
      },
      {
        "id": 9,
        "clicked" : false,
        "name": "Daddy Yankee",
        "image": "https://media1.fdncms.com/orlando/imager/u/original/2514354/gal_sel_daddy-yankee-2016.jpg",
        "occupation": "Singer"
      },
      {
        "id": 10,
        "clicked" : false,
        "name": "Sean Paul",
        "image": "https://www.thepeninsulaqatar.com/uploads/2018/09/20/post_main_cover_fit//1b21da4888de17e14120771c191d5373a06fe9c1.jpg",
        "occupation": "Singer"
      },
      {
        "id": 11,
        "clicked" : false,
        "name": "Deadpool",
        "image": "https://vignette.wikia.nocookie.net/marvelmovies/images/6/66/Deadpool_promo.png/revision/latest?cb=20150707202600",
        "occupation": "Hero"
      },
      {
        "id": 12,
        "clicked" : false,
        "name": "Sofia Vergara",
        "image": "https://i.dailymail.co.uk/i/newpix/2018/09/18/20/5017C57300000578-6182201-image-a-100_1537300563965.jpg",
        "occupation": "Actress"
      }
 ]
```

```sh
npm start
```
If you receive a warning Something is already running on Port 3000, Would you like to run the app on another port instead?
Type YES (Y/no) to launch my-app in the browser on another port instead [localhost:3001](http://localhost:3001/)

When you’re ready to deploy to production, running ```npm run build``` will create an optimized build of your app in the ```build``` folder.
 
## Lab 3 - MEMORY GAME
* Review ```<image: "/path"> <name: "celebrity name">``` in */src/characters.json 
* Replace image sources and names with your own interest
* Change Title, Description and Style the App */src/App.css

[Next: Tic Tac Toe](04-TicTacToe.md)
