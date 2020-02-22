let roomBoxSize = 64; //helst delbar m 2
let spriteGridWidth = 3;
let spriteGridHeight = 3;

let canvasSize = {width: roomBoxSize*100, height: roomBoxSize*100 }

let topCoordinate = {x: -1, y: -1};
let activeRoom; //stores the active room Object.
let activeOptionGui;

let colors = {};

let rooms = [];
let roomSprites = [];

let guiBackgroundHidden = false;
let guiMouseIsOver = false;

let guiParent
let maxCommandValues = 4;
let maxOptionAmount = 5;

function setup(){
  colors =
  {
    fillColor: color(51),
    strokeColor: color(255),
    highlight: color(255,255,255,25),
    inactiveFillColor: color(51)
  };

  createCanvas(canvasSize.width, canvasSize.height);

  guiParent = document.getElementById('guiBackground');
  guiParent.onmouseenter = function(){guiMouseIsOver = true;}
  guiParent.onmouseleave = function(){guiMouseIsOver = false;}

  createFirstRoom();


  print(roomSprites);
  Camera(floor(width/2),floor(height/2))
}

function draw(){

  background(colors.inactiveFillColor);
  drawSprites();

  highlightOverMouse();// borde bara göras där det går

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
  if(!onSprite && !guiMouseIsOver){ //borde bli en låda
    createRoom(mouseX + (roomBoxSize/2-(mouseX%roomBoxSize)), mouseY + (roomBoxSize/2-(mouseY%roomBoxSize)) ); //modulo skiten gör så att den hamnar på  sitt grid
  }


}

function mouseReleased(){
  //snuskigaste koden jag har skrivit på ett tag men den får va här tills jag fattar hur quicksettings divvarna går att ändra på.
  if (activeRoom) {
    for (var i = 0; i < activeRoom.optionGuis.length; i++) {
      showAmount = 0;
      switch (activeRoom.optionGuis[i].getValue('option_command').value) {

        case '':
          break;
        case 'tp':
          showAmount = 2;
          break;
        case 'info':
          showAmount = 1;
          break;
      }
      for (var j = 0; j < maxCommandValues; j++) {
        activeRoom.optionGuis[i].hideControl('command_value_'+j);
      }
      for (var j = 0; j < showAmount; j++) {
        activeRoom.optionGuis[i].showControl('command_value_'+j);
      }
    }
  }

}

function createFirstRoom(){
    drawCoordinate = {x: floor(width/2)+roomBoxSize/2, y: floor(height/2)+roomBoxSize/2};
    createRoom(drawCoordinate.x, drawCoordinate.y);
    roomSprites[0].gui.hide();
}


function createRoom(x, y){
  this.x = x;
  this.y = y;

  roomSprite = createSprite(this.x, this.y, roomBoxSize, roomBoxSize);
  roomSprite.active = true;
  roomSprite.indexX = (this.x-floor(width/2)-roomBoxSize/2)/roomBoxSize;
  roomSprite.indexY = (this.y-floor(height/2)-roomBoxSize/2)/roomBoxSize;
  roomSprite.exportRoom;

  roomSprite.optionObjs = [];
  for (var i = 0; i < maxOptionAmount; i++) {
    roomSprite.optionObjs.push({option_text: '', option_command: '', values: [] })
  }
  roomSprite.roomObj = {x: roomSprite.indexX , y: roomSprite.indexY , main_text: "", options: roomSprite.optionObjs }

  roomSprite.coordinateString = "(" + roomSprite.indexX + ", " + roomSprite.indexY + ")";

  if (guiBackgroundHidden) {
    guiBackground.show();
    guiBackgroundHidden =false;

  }
  roomSprite.gui =  QuickSettings.create(10, 10, "Room "+ roomSprite.coordinateString, guiParent);
  roomSprite.gui.bindTextArea('main_text', "", roomSprite.roomObj);
  roomSprite.gui.addNumber('option_amount', 0,maxOptionAmount,0,1, function(value)
  {
    for (var i = 0; i < maxOptionAmount; i++) {
      roomSprite.optionGuis[i].hide()
    }
    for (var i = 0; i < value; i++) {
      roomSprite.optionGuis[i].show()
    }
  });
  roomSprite.gui.addButton('save',function(){saveRoom();});

  roomSprite.optionGuis = [];

  for (var i = 1; i <= maxOptionAmount; i++) {
    roomSprite.optionGui = QuickSettings.create( 210*i+10,10,'option_'+i, guiParent).hide(); //borde parenta till en egen.
    roomSprite.optionGui.bindText('option_text', '' , roomSprite.roomObj);
    roomSprite.optionGui.addDropDown('option_command', ['','tp', 'info']);

    for (var j = 0; j < maxCommandValues; j++) {
      roomSprite.optionGui.addText('command_value_'+j);
      roomSprite.optionGui.hideControl('command_value_'+j);
    }
    roomSprite.optionGuis.push(roomSprite.optionGui);
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

    if(activeRoom){
      activeRoom.gui.hide();

    }

    if (activeOptionGui!=null) {
      for (var i = 0; i < maxOptionAmount; i++) {
        activeOptionGui[i].hide();
      }
      for (var i = 0; i < this.gui.getValue('option_amount'); i++) {
        this.optionGuis[i].show();
      }
    }


    this.gui.show();
    activeRoom = this;
    activeOptionGui = this.optionGuis;//väldigt slarvigt borde sättas ihop m activeRoom
    //if(this.roomObj === null){
    //  this.roomObj = new room(this.indexX, this.indexY, this.mainText, this.options);
    //}
  }

  roomSprite.debug = false;

  //roomSprite.indexX = j;
  //roomSprite.indexY = i;

  roomSprites.push(roomSprite);


}
function addOptionGuis(roomSprite){
  print(roomSprite.gui.getValue('option_amount'));
}


function saveRoom(){
  print(rooms);
  if (!activeRoom.exportRoom) {
    activeRoom.exportRoom = new room(activeRoom.indexX, activeRoom.indexY, activeRoom.gui.getValue('main_text'), [

    ])
    //save option object
    for (var i = 0; i < activeRoom.optionGuis.length; i++) {
      option = {
        text: activeRoom.optionGuis[i].getValue('option_text'),
        command: activeRoom.optionGuis[i].getValue('option_command').value,
        values: []
        }
      for (var j = 0; j < maxCommandValues; j++) {
        option.values.push(activeRoom.optionGuis[i].getValue('command_value_'+j)) //sparar onödigt många värden men yolo

      }
      activeRoom.exportRoom.options.push(option);
    }
    print(activeRoom.exportRoom);
    rooms.push(activeRoom.exportRoom);

  }else if(activeRoom.exportRoom){ //uppdaterar objektet om det redan finns

    for (var i = 0; i < rooms.length; i++) {
      if (rooms[i].x == activeRoom.indexX && rooms[i].y == activeRoom.indexY) {
        print(rooms[i]);
        rooms[i].mainText = activeRoom.gui.getValue('main_text');
        for (var j = 0; j < activeRoom.optionGuis.length; j++) {
          rooms[i].options[j].text = activeRoom.optionGuis[j].getValue('option_text')
          rooms[i].options[j].command = activeRoom.optionGuis[j].getValue('option_command').value
          for (var k = 0; k < maxCommandValues; k++) {
            rooms[i].options[j].values[k] = activeRoom.optionGuis[j].getValue('command_value_'+k);
          }
        }
        print("new")
        print(rooms[i]);

        break;
      }
    }
  }

}

function loadRoom(){
  //borde kunna ladda in en room.js dokument och visualisera den.
  
}
