var mj_player, mj_playersize, mj_playerv, mj_jumpv;
var mj_gravity;
var spawnrate;
var score;
var currentheight;
var rockwidth;
var friction;

var rocks;
var pens, penv;
var positive;

var startSc = true;
var gameOver = true;

var difficulty;



function mj_draw(){
  if(startSc){
    startScreen("Mountain Jump");
  }

  if(!gameOver){
    background(51);
    mountainJumpDraw();

 }
  if(gameOver && !startSc){
    gameOverScreen();
    camera.position.x = width/2;
    camera.position.y = height/2;
    if(clearVar){mj_deleteVar();}

  }
}




function mj_defineVar(){
  friction = 0.08;
  score = 0;
  difficulty = 1; //3 = max
  oldscore = 0;
  currentheight = 0;
  penv = 2;

  rockwidth = 100;
  spawnrate = floor(random(20,40));
  mj_playersize = 50;
  mj_playerv = 4;
  mj_jumpv = 20;
  mj_gravity = 0.4;
  mj_player = createSprite(width/2,height/2, mj_playersize, mj_playersize);
  mj_player.shapeColor = color(255);
  mj_player.velocity.x = mj_playerv + 0.01*score;
  mj_player.setCollider('circle', 0, 0, mj_playersize/2)
  ground = createSprite(0,height, width*5, 1000);
  rocks = new Group();
  pens = new Group();
  positive = 1;


  camera.position.y = height/2;
  camera.position.x = width/2
}
function mj_deleteVar(){
  rocks.removeSprites();
  pens.removeSprites();
  mj_player.remove();
  ground.remove();
}



function mountainJumpDraw(){
    drawSprites();
    textSize(40);
    fill(255);

    if(mj_player.velocity.y < 0 && mj_player.position.y <= camera.position.y){
      camera.position.y = mj_player.position.y
    }
    if(mj_player.position.y > camera.position.y+width){
      gameOver = true;
    }
    text(score,  width -100, mj_player.position.y-height/2+100)
    if(mj_player.velocity.y < 0){
    }
    mj_player.debug = true;

    mj_player.velocity.y += mj_gravity
    if(score > 2500){
      difficulty = 2;
    }
    if(score > 5000){
      difficulty = 3;
    }
    if(score > 7500){
      difficulty = 4;
    }
    if(mj_player.overlap(ground)){
      mj_player.velocity.y = -2*mj_jumpv;
    }

    if(keyDown(LEFT_ARROW) && mj_player.velocity.x >-2*mj_playerv){
      mj_player.velocity.x -= 0.3*mj_playerv;
    }else if(!keyDown(LEFT_ARROW) &&mj_player.velocity.x < 0){
      mj_player.velocity.x +=-1*friction*mj_player.velocity.x
    }
    if(keyDown(RIGHT_ARROW)&& mj_player.velocity.x <2*mj_playerv){
      mj_player.velocity.x += 0.3*mj_playerv;
    }else if(!keyDown(RIGHT_ARROW) && mj_player.velocity.x > 0){
        mj_player.velocity.x -=friction*mj_player.velocity.x
    }
    if(mj_player.position.x < 0){
      mj_player.position.x = width;
    }
    if(mj_player.position.x > width){
      mj_player.position.x = 0;
    }
    if (frameCount % floor(400/difficulty) == 0 && mj_player.velocity.y >-10) {

      pen = createSprite(random(10,width-10),mj_player.position.y-height,10,60);
    //  pen.setCollider('c',0,0,10,60);
      pen.rotationSpeed = random(-1,2)*10;
      //pen.velocity.y = penv*difficulty;

      pens.add(pen);
    }

    for (var i = 0; i < pens.length; i++) {
      if(mj_player.overlap(pens[i])){
        gameOver = true;
        //pens[i].remove();
        //i-=1
      }
      // } else if(mj_player.overlap(pens[i])&& mj_player.velocity.y> 0){
      //   mj_player.velocity.y = -0.5*mj_jumpv;
      //   //pens[i].remove();
      //   //i-=1
      // }
      if(pens[i].position.y > mj_player.position.y+height){
        pens[i].remove();
      }
    }

    if(mj_player.position.y < currentheight){
      currentheight = mj_player.position.y - 400;
      score += 100;
      for (var i = 0; i < 5-difficulty; i++) {
        randint = floor(random(0, 20));
        if(difficulty<3){
          rock = createSprite(random(rockwidth/2+width*i/3, width*(i+1)/3), random(currentheight-width/2-50, currentheight-width/2-200), rockwidth, 40);
        }else{
          rock = createSprite(random(rockwidth/2, width-rockwidth/2), random(currentheight-width/2-50, currentheight-width/2-200), rockwidth, 40);

        }
        rock.setCollider('rectangle',0,0,rockwidth,50);

        if(randint >=0 && randint <17-difficulty){rock.type = 0;rock.shapeColor= color(150);}
        if(randint ==17-difficulty ){rock.type = 1; rock.shapeColor = color(100,100,200);}//jump
        if(randint > 17-difficulty && randint< 20-difficulty){rock.type = 2; rock.shapeColor = color(200,100,100);}//break
        if(randint >= 20-difficulty){rock.type = 3; rock.shapeColor = color(200,100,200); rock.dir = random(-difficulty,difficulty)}//move

        rocks.add(rock);


      }
    }

    for (var i = 0; i < rocks.length; i++) {
      if(rocks[i].position.y > mj_player.position.y+height){
        rocks[i].remove();
      }
      if(rocks[i].type == 3){
        if(rocks[i].position.x > width -rockwidth/2){rocks[i].dir = -1}
        if(rocks[i].position.x < rockwidth/2){rocks[i].dir = 1}
        rocks[i].velocity.x = rocks[i].dir*0.7*difficulty;

      }
      if(mj_player.overlap(rocks[i])&& mj_player.velocity.y >0){
        switch (rocks[i].type) {
          case 0:
            mj_player.velocity.y = -mj_jumpv;
            break;
          case 1:
            mj_player.velocity.y = -2*mj_jumpv
            break;
          case 2:
            mj_player.velocity.y = -mj_jumpv;
            rocks[i].remove();
            break;
          case 3:
            mj_player.velocity.y = -mj_jumpv;
            break;
        }
      }
    }
}

function newGame(){
  currentheight = 0;
  difficulty = 1;
  oldscore = 0;
  rocks.removeSprites();
  score = 0;
  pens.removeSprites();
  gameOver = false;
  mj_player.position.x = width/2
  mj_player.position.y = height/2
  camera.position.x = height/2
  camera.position.y = width/2
}



/*
function setup(){
  defineCanvas();
  defineVar();



  //updateSprites(false);

} // setup()

function draw(){
  if(startSc){
    startScreen("Mountain Jump");
  }

  if(!gameOver){
    background(51);
    mountainJumpDraw();

 }
  if(gameOver && !startSc){
    gameOverScreen();
    camera.position.x = width/2;
    camera.position.y = height/2;
  }
}// function draw()

*/
