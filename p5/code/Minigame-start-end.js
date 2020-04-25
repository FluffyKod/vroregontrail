let usingRoomDraw = false;

var enterTextShow = true;

function startScreen(title, description){
  background(51);
  fill(255);
  this.title = title;

  textSize(50);
  textAlign(CENTER, BOTTOM)
  text(this.title, width/2,height/2);

  blinkingText();
  if(enterTextShow){
    textSize(20)
    textAlign(CENTER, TOP);
    text("press 'r' to start",width/2,height/2)
  }

  if(keyWentDown('r')){
    gameOver = false;
    startSc = false;
  }
}

function winScreen(){
  background(51);
  fill(255);
  textSize(50);
  textAlign(CENTER, BOTTOM);
  text("Congratulations!", width/2,height/2);
  blinkingText();

  if(enterTextShow){
    textSize(20)
    textAlign(CENTER,TOP);
    text("press 'q' to continue",width/2,height/2);
  }
  if(keyWentDown('q')){
    //TODO: ett sätt att specifiera vart man hamnar
    player.position.y +=1;
  }
}

function gameOverScreen(){
  background(51);
  fill(255);
  textSize(50);
  textAlign(CENTER, BOTTOM);
  text("Game Over", width/2,height/2);
  blinkingText();

  if(enterTextShow){
    textSize(20)
    textAlign(CENTER,TOP);
    text("press 'q' to go back",width/2,height/2)

  }
  if(keyWentDown('q')){
    switchToText();
    clearVar= true
  }
}

function blinkingText(){
  if(frameCount % 60 == 0){
    if(enterTextShow){
      enterTextShow = false;
    }else if(!enterTextShow){
      enterTextShow = true;
    }
  }
}
