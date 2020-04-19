
let displayedOptions = [];
let currentoption;
let optionlength;
let maxOptionLength = 5;
let rooms = [];

// All rooms
let allAreaRooms;

let load;
let grandparent;
let canvas;
let write = true; //kontrollerar om det som står i rummet ska skrivas eller inte
var gameOver;
var startSc;
var drawText;
let drawCanvas;

var player;
let currentRoom;
let currentArea = 'test';

let define = true;
let clearVar = false;

let texttest;
let counter;

let textbox;

//minigame-switch variables;
let current_encounter;

//ljud
let blip;
let soundEnabled;

let keypressed = false;
let timer;

// GAME ASSETS
let backgrounds = {
  highlandsMain: 'highlands-general.jpg',
  introMain: 'village.png'
}

let music = {
  highlandsAmbient: 'http://vroregon.local/wp-content/uploads/highlands-ambient.mp3'
}

////////////////////////////////////////////
// SETUP
////////////////////////////////////////////



function setup(){

  // Get all saved rooms from the database
  loadRoomsFromDatabase(currentArea, function(returnedRooms) {


    // Set all rooms
    allAreaRooms = returnedRooms;

    // Set the current room array
    rooms = getRoomsFromArea( returnedRooms, currentArea );

    defineCanvas();
    grandparent = select('#grandparent');

    drawText = true;
    soundEnabled = false;
    optionlength = 1;
    load = false;
    counter = 0;

    timer = 0;

    // Create the player
    player = new player();

    // Update player stats from the database
    getPlayer();

    currentRoom = findRoomWithPlayer();

    // Set id for the displayed options
    displayedOptions.push(new option('#option-1'));
    displayedOptions.push(new option('#option-2'));
    displayedOptions.push(new option('#option-3'));
    displayedOptions.push(new option('#option-4'));
    displayedOptions.push(new option('#option-5'));

    textbox = select('#textbox');
    textbox.html("")

    updateDebug();

  });



}

////////////////////////////////////////////
// MAIN GAME LOOP
////////////////////////////////////////////

function draw(){

  if(drawText){
    drawTextbox();
  }
  if(drawCanvas){

    // TODO: Borde lagras i en "aktiv encounter"
    switch (current_encounter) {
      case 'flappy_river':
        if(define){fr_defineVar(); define= false;}
        fr_draw();
        break;
      case 'card_game':
        if(define){cg_defineVar(); define= false;}
        cg_draw();
        break;
      case 'ernst_running':
        if(define){er_defineVar(); define= false;}
        er_draw();
        break;
      case 'ddr':
        if(define){ddr_defineVar(); define= false;}
        ddr_draw();
        break;
      case 'mountain_jump':
        if(define){mj_defineVar(); define = false;}
        mj_draw();
        break;
      case 'wasp_invaders':
        if(define){i_defineVar(); define= false}
        i_draw();
        break;
      case 'frog_king':
        break;
      case 'pepes_bread':
        if(define){pb_defineVar(); define = false;}

        pb_draw();
        break;
      case 'sheep_invaders':

        break;
      case 'wasp_attack':

        break;
    }
  }
}

////////////////////////////////////////////
// KEY PRESSED
////////////////////////////////////////////

function keyPressed(){
  timer = 0;

  if(!keypressed){
    // Set the current selected option by the player to no one
    // currentoption 1 is the first option, 2 is second etc.
    currentoption = 0;
    keypressed = true;
  }
  if(keyCode == UP_ARROW){
    if(currentoption > 0){
      currentoption -= 1;
    }else {
      currentoption = optionlength-1;
    }

  }
  if(keyCode == DOWN_ARROW){
    if(currentoption < optionlength-1){
      currentoption += 1;
    }else {
      currentoption = 0;
    }


  }
  if(keyCode == ENTER){
    textbox = select('#textbox');
    textbox.html("")
    counter = 0;
    displayedOptions[currentoption].runCommand();
    currentoption = 0;
    load = false;

    // SAVE PLAYER PROGRESS
    savePlayer()

    // DEBUG
    updateDebug();

    }
  if(keyCode == SHIFT && !soundEnabled){
    blip = loadSound("menu_blip.wav")
    soundEnabled = true;
  }


  }

////////////////////////////////////////////
// PLAYER CLASS
////////////////////////////////////////////

function player(){
  // Keep track of which room the player is in
  this.x = 0;
  this.y = 0;

  // Track stats
  this.inventory = [];
  this.intellegence = 0;
  this.charisma = 0;
  this.grit = 0;
  this.kindness = 0;
  this.area = currentArea;
  this.background = backgrounds.highlandsMain;
  this.music = music.highlandsAmbient;

}

////////////////////////////////////////////
// AREA FUNCTIONS
////////////////////////////////////////////
function changeBackgroundImage( fileName ) {

  // Get path to the game-assets/backgrounds/ folder
  let backgroundAssetFolder = document.getElementById('game-asset-folder').innerText + 'backgrounds/';

  // Get the html element which displays the image
  let backgroundElement = document.getElementById('background-image');

  // Create full filepath
  let newImagePath = backgroundAssetFolder + fileName;

  // Update player info
  player.background = fileName;

  // Set new background image
  backgroundElement.src = newImagePath;

  // console.log('SUPPLIED FILENAME: ', fileName);
  // console.log('BACKGROUND ELEMENT SRC:', backgroundElement.src);

}

function getBackgroundImageFromArea( area ) {

  let imageName = backgrounds.highlandsMain;

  switch (area) {
    case 'highlands':
      imageName = backgrounds.highlandsMain;
      break;

    case 'intro':
      imageName = backgrounds.introMain;
      break;

    default:
      imageName = backgrounds.highlandsMain;
  }

  return imageName;

}

function changeArea() {

  // Update player
  player.area = currentArea;

  // Set rooms to new area rooms
  rooms = getRoomsFromArea( allAreaRooms, currentArea );

  // Change background image
  let newAreaImage = getBackgroundImageFromArea( currentArea );
  changeBackgroundImage( newAreaImage );

  // Change music

}

////////////////////////////////////////////
// OPTION CLASS
////////////////////////////////////////////

function option(ref){
  this.ref = select(ref);

  this.text = 'test';
  this.ref.html(this.text);

  this.command;
  this.values;

  this.highlight = function(){
      this.ref.style('background-color','#fff');
      this.ref.style('padding-color', '#fff');
      this.ref.style('color','#80a4b2');

      if(soundEnabled) {blip.play();}
  }
  this.unhighlight = function(){
      this.ref.style('background-color','#80a4b2');
      this.ref.style('padding-color', '#80a4b2');
      this.ref.style('color','#fff');
  }

  this.addItemToInventory = function(suppliedValues) {
    // Check if there is enough values
    if (suppliedValues.length >= 1) {
      player.inventory.push(suppliedValues[0]);
      updateInventoryGui();

    } else {
      console.log('ERROR: Not enough values supplied to item command');
    }
  }
  this.moveToNewPlace = function(suppliedValues) {
    // Check that there are enough values
    if (suppliedValues.length >= 2) {
      write = true;
      player.x = Number(suppliedValues[0]);
      player.y = Number(suppliedValues[1]);
      currentRoom = findRoomWithPlayer();
    } else {
      console.log('ERROR: Not enough values supplied to move command');
    }
  }
  this.writeInfo = function(suppliedValues) {
    // Check that there are enough values
    if (suppliedValues.length >= 1) {
      textbox.html(suppliedValues[0]);
      write = false;
    } else {
      console.log('ERROR: Not enough values supplied to info command');
    }
  }
  this.switchToArea = function(suppliedValues) {
    if (suppliedValues.length >= 1) {
      // switch area
      currentArea = suppliedValues[0];

      changeArea();

    } else {
      console.log('ERROR: Not enough values supplied to switcharea command');
    }
  }
  this.doEncounter = function(suppliedValues) {
    // Check that there are enough values
    if (suppliedValues.length >= 2) {
      current_encounter = suppliedValues[0]
      define = true;
      clearVar = false;
      startSc = true;
      gameOver = true;
      score = 0;
      if(suppliedValues[1]){fr_hard = true;}//slarvigt måste ändras
      if(!suppliedValues[1]){er_hard = true;}
      switchToEncounter();
    } else {
      console.log('ERROR: Not enough values supplied to encounter command');
    }
  }
  this.giveStat = function(suppliedValues) {
    if (suppliedValues.length >= 2) {
      if (suppliedValues[0] == 'intelligence') {
        player.intellegence += Number(suppliedValues[1])
        updateStatGui('intelligence')
      }
      if (suppliedValues[0] == 'charisma') {
        player.charisma += Number(suppliedValues[1])
        updateStatGui('charisma')
      }
      if (suppliedValues[0] == 'grit') {
        player.grit += Number(suppliedValues[1])
        updateStatGui('grit')
      }
      if (suppliedValues[0] == 'kindness') {
        player.kindness += Number(suppliedValues[1])
        updateStatGui('kindness')
      }

    } else {
      console.log('ERROR: Not enough values supplied to giveIntelligence command');
    }
  }

  this.runCommand = function() {

      // SINGLE COMMANDS

      // Give player an item
      if(this.command == 'item'){
        this.addItemToInventory(this.values)
      }

      // Move player to new location
      if(this.command == 'move'){
        this.moveToNewPlace(this.values)
      }

      // Write out info
      if(this.command == 'info'){
        this.writeInfo(this.values)
      }

      // Switch to a new area
      if (this.command == 'switchArea'){
        this.switchToArea(this.values)
      }

      // Start a new game
      if(this.command == 'encounter'){
        this.doEncounter(this.values)
      }

      // Give stats
      if(this.command == 'giveStat'){
        this.giveIntelligence(this.values);
      }

      // ******************
      // COMPOSITE COMMANDS
      // ******************

      // (x, y), item to add to inventory
      if(this.command == 'move-item'){
        this.moveToNewPlace(this.values.slice(0, 2));
        this.addItemToInventory(this.values.slice(2));

      }

      // (z, y), item, new area
      if(this.command == 'move-item-switchArea'){
        this.moveToNewPlace(this.values.slice(0, 2));
        this.addItemToInventory(this.values.slice(2, 3));
        this.switchToArea(this.values.slice(3, 4));

      }

      // (x, y), (stat, change)
      if(this.command == 'move-stat'){
        this.moveToNewPlace(this.values.slice(0, 2));
        this.giveStat(this.values.slice(2));
      }

      // info, (stat, change)
      if(this.command == 'info-stat'){
        this.writeInfo(this.values.slice(0, 1));
        this.giveStat(this.values.slice(1));
      }

      // info, item
      if(this.command == 'info-item'){
        this.writeInfo(this.values.slice(0, 1));
        this.addItemToInventory(this.values.slice(1));
      }

      // (x, y), new area name
      if(this.command == 'move-switchArea'){
        this.moveToNewPlace(this.values.slice(0, 2));
        this.switchToArea(this.values.slice(2));

      }

      // (x, y), new background name
      if(this.command == 'move-background'){
        this.moveToNewPlace(this.values.slice(0,2));
        changeBackgroundImage(this.values.slice(2)[0]);
      }

      // (x,y), background name, music name
      if(this.command == 'move-background-music'){
        this.moveToNewPlace(this.values.slice(0,2));
        changeBackgroundImage(this.values.slice(2,3)[0]);
        // changeMusic(this.values.slice(3,4)[0]);
      }
  }

}

////////////////////////////////////////////
// ROOM CLASS
////////////////////////////////////////////

function Room( x, y, mainText, options ){

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

      displayedOptions[i].command = this.options[i].command;

      displayedOptions[i].values = this.options[i].values;

    }

  }
}

  function typing(divId, inputtext){

    this.divId = divId;

    if (counter < inputtext.length) {
      document.getElementById(this.divId).innerHTML += inputtext.charAt(counter);
      counter++
    } else {
      write = false;
    }

  }

  function switchToEncounter(){
    drawText = false;
    drawCanvas = true;
    grandparent.hide();
    canvas.show();

  }
  function switchToText(){
    drawText = true;
    drawCanvas = false;
    grandparent.show();
    canvas.hide();

  }


function defineCanvas(){
  canvas = createCanvas(600, 600);
  canvas.style('position: static')
  canvas.style('margin: auto')
  canvas.style('margin-top: 140px')

  canvas.class('box');
  canvas.hide();

}


function drawTextbox(){

  // ALL OF THIS IS CALLED SEVERAL TIMES A SECOND: NEED FOR LOOPS EVERY TIME??

  for (var i = 0; i < displayedOptions.length; i++) {
    displayedOptions[i].unhighlight();
  }

  if(keypressed && timer < 600){
    timer++;
    displayedOptions[currentoption].highlight();
  }

  // IT WORKS WITHOUT THE CODE BELOW
  // for (var i = 0; i < rooms.length; i++) {
  //   if(write){
  //     typing("textbox", rooms[i].mainText);
  //   }
  //   if(!load && currentRoom){
  //     currentRoom.load();
  //     load = true;
  //   }
  //
  // }

  if (write) {
    typing('textbox', currentRoom.mainText);
  }

  if(!load && currentRoom){
    currentRoom.load();
    load = true;
  }


}

function findRoomWithPlayer(){
  for (var i = 0; i < rooms.length; i++) {
    if(player.x == rooms[i].x && player.y == rooms[i].y){
      return rooms[i];
      break;
    }
  }
}

function resetTextbox() {
  write = true;
  currentRoom = findRoomWithPlayer();
  currentRoom.load();
  textbox = select('#textbox');
  textbox.html("")
  counter = 0;
  currentoption = 0;
  load = false;
  typing('textbox', currentRoom.mainText);
  drawTextbox();
}


function changeRoom( area, x, y ) {

  // Set the properties
  currentArea = area;
  player.area = area;
  changeArea();

  rooms = getRoomsFromArea( allAreaRooms, currentArea );

  player.x = x;
  player.y = y;

  // Set current room
  currentRoom = findRoomWithPlayer();
  currentRoom.load();

  // Update gui
  resetTextbox()

  // Save to database
  savePlayer();

}


function changeRoomDebug() {

  const switchAreaElement = document.getElementById('switch-area');
  const switchArea = switchAreaElement.options[switchAreaElement.selectedIndex].text;

  const switchX = document.getElementById('switch-x').value;
  const switchY = document.getElementById('switch-y').value;

  // Got all values
  if (switchArea && switchX && switchY) {
    changeRoom(switchArea, switchX, switchY);
  }

}

function resetPlayer() {

  // Keep track of which room the player is in
  player.x = 0;
  player.y = 0;

  // Track stats
  player.inventory = [];
  player.intellegence = 0;
  player.charisma = 0;
  player.grit = 0;
  player.kindness = 0;
  player.area = currentArea;
  player.background = backgrounds.highlandsMain;
  player.music = music.highlandsAmbient;

  currentArea = 'test';
  rooms = getRoomsFromArea( allAreaRooms, currentArea );
  changeRoom( 'test', 0, 0 );
  player.background = backgrounds.highlandsMain;

  changeBackgroundImage( player.background );

  resetTextbox();

  updateDebug();

  savePlayer();

  location.reload();
  return false;

}

function updateDebug() {
  const roomInfo = document.getElementById('room-info');
  roomInfo.innerText = `${player.area}: (${player.x}, ${player.y})`;
}

function updateInventoryGui() {
  const inventoryUl = document.getElementById('inventory');

  // Remove all children
  inventoryUl.innerHTML = '';

  // Add a list item for every inventory item
  for (const item of player.inventory) {
    var li = document.createElement("li");
    li.appendChild(document.createTextNode(item));
    inventoryUl.appendChild(li);
  }
}

function updateStatGui(stat = '', all = false) {

  if (stat == 'intelligence' || all == true) {
    document.getElementById('intelligence').innerText = player.intellegence;
  }
  if (stat == 'charisma' || all == true) {
    document.getElementById('charisma').innerText = player.charisma;
  }
  if (stat == 'grit' || all == true) {
    document.getElementById('grit').innerText = player.grit;
  }
  if (stat == 'kindness' || all == true) {
    document.getElementById('kindness').innerText = player.kindness;
  }

}
