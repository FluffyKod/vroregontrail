
roomSprites = [];
var scaleFactor;

function setup(){
  scaleFactor = 50;
  createCanvas(windowWidth,windowHeight);

  loadRooms();

  //createRoomSprites();

}

function draw(){
  translate(floor(width/2), floor(height/2)); //lägger 0,0 i mitten

  background(51);
  drawSprites();
  vizualizeRooms();

  //fill(255);

}

function createRoomSprites(){
  for (var i = 0; i < rooms.length; i++) {
    roomX = rooms[i].x;
    roomY = rooms[i].y;
    x = floor(width/2) + roomX*scaleFactor;
    y = floor(height/2) + roomY*scaleFactor;
    roomSprite = createSprite(x, y, scaleFactor, scaleFactor);


    roomSprites.push(roomSprite);
    roomSprites[i].draw = function(){
      strokeWeight(5);
      stroke(0);
      fill(255)
      rect(0,0,scaleFactor,scaleFactor);
      this.drawX = roomSprites[i].position.x/50 - floor(width/2)
      this.drawY = roomSprites[i].position.y/50 - floor(height/2)
      coordinateText = "(" +  this.drawX + "," + this.drawY + ")";
      fill(0);
      noStroke();
      textSize(32);
      text(coordinateText,0,0);
    }

  }
}

function vizualizeRooms(){
  for (var i = 0; i < rooms.length; i++) {
    rooms[i].vizualize();
  }
  for (var i = 0; i < rooms.length; i++) {
    rooms[i].vizualize.drawConnections();
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

  this.vizualize = function(){
    this.drawX = this.x*scaleFactor; //borde translatea hela koordinatsystemet istället
    this.drawY = this.y*scaleFactor;
    this.textSize = 12;
    this.connectionColors = [color(255, 0, 0), color(255, 255, 0), color(0, 255, 0), color(0, 255, 255), color(0, 0, 255)];


    //ritar rektangeln
    fill(51);
    stroke(255);
    rectMode(CENTER);
    rect(this.drawX,this.drawY,scaleFactor, scaleFactor);

    //ritar kopplingar

    this.drawConnections = function(){
        for (var i = 0; i < this.options.length; i++) {
          stroke(this.connectionColors[i]);
          print("pipi")
          line(this.drawX+i-5, this.drawY, this.connectionX, this.connectionY);

          this.connectionX =  this.options[i].values[i]*scaleFactor;
          this.connectionY =  this.options[i].values[i+1]*scaleFactor;

        }
    }


    noStroke();
    fill(255);
    textSize(this.textSize);
    this.displayText = "("+this.x+","+this.y+")";
    text(this.displayText, this.drawX-scaleFactor/2, this.drawY+this.textSize-scaleFactor/2);



  }
}
