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
    console.log(response);

    // Translate the recieved player and set the new player
    if ( response.player != false ) {
      player = JSON.parse(response.player);
    }

  });

}

////////////////////////////////////////////
// SAVE ROOMS OPTIONS TO DATABASE
////////////////////////////////////////////
function saveRooms(roomsToSave) {

  // console.log(roomsToSave);
  var roomsString = JSON.stringify(roomsToSave);
  parameters = {
    action: 'save_rooms',
    rooms_string: roomsString
  }

  sendAjax(parameters, function(response) {
    console.log(response);
  })

}

function loadRooms(callback){

    sampleRooms = [

      new Room(0, 0, 'You wake up on a sandy beach', [
        {
          text: 'Go right',
          cmd: 'tp',
          values: [0, 1]
        },
        {
          text: 'Go left',
          cmd: 'tp',
          values: [0, 2]
        }
      ]),
      new Room(0, 1, 'You see a shipreck.', [
        {
          text: 'Check out the ship',
          cmd: 'info',
          values: ['The ship is broken at many places.']
        },
        {
          text: 'Go back',
          cmd: 'tp',
          values: [0, 0]
        }
      ]),
      new Room(0, 2, 'You come to a forest.', [
        {
          text: 'Go back',
          cmd: 'tp',
          values: [0, 0]
        }
      ])
    ]  //slut på rooms arrayn

  // Get the rooms
  parameters = {
    action: 'fetch_rooms'
  }

  sendAjax(parameters, function(response) {
    if (response.rooms == false){
      // Save the test rooms instead
      //saveRooms(sampleRooms);
      return false
    }

    rooms = []
    parsedRooms = JSON.parse(response.rooms);

    parsedRooms.forEach(room => {
      var newRoom = new Room(room.x, room.y, room.mainText, room.options);
      rooms.push( newRoom );
    });

    callback(rooms);

  })

}
