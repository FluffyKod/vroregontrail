var docks, spacing, docksize;
var arrows, arrowspeed, arrowspacing, bps;
var level, levelpos;
var score;
var startSc;
var gameOver;


function ddr_draw(){
  frameRate(30);
  if(startSc){startScreen("Dj G&E's DDR")}
  if(!gameOver){drawDDR();}
  if(!startSc && gameOver){
    gameOverScreen();
    if(clearVar){ddr_deleteVar();}
  }
}

function ddr_deleteVar(){
  docks.removeSprites();
  arrows.removeSprites();
}

function ddr_keyCommands(){

  if(keyWentDown(LEFT_ARROW)){
    docks[0].shapeColor = color(255);
    checkScore();


    for (var i = 0; i < arrows.length; i++) {
      if(arrows[i].position.x == docks[0].position.x && abs(docks[0].position.y-arrows[i].position.y)<docksize){
        arrows[i].remove();

      }
    }

  }
  if(keyWentDown(UP_ARROW)){
    docks[1].shapeColor = color(255);
    checkScore();


    for (var i = 0; i < arrows.length; i++) {
      if(arrows[i].position.x == docks[1].position.x && abs(docks[1].position.y-arrows[i].position.y)<docksize){
        arrows[i].remove();
      }
    }

  }
  if(keyWentDown(DOWN_ARROW)){
    checkScore();

    for (var i = 0; i < arrows.length; i++) {
      if(arrows[i].position.x == docks[2].position.x && abs(docks[2].position.y-arrows[i].position.y)<docksize){
        arrows[i].remove();
      }
    }

    docks[2].shapeColor = color(255)
  }
  if(keyWentDown(RIGHT_ARROW)){
    checkScore();

    for (var i = 0; i < arrows.length; i++) {
      if(arrows[i].position.x == docks[3].position.x && abs(docks[3].position.y-arrows[i].position.y)<docksize){
        arrows[i].remove();
      }
    }
    docks[3].shapeColor = color(255)
  }

  if(keyWentUp(LEFT_ARROW)){
    docks[0].shapeColor = color(100)
  }
  if(keyWentUp(UP_ARROW)){
    docks[1].shapeColor = color(100)
  }
  if(keyWentUp(DOWN_ARROW)){
    docks[2].shapeColor = color(100)
  }
  if(keyWentUp(RIGHT_ARROW)){
    docks[3].shapeColor = color(100)
  }



}// keyCommands()


function ddr_defineVar(){

    docksize = 120;
    spacing = 24;
    score = 0;
    startSc = true;
    gameOver = true;

    spawnrate = 40; //higher -> lower rate
    arrowspacing = 2*(docksize+spacing)
    bps = 3; // f
    arrowspeed = arrowspacing*(bps/30) //v = lambda * f
    arrows = new Group();
    docks = new Group();

    for (var i = 0; i < 4; i++) {
      dock = createSprite(i*(spacing+docksize)+docksize/2+spacing, height-spacing-docksize/2, docksize, docksize)
      dock.shapeColor = color(100)
      //dock.addImage(dock_img)
      docks.add(dock);
    }


    level =[1,1,0,0,
            1,0,0,0,
            0,1,0,0,
            0,0,1,0,
            0,0,0,1,
            1,1,0,0,
            1,0,0,0,
            1,0,0,0,
            0,1,0,0,
            0,0,1,0,
            0,0,0,1,
            1,1,0,0,
            1,1,0,0,
            1,0,0,0,
            0,1,0,0,
            0,0,1,0,
            0,0,0,1,
            1,1,0,0,
            1,0,0,0,
            0,1,0,0,
            0,0,1,0,
            0,0,0,1,
            1,1,0,0,
            1,0,0,0,
            1,0,0,0,
            0,1,0,0,
            0,0,1,0,
            0,0,0,1,
            1,1,0,0,
            1,1,0,0,
            1,0,0,0,
            0,1,0,0,
            0,0,0,1,]
    levelpos = -4; //startvalue
    fill(255)


}


function checkScore(){//måste fixas
  for (var i = 0; i < arrows.length; i++) {
    if(abs(docks[0].position.y-arrows[i].position.y)<(docksize/4) && docks[arrows[i].type].position.x == arrows[i].position.x){
      score += 100
    }else if(abs(docks[0].position.y-arrows[i].position.y)<(docksize/2)&& docks[arrows[i].type].position.x == arrows[i].position.x){
      score += 75
    }else if(abs(docks[0].position.y-arrows[i].position.y)<(docksize)&& docks[arrows[i].type].position.x == arrows[i].position.x){
      score +=25
    }
  }

}

function newGame() {

  arrows.removeSprites();
  levelpos = -4;
  gameOver = false;
  updateSprites(true);
  score = 0;



}

function spawnArrows(){

}

function drawDDR(){
  background(51);
  fill(255)
  drawSprites();
  sec = floor(millis())/1000;
  text(score, width-100, 50);
  ddr_keyCommands();
  if(frameCount%((1/bps)*30) == 0){
    levelpos+=4
    for (var i = 0; i < 4; i++) {
      if(level[levelpos+i] == 1){
        arrow = createSprite(i*(spacing+docksize)+docksize/2+spacing, 0, docksize, docksize);
        arrow.velocity.y = arrowspeed;
        arrow.type = i;
        //arrow.addImage(arrow_img[i])
        arrows.add(arrow);//kan förbättras genom att göra 4 separata listor
      }
    }
    for (var i = 0; i < arrows.length; i++) {
      if(arrows[i].position.y > height){
        arrows[i].remove();
      }
    }

  }

}


/*
function preload(){
  //dock_img = loadImage("p5/Projects/Textaventyr/Sprites/Png/Left_dock_ddr.png") //[loadImage('Left_dock_ddr.png'),loadImage('Sprites\Png\Up_dock_ddr.png'),loadImage('Sprites\Png\Down_dock_ddr.png'), loadImage('Sprites\Png\Right_dock_ddr.png')];
//  arrow_img = [loadImage('Sprites\Png\Left_arrow_ddr.png'),loadImage('Sprites\Png\Up_arrow_ddr.png'),loadImage('Sprites\Png\Down_arrow_ddr.png'), loadImage('Sprites\Png\Right_arrow_ddr.png')];
}




function setup(){

  defineCanvas();
  defineVar();




} // setup()



function draw(){
  frameRate(30);
  if(startSc){startScreen("Dj G&E's DDR")}
  if(!gameOver){drawDDR();}
  if(!startSc && gameOver){gameOverScreen();}

}// function draw()
*/
