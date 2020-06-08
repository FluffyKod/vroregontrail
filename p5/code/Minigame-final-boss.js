let fb_selectedText = false;

function fb_preload(){

}

function fb_defineVar(){

  resizeCanvas(900,675)
  camera.position.x = width/2;
  camera.position.y = height/2;
}

function fb_deleteVar(){

}

function fb_draw(){
  if(startSc){
    startScreen("The Red Circle")

  }
  if(!gameOver && !win){
    fb_game();
 }
 if(!startSc && gameOver && !win){
   camera.position.x = width/2;
   camera.position.y = height/2;
   gameOverScreen();
   if(clearVar){fb_deleteVar();}
 }
 if(win && !gameOver){
   camera.position.x = width/2;
   camera.position.y = height/2;
   winScreen();
   if(clearVar){fb_deleteVar();}
 }
}

function fb_game(){
  background(51)
  if(keyWentDown(UP_ARROW)){
    win = true
  }
}
