
roomSprites = [];
var scaleFactor;

function setup(){
  scaleFactor = 50;
  print("hello world");
  createCanvas(windowWidth,windowHeight);
  loadRooms();
  createRoomSprites();

}

function draw(){
  background(51);
  drawSprites();
  //fill(255);

}

function createRoomSprites(){
  for (var i = 0; i < rooms.length; i++) {
    roomX = rooms[i].x;
    roomY = rooms[i].y;
    x = floor(width/2) + roomX*scaleFactor;
    y = floor(height/2) + roomY*scaleFactor;
    roomSprite = createSprite(x, y, scaleFactor, scaleFactor);

    roomSprite.draw = function(){
      strokeWeight(5);
      stroke(0);
      fill(roomX*50, roomY*10, 0)
      rect(0,0,scaleFactor,scaleFactor);
      coordinateText = "(" +  roomX + "," + roomY + ")";
      fill(0);
      noStroke();
      textSize(32);
      text(coordinateText,0,0);
    }
    roomSprites.push(roomSprite);

  }
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

  }
}
