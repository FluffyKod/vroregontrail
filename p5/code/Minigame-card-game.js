//--Card game--

var cg_player, cg_playersize, cg_playerspeed, cg_playerhp;
var cg_bullets, cg_bulletspeed;
var cards, cardwidth, cardheight, cardspeed, cardrate;
var score = 0;


function cg_draw(){
  if(startSc){startScreen("Card Fight");}
  if(!gameOver){
    drawCardGame();


  }
  if(gameOver && !startSc){
    gameOverScreen();
    if(clearVar){cg_deleteVar();}
  }
  if(win){
    winScreen();
    
  }
}
/*
function setup(){

  defineCanvas();
  textSize(40)

  defineVar();




} // setup()



function draw(){


}// function draw()
*/


function cg_defineVar(){
    gameOver = true;
    startSc = true;
    spawnrate = 80; //higher -> lower rate
    cardspeed = 2;
    cardwidth = 40;
    cardheight = 60;
    cards = new Group();
    cg_bullets = new Group();
    cg_bulletspeed = 5;

    cg_playerhp = 3;

    cg_playersize = 50;
    cg_playerspeed = 7;


    cg_player = createSprite(width/2, height-cg_playersize, cg_playersize, cg_playersize);
    cg_player.shapeColor = color(255);
    cg_player.setCollider('rectangle', 0, 0, cg_playersize, cg_playersize)
}

function cg_deleteVar(){
  cg_player.remove();
  cards.removeSprites();
  cg_bullets.removeSprites();
}


function cg_playerMove(){

  if(keyIsDown(LEFT_ARROW) && cg_player.position.x > (cg_playersize/2) ){
    cg_player.velocity.x = -cg_playerspeed;

  } else if(keyIsDown(RIGHT_ARROW) && cg_player.position.x < (width-(cg_playersize/2)) ){
    cg_player.velocity.x = cg_playerspeed;
  } else {
    cg_player.velocity.x = 0;

  }

}

function spawnCards(){
  if(frameCount % spawnrate == 0){

    card = createSprite(random(cardwidth,width-cardwidth), -20, cardwidth, cardheight)

    card.velocity.y = random(5, cardspeed+score*0.15);
    cards.add(card);
  }

}

function newGame() {
  cards.removeSprites();
  cg_bullets.removeSprites();
  gameOver = false;
  updateSprites(true);
  score = 0;
  cg_playerhp = 3;
}

function cardHit(card, bullet) {
  bullet.remove();
  card.remove();
  score++;
}


function drawCardGame(){

    background(51);
    fill(255)
    text(score, width-100, 50);
    cardspeed = 2 + 0.1*score;
    if(score >= 52){
      win = true;
    }
    drawSprites();
    cg_playerMove();
    if(keyWentDown(" ") && cg_bullets.length < 4){
      bullet = createSprite(cg_player.position.x, cg_player.position.y, 12, 38)
      bullet.setCollider('circle',0,0,12)
      //bullet.rotation += 360
      bullet.velocity.y = -cg_bulletspeed
      //bullet.rotateToDirection = true;
      cg_bullets.add(bullet);



    }
    spawnCards();

    cg_bullets.overlap(cards, cardHit);
    if(cg_playerhp <= 0){gameOver = true;}


    for (var i = 0; i < cg_bullets.length; i++) {
      if(cg_bullets[i].position.y < 0){
        cg_bullets[i].remove()
      }
    }
    for (var i = 0; i < cards.length; i++) {
            //cards[i].rotation += 4
      if(cards[i].position.y > height){
        cg_playerhp-=1;
        cards[i].remove();
      }
      if(cards[i].overlap(cg_player)){
        cards[i].remove();
        cg_playerhp -=1;
      }

    }
  }
