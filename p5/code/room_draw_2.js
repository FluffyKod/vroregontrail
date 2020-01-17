let roomBoxSize = 64; //helst delbar m 2
let spriteGridWidth = 3;
let spriteGridHeight = 3;

let params = {
  poop: 1,
  pee: "text"
}

let canvasSize = {width: roomBoxSize*100, height: roomBoxSize*100 }

let topCoordinate = {x: -1, y: -1};
let activeRoom;

let colors = {};

let rooms = [];
let roomSprites = [];

let guiBackgroundHidden = false;
let guiMouseIsOver = false;

function setup(){
  colors =
  {
    fillColor: color(51),
    strokeColor: color(255),
    highlight: color(255,255,255,25),
    inactiveFillColor: color(51)
  };
  badDummyGui = createGui('');
  badDummyGui.hide()//never to be seen again

  createCanvas(canvasSize.width, canvasSize.height);
  createFirstRoom();

  //borde hitta något sätt att parenta guin till den här istället
  guiBackground = createDiv('');
  guiBackground.class('guiBackground');
  guiBackground.hide();
  guiBackgroundHidden = true;
  guiBackground.mouseOver(guiMouseOver);
  guiBackground.mouseOut(guiMouseOut);

  print(roomSprites);
  Camera(floor(width/2),floor(height/2))
}

function draw(){

  background(colors.inactiveFillColor);
  drawSprites();
  highlightOverMouse();






  }

  function highlightOverMouse(){
    x = mouseX + (32-(mouseX%64));
    y = mouseY + (32-(mouseY%64));
    fill(colors.highlight);
    noStroke();
    rectMode(CENTER);
    rect(x,y,roomBoxSize, roomBoxSize);
  }

  function keyPressed(){
    if(keyCode === TAB){
      window.scrollTo(floor(width/2-window.innerWidth/2),floor(height/2-window.innerHeight/2));
    }
  }

  function mousePressed(){
    onSprite = false;
    for (var i = 0; i < roomSprites.length; i++) { // borde göras bättre
      if(roomSprites[i].mouseIsOver){
        onSprite = true;
      }
    }
    if(!onSprite && !guiMouseIsOver){
      createRoom(mouseX + (roomBoxSize/2-(mouseX%roomBoxSize)), mouseY + (roomBoxSize/2-(mouseY%roomBoxSize)) ); //modulo skiten gör så att den hamnar på  sitt grid
    }
  }

function createFirstRoom(){ //får en konstig gui som sitter fast (har absolute positioning) EDIT: solved with badDummyGui B)
    drawCoordinate = {x: floor(width/2)+roomBoxSize/2, y: floor(height/2)+roomBoxSize/2};
    createRoom(drawCoordinate.x, drawCoordinate.y);
    roomSprites[0].gui.hide();
}


function createRoom(x, y){
  this.x = x;
  this.y = y;

  this.mainGuiParams = {
    mainText: "",
    optionAmount: [0,1,2,3,4,5]
  }
  this.optionGuiParams= {
    optionText: "",
    command: ["tp", "info", "itemTp", "statTp", "encounter"],

  }


  roomSprite = createSprite(this.x, this.y, roomBoxSize, roomBoxSize);
  roomSprite.active = true;


  roomSprite.indexX = (this.x-floor(width/2)-roomBoxSize/2)/roomBoxSize;
  roomSprite.indexY = (this.y-floor(height/2)-roomBoxSize/2)/roomBoxSize;
  roomSprite.coordinateString = "(" + roomSprite.indexX + ", " + roomSprite.indexY + ")";



  if (guiBackgroundHidden) {
    guiBackground.show();
    guiBackgroundHidden =false;

  }
  roomSprite.gui = createGui( "Room "+ roomSprite.coordinateString );
  roomSprite.gui.addObject(this.mainGuiParams);
  if (activeRoom === null) {
    activeRoom = roomSprite.gui();
    noLoop();// kanske kan kallas för alla

  }

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
    textSize(15);
    noStroke();
    fill(colors.strokeColor)
    text(this.coordinateString, -roomBoxSize/2+10,-roomBoxSize/2+25)

  }
  print(this.x);
  roomSprite.onMousePressed = function(){ //maybe this is retarded and should be called in mousePressed() instead

    if(activeRoom!= null){
      activeRoom.hide();

    }
    this.gui.show();
    activeRoom = this.gui;
    print(this.indexY +", "+ this.indexX)
    //if(this.roomObj === null){
    //  this.roomObj = new room(this.indexX, this.indexY, this.mainText, this.options);
    //}
  }

  roomSprite.debug = false;

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
//BRUH GUIN RÄKNAS SOM MOUSE OUT
function guiMouseOver(){
  guiMouseIsOver = true;
};

function guiMouseOut(){
  guiMouseIsOver = false;
};
