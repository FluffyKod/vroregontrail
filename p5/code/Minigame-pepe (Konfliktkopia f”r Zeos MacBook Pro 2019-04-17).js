var player, playersize, playerspeed;
var bread = 0;
var handresistance;
var breadbowl;


function setup(){

  defineCanvas();
  textSize(40)

  defineVar();




} // setup()

function draw(){
  text(bread, width-100, 50);
  background(51);
  fill(255)
  if(player.position.x > -playerwidth/3){
    player.velocity.x += -handresistance;
  } else { player.velocity.x = 0}

  if(player.overlap(breadbowl)){
    bread++
    player.position.x = -width/2;
  }


  drawSprites();





}// function draw()

function keyPressed(){
  if(key === ' '){
    player.velocity.x = 10;


  }



}// keyPressed()

function keyReleased(){



}// keyReleased()


function defineVar(){
  
    playersize = 50;
    playerwidth = width/2
    playerspeed = 10;
    handresistance = 1;
    breadbowl = createSprite(width/2, height/2, 50,50)



    player = createSprite(0, height/2, playerwidth, playersize);
    player.shapeColor = color(255);
    player.setCollider('rectangle', 0, 0, playerwidth, playersize)
}

function defineCanvas(){

    div = createDiv();
    canvas = createCanvas(600, 600);
    canvas.position(windowWidth/2-300, windowHeight/2-300)
    canvas.style('outline', '1px');
    canvas.style('outline-color', '#fff');
    canvas.style('outline-style', 'solid');


}
