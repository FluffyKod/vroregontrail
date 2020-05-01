////////////////////////////////////////////
// HELPER FUNCTIONS
////////////////////////////////////////////

function sendAjax( parameters, callbackFunction) {

  jQuery.ajax({
      url: '/wp-admin/admin-ajax.php',
      type: 'post',
      dataType: 'json',
      data: parameters,
      success: function(response){
        callbackFunction(response);
      }
  });

}


////////////////////////////////////////////
// SAVE PLAYER OPTIONS TO DATABASE
////////////////////////////////////////////
function savePlayer() {

  var playerString = JSON.stringify(player);
  parameters = {
    action: 'save_player',
    player_string: playerString
  }

  sendAjax(parameters, function(response) {
    console.log(response);
  });

}

function getPlayer() {

  parameters = {
    action: 'get_saved_player'
  }

  sendAjax(parameters, function(response) {

    // Translate the recieved player and set the new player
    if ( response.player != false ) {

      player = JSON.parse(response.player);

      changeBackgroundImage(player.background);
      currentArea = player.area;
      rooms = getRoomsFromArea( allAreaRooms, currentArea );
      currentRoom.unlockedOptions = getUnlockedOptions(currentRoom.options);
      // changeBackgroundImage( player.background );

      // $('#audio-holder').attr('src', player.music)

      resetTextbox();
      changeBoxColor();

      updateDebug();
      updateInventoryGui()
      updateStatGui('', true);

      return;

      // rooms = getRoomsFromArea( allAreaRooms, currentArea );
      // currentRoom = findRoomWithPlayer();
      // console.log(currentRoom);
      // console.log(currentArea);
    }

  });

}

function clearPlayer() {
  parameters = {
    action: 'clear_player'
  }

  sendAjax(parameters, function(response) {
    console.log(response);
  });

  location.reload();
  return false;
}

////////////////////////////////////////////
// SAVE ROOMS OPTIONS TO DATABASE
////////////////////////////////////////////
function saveRoomsToDatabase(roomsToSave) {

  // console.log(roomsToSave);
  var roomsString = JSON.stringify(roomsToSave);
  parameters = {
    action: 'save_rooms',
    rooms_string: roomsString
  }

  sendAjax(parameters, function(response) {
    console.log(response);
  });

}

function saveSprites(spriteArrayToSave) {
  console.log('In the function saveSprites');

  let spriteArray = spriteArrayToSave;

  for (var i = 0; i < spriteArray.length; i++) {
    let spriteGuis = {gui: "", optionGuis: []};
    console.log(spriteArray[i]);
    spriteGuis.gui = spriteArray[i].gui.getValuesAsJSON(true);
    spriteArray[i].gui = spriteGuis.gui;

    spriteGuis.optionGuis = [];
    for (var j = 0; j < spriteArray[i].optionGuis.length; j++) {
      spriteGuis.optionGuis.push(spriteArray[i].optionGuis[j].getValuesAsJSON(true));
      spriteArray[i].optionGuis[j] = spriteGuis.optionGuis[j];
    }
  }
  let spriteString = JSON.stringify(spriteArray);

  console.log(spriteArrayToSave);
  console.log(spriteString);

  // parameters = {
  //   action: 'save_sprites',
  //   rooms_string: spritesString
  // }
  //
  // sendAjax(parameters, function(response) {
  //   console.log(response);
  // })
}

function loadRoomsFromDatabase(area, callback){

    // sampleRooms = [
    //
    //   new Room(0, 0, 'You wake up on a sandy beach', [
    //     {
    //       text: 'Go right',
    //       cmd: 'move',
    //       values: [0, 1]
    //     },
    //     {
    //       text: 'Go left',
    //       cmd: 'tp',
    //       values: [0, 2]
    //     }
    //   ]),
    // ]  //slut på rooms arrayn

  // Get the rooms
  parameters = {
    action: 'fetch_rooms'
  }

  sendAjax(parameters, function(response) {

    allAreaRooms = []

    parsedRooms = JSON.parse(response.rooms);
    console.log('DATABASE RESPONSE: ', parsedRooms);

    parsedRooms.forEach(roomArray => {
      rooms = []

      roomArray.forEach(room => {
        var newRoom = new Room(room.x, room.y, room.mainText, room.options);
        rooms.push( newRoom );
      });

      allAreaRooms.push(rooms);
    });

    callback(allAreaRooms);

  })

}

////////////////////////////////////////////
// GET CORRECT AREA
////////////////////////////////////////////
function getAreaRooms(allRooms, area) {
  switch (area) {

    case 'test':
      return allRooms.test.rooms

    case 'intro':
      return allRooms.intro.rooms

    case 'highlands':
      return allRooms.highlands.rooms

    case 'bog':
      return allRooms.bog.rooms

    case 'city':
      return allRooms.city.rooms

    case 'mountain':
      return allRooms.mountain.rooms

    case 'core':
      return allRooms.core.rooms

    default:
      return Array()

  }
}

function getAreaIndex( areaName ) {
  const areas = ['test', 'intro', 'highlands', 'bog', 'city', 'mountain', 'core'];
  return areas.indexOf(areaName);
}

function getRoomsFromArea( rooms, area ) {
  switch (area) {

    case 'test':
      return rooms[0];
      break;

    case 'intro':
      return rooms[1];
      break;

    case 'highlands':
      return rooms[2];
      break;

    case 'bog':
      return rooms[3];
      break;

    case 'city':
      return rooms[4];
      break;

    case 'mountain':
      return rooms[5];
      break;

    case 'core':
      return rooms[6];
      break;

    default:
      return Array()

  }
}
