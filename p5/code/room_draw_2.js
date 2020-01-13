let roomBoxSize = 64; //helst delbar m 2
let spriteGridWidth = 3;
let spriteGridHeight = 3;

let canvasSize = {width: roomBoxSize*100, height: roomBoxSize*100 }

let   topCoordinate = {x: -1, y: -1};


let colors = {};

let rooms = [];
let roomSprites = [];

function setup(){
  colors =
  {
    fillColor: color(210),
    strokeColor: color(0),
    highLight: color(255),
    inactiveFillColor: color(51)
  };

  createCanvas(canvasSize.width, canvasSize.height);
  createFirstRoom();
  print(roomSprites);
  Camera(floor(width/2),floor(height/2))
}

function draw(){

  background(colors.inactiveFillColor);
  highlightOverMouse();
  drawSprites();



  }

  function highlightOverMouse(){
    x = mouseX + (32-(mouseX%64))
    y = mouseY + (32-(mouseY%64))
    fill(colors.fillColor);
    noStroke();
    rectMode(CENTER);
    rect(x,y,roomBoxSize, roomBoxSize);
  }

  function keyPressed(){
    if(keyCode === TAB){
      window.scrollTo(floor(width/2-window.innerWidth/2),floor(height/2-window.innerHeight/2))
    }
  }

  function mousePressed(){
    onSprite = false;
    for (var i = 0; i < roomSprites.length; i++) { // borde göras bättre
      if(roomSprites[i].mouseIsOver){
        onSprite = true;
      }
    }
    if(!onSprite){
      createRoom(mouseX + (roomBoxSize/2-(mouseX%roomBoxSize)), mouseY + (roomBoxSize/2-(mouseY%roomBoxSize)) ) //modulo skiten gör så att den hamnar på  sitt grid
    }
  }

function createFirstRoom(){
    drawCoordinate = {x: floor(width/2)+roomBoxSize/2, y: floor(height/2)+roomBoxSize/2};
    createRoom(drawCoordinate.x, drawCoordinate.y);
}


function createRoom(x, y){
  this.x = x;
  this.y = y;
  roomSprite = createSprite(this.x, this.y, roomBoxSize, roomBoxSize);
  roomSprite.active = false;

  roomSprite.indexX = (this.x-floor(width/2)-roomBoxSize/2)/roomBoxSize;
  roomSprite.indexY = (this.y-floor(height/2)-roomBoxSize/2)/roomBoxSize;

  roomSprite.draw = function(){
    rectMode(CENTER);

    if(this.active){
      fill(colors.fillColor);
      stroke(colors.strokeColor);
    }
    if(!this.active){
      fill(colors.inactiveFillColor);
      noStroke();
    }
    rect(0,0, roomBoxSize, roomBoxSize);

  }
  print(this.x);
  roomSprite.onMousePressed = function(){ //maybe this is retarded and should be called in mousePressed() instead

    this.active = true;

    print(this.indexY +", "+ this.indexX)
    //if(this.roomObj === null){
    //  this.roomObj = new room(this.indexX, this.indexY, this.mainText, this.options);
    //}
  }

  roomSprite.debug = true;

  //roomSprite.indexX = j;
  //roomSprite.indexY = i;

  roomSprites.push(roomSprite);


}
//not used---
function createVisualizationBox(roomObj){

  this.roomObj = roomObj

  this.drawCoordinates = {x: (this.roomObj.x*64-floor(width/2)), y: (this.roomObj.y*64-floor(height/2))};
  this.roomSprite = createSprite(this.drawCoordinates.x, this.drawCoordinates.y, roomBoxSize, roomBoxSize);
  this.roomSprite.active = false;

  this.roomSprite.draw = function(){
    rectMode(CENTER);

    if(this.active){
      fill(colors.fillColor);
      stroke(colors.strokeColor);
    }
    if(!this.active){
      fill(colors.inactiveFillColor);
      noStroke();
    }
     rect(0,0, roomBoxSize, roomBoxSize);

  }

  this.roomSprite.onMousePressed = function(){

    this.active = true;
  }

  this.roomSprite.debug = true;

    //roomSprite.indexX = j;
    //roomSprite.indexY = i;



  this.generateGui = function(){
    this.gui = createGui( "(" + this.roomObj.x + ", " + this.roomObj.y + ")" );
    this.gui.addGlobals('roomText');
    noLoop();
  }

}
