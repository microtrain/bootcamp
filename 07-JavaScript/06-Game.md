# Game

The purpose of this section is to cover basic concepts for build a game using HTML5.

1. Creating a canvas.
1. Drawing a player sprite.
1. Controlling a player's movements.
1. Spawning and moving enemies.
1. Collision detection.
1. Scoring and ending the game.


```sh
cd /var/www
git clone https://github.com/microtrain/html-starter.git game
cd game
rm -fR .git
```

Create a repository called game and add the remote to your local project. Replace XXX with your GitHub username.
```sh
git init
git add .
git commit -am 'Initial Commit'
git remote add origin git@github.com:XXX/game.git
git push origin master
```

Run npm install and start a Gulp watcher.
```sh
npm install
gulp
```

[</> code]() Add a canvas with a black background.

Open *index.html* and update the title to read *HTML5 Game*

*index.html*
```html
<title>HTML5 Game</title>
```

Replace ```<h1>HTML Starter</h1>``` with a *canvas* tag that has and id of *canvas* 
*index.html*
```html
<canvas id="canvas"></canvas>
```

Open *src/scss/main.scss* and apply a black background to the canvas. 

*src/scss/main.scss*
```scss
canvas {
  background: #222;
}
```

```sh
# Add a canvas with a black background.
git add .
git commit -a
git push origin master
```


[</> code]() Load a closure into a game variable.

Our JavaScript will start with an empty closure.

*src/js/main.js*
```js
var game = (function(){})();
```

[</> code]() Initialize the game and set the canvas to 600x800

Load a canvas and a content, then initialize the object.

*src/js/main.js*
```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  return {
    init: function(){
      canvas.height = 600;
      canvas.width = 800;
    }
  }
})();

game.init();
```

[</> code]() Create a player object and draw that player to the screen.

1. Create a player object
1. Draw the player object to the canvas

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  //1. Create the player object
  // Define all argument that will be used by fillRect()
  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff'
  }

  return {

    //2. Draw the player to the canvas
    player: function(){
      ctx.fillStyle=player.fill;
      ctx.fillRect(player.x, player.y, player.w, player.h);
    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      this.player();
    }
  }
})();

game.init();
```

[</> code]() Animate the game using animation frames.

1. Define how many pixels the player should move each frame (i.e. speed).
1. Create an animation frame.
1. Redraw the player every time a frame is executed.

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff'
  }

  return {

    player: function(){
      ctx.fillStyle=player.fill;

      //1. Define how many pixels the player
      // should move each frame (i.e. speed)
      ctx.clearRect(
        player.x-1,
        player.y-1,
        player.w+2,
        player.h+2
      );

      ctx.fillRect(
        player.x++,
        player.y,
        player.w,
        player.h
      );

    },

    //2. Create an animation frame
    //3. Redraw the player every time a frame is executed
    animate: function(){
      this.player();
      window.requestAnimationFrame(this.animate.bind(this));
    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      this.animate();
    }
  }
})();

game.init();
```

[</> code]() Touching the edge of the canvas changes the player's direction

1. Add a default direction for player movement.
1. Add x pixels to move the player to the right
1. Change the player direction when the player touches the edge of the canvas.
1. Subtract x pixels to move the player to the left.
1. Change the player direction when the player touches the edge of the canvas.

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff',
    //1. Add a default direction for player movement.
    dir: 'right'
  }

  return {

    player: function(){
      ctx.fillStyle=player.fill;

      ctx.clearRect(
        player.x-1,
        player.y-1,
        player.w+2,
        player.h+2
      );

      //2. Add x pixels to move the player to the right
      if(player.dir === 'right'){
        ctx.fillRect(
          player.x++,
          player.y,
          player.w,
          player.h
        );

        //3. Change the player direction when the player touches the edge 
        //of the canvas.
        if((player.x + player.w) >= canvas.width){
          player.dir = 'left';
        }

      }else{

        //4. Subtract x pixels to move the player to the left
        ctx.fillRect(
          player.x--,
          player.y,
          player.w,
          player.h
        );

        //5. Change the player direction when the player touches the edge 
        //of the canvas.
        if(player.x <= 0){
          player.dir = 'right';
        }
      }
    },

    animate: function(){
      this.player();
      window.requestAnimationFrame(this.animate.bind(this));
    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      this.animate();
    }
  }
})();

game.init();
```

[</> code]() Pressing any key shall change the direction in which the player is moving

1. Create a setter for changing the current direction of the user.
1. Add a listener to allow the  user to change the direction of the player sprite

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff',
    dir: 'right'
  }

  return {

    player: function(){
      ctx.fillStyle=player.fill;

      ctx.clearRect(
        player.x-1,
        player.y-1,
        player.w+2,
        player.h+2
      );

      if(player.dir === 'right'){
        ctx.fillRect(
          player.x++,
          player.y,
          player.w,
          player.h
        );

        if((player.x + player.w) >= canvas.width){
          player.dir = 'left';
        }

      }else{
        ctx.fillRect(
          player.x--,
          player.y,
          player.w,
          player.h
        );

        if(player.x <= 0){
          player.dir = 'right';
        }
      }
    },

    //1. Create a setter for changing the current direction of the user.
    changeDirection: function(){
      if(player.dir === 'left'){
        player.dir = 'right';
      }else if(player.dir === 'right'){
        player.dir = 'left';
      }
    },

    animate: function(){
      this.player();
      window.requestAnimationFrame(this.animate.bind(this));
    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      this.animate();
    }
  }
})();

game.init();

//2. Add a listener to allow the  user to change the direction
//of the player sprite
window.addEventListener('keyup', function(){
  game.changeDirection();
});
```

[</> code]() Increase the speed of the player

1. Add a speed property to the player this is the number of pixels the player will move each frame.
1. Change x-1 to player.x-player.speed.
1. Change player.x++ to player.x = (player.x + player.speed).
1. Change player.x+1 to player.x+player.speed.
1. Change player.x-- to player.x = (player.x - player.speed),

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff',
    dir: 'right',
    //1. Add a speed property to the player this is the number of pixels 
    //the player will move each frame
    speed: 5
  }

  return {

    player: function(){
      ctx.fillStyle=player.fill;

      if(player.dir === 'right'){

        //2. Change x-1 to player.x-player.speed
        ctx.clearRect(
          player.x-player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        //3. Change player.x++ to player.x = (player.x + player.speed)
        ctx.fillRect(
          player.x = (player.x + player.speed),
          player.y,
          player.w,
          player.h
        );

        if((player.x + player.w) >= canvas.width){
          player.dir = 'left';
        }

      }else{

        //4. Change player.x+1 to player.x+player.speed
        ctx.clearRect(
          player.x+player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        //5. Change player.x-- to player.x = (player.x - player.speed),
        ctx.fillRect(
          player.x = (player.x - player.speed),
          player.y,
          player.w,
          player.h
        );

        if(player.x <= 0){
          player.dir = 'right';
        }
      }
    },

    changeDirection: function(){
      if(player.dir === 'left'){
        player.dir = 'right';
      }else if(player.dir === 'right'){
        player.dir = 'left';
      }
    },

    animate: function(){
      this.player();
      window.requestAnimationFrame(this.animate.bind(this));
    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      this.animate();
    }
  }
})();

game.init();

window.addEventListener('keyup', function(){
  game.changeDirection();
});
```

[</> code]() Launch an enemy spawn down the Y axis

1. Define an enemy spawn.
1. Create a method for launching spawns. 
  * This iteration will launch a single spawn.
1. Animate the spawns.

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff',
    dir: 'right',
    speed: 5
  }

  //1. Define an enemy spawn
  var spawn = {
    x: 50,
    y: 0,
    h: 10,
    w: 10,
    fill: '#ff0',
    speed: 5
  }

  //2. Create a method for launching spawns
  // this iteration will launch a single spawn
  function launchSpawns(){
    ctx.fillStyle=spawn.fill;

    ctx.clearRect(
      spawn.x-1,
      spawn.y-spawn.speed,
      spawn.w+2,
      spawn.h+2
    );

    ctx.fillRect(
      spawn.x,
      spawn.y = (spawn.y + spawn.speed),
      spawn.w,
      spawn.h
    );
  }

  return {

    player: function(){
      ctx.fillStyle=player.fill;

      if(player.dir === 'right'){

        ctx.clearRect(
          player.x-player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        ctx.fillRect(
          player.x = (player.x + player.speed),
          player.y,
          player.w,
          player.h
        );

        if((player.x + player.w) >= canvas.width){
          player.dir = 'left';
        }

      }else{

        ctx.clearRect(
          player.x+player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        ctx.fillRect(
          player.x = (player.x - player.speed),
          player.y,
          player.w,
          player.h
        );

        if(player.x <= 0){
          player.dir = 'right';
        }
      }
    },

    changeDirection: function(){
      if(player.dir === 'left'){
        player.dir = 'right';
      }else if(player.dir === 'right'){
        player.dir = 'left';
      }
    },

    animate: function(){
      this.player();
      //3. Animate the spawns
      launchSpawns();
      window.requestAnimationFrame(this.animate.bind(this));
    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      this.animate();
    }
  }
})();

game.init();

window.addEventListener('keyup', function(){
  game.changeDirection();
});

```

[</> code]() Launch a new spawn every 400ms and move all spawns in a loop

1. Initialize an Object of spawns.
1. Initialize a variable for launching spawns.
1. Create a new enemy spawn every 400 ms.
1. Use psuedo-random strings to name the new spawns.
1. Add the new spawn to the Object of spawns.
1. Move all spawns.
  1. Loop through the Object of spawns and move each one individually.
    * This will look a lot like movePlayer()
  1. Only move the spawn, if the spawn has not moved off of the screen.
  1. Delete the spawn from the Object of spawns if that spawn has moved off of the screen.
1. Add ```moveSpawns()``` to the animation frame.

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff',
    dir: 'right',
    speed: 5
  }

  var spawn = {
    x: 50,
    y: 0,
    h: 10,
    w: 10,
    fill: '#ff0',
    speed: 5
  }

  //1. Initialize an Object of spawns
  var spawns = {}

  //2. Initialize a variable for launching spawns.
  var spawner = null;


  function launchSpawns(){
    //3. Create a new enemy spawn every 400 ms
    spawner = setInterval(()=>{
      //4. Use psuedo-random strings to name the new spawns
      var text = "";
      var possible = "abcdefghijklmnopqrstuvwxyz";

      for (var i = 0; i < 10; i++){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
      }

      //5. Add the new spawn to the Object of Spawns
      spawns[text] = {
        x:Math.floor(Math.random()*this.canvas.width),
        y:spawn.y,
        h:spawn.h,
        w:spawn.w,
        fill:spawn.fill,
        speed:spawn.speed,
      }

    },400);
  }

  //6. Move all spawns
  function moveSpawns(){

    //7. Loop through the Object of spawns
    //and move each one individually.
    //This will look a lot like movePlayer()
    if(Object.keys(spawns).length>0){
      for(let spawn in spawns){

        //8. Only move the spawn, if the spawn has not 
        //moved off of the screen.
        if(spawns[spawn].y<=canvas.height){

          ctx.fillStyle = spawns[spawn].fill;

          ctx.save();

          ctx.clearRect(
            spawns[spawn].x-1,
            spawns[spawn].y-spawns[spawn].speed,
            spawns[spawn].w+2,
            spawns[spawn].h+2
          );

          ctx.fillRect(
            spawns[spawn].x,
            spawns[spawn].y = (spawns[spawn].y+spawns[spawn].speed),
            spawns[spawn].w,
            spawns[spawn].h
          );

          ctx.restore();
          

        }else{
          //9. Delete the spawn from the Object of spawns if 
          // that spawn has moved off of the screen.
          delete spawns[spawn];
        }
      }
    }

  }

  return {

    player: function(){
      ctx.fillStyle=player.fill;

      if(player.dir === 'right'){

        ctx.clearRect(
          player.x-player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        ctx.fillRect(
          player.x = (player.x + player.speed),
          player.y,
          player.w,
          player.h
        );

        if((player.x + player.w) >= canvas.width){
          player.dir = 'left';
        }

      }else{

        ctx.clearRect(
          player.x+player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        ctx.fillRect(
          player.x = (player.x - player.speed),
          player.y,
          player.w,
          player.h
        );

        if(player.x <= 0){
          player.dir = 'right';
        }
      }
    },

    changeDirection: function(){
      if(player.dir === 'left'){
        player.dir = 'right';
      }else if(player.dir === 'right'){
        player.dir = 'left';
      }
    },

    animate: function(){
      this.player();
      //10. Add moveSpawns to the animation frame.
      moveSpawns();
      window.requestAnimationFrame(this.animate.bind(this));
    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      launchSpawns();
      this.animate();
    }
  }
})();

game.init();

window.addEventListener('keyup', function(){
  game.changeDirection();
});

```

[</> code]() Add collision detection and end game on collision

1. Add the animation frames to a variable the we can kill later
2. Track the state of game over
3. When each spawn move detect if that spawn shares common pixels with the player. 
   1. If so this is a collision.
4. If there is a collision.
   1. Set ```gameOver``` to true.
   2. Kill the animation frames.
   3. Kill the spawner.
5. Only animate if the game is not over.

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff',
    dir: 'right',
    speed: 5
  }

  var spawn = {
    x: 50,
    y: 0,
    h: 10,
    w: 10,
    fill: '#ff0',
    speed: 5
  }

  var spawns = {}

  var spawner = null;

  //1. Add the animation frames to a variable
  //the we can kill later
  var animation  = null;

  //2. Track the state of game over
  var gameOver = false;


  function launchSpawns(){
    spawner = setInterval(()=>{

      var text = "";
      var possible = "abcdefghijklmnopqrstuvwxyz";

      for (var i = 0; i < 10; i++){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
      }

      spawns[text] = {
        x:Math.floor(Math.random()*this.canvas.width),
        y:spawn.y,
        h:spawn.h,
        w:spawn.w,
        fill:spawn.fill,
        speed:Math.floor(Math.random() * 7),
      }

    },400);
  }



  return {
    moveSpawns: function(){

      if(Object.keys(spawns).length>0){
        for(let spawn in spawns){

          if(spawns[spawn].y<=canvas.height){


            ctx.fillStyle = spawns[spawn].fill;


            ctx.save();

            ctx.clearRect(
              spawns[spawn].x-1,
              spawns[spawn].y-spawns[spawn].speed,
              spawns[spawn].w+2,
              spawns[spawn].h+2
            );

            ctx.fillRect(
              spawns[spawn].x,
              spawns[spawn].y = (spawns[spawn].y+spawns[spawn].speed),
              spawns[spawn].w,
              spawns[spawn].h
            );

            ctx.restore();

            //3. When each spawn move detect if that spawn shares common pixels
            //with the player. If so this is a collision.
            //@see https://developer.mozilla.org/en-US/docs/Games/Techniques/2D_collision_detection
            if (
              player.x < spawns[spawn].x + spawns[spawn].w &&
              spawns[spawn].x > player.x && spawns[spawn].x < (player.x + player.w) &&
              player.y < spawns[spawn].y + spawns[spawn].h &&
              player.y + player.h > spawns[spawn].y
            ){
              //4. If there is a collision set gameOver to true
              gameOver = true;
              //5. ...kill the animation frames
              cancelAnimationFrame(animation);
              //6. ...kill the spawner
              clearInterval(spawner);
            }

          }else{
            delete spawns[spawn];
          }
        }
      }

    },

    player: function(){
      ctx.fillStyle=player.fill;

      if(player.dir === 'right'){

        ctx.clearRect(
          player.x-player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        ctx.fillRect(
          player.x = (player.x + player.speed),
          player.y,
          player.w,
          player.h
        );

        if((player.x + player.w) >= canvas.width){
          player.dir = 'left';
        }

      }else{

        ctx.clearRect(
          player.x+player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        ctx.fillRect(
          player.x = (player.x - player.speed),
          player.y,
          player.w,
          player.h
        );

        if(player.x <= 0){
          player.dir = 'right';
        }
      }
    },

    changeDirection: function(){
      if(player.dir === 'left'){
        player.dir = 'right';
      }else if(player.dir === 'right'){
        player.dir = 'left';
      }
    },

    animate: function(){
      this.player();
      this.moveSpawns();
      //7. Only animate if the game is not over.
      if(gameOver===false){
        animation = window.requestAnimationFrame(this.animate.bind(this));
      }

    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      launchSpawns();
      this.animate();
    }
  }
})();

game.init();

window.addEventListener('keyup', function(){
  game.changeDirection();
});
```

[</> code]() Add a scoring mechanism

1. Create a variable to hold the score.
1. Increment the score when any time an enemy sprite move off screen.
1. Write the score to a separate div.
1. Over lay the score on the top left corner of the canvas.
1. Add a preset score div to the HTML page.

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff',
    dir: 'right',
    speed: 5
  }

  var spawn = {
    x: 50,
    y: 0,
    h: 10,
    w: 10,
    fill: '#ff0',
    speed: 5
  }

  var spawns = {}

  var spawner = null;

  var animation  = null;

  var gameOver = false;

  //1. Create a variable to hold the score
  var score = 0;


  function launchSpawns(){
    spawner = setInterval(()=>{

      var text = "";
      var possible = "abcdefghijklmnopqrstuvwxyz";

      for (var i = 0; i < 10; i++){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
      }

      spawns[text] = {
        x:Math.floor(Math.random()*this.canvas.width),
        y:spawn.y,
        h:spawn.h,
        w:spawn.w,
        fill:spawn.fill,
        speed:5,
      }

    },400);
  }



  return {
    moveSpawns: function(){

      if(Object.keys(spawns).length>0){
        for(let spawn in spawns){

          if(spawns[spawn].y<=canvas.height){


            ctx.fillStyle = spawns[spawn].fill;


            ctx.save();

            ctx.clearRect(
              spawns[spawn].x-1,
              spawns[spawn].y-spawns[spawn].speed,
              spawns[spawn].w+2,
              spawns[spawn].h+2
            );

            ctx.fillRect(
              spawns[spawn].x,
              spawns[spawn].y = (spawns[spawn].y+spawns[spawn].speed),
              spawns[spawn].w,
              spawns[spawn].h
            );

            ctx.restore();

            if (
              player.x < spawns[spawn].x + spawns[spawn].w &&
              spawns[spawn].x > player.x && spawns[spawn].x < (player.x + player.w) &&
              player.y < spawns[spawn].y + spawns[spawn].h &&
              player.y + player.h > spawns[spawn].y
            ){
              gameOver = true;
              cancelAnimationFrame(animation);
              clearInterval(spawner);
            }

          }else{
            //2. Increment the score when any time
            //an enemy sprite move off screen
            score = score + 10;
            //3. Write the score to a separate div
            document.getElementById('score').innerHTML = score;
            delete spawns[spawn];
          }
        }
      }

    },

    player: function(){
      ctx.fillStyle=player.fill;

      if(player.dir === 'right'){

        ctx.clearRect(
          player.x-player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        ctx.fillRect(
          player.x = (player.x + player.speed),
          player.y,
          player.w,
          player.h
        );

        if((player.x + player.w) >= canvas.width){
          player.dir = 'left';
        }

      }else{

        ctx.clearRect(
          player.x+player.speed,
          player.y-1,
          player.w+2,
          player.h+2
        );

        ctx.fillRect(
          player.x = (player.x - player.speed),
          player.y,
          player.w,
          player.h
        );

        if(player.x <= 0){
          player.dir = 'right';
        }
      }
    },

    changeDirection: function(){
      if(player.dir === 'left'){
        player.dir = 'right';
      }else if(player.dir === 'right'){
        player.dir = 'left';
      }
    },

    animate: function(){
      this.player();
      this.moveSpawns();
      if(gameOver===false){
        animation = window.requestAnimationFrame(this.animate.bind(this));
      }

    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      launchSpawns();
      this.animate();
    }
  }
})();

game.init();

window.addEventListener('keyup', function(){
  game.changeDirection();
});
```

```scss
canvas {
  background: #000;
}

/* 4. Over lay the score on the top left corner of the canvas.*/
#score {
  position: absolute;
  top: 20px;
  left: 20px;
  z-index: 100;
  font-weight: bold;
  font-size: 20px;
  color: #fff;
}
```

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>HTML5 Game</title>
    <base href="./">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dist/css/main.css" type="text/css">
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
  </head>
  <body>
    <!-- 5.  Add a preset score div to the HTML page-->
    <div id="score">0</div>
    <canvas id="canvas"></canvas>
    <script src="dist/js/main.js"></script>
  </body>
</html>
```

[</>code]() Refactor

```js
var game = (function(){
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var player = {
    x:0,
    y:475,
    h: 25,
    w: 25,
    fill: '#fff',
    dir: 'right',
    speed: 5
  }

  var spawn = {
    x: 50,
    y: 0,
    h: 10,
    w: 10,
    fill: '#ff0',
    speed: 5
  }

  var spawns = {}

  var spawner = null;

  var animation  = null;

  var gameOver = false;

  var score = 0;


  function launchSpawns(){
    spawner = setInterval(()=>{
      //Use psuedo-random strings to name the new spawns
      var text = "";
      var possible = "abcdefghijklmnopqrstuvwxyz";

      for (var i = 0; i < 10; i++){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
      }

      spawns[text] = {
        x:Math.floor(Math.random()*canvas.width),
        y:spawn.y,
        h:spawn.h,
        w:spawn.w,
        fill:spawn.fill,
        speed:5,
      }

    },400);
  }

  function moveSpawns(){

    if(Object.keys(spawns).length>0){
      for(let spawn in spawns){

        if(spawns[spawn].y<=canvas.height){


          ctx.fillStyle = spawns[spawn].fill;


          ctx.save();

          ctx.clearRect(
            spawns[spawn].x-1,
            spawns[spawn].y-spawns[spawn].speed,
            spawns[spawn].w+2,
            spawns[spawn].h+2
          );

          ctx.fillRect(
            spawns[spawn].x,
            spawns[spawn].y = (spawns[spawn].y+spawns[spawn].speed),
            spawns[spawn].w,
            spawns[spawn].h
          );

          ctx.restore();

          if (
            player.x < spawns[spawn].x + spawns[spawn].w &&
            spawns[spawn].x > player.x && spawns[spawn].x < (player.x + player.w) &&
            player.y < spawns[spawn].y + spawns[spawn].h &&
            player.y + player.h > spawns[spawn].y
          ){
            gameOver = true;
            cancelAnimationFrame(animation);
            clearInterval(spawner);
          }

        }else{
          score = score + 10;
          document.getElementById('score').innerHTML = score;
          delete spawns[spawn];
        }
      }
    }
  }

  function movePlayer(){
    ctx.fillStyle=player.fill;

    if(player.dir === 'right'){

      ctx.clearRect(
        player.x-player.speed,
        player.y-1,
        player.w+2,
        player.h+2
      );

      ctx.fillRect(
        player.x = (player.x + player.speed),
        player.y,
        player.w,
        player.h
      );

      if((player.x + player.w) >= canvas.width){
        player.dir = 'left';
      }

    }else{

      ctx.clearRect(
        player.x+player.speed,
        player.y-1,
        player.w+2,
        player.h+2
      );

      ctx.fillRect(
        player.x = (player.x - player.speed),
        player.y,
        player.w,
        player.h
      );

      if(player.x <= 0){
        player.dir = 'right';
      }
    }
  }

  function animate(){
    movePlayer();
    moveSpawns();
    if(gameOver===false){
      animation = window.requestAnimationFrame(animate.bind(animation));
    }
  }

  return {

    changeDirection: function(){
      if(player.dir === 'left'){
        player.dir = 'right';
      }else if(player.dir === 'right'){
        player.dir = 'left';
      }
    },

    init: function(){
      canvas.height = 600;
      canvas.width = 800;

      launchSpawns();
      animate();
    }
  }
})();

game.init();

window.addEventListener('keyup', function(){
  game.changeDirection();
});
```

[Next: jQuery](07-jQuery.md)


