let fb_mouseOnUrlBox = false;
let site_background_img, red_circle_loading_animation, red_circle_rotation_animation;

let url_box, close_button, other_button1, other_button2;
let fb_circleLoading;

let fb_activeCircleAnimation;
let fb_urlText;
let fb_time, fb_loadingTime;

function fb_preload(){
  site_background_img = loadImage(spriteImgSrc+'website_background.png')
  red_circle_loading_animation = loadAnimation(spriteImgSrc+'RED_CIRCLE/loading_0001.png', spriteImgSrc+'RED_CIRCLE/loading_0012.png')
  red_circle_loading_animation.frameDelay = 20;
  red_circle_rotation_animation = loadAnimation(spriteImgSrc+'RED_CIRCLE/rotation_0001.png', spriteImgSrc+'RED_CIRCLE/rotation_0004.png')
}

function fb_defineVar(){
  win = false;
  gameOver = false;
  resizeCanvas(800,575)
  canvas.style('border', 'none')
  canvas.style('outline', 'none')
  canvas.style('padding', '0px')
  camera.position.x = width/2;
  camera.position.y = height/2;
  fb_circleLoading = false;
  fb_urlText = ""
  fb_time = 0;
  fb_loadingTime = 10000

  fb_activeCircleAnimation = red_circle_rotation_animation;

  url_box = createSprite(400,79,768,52)
  url_box.mouseActive = true;
  url_box.onMousePressed = function(){
    fb_mouseOnUrlBox = true;
  }
  url_box.draw = function(){
    textFont(pixel_font, 40)
    fill(255)
    text(fb_urlText, -350,16)
  }
  url_box.debug = true;

  close_button = createSprite(778,18,12,12)
  close_button.setCollider('circle',0,0,8)
  close_button.mouseActive = true;
  close_button.onMousePressed= function(){
    if(fb_loadingTime <10000){
      win = true;
    }
  }
  close_button.debug = true;

  other_button1 = createSprite(754,18,12,12)
  other_button1.setCollider('circle',0,0,8)
  other_button1.mouseActive = true;
  other_button1.onMousePressed= function(){
    //trigger text
  }
  other_button1.debug = true;
  other_button2 = createSprite(730,18,12,12)
  other_button2.setCollider('circle',0,0,8)
  other_button2.mouseActive = true;
  other_button2.onMousePressed= function(){
    //trigger text
  }
  other_button2.debug = true;
}

function fb_deleteVar(){

}

function fb_draw(){
  if(startSc){
    startScreen("The Red Circle")

  }
  if(!gameOver && !win && !startSc){
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
  imageMode(CENTER)
  image(site_background_img, width/2,height/2)
  drawSprites()
  fb_time+=deltaTime
  fb_loadingTime+=deltaTime
  fb_activeCircleAnimation.draw(width/2-100, height/2+50)

  if(mouseWentDown() && !url_box.mouseIsOver){
    fb_mouseOnUrlBox = false;
  }

  if(keyWentDown(BACKSPACE)){
    fb_urlText = fb_urlText.substring(0, fb_urlText.length -1)
  }
  if(fb_loadingTime > 10000){
    fb_activeCircleAnimation = red_circle_rotation_animation //borde optimeras
  }

  if(keyWentDown(ENTER)){
    if(fb_urlText == "www.canvas.com"){
      fb_urlText = ""
      fb_activeCircleAnimation = red_circle_loading_animation;
      fb_loadingTime = 0;
    }
  }
}

function fb_keyTyped(){
  if(fb_mouseOnUrlBox && keyCode != ENTER){
    fb_urlText += key
  }

}
