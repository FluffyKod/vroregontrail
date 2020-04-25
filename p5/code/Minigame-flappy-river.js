var bird;
var birdv;
var swimv;
var streamforce = 0.75;
var logs, rocks;
var logv, rockv;
var gameOver = true;
var startSc = true;
var score;
var fr_hard = false;
var win = false;

function fr_preload(){
  let imgSrc = document.getElementById('game-asset-folder').innerText + 'Sprites/Png/';
  //let imgSrc = "../../game-assets/Sprites/Png/"
  img_riverplayer_falling = loadImage(imgSrc + 'riverplayer-falling.png');
  img_riverplayer_swim = loadImage(imgSrc + 'riverplayer-swim.png');
  img_riverplayer_up = loadImage(imgSrc + 'riverplayer-up.png');
}


function fr_defineVar(){
  if(fr_hard){
    swimv = -21
    streamforce = 2.5
  }else{
    streamforce = 0.75
    swimv = -11
  }
  shore = createSprite(8000, height/2, width, height+200 );
  logv = -3
  rockv = 10
  score = 0;
  win = false;
  bird = createSprite(width/2,height/2, 50, 50);
  var myAnimation = bird.addAnimation('idle',img_riverplayer_falling)
  bird.addAnimation('swim', img_riverplayer_falling, img_riverplayer_swim, img_riverplayer_up)



  bird.shapeColor = color(255);
  //bird.rotateToDirection = true;
  bird.velocity.x = 3
  bird.setCollider('circle', 0, 0, 25)

  logs = new Group();

  camera.position.y = height/2;
  camera.position.x = width/2;

}

function fr_draw(){
    if(startSc){
      startScreen("Flappy River")

    }
    if(!gameOver && !win){
      flappyDraw();
   }
   if(!startSc && gameOver && !win){
     camera.position.x = width/2;
     camera.position.y = height/2;
     gameOverScreen();
     if(clearVar){fr_deleteVar();}
   }
   if(win && !gameOver){
     camera.position.x = width/2;
     camera.position.y = height/2;
     winScreen();
   }
}

function fr_deleteVar(){
  bird.remove();
  logs.removeSprites();
//  shore.remove();

}

/*
function setup(){

} // setup()

function draw(){

}// function draw()
*/

function newGame() {
  logs.removeSprites();
  rocks.removeSprites();
  gameOver = false;
  updateSprites(true);
  bird.position.x = width/2;
  bird.position.y = height/2;
  bird.velocity.y = 0;


}

function flappyDraw(){
  print(bird.position.x)
  background(51);
  drawSprites();

  if(keyWentDown(UP_ARROW)){
    bird.changeAnimation('swim')
    bird.velocity.y = swimv;
  }else {bird.changeAnimation('idle');}
  bird.velocity.y += streamforce

  if(bird.overlap(logs) || bird.position.y > height+30 || (bird.position.y < -200)){
    gameOver = true;
  }
  if(bird.overlap(shore)){
    win = true;
  }

  if(frameCount%120 == 0 && (bird.position.x +2*width < shore.position.x)){
    Logt = createSprite(bird.position.x + width, random(-200,200), 100, 400)
    Logt.setCollider('rectangle',0,0,100,400);
    Logb = createSprite(Logt.position.x, Logt.position.y + 600, 100, 400)
    Logb.setCollider('rectangle',0,0,100,400);
    logs.add(Logt)
    logs.add(Logb)

  }
  for (var i = 0; i < logs.length; i++) {
    if(logs[i].position.x < bird.position.x-width/2){
      logs[i].remove();
    }
  }
  camera.position.x = bird.position.x + width/4
}
