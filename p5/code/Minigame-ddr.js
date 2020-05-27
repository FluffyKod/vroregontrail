var docks, spacing, docksize;
var arrows, arrowspeed, arrowspacing, bps;
var level, levelpos;
var ddr_score;
var startSc;
var gameOver;
let ddr_time;
let dock_img, arrow_dock_img;
let niklas_anim;
let elena_anim;
let frame_rate;

function ddr_preload(){
  arrow_images = [
    loadImage(spriteImgSrc +'ddr_arrows/arrow_left.png'),
    loadImage(spriteImgSrc +'ddr_arrows/arrow_down.png'),
    loadImage(spriteImgSrc +'ddr_arrows/arrow_up.png'),
    loadImage(spriteImgSrc +'ddr_arrows/arrow_right.png'),
  ]
  dock_images = [
    loadImage(spriteImgSrc +'ddr_arrows/dock_left.png'),
    loadImage(spriteImgSrc +'ddr_arrows/dock_down.png'),
    loadImage(spriteImgSrc +'ddr_arrows/dock_up.png'),
    loadImage(spriteImgSrc +'ddr_arrows/dock_right.png'),
  ]
  elena_anim = loadAnimation(spriteImgSrc + 'niklas_elena_anim/separat/elena_0001.png', spriteImgSrc + 'niklas_elena_anim/separat/elena_0008.png')
  niklas_anim = loadAnimation(spriteImgSrc + 'niklas_elena_anim/separat/niklas_0001.png', spriteImgSrc + 'niklas_elena_anim/separat/niklas_0008.png')
  niklas_anim.frameDelay = 2;
  elena_anim.frameDelay = 2;
}

function ddr_draw(){
  frameRate(frame_rate)
  ddr_time += deltaTime
  if(startSc){startScreen("Dj G&E's DDR")}
  if(!gameOver && !startSc){ddr_game();}
  if(!startSc && gameOver && !win){
    camera.position.x = width/2;
    camera.position.y = height/2;
    resizeCanvas(600, 600)
    gameOverScreen();
    if(clearVar){ddr_deleteVar();}
  }
  if(!startSc && win && !gameOver){
    camera.position.x = width/2;
    camera.position.y = height/2;
    resizeCanvas(600, 600)
    winScreen();
    if(clearVar){ddr_deleteVar();}
  }
}

function ddr_deleteVar(){
  docks = []
  arrows = [[], [], [], []]
  ddr_time = 0;
  levelpos = 0;
  ddr_score = 0
}

function ddr_keyCommands(){
  ddr_collisionCheck(LEFT_ARROW, 0);
  ddr_collisionCheck(DOWN_ARROW, 1);
  ddr_collisionCheck(UP_ARROW, 2);
  ddr_collisionCheck(RIGHT_ARROW, 3);
}// keyCommands()

function ddr_collisionCheck(key, index){
  if(keyWentDown(key)){
    //docks[index].animation.changeFrame(0)
    ddr_checkScore(index);
    for (var i = 0; i < arrows[index].length; i++) {
      if(abs(docks[index].y-arrows[index][i].y)<docksize){
        arrows[index].splice(i,1);
      }
    }
  }
}

function ddr_defineVar(){
  resizeCanvas(1200, 700)


  startSc = true;
  gameOver = true;
  camera.position.x = width/2;
  camera.position.y = height/2;

  frame_rate = 24;
  let playAreaWidth = 280
  ddr_time = 0;
  docksize = 60;
  spacing = 10;
  ddr_score = 0;

  spawnrate = 40; //higher -> lower rate
  arrowspacing = 2*(docksize+spacing)
  bps = 3; // f
  arrowspeed = arrowspacing*bps //v = lambda * f

  arrows = [[], [], [], []] //0- right, 1-down, 2- up, 3-left
  docks = [];

  let dockStartXCoordinate = (width-playAreaWidth)/2
  for (var i = 0; i < 4; i++) {
    dock = new ddr_arrowDock(i, dockStartXCoordinate);
    docks.push(dock);
  }

  level = ddr_getLevel();
  levelpos = 0;
  fill(255)
}

function ddr_checkScore(index){
  for (var i = 0; i < arrows[index].length; i++) {
    if(abs(docks[0].y-arrows[index][i].y)<(docksize/4) && docks[index].x == arrows[index][i].x){
      ddr_score += 100
    }else if(abs(docks[0].y-arrows[index][i].y)<(docksize/2)&& docks[index].x == arrows[index][i].x){
      ddr_score += 75
    }else if(abs(docks[0].y-arrows[index][i].y)<(docksize)&& docks[index].x == arrows[index][i].x){
      ddr_score +=25
    }
  }

}

function ddr_drawLanes(){
  noStroke();
  rectMode(CENTER)
  for (var i = 0; i < docks.length; i++) {
    switch (i) {
      case 0:
        if(keyIsDown(LEFT_ARROW)){
          fill(255,255,255,50)
        }else{
          fill(255,255,255,25)
        }
        break;
      case 1:
        if(keyIsDown(DOWN_ARROW)){
          fill(255,255,255,50)
        }else{
          fill(255,255,255,25)
        }
        break;
      case 2:
        if(keyIsDown(UP_ARROW)){
          fill(255,255,255,50)
        }else{
          fill(255,255,255,25)
        }
        break;
      case 3:
        if(keyIsDown(RIGHT_ARROW)){
          fill(255,255,255,50)
        }else{
          fill(255,255,255,25)
        }
        break;
    }
    rect(docks[i].x, height/2, docksize+4, height)
  }
}

function ddr_game(){
  background(51);
  fill(255)
  ddr_drawLanes()
  ddr_spawnAndDespawnArrows();
  ddr_updateArrowsAndDocks();
  niklas_anim.draw(niklas_anim.getWidth()/2,niklas_anim.getHeight()/2+100);
  elena_anim.draw(width-(elena_anim.getWidth()/2), elena_anim.getHeight()/2+100)

  text(ddr_score, width-100, 50);
  ddr_keyCommands();

}

function ddr_arrow(index){
  this.x = docks[index].x;
  this.y = 0;
  this.move = function(){
    this.y += deltaTime*arrowspeed/1000;
  }
  this.draw = function(){
    imageMode(CENTER)
    //ddr_rotateArrowToIndex(index)
    image(arrow_images[index], this.x, this.y)
  }
  this.update = function(){
    this.move();
    this.draw();
  }
}

function ddr_arrowDock(index, startX){
  this.x = startX+index*(spacing+docksize)+docksize/2+spacing
  this.y = height-spacing-docksize/2

  this.draw = function(){
    imageMode(CENTER)
    //ddr_rotateArrowToIndex(index)
    image(dock_images[index], this.x, this.y)
  }
  this.update = function(){
    this.draw();
  }
}

function ddr_rotateArrowToIndex(index){
  angleMode(DEGREES)
  switch (index) {
    case 1:
      rotate(270)
      break;
    case 2:
      rotate(90)
      break;
    case 3:
      rotate(180)
      break;
  }
}

function ddr_spawnAndDespawnArrows(){
  if(ddr_time > (1/bps)*1000 && levelpos < level.length){
    for (var i = 0; i < 4; i++) {
      if(level[levelpos][i] == 1){
        arrow = new ddr_arrow(i)
        arrows[i].push(arrow)
      }
    }
    for (var i = 0; i < arrows.length; i++) {
      for (var j = 0; j < arrows[i].length; j++) {
        if(arrows[i][j].y > height){
          arrows[i].splice(j,1)
        }
      }
    }
    levelpos+=1
    ddr_time = 0
  }
}

function ddr_updateArrowsAndDocks(){
  for (var i = 0; i < 4; i++) {
    for (var j = 0; j < arrows[i].length; j++) {
      arrows[i][j].update()
    }
    docks[i].update();
  }
}
