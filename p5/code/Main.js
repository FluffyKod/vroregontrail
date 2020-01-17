
var displayedOptions = [];
var currentoption;
var optionlength;
var maxOptionLength = 5;
var rooms = [];
var load;
var grandparent;
var canvas;
var write = true; //kontrollerar om det som står i rummet ska skrivas eller inte
var player;
var gameOver;
var startSc;
var drawText;
var drawCanvas;

var define = true;
var clearVar = false;

var texttest;
var counter;

var textbox;

//minigame-switch variables;
var current_encounter;


//ljud
var blip;
var soundEnabled;

var keypressed = false;
var timer;

////////////////////////////////////////////
// SETUP
////////////////////////////////////////////

function setup(){

  loadRooms(function(returnedRooms) {
    rooms = returnedRooms;

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

    // Set id for the displayed options
    displayedOptions.push(new option('#option-1'));
    displayedOptions.push(new option('#option-2'));
    displayedOptions.push(new option('#option-3'));
    displayedOptions.push(new option('#option-4'));
    displayedOptions.push(new option('#option-5'));


    textbox = select('#textbox');
    textbox.html("")

    // saveRooms(rooms);
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

    // Check which encounter is chosen
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
    displayedOptions[currentoption].command();
    currentoption = 0;
    load = false;


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
}

////////////////////////////////////////////
// OPTION CLASS
////////////////////////////////////////////

function option(ref){
  this.ref = select(ref);

  this.text = 'test';
  this.ref.html(this.text);

  this.cmd;
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
  this.command = function() {

      // Give player an item
      if(this.cmd == 'item'){
        // Check that there are enough values
        if (this.values.length >= 1) {
          player.invertory.push(this.values[0]);
        } else {
          console.log('ERROR: Not enough values supplied to item command');
        }

      }

      // Start a new game
      if(this.cmd == 'encounter'){

        // Check that there are enough values
        if (this.values.length >= 2) {
          current_encounter = this.values[0]
          define = true;
          clearVar = false;
          startSc = true;
          gameOver = true;
          score = 0;
          if(this.values[1]){fr_hard = true;}//slarvigt måste ändras
          if(!this.values[1]){er_hard = true;}
          switchToEncounter();
        } else {
          console.log('ERROR: Not enough values supplied to encounter command');
        }

      }

      // Move player to new location
      if(this.cmd == 'tp'){

        // Check that there are enough values
        if (this.values.length >= 2) {
          write = true;
          player.x = this.values[0];
          player.y = this.values[1];
        } else {
          console.log('ERROR: Not enough values supplied to tp command');
        }

      }

      // if(this.cmd == 'stat'){
      //
      // }
      if(this.cmd == 'info'){

        // Check that there are enough values
        if (this.values.length >= 1) {
          textbox.html(this.values[0]);
          write = false;
        } else {
          console.log('ERROR: Not enough values supplied to info command');
        }

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

      displayedOptions[i].cmd = this.options[i].cmd;

      displayedOptions[i].values = this.options[i].values;

  }

  }
}

  function typing(divId, inputtext){
    this.divId = divId;

    if (counter < inputtext.length) {
      document.getElementById(this.divId).innerHTML += inputtext.charAt(counter);
      counter++

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
  for (var i = 0; i < displayedOptions.length; i++) {
    displayedOptions[i].unhighlight();
  }
  if(keypressed && timer < 600){
    timer++;
    displayedOptions[currentoption].highlight();
  }

  // Goes through every room to find the room the current player is in
  for (var i = 0; i < rooms.length; i++) {
    if(player.x == rooms[i].x && player.y == rooms[i].y){
      if(write){
        typing("textbox", rooms[i].mainText);
      }
      if(!load){
        rooms[i].load();// borde kanske inte uppdateras
        load = true;
      }
    }

  }

}
