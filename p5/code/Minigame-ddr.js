var docks, spacing, docksize;
var arrows, arrowspeed, arrowspacing, bps;
var level, levelpos;
var ddr_score;
var startSc;
var gameOver;
let ddr_time;
let dock_img, arrow_dock_img;

function ddr_preload(){
  arrow_img = loadImage(spriteImgSrc + 'arrow_left.png')
  arrow_dock_img = loadImage(spriteImgSrc + 'arrow_dock.png')
  arrow_dock_selected_img = loadImage(spriteImgSrc + 'arrow_dock_selected.png')
}

function ddr_draw(){
  frameRate(30)
  ddr_time += deltaTime
  if(startSc){startScreen("Dj G&E's DDR")}
  if(!gameOver && !startSc){drawDDR();}
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
  docks.removeSprites();
  for (var i = 0; i < arrows.length; i++) {
    arrows[i].removeSprites();
  }
  arrows = []
  arrows = [new Group(), new Group(), new Group(), new Group()]
  ddr_time = 0;
  levelpos =0;
  ddr_score = 0
}

  function ddr_collisionCheck(key, index){
  if(keyWentDown(key)){
    docks[index].changeImage('selected')
    checkScore(index);
    for (var i = 0; i < arrows[index].length; i++) {
      if(abs(docks[index].position.y-arrows[index][i].position.y)<docksize){
        arrows[index][i].remove();
      }
    }
  }
  if(keyWentUp(key)){
    docks[index].changeImage('unselected')
  }
}

function ddr_keyCommands(){
  ddr_collisionCheck(LEFT_ARROW, 0);
  ddr_collisionCheck(DOWN_ARROW, 1);
  ddr_collisionCheck(UP_ARROW, 2);
  ddr_collisionCheck(RIGHT_ARROW, 3);
}// keyCommands()


function ddr_defineVar(){
  let playAreaWidth = 280
  resizeCanvas(1200, 700)
  ddr_time = 0;
  docksize = 60;
  spacing = 10;
  ddr_score = 0;
  startSc = true;
  gameOver = true;
  camera.position.x = width/2;
  camera.position.y = height/2;
  spawnrate = 40; //higher -> lower rate
  arrowspacing = 2*(docksize+spacing)
  bps = 3; // f
  arrowspeed = arrowspacing*(bps/30) //v = lambda * f
  arrows = [new Group(), new Group(), new Group(), new Group()] //0- right, 1-down, 2- up, 3-left
  docks = new Group();

  let dockStartXCoordinate = (width-playAreaWidth)/2
  for (var i = 0; i < 4; i++) {
    dock = createSprite(dockStartXCoordinate+i*(spacing+docksize)+docksize/2+spacing, height-spacing-docksize/2, docksize, docksize)
    dock.addImage('unselected', arrow_dock_img)
    dock.addImage('selected', arrow_dock_selected_img)
    switch (i) {
      case 0:
        dock.rotation = 0;
        break;
      case 1:
        dock.rotation = 270;
        break;
      case 2:
        dock.rotation = 90;
        break;
      case 3:
        dock.rotation = 180;
        break;
    }
    //dock.addImage(dock_img)
    docks.add(dock);
  }
  level =[
    [1,1,0,0],
    [1,0,0,0],
    [0,1,0,0],
    [0,0,1,0],
    [0,0,0,1],
    [1,1,0,0],
    [1,0,0,0],
    [1,0,0,0],
    [0,1,0,0],
    [0,0,1,0],
    [0,0,0,1],
    [1,1,0,0],
    [1,1,0,0],
    [1,0,0,0],
    [0,1,0,0],
    [0,0,1,0],
    [0,0,0,1],
    [1,1,0,0],
    [1,0,0,0],
    [0,1,0,0],
    [0,0,1,0],
    [0,0,0,1],
    [1,1,0,0],
    [1,0,0,0],
    [1,0,0,0],
    [0,1,0,0],
    [0,0,1,0],
    [0,0,0,1],
    [1,1,0,0],
    [1,1,0,0],
    [1,0,0,0],
    [0,1,0,0],
    [0,0,0,1]
  ]
  levelpos = 0;
  fill(255)
}

function checkScore(index){
  for (var i = 0; i < arrows[index].length; i++) {
    if(abs(docks[0].position.y-arrows[index][i].position.y)<(docksize/4) && docks[index].position.x == arrows[index][i].position.x){
      ddr_score += 100
    }else if(abs(docks[0].position.y-arrows[index][i].position.y)<(docksize/2)&& docks[index].position.x == arrows[index][i].position.x){
      ddr_score += 75
    }else if(abs(docks[0].position.y-arrows[index][i].position.y)<(docksize)&& docks[index].position.x == arrows[index][i].position.x){
      ddr_score +=25
    }
  }

}

function newGame() {
  for (var i = 0; i < arrows.length; i++) {
    arrows[i].removeSprites();
  }
  levelpos = 0;
  gameOver = false;
  updateSprites(true);
  ddr_score = 0;
  ddr_time = 0;

  startSc = true;
  gameOver = false;
  win = false;
}

function drawDDR(){
  background(51);
  fill(255)
  drawSprites();
  sec = floor(millis())/1000;
  text(ddr_score, width-100, 50);
  ddr_keyCommands();
  if(frameCount%((1/bps)*30) == 0 && levelpos < level.length){
    for (var i = 0; i < 4; i++) {
      if(level[levelpos][i] == 1){
        arrow = createSprite(docks[i].position.x, 0, docksize, docksize);
        arrow.velocity.y = arrowspeed;
        arrow.addImage(arrow_img)
        switch (i) {
          case 0:
            arrow.rotation = 0;
            break;
          case 1:
            arrow.rotation = 270;
            break;
          case 2:
            arrow.rotation = 90;
            break;
          case 3:
            arrow.rotation = 180;
            break;
        }
        //arrow.addImage(arrow_img[i])
        arrows[i].add(arrow);
      }
    }
    for (var i = 0; i < arrows.length; i++) {
      for (var j = 0; j < arrows[i].length; j++) {
        if(arrows[i][j].position.y > height){
          arrows[i][j].remove();
        }
      }
    }
    levelpos+=1
  }
}
