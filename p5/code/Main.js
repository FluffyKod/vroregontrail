//ett git test
// Ett till gittest
// this is rooms 2.0 o.O
var options = [];
var currentoption;
var optionlength;
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

function setup(){

  loadRooms();
  defineCanvas();
  grandparent = select('#grandparent');

  drawText = true;
  soundEnabled = false;
  optionlength = 1;
  load = false;
  counter = 0;

  timer = 0;
  player = new player();




  options.push(new option('#option-1'));
  options.push(new option('#option-2'));
  options.push(new option('#option-3'));
  options.push(new option('#option-4'));
  options.push(new option('#option-5'));


  textbox = select('#textbox');
  textbox.html("")



}

function draw(){
  if(drawText){
    drawTextbox();
  }
  if(drawCanvas){
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

function keyPressed(){
  timer = 0;

  if(!keypressed){
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
    options[currentoption].command();
    currentoption = 0;
    load = false;


    }
  if(keyCode == SHIFT && !soundEnabled){
    blip = loadSound("menu_blip.wav")
    soundEnabled = true;
  }


  }


function player(){
  this.x = 0;
  this.y = 0;

  this.inventory = [];
  this.intellegence = 0;
  this.charisma = 0;
  this.grit = 0;
  this.kindness = 0;
}

function option(ref){
  this.ref = select(ref);

  this.text = 'test';
  this.ref.html(this.text);

  this.type;
  this.value;
  this.valuetype;

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

      if(this.type == "move"){
        write = true;
        if(this.valuetype == "y"){
          player.y += this.value;
        } else if(this.valuetype == "x"){
          player.x += this.value;
        } else if(this.valuetype == "xy"){
          player.y += this.value;
          player.x += this.value;
        }

      }
      if(this.type == 'item'){
        player.invertory.push(this.value);

      }
      if(this.type == 'encounter'){
        current_encounter = this.value
        define = true;
        clearVar = false;
        startSc = true;
        gameOver = true;
        score = 0;
        if(this.valuetype){fr_hard = true;}//slarvigt måste ändras
        if(!this.valuetype){er_hard = true;}
        switchToEncounter();
      }

      if(this.type == 'tp'){ //version av move
        write = true;
        player.x = this.value;
        player.y = this.valuetype;
      }

      if(this.type == 'stat'){



      }
      if(this.type == 'info'){
        textbox.html(this.value);
        write = false;





      }
      if(this.type == 'test'){
        id = this.value;
        player.x = rooms[id].o2value
        player.y = rooms[id].o2valuetype
      }
  }

}

  function room(id, x, y, text,
  o1text, o1type, o1value, o1valuetype,
  o2text, o2type, o2value, o2valuetype,
  o3text, o3type, o3value, o3valuetype,
  o4text, o4type, o4value, o4valuetype,
  o5text, o5type, o5value, o5valuetype){

    this.id = id;
    this.x = x;
    this.y = y;
    this.text = text;


    this.o1text = o1text;
    this.o1type = o1type;
    this.o1value = o1value;
    this.o1valuetype = o1valuetype;

    this.o2text = o2text;
    this.o2type = o2type;
    this.o2value = o2value;
    this.o2valuetype = o2valuetype;

    this.o3text = o3text;
    this.o3type = o3type;
    this.o3value = o3value;
    this.o3valuetype = o3valuetype;

    this.o4text = o4text;
    this.o4type = o4type;
    this.o4value = o4value;
    this.o4valuetype = o4valuetype;

    this.o5text = o5text;
    this.o5type = o5type;
    this.o5value = o5value;
    this.o5valuetype = o5valuetype;

    this.load = function(){

      optionlength=1;
      options[0].ref.html(this.o1text);
      options[0].type = this.o1type;
      options[0].value = this.o1value;
      options[0].valuetype = this.o1valuetype;

      options[1].type = this.o2type;
      options[1].value = this.o2value;
      options[1].valuetype = this.o2valuetype;

      options[2].type = this.o3type;
      options[2].value = this.o3value;
      options[2].valuetype = this.o3valuetype;

      options[3].type = this.o4type;
      options[3].value = this.o4value;
      options[3].valuetype = this.o4valuetype;

      options[4].type = this.o5type;
      options[4].value = this.o5value;
      options[4].valuetype = this.o5valuetype;

      if(this.o2text != " "){
        optionlength++;

        options[1].ref.html(this.o2text);

      }else{options[1].ref.html("")}

      if(this.o3text != " "){
        optionlength++;
        options[2].ref.html(this.o3text);

      }else{options[2].ref.html("")}

      if(this.o4text != " "){
        optionlength++;
        options[3].ref.html(this.o4text);

      }else{options[3].ref.html(""); }

      if(this.o5text != " "){
        optionlength++;

        options[4].ref.html(this.o5text);

      }else{options[4].ref.html("")}


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
  for (var i = 0; i < options.length; i++) {
    options[i].unhighlight();
  }
  if(keypressed && timer < 600){
    timer++;
    options[currentoption].highlight();
  }
  for (var i = 0; i < rooms.length; i++) {
    if(player.x == rooms[i].x && player.y == rooms[i].y){
      if(write){
        typing("textbox", rooms[i].text);
      }
      if(!load){
        rooms[i].load();// borde kanske inte uppdateras
        load = true;
      }
    }


  }

}
