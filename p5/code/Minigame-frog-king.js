
var player, playersize, playerspeed;
var enemies, enemyspeed;
var bullets, bulletsize, bulletspeed;

var enemysize;
var playerdmg;
var espacing;

var score;
var gameOver;



function setup(){
  enemysize = 60;
  enemyspeed = 0.5;
  bulletsize = 10;
  bulletspeed = 5;
  playerdmg = 1;
  gameOver = false;
  score = 0;
  playersize = 60;
  playerspeed = 10;
  espacing = 10;

  textSize(40);
  defineCanvas();

  enemies = new Group();
  bullets = new Group();
  player = createSprite(width/2, height-playersize, playersize, playersize);
  player.setCollider("rectangle",0,0,playersize,playersize);
  spawnEnemies();




}

function draw(){
  if(!gameOver){
    background(51);
    fill(255);

    drawSprites();
    text(score, width-100, 50);
    playerMove();
    enemyMove();

    enemyspeed = 0.5+0.005*score;

    //collision
    if(player.overlap(enemies)){
      gameOver = true
    }
    bullets.overlap(enemies, enemyHit);

    //cleanup
    for (var i = 0; i < bullets.length; i++) {
      if(bullets[i].position.y < 0){
        bullets[i].remove();
      }
    }
    //restart
    if(enemies.length == 0){
      spawnEnemies();
    }
  }
}//end function draw()

function keyPressed(){

  if(key == ' '){

    bullet = createSprite(player.position.x, player.position.y, bulletsize, bulletsize);
    bullet.velocity.y = -bulletspeed;
    bullet.setCollider("circle",0,0,bulletsize);
    bullets.add(bullet);
    gameOver = false;
  }

}//end keypressed

function keyReleased(){

}//end key released,jhgljhgkhjnöyrg.,vjhtfsdj,.kfdk.jgv nkhgj


function defineCanvas(){
  canvas = createCanvas(600, 600);
  canvas.position(windowWidth/2-300, windowHeight/2-300)
  canvas.style('outline', '1px');
  canvas.style('outline-color', '#fff');
  canvas.style('outline-style', 'solid');
}

function playerMove(){

  if(keyIsDown(LEFT_ARROW) && player.position.x > (playersize/2) ){
    player.velocity.x = -playerspeed;

  } else if(keyIsDown(RIGHT_ARROW) && player.position.x < (width-(playersize/2)) ){
    player.velocity.x = playerspeed;
  } else {
    player.velocity.x = 0;

  }

}
function enemyMove(){
  for (var i = 0; i < enemies.length; i++) {
    if(enemies[i].position.x > width-enemysize/2){
      for (var j = 0; j < enemies.length; j++) {
        enemies[j].position.y += (enemysize + espacing);
        enemies[j].position.x -= 10;
        enemies[j].velocity.x = -enemyspeed;
      }
    }
    if(enemies[i].position.x < enemysize/2){
      for (var j = 0; j < enemies.length; j++) {
        enemies[j].position.y += (enemysize + espacing);
        enemies[j].position.x += 10;
        enemies[j].velocity.x = enemyspeed;
      }
    }
  }
}

function spawnEnemies(){
  for (var i = 0; i < 4; i++) {
    for (var j = 0; j < 7; j++) {
      enemy = createSprite((j*(enemysize+espacing)+enemysize/2 +espacing) , i*(enemysize+espacing)+(enemysize/2 +espacing) , enemysize, enemysize)
      enemy.velocity.x = enemyspeed;
      enemies.add(enemy)

    }
  }
}
function enemyHit(enemy, bullet) {
  bullet.remove();
  enemy.remove();
  score++;
}
