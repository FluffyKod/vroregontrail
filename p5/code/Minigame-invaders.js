
var i_player, i_playersize, i_playerspeed;
var i_enemies, i_enemyspeed;
var bullets, bulletsize, bulletspeed;
let i_ground;

var i_enemysize;
var playerdmg;
var espacing;
let sheep = false;
let wasp = false;
let waveAmount;

var i_score;
var gameOver = true;
var startSc = true;
let bulletAmount;
let has_crossbow;

function i_preload(){
  sheep_img = loadImage(spriteImgSrc + 'sheep.png');
  wasp_img = loadImage(spriteImgSrc + 'wasp.png');
  bow_idle = loadImage(spriteImgSrc + 'bow_loaded.png');
  bow_shoot = loadImage(spriteImgSrc + 'bow_shot.png');
  bow_reload = loadImage(spriteImgSrc + 'bow_reload.png');
}

function i_defineVar(){
  has_crossbow = false;
  for (var i = 0; i < player.inventory.length; i++) {
    if(player.inventory[i] == 'Crossbow'){
      has_crossbow = true;
    }
  }

  i_enemysize = 60;
  i_enemyspeed = 0.15;
  bulletsize = 10;
  bulletspeed = 5;
  playerdmg = 1;
  gameOver = true;
  i_score = 0;
  i_playersize = 60;
  i_playerspeed = 10;
  espacing = 10;
  waveAmount = 4
  camera.position.x = width/2;
  camera.position.y = height/2;

  let weapon_reload_animation
  if(has_crossbow){
    weapon_reload_animation = loadAnimation(crossbow_shoot, crossbow_reload1, crossbow_reload2, crossbow_idle);
    weapon_reload_animation.looping = false;
    bulletAmount = 2
  }else{
    weapon_reload_animation = loadAnimation(bow_shoot, bow_reload, bow_idle)
    weapon_reload_animation.looping = false;

    bulletAmount = 1
  }


  i_enemies = new Group();
  bullets = new Group();
  i_player = createSprite(width/2, height-i_playersize, i_playersize, i_playersize);
  i_player.addAnimation('shoot', weapon_reload_animation)

  i_player.setCollider("rectangle",0,0,i_playersize,i_playersize);
  i_ground = createSprite(width/2, height+50, width, 100)

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
      if(sheep){
        i_enemy.addImage(sheep_img);
      }else if(wasp){
        i_enemy.addImage(wasp_img)
      }
      i_enemy.velocity.x = i_enemyspeed;
      i_enemies.add(i_enemy)

    }
  }
  i_score++;
}
function enemyHit(i_enemy, bullet) {
  bullet.remove();
  i_enemy.remove();
}

function invadersDraw(){
  background(51);
  fill(255);

  drawSprites();

  noStroke()
  //fill(51)
  //rect(0,0, 300, 80)
  fill(255)
  textFont(pixel_font, 40)
  let scoretext = waveAmount-i_score
  text("Herds left: " + scoretext, 12, 50);

  i_playerMove();
  enemyMove();

  if(i_player.animation.getFrame()!=i_player.animation.getLastFrame() && frameCount % 12 == 0)
    i_player.animation.nextFrame();
  if(keyWentDown(' ') && bullets.length < bulletAmount){
    i_player.animation.changeFrame(0)
    bullet = createSprite(i_player.position.x, i_player.position.y, 12, 38);
    bullet.addImage(crossbow_arrow)
    bullet.velocity.y = -bulletspeed;
    bullet.setCollider("circle",0,0,bulletsize);
    bullets.add(bullet);
    gameOver = false;
  }

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
    if(i_score < waveAmount ){
      i_enemyspeed += 0.2
      spawnEnemies();
    }else{
      win = true;
    }
  }
}

function newGame(){
  bullets.removeSprites();
  i_enemies.removeSprites();
  gameOver = false;
  spawnEnemies();
  i_score = 0;
}


/*
function setup(){
  i_enemysize = 60;
  i_enemyspeed = 0.5;
  bulletsize = 10;
  bulletspeed = 5;
  playerdmg = 1;
  gameOver = true;
  i_score = 0;
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
