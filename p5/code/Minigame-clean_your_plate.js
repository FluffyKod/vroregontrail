var cyp_player, cyp_playersize, cyp_playerspeed;
var cyp_food = 0;
var foodResistance;
var cyp_mouthCollider;
var pepe, looktimer, pepecolors, pepe_state;
var gameOver;
var startSc;

var cyp_background_img;

function cyp_preload(){
  mouth_open = loadAnimation(
    spriteImgSrc + 'mouth_closed.png',
    spriteImgSrc + 'mouth_open_1.png',
    spriteImgSrc + 'mouth_open_2.png',
    spriteImgSrc + 'mouth_open_3.png'
  )
  mouth_swallow = loadAnimation(
    spriteImgSrc + 'mouth_swallow.png',
    spriteImgSrc + 'mouth_closed.png'
  )
  mouth_swallow.frameDelay = 30

  spoon = loadAnimation(
    spriteImgSrc + 'spoon_full.png',
    spriteImgSrc + 'spoon_empty.png'
  )
}

function cyp_setup(){

  cyp_defineVar();

}

function cyp_draw(){
  if(startSc){
    startScreen("Clean your wooden bowl!");
  }
  if(!gameOver){
    drawPepe();
  }
  if(gameOver && !startSc){
    gameOverScreen();
    if(clearVar){
      cyp_deleteVar();
    }
  }
  if(win && !gameOver){
    camera.position.x = width/2;
    camera.position.y = height/2;
    winScreen();
  }
  if(clearVar){
    cyp_deleteVar();
  }
}

function cyp_defineVar(){

  cyp_food = 15;
  camera.position.x = width/2;
  camera.position.y = height/2;
  gameOver = true;
  startSc = true;
  cyp_playersize = 50;
  cyp_playerwidth = width/2
  cyp_playerspeed = 10;
  foodResistance = 1.2;
  cyp_mouthCollider = createSprite(width/2, height/2, 50,50);
  cyp_mouthCollider.visible = false

  cyp_mouthVisual = createSprite(width/2, height/2, width, height)
  cyp_mouthVisual.addAnimation('open', mouth_open)
  cyp_mouthVisual.addAnimation('swallow', mout_swallow)

  cyp_player = createSprite(-cyp_playerwidth/3, height/2, cyp_playerwidth, cyp_playersize);
  cyp_player.addAnimation('spoon', spoon);
  cyp_player.setCollider('rectangle', 0, 0, cyp_playerwidth, cyp_playersize)
}

function cyp_deleteVar(){
  cyp_mouthCollider.remove();
  cyp_player.remove();
}

function drawPepe(){
  background(51);
  image(cyp_background_img,0,0);
  fill(255);
  drawSprites();
  textFont(pixel_font, 40)
  text("Food left: "+cyp_food, 12, 50);
  if(cyp_food<=0){
    win = true;
  }
  if(cyp_player.position.x > -cyp_playerwidth/3){
    cyp_player.velocity.x += -foodResistance;
  } else { cyp_player.velocity.x = 0; cyp_player.position.x = -cyp_playerwidth/3}
  if(keyWentDown(RIGHT_ARROW)){
    cyp_player.velocity.x = 10;
  }
  cyp_player.animation.changeFrame(0);
  if(cyp_player.overlap(cyp_mouthCollider)){
    cyp_player.animation.changeFrame(1);
    cyp_food-=1
    cyp_player.position.x = -cyp_playerwidth/3;
    foodResistance += 0.1
  }
}

function newGame(){
  cyp_player.position.x = -cyp_playerwidth/3
  cyp_player.position.y = height/2;
  gameOver = false;
  foodResistance = 1.5
  looktimer = floor(random(120, 60*5));
  cyp_food = 0;
}
