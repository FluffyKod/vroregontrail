let roomBoxSize = 64; //helst delbar m 2
let spriteGridWidth = 3;
let spriteGridHeight = 3;

let canvasSize = {width: roomBoxSize*100, height: roomBoxSize*100 }

let topCoordinate = {x: -1, y: -1};
let activeRoom;
let activeOptionGui;

let colors = {};

let rooms = [];
let roomSprites = [];

let guiBackgroundHidden = false;
let guiMouseIsOver = false;

let guiParent

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
  roomSprite.coordinateString = "(" + roomSprite.indexX + ", " + roomSprite.indexY + ")";

  if (guiBackgroundHidden) {
    guiBackground.show();
    guiBackgroundHidden =false;

  }
  roomSprite.gui =  QuickSettings.create(10, 10, "Room "+ roomSprite.coordinateString, guiParent);
  roomSprite.gui.addTextArea('main_text', "", function(){})
  roomSprite.gui.addNumber('option_amount', 0,5,0,1, function(value)
  {
    for (var i = 0; i < 5; i++) {
      roomSprite.optionGuis[i].hide()
    }
    for (var i = 0; i < value; i++) {
      roomSprite.optionGuis[i].show()
    }
  });
  roomSprite.gui.addButton('revert_changes', function(){
    //GET VALUES AND PUT IN FROM ROOM ARRAY
  });
  roomSprite.gui.addButton('save', function(){
    //CREATE/ UPDATE ROOM OBJECT HERE WITH VALUES
  });


  roomSprite.optionGuis = [];

  for (var i = 1; i <= 5; i++) {
    roomSprite.optionGui = QuickSettings.create( 210*i+10,10,'option_'+i, guiParent).hide();
    roomSprite.optionGui.addText('opt_text',"");
    roomSprite.optionGui.addDropDown('option_command', ['','tp', 'info'], function(value){
      valuesRequired = 0;
      print(value.value)
      switch (value.value) {
        case 'tp':
          valuesRequired = 2
          print(valuesRequired)
          break;

      };
      for (var j = 0; j < valuesRequired; j++) {
        roomSprite.optionGui.addText('value_'+j, ""); //OBSfungerar inte eftersom den måste veta index
        print('que')
      }
    });
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

    if(activeRoom!= null){
      activeRoom.hide();

    }

    if (activeOptionGui!=null) {
      for (var i = 0; i < 5; i++) {
        activeOptionGui[i].hide();
      }
      for (var i = 0; i < this.gui.getValue('option_amount'); i++) {
        this.optionGuis[i].show();
      }
    }


    this.gui.show();
    activeRoom = this.gui;
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
