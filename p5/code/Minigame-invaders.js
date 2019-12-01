
var i_player, i_playersize, i_playerspeed;
var i_enemies, i_enemyspeed;
var bullets, bulletsize, bulletspeed;

var i_enemysize;
var playerdmg;
var espacing;

var score;
var gameOver = true;
var startSc = true;


function i_defineVar(){
  i_enemysize = 60;
  i_enemyspeed = 0.5;
  bulletsize = 10;
  bulletspeed = 5;
  playerdmg = 1;
  gameOver = true;
  score = 0;
  i_playersize = 60;
  i_playerspeed = 10;
  espacing = 10;


  i_enemies = new Group();
  bullets = new Group();
  i_player = createSprite(width/2, height-i_playersize, i_playersize, i_playersize);
  i_player.setCollider("rectangle",0,0,i_playersize,i_playersize);
  spawnEnemies();


}

function i_deleteVar(){
  i_enemies.removeSprites();
  bullets.removeSprites();
  i_player.remove();
}

function i_draw(){
  if(startSc){
    startScreen("Invaders");
  }
  if(!gameOver){
    invadersDraw();
  }
  if(gameOver && !startSc){
    gameOverScreen();
    if(clearVar){i_deleteVar();}
  }
}


function i_playerMove(){

  if(keyIsDown(LEFT_ARROW) && i_player.position.x > (i_playersize/2) ){
    i_player.velocity.x = -i_playerspeed;

  } else if(keyIsDown(RIGHT_ARROW) && i_player.position.x < (width-(i_playersize/2)) ){
    i_player.velocity.x = i_playerspeed;
  } else {
    i_player.velocity.x = 0;

  }

}
function enemyMove(){
  for (var i = 0; i < i_enemies.length; i++) {
    if(i_enemies[i].position.x > width-i_enemysize/2){
      for (var j = 0; j < i_enemies.length; j++) {
        i_enemies[j].position.y += (i_enemysize + espacing);
        i_enemies[j].position.x -= 10;
        i_enemies[j].velocity.x = -i_enemyspeed;
      }
    }
    if(i_enemies[i].position.x < i_enemysize/2){
      for (var j = 0; j < i_enemies.length; j++) {
        i_enemies[j].position.y += (i_enemysize + espacing);
        i_enemies[j].position.x += 10;
        i_enemies[j].velocity.x = i_enemyspeed;
      }
    }
  }
}

function spawnEnemies(){
  for (var i = 0; i < 4; i++) {
    for (var j = 0; j < 7; j++) {
      i_enemy = createSprite((j*(i_enemysize+espacing)+i_enemysize/2 +espacing) , i*(i_enemysize+espacing)+(i_enemysize/2 +espacing) , i_enemysize, i_enemysize)
      i_enemy.velocity.x = i_enemyspeed;
      i_enemies.add(i_enemy)

    }
  }
}
function enemyHit(i_enemy, bullet) {
  bullet.remove();
  i_enemy.remove();
  score++;
}

function invadersDraw(){
  background(51);
  fill(255);

  drawSprites();
  text(score, width-100, 50);
  i_playerMove();
  enemyMove();
  if(keyWentDown(' ') && bullets.length < 1){

    bullet = createSprite(i_player.position.x, i_player.position.y, bulletsize, bulletsize);
    bullet.velocity.y = -bulletspeed;
    bullet.setCollider("circle",0,0,bulletsize);
    bullets.add(bullet);
    gameOver = false;
  }
  i_enemyspeed = 0.5+0.005*score;

  //collision
  if(i_player.overlap(i_enemies)){
    gameOver = true
  }
  bullets.overlap(i_enemies, enemyHit);

  //cleanup
  for (var i = 0; i < bullets.length; i++) {
    if(bullets[i].position.y < 0){
      bullets[i].remove();
    }
  }
  //restart
  if(i_enemies.length == 0){
    spawnEnemies();
  }
}

function newGame(){
  bullets.removeSprites();
  i_enemies.removeSprites();
  gameOver = false;
  spawnEnemies();
  score = 0;
}


/*
function setup(){
  i_enemysize = 60;
  i_enemyspeed = 0.5;
  bulletsize = 10;
  bulletspeed = 5;
  playerdmg = 1;
  gameOver = true;
  score = 0;
  i_playersize = 60;
  i_playerspeed = 10;
  espacing = 10;

  textSize(40);
  defineCanvas();

  i_enemies = new Group();
  bullets = new Group();
  i_player = createSprite(width/2, height-i_playersize, i_playersize, i_playersize);
  i_player.setCollider("rectangle",0,0,i_playersize,i_playersize);
  spawnEnemies();




}

function draw(){
  if(startSc){
    startScreen("Invaders");
  }
  if(!gameOver){
    invadersDraw();
  }
  if(gameOver && !startSc){
    gameOverScreen();
  }
}//end function draw()
*/
