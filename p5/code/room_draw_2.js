let roomBoxSize = 64; //helst delbar m 2
let spriteGridWidth = 3;
let spriteGridHeight = 3;

let canvasSize = {width: roomBoxSize*100, height: roomBoxSize*100 }

let topCoordinate = {x: -1, y: -1};
let activeRoom; //stores the active room Object.
let activeOptionGui;

let colors = {};

<<<<<<< HEAD
=======
let ableToCreateRoom;



>>>>>>> 358c90fdb6539c60a5065ee56281bfb2a481b9f2
let roomArrays;
let activeArea;
let activeRoomArray;
let activeRoomSpriteArray;

let guiBackgroundHidden = false;
let guiMouseIsOver = false;

let showCoordinatesHighlight = false;

let guiParent
let maxCommandValues = 4;
let maxOptionAmount = 5;

let generalGui;
let generalGuiParent;

let connectionColors;


function setup(){

  // Get rooms array
  roomArrays = {//kanske konstigt att kalla det sprites
    test: {rooms: [], sprites: [], lightColor: color(255), darkColor: color(51)},
    intro: {rooms: [], sprites: [], lightColor: color(214), darkColor: color(51)},
    highlands: {rooms: [], sprites: [], lightColor: color(208, 240, 156), darkColor: color(73, 117, 52)},
    bog: {rooms: [], sprites: [], lightColor: color(189, 172, 157), darkColor: color(66, 46, 33)},
    city: {rooms: [], sprites: [], lightColor: color(212, 207, 178), darkColor: color(120, 108, 41)},
    mountain: {rooms: [], sprites: [], lightColor: color(135,222,224), darkColor: color(64,106,107)},
    core: {rooms: [], sprites: [], lightColor: color(145, 42, 42), darkColor: color(36, 35, 35)}
  }

  activeArea = roomArrays.test;
  activeRoomArray = activeArea.rooms;
  activeRoomSpriteArray = activeArea.sprites;

  colors =
  {
    activeFillColor: color(255),
    activeStrokeColor: color(51),
    highlight: color(255,255,255,25),
    inactiveFillColor: color(51),
    inactiveStrokeColor: color(255)
  };

  connectionColors = [color(255, 0, 0), color(255, 255, 0), color(0, 255, 0), color(0, 255, 255), color(0, 0, 255)];

  createCanvas(canvasSize.width, canvasSize.height);

  guiParent = document.getElementById('guiBackground');
  guiParent.onmouseenter = function(){guiMouseIsOver = true;}
  guiParent.onmouseleave = function(){guiMouseIsOver = false;}

  generalGuiParent = document.getElementById('generalGuiBackground');
  generalGuiParent.onmouseenter = function(){guiMouseIsOver = true;}
  generalGuiParent.onmouseleave = function(){guiMouseIsOver = false;}

  createGeneralGui();

}

function draw(){



  background(activeArea.darkColor);
  drawZeroIndicator();
  drawSprites();
  drawConnections();

  highlightOverMouse();// borde bara göras där det går

}

function highlightOverMouse(){
  if(!guiMouseIsOver){
    hx = mouseX + (32-(mouseX%64));
    hy = mouseY + (32-(mouseY%64));
    fill(colors.highlight);
    noStroke();
    rectMode(CENTER);
    rect(hx,hy,roomBoxSize, roomBoxSize);
    if(showCoordinatesHighlight){
      indexCoordinates = screenToIndexCoordinates(hx,hy);
      fill(activeArea.darkColor);
      coordinateStr= "(" + indexCoordinates.x + ", " + indexCoordinates.y + ")"
      textSize(15);
      text(coordinateStr, hx-roomBoxSize/2+10,hy-roomBoxSize/2+25);
    };
  }
}

function keyPressed(){
  if(keyCode === TAB){
    window.scrollTo(floor(width/2-window.innerWidth/2),floor(height/2-window.innerHeight/2));
  }
}

function mousePressed(){
  if(activeRoom){ //kollar om något rum ens finns
    showValueAmountControl();
    optionShowControl();
  } //lite spray and pray måste nog inte kallas här

  onSprite = false;
  for (var i = 0; i < activeRoomSpriteArray.length; i++) { // borde göras bättre
    if(activeRoomSpriteArray[i].mouseIsOver){
      onSprite = true;
    }
  }
  if(!onSprite && !guiMouseIsOver){

    createRoom(mouseX + (roomBoxSize/2-(mouseX%roomBoxSize)), mouseY + (roomBoxSize/2-(mouseY%roomBoxSize)) ); //modulo skiten gör så att den hamnar på  sitt grid

  }


}

function mouseReleased(){ //funkar typ inte på mac??
  showValueAmountControl();
  optionShowControl(); //lite spray and pray måste nog inte kallas här

}

function drawZeroIndicator(){
  frX = floor(width/2) + (32-(floor(width/2)%64));
  frY = floor(height/2) + (32-(floor(height/2)%64));
  noFill();
  stroke(colors.highlight)
  rectMode(CENTER);
  rect(frX,frY,roomBoxSize, roomBoxSize);
  indexCoordinates = screenToIndexCoordinates(frX,frY);

  fill(colors.highlight);
  coordinateStr= "(" + indexCoordinates.x + ", " + indexCoordinates.y + ")"
  textSize(15);
  text(coordinateStr, frX-roomBoxSize/2+10,frY-roomBoxSize/2+25);
}

function createRoom(x, y){

  //ser till att den aktiva guin blir gömd när ett nytt rum skapas
  if(activeRoom && activeRoom.gui){
    showValueAmountControl();//kallas för den borde det och kommer typ kalla den på en massa ställen bara yolo
    optionShowControl(); //lite spray and pray måste nog inte kallas här
    activeRoom.gui.hide();
  }

  this.x = x;
  this.y = y;

  //dubbelkollar att rummet inte finns
  ableToCreateRoom = true;
  for (var i = 0; i < activeRoomSpriteArray.length; i++) {
    if(activeRoomSpriteArray[i].indexX == (this.x-floor(width/2)-roomBoxSize/2)/roomBoxSize && activeRoomSpriteArray[i].indexY ==  (this.y-floor(height/2)-roomBoxSize/2)/roomBoxSize){
      print("error: stupid code tried to make a room where one already existed");
      ableToCreateRoom = false;

    }
  }

  if(ableToCreateRoom){
    roomSprite = createSprite(this.x, this.y, roomBoxSize, roomBoxSize);
    roomSprite.active = false;
    roomSprite.indexX = (this.x-floor(width/2)-roomBoxSize/2)/roomBoxSize;
    roomSprite.indexY = (this.y-floor(height/2)-roomBoxSize/2)/roomBoxSize;

    roomSprite.depth = 1;

    roomSprite.exportRoom;

    roomSprite.optionGuis = [];


    roomSprite.optionObjs = [];
    for (var i = 0; i < maxOptionAmount; i++) {
      roomSprite.optionObjs.push({option_text: '', option_command: '', values: [] })
    }


    roomSprite.coordinateString = "(" + roomSprite.indexX + ", " + roomSprite.indexY + ")";

    if (guiBackgroundHidden) {
      guiBackground.show();
      guiBackgroundHidden =false;

    }
    roomSprite.gui =  QuickSettings.create(10, 10, "Room "+ roomSprite.coordinateString, guiParent);
    roomSprite.gui.setDraggable(false);
    roomSprite.gui.setWidth(250);
    roomSprite.gui.addTextArea('main_text', "");
    roomSprite.gui.addNumber('option_amount', 0,maxOptionAmount,0,1, function(value)
    {
      for (var i = 0; i < maxOptionAmount; i++) {
        roomSprite.optionGuis[i].hide()
      }
      for (var i = 0; i < value; i++) {
        roomSprite.optionGuis[i].show()
      }
    });
    roomSprite.gui.addButton('save',function(){saveRoom()});
    roomSprite.gui.addButton('delete',function(){deleteRoom()});


    for (var i = 1; i <= maxOptionAmount; i++) {
      roomSprite.optionGui = QuickSettings.create( 210*i+60,10,'option_'+i, guiParent).hide();//borde parenta till en egen.
      roomSprite.optionGui.setDraggable(false);
      roomSprite.optionGui.addText('option_text', '' );
      roomSprite.optionGui.addDropDown('option_command', ['','move', 'info']);

      for (var j = 0; j < maxCommandValues; j++) {
        roomSprite.optionGui.addText('command_value_'+j);
        roomSprite.optionGui.hideControl('command_value_'+j);
      }

      roomSprite.optionGuis.push(roomSprite.optionGui);
    }

    roomSprite.draw = function(){
      rectMode(CENTER);

      if(this.active){
        fillColor = activeArea.lightColor
        strokeColor = activeArea.darkColor
      }
      if(!this.active){
        fillColor = activeArea.darkColor
        strokeColor = activeArea.lightColor
      }
      fill(fillColor);
      stroke(strokeColor);
      rect(0,0, roomBoxSize, roomBoxSize);
      textSize(15);
      noStroke();
      fill(strokeColor);
      text(this.coordinateString, -roomBoxSize/2+10,-roomBoxSize/2+25)


    }
    roomSprite.onMousePressed = function(){ //maybe this is retarded and should be called in mousePressed() instead

      if(activeRoom){
        activeRoom.gui.hide();

      }
      // TODO: Måste kallas på fler ställen
      if (activeOptionGui!=null) {
        for (var i = 0; i < maxOptionAmount; i++) {
          activeOptionGui[i].hide();
        }
        for (var i = 0; i < this.gui.getValue('option_amount'); i++) {
          this.optionGuis[i].show();
        }
      }


      this.gui.show();
      activeRoom.active = false;
      activeRoom = this;
      activeRoom.active = true;
      activeOptionGui = this.optionGuis;//väldigt slarvigt borde sättas ihop m activeRoom
      //if(this.roomObj === null){
      //  this.roomObj = new room(this.indexX, this.indexY, this.mainText, this.options);
      //}
    }

    roomSprite.debug = false;

    //roomSprite.indexX = j;
    //roomSprite.indexY = i;
    if(activeRoom){activeRoom.active = false;}
    activeRoom = roomSprite;
    activeRoom.active = true;
    activeRoomSpriteArray.push(roomSprite);

  }
}

function addOptionGuis(roomSprite){
}

function saveRoom(){
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
    activeRoomArray.push(activeRoom.exportRoom);

  }else if(activeRoom.exportRoom){ //uppdaterar objektet om det redan finns

    for (var i = 0; i < activeRoomArray.length; i++) {
      if (activeRoomArray[i].x == activeRoom.indexX && activeRoomArray[i].y == activeRoom.indexY) {
        activeRoomArray[i].mainText = activeRoom.gui.getValue('main_text');
        for (var j = 0; j < activeRoom.optionGuis.length; j++) {
          activeRoomArray[i].options[j].text = activeRoom.optionGuis[j].getValue('option_text')
          activeRoomArray[i].options[j].command = activeRoom.optionGuis[j].getValue('option_command').value
          for (var k = 0; k < maxCommandValues; k++) {
            activeRoomArray[i].options[j].values[k] = activeRoom.optionGuis[j].getValue('command_value_'+k);
          }
        }

        break;
      }
    }
  }

}

function deleteRoom(){
  print(activeRoom);
  print(activeRoomSpriteArray);
  for (var i = 0; i < activeRoomArray.length; i++) {
    if(activeRoomArray[i].x == activeRoom.indexX && activeRoomArray[i].y == activeRoom.indexY){
      print("presplice: "+activeRoomArray.length)
      activeRoomArray.splice(i,1);
      print("postsplice: "+activeRoomArray.length)
      break;
    }
  }
  for (var i = 0; i < activeRoomSpriteArray.length; i++) {
    if(activeRoomSpriteArray[i].indexX == activeRoom.indexX && activeRoomSpriteArray[i].indexY == activeRoom.indexY){
      activeRoom.gui.hide();
      for (var j = 0; j < activeRoom.optionGuis.length; j++) {
        activeRoom.optionGuis[j].hide();
      }
      print("presplice sprite: "+activeRoomSpriteArray.length)

      activeRoom.remove();
      activeRoomSpriteArray.splice(i,1);
      print("postsplice sprite: "+activeRoomSpriteArray.length)
      break;
    }
  }

}
// TODO: make littlebit nicer looking
function drawConnections(){
  for (var i = 0; i < activeRoomSpriteArray.length; i++) {
    for (var j = 0; j < activeRoomSpriteArray[i].optionGuis.length; j++) {
      if(activeRoomSpriteArray[i].optionGuis[j].getValue('option_command').value == "move"){
        stroke(connectionColors[j]);
        //tar in koordinaterna från values delen
        connection = indexToScreenCoordinates(
          Number(activeRoomSpriteArray[i].optionGuis[j].getValue('command_value_'+0)), Number(activeRoomSpriteArray[i].optionGuis[j].getValue('command_value_'+1))
        );
        if(connection.x!=null && connection.y != null
        ){

          line(activeRoomSpriteArray[i].position.x-10+j*4, activeRoomSpriteArray[i].position.y-10+j*4, connection.x-10+j*4, connection.y-10+j*4)

        }
      }
    }
  }
}

function createGeneralGui(){
  generalGui = QuickSettings.create( 0,0,'Settings', generalGuiParent);
  generalGui.setDraggable(false);
  generalGui.addButton('center (tab)', function(){window.scrollTo(floor(width/2-window.innerWidth/2),floor(height/2-window.innerHeight/2));});
  generalGui.addDropDown('area' ,['test','intro', 'highlands', 'bog', 'city', 'mountain', 'core'], function(value){
      for (var i = 0; i < 7; i++) { //om det går borde man hämta antal värden i objektet istället för att hårdkoda 7
        if (i == value.index){

          for (var j= 0; j < activeRoomSpriteArray.length; j++) {
            activeRoomSpriteArray[j].depth = 0; //allt det här är dåligt gjort kommer finnas en massa sprites som är osynliga hela tiden
            activeRoomSpriteArray[j].mouseActive = false;
            activeRoomSpriteArray[j].visible = false;
          }
          activeArea = roomArrays[value.value];
          activeRoomArray = activeArea.rooms;
          activeRoomSpriteArray = activeArea.sprites;

          for (var j= 0; j < activeRoomSpriteArray.length; j++) {
            activeRoomSpriteArray[j].depth = 1;
            activeRoomSpriteArray[j].mouseActive = true;
            activeRoomSpriteArray[j].visible = true;
          }

        }
      }



  } );
  generalGui.addBoolean('show_all_connections',false, function(value){
    // TODO: toggla mellan att visa alla rumskopplingar och bara visa för de som är selected.
  });
  generalGui.addBoolean('highlight_coordinates',false,  function(value){
    showCoordinatesHighlight = value;
  });
  generalGui.addButton('upload', function(){
    // TODO: spara nuvarande arrays till databasen
    saveRooms(roomArrays.test.rooms);
  })

}




function indexToScreenCoordinates(indexX, indexY){
  x = indexX*roomBoxSize+floor(width/2)+roomBoxSize/2
  y = indexY*roomBoxSize+floor(height/2)+roomBoxSize/2
  return {x: x, y: y};
}

function screenToIndexCoordinates(screenX, screenY){
  x = (screenX-floor(width/2)-roomBoxSize/2)/roomBoxSize
  y = (screenY-floor(height/2)-roomBoxSize/2)/roomBoxSize
  return {x: x, y: y};
}

//kollar hur många values som ska visas för det aktiva rummet

function optionShowControl(){
  for (var i = 0; i < maxOptionAmount; i++) {
    activeRoom.optionGuis[i].hide();
  }
  for (var i = 0; i < activeRoom.gui.getValue('option_amount'); i++) {
    activeRoom.optionGuis[i].show();
  }
}

function showValueAmountControl(){
  //snuskigaste koden jag har skrivit på ett tag men den får va här tills jag fattar hur quicksettings divvarna går att ändra på.
  if (activeRoom) {
    for (var i = 0; i < activeRoom.optionGuis.length; i++) {
      showAmount = 0;
      switch (activeRoom.optionGuis[i].getValue('option_command').value) {

        case '':
          break;
        case 'move':
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
