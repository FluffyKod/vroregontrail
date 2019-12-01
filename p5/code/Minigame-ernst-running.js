var er_player, er_playersize, er_playerv, jumpv;
var er_gravity;
var er_spawnrate;
var score;
var er_ground;
var jump, slide;


var gameOver = true;
var startSc = true;



function er_draw(){
  if(startSc){startScreen("Ernst Running"); }
  if(!gameOver){drawErnstRunning();}
  if(!startSc && gameOver){
    camera.position.x = width/2;
    camera.position.y = height/2;
    gameOverScreen();
    if(clearVar){er_deleteVar();}
  }
  if(win){
    
  }
}

/*
function setup(){
  defineCanvas();
  defineVar();



} // setup()

function draw(){
  if(startSc){startScreen("Ernst Running");}
  if(!gameOver){drawErnstRunning();}
  if(!startSc && gameOver){
    camera.position.x = width/2;
    camera.position.y = height/2;
    gameOverScreen();
  }
}// function draw()
*/


function newGame() {
  birds.removeSprites();
  er_rocks.removeSprites();
  gameOver = false;
  er_player.position.x = width/2;
  er_player.position.y = height/2;
  er_player.velocity.y = 0;
  jump = false;
  slide = false;
  score = 0;


}

function er_deleteVar(){
  er_player.remove();
  er_ground.remove();
  birds.removeSprites();
  er_rocks.removeSprites();
  frameCount = 0;


}


function er_defineVar(){
  score = 0;
  er_spawnrate = 40
  er_playersize = 50;
  er_playerv = 8;
  jumpv = 15;
  er_gravity = 1;
  er_player = createSprite(width/2,height/2, er_playersize, er_playersize);
  er_player.shapeColor = color(255);
  er_player.velocity.x = er_playerv + 0.01*score;
  er_player.setCollider('rectangle', 0, 0, er_playersize, er_playersize)
  er_ground = createSprite(width/2,3*height/4+er_playersize/2,width,height/2);
  birds = new Group();
  er_rocks = new Group();

  jump = false;
  slide = false;

  er_player.position.x = width/2;
  er_player.position.y = height/2;
  camera.position.y = height/2;
  camera.position.x = width/2
  er_ground.position.x = camera.position.x
}



function drawErnstRunning(){
  background(51);
  drawSprites();



    textSize(40);
    fill(255);
    text(20*floor(score)+'m', er_player.position.x+ width/2 -100, 100);
    score += 0.1;
    er_player.debug = true;
    er_player.velocity.x = er_playerv + 0.01*score;

    if(score >= 500){
      win = true;
    }
    if(keyIsDown(DOWN_ARROW)){
      //er_player = createSprite(width/2,height/2, er_playersize, er_playersize/2);
      slide = true;
      er_player.setCollider('rectangle', 0, er_playersize/4, er_playersize, er_playersize/2)
    }else if(keyWentUp(DOWN_ARROW)){
      er_player.setCollider('rectangle', 0, 0, er_playersize, er_playersize)
      slide = false;
    }

    if(er_player.position.y < height/2 ) {
      er_player.velocity.y += er_gravity
    } else {
      er_player.velocity.y = 0;
      er_player.position.y = height/2
      jump = false;
    }
    if(keyWentDown(UP_ARROW) && !jump && !slide){
      er_player.velocity.y = -jumpv;
      jump = true;
    }

    if(er_player.overlap(er_rocks) || er_player.overlap(birds)){
      gameOver = true;
    }


    if(frameCount%er_spawnrate == 0){
      rint = floor(random(0,2));

      if(rint == 0){
      rock = createSprite(er_player.position.x + width+random(0,120), height/2, er_playersize, er_playersize);
      rock.setCollider('rectangle',0,0,er_playersize,er_playersize);
      er_rocks.add(rock);
      }else if(rint == 1){
      bird = createSprite(er_player.position.x + width+ random(0,120), height/2- er_playersize/2-10, er_playersize, er_playersize);
      birds.add(bird);

      }

    //  er_spawnrate += floor(random(30,60));

    }

    for (var i = 0; i < er_rocks.length; i++) {
      if(er_rocks[i].position.x < er_player.position.x-width/2){
        er_rocks[i].remove();
      }
    }
    for (var i = 0; i < birds.length; i++) {
      if(birds[i].position.x < er_player.position.x-width/2){
        birds[i].remove();
      }
    }
    camera.position.y = height/3
    camera.position.x = er_player.position.x+width/3
    er_ground.position.x = camera.position.x

}
