let roomBoxSize = 64;
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
  createRoomSprites();
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
      createRoomSprite()
    }
  }

function createRoomSprite(){
  x = mouseX + (32-(mouseX%64))
  y = mouseY + (32-(mouseY%64))
  drawBox(x,y);
}





function createRoomSprites(){

  for (var i = topCoordinate.y; i < spriteGridHeight+topCoordinate.y; i++) {
      for (var j = topCoordinate.x; j < spriteGridWidth+topCoordinate.x; j++) {
        drawCoordinate = {x: floor(width/2)+j*roomBoxSize+32, y: floor(height/2)+i*roomBoxSize+32};
        drawBox(drawCoordinate.x, drawCoordinate.y);



    }
  }
}


function drawBox(x, y){
  roomSprite = createSprite(x, y, roomBoxSize, roomBoxSize);
  roomSprite.active = false;

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

  roomSprite.onMousePressed = function(){

    this.active = true;
  }

  roomSprite.debug = true;

  //roomSprite.indexX = j;
  //roomSprite.indexY = i;

  roomSprites.push(roomSprite);
}












function room( x, y, mainText, options ){

  // Set default values
  this.x = x;
  this.y = y;
  this.mainText = mainText;
  this.options = options;

  this.load = function(){

    // Reset the displayed options
    for (var i = 0; i < maxOptionLength; i++) {
      displayedOptions[i].ref.html('');
    }

    // Get the number of displayedOptions
    optionlength = this.options.length;

    // Set the option variables for use in front ends display options
    for (var i = 0; i < optionlength; i++) {
      // Set the displayed text on option
      displayedOptions[i].ref.html(this.options[i].text);

      displayedOptions[i].cmd = this.options[i].cmd;

      displayedOptions[i].values = this.options[i].values;

    }

  }//this.load()



}
