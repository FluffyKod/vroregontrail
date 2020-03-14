function saveRooms(roomsToSave) {

  // console.log(roomsToSave);
  var roomsString = JSON.stringify(roomsToSave);
  console.log('saveRooms string: ', roomsString);

  // jQuery.ajax({
  //     url: '/wp-admin/admin-ajax.php',
  //     type: 'post',
  //     dataType: 'json',
  //     data: { action: 'save_rooms', roomsString: roomsString },
  //     success: function(response) {
  //       console.log('in success');
  //       console.log(response);
  //
  //     }
  // });

  jQuery.ajax({
      url: '/wp-admin/admin-ajax.php',
      type: 'post',
      dataType: 'json',
      data: { action: 'save_rooms', rooms_string: roomsString },
      success: function(data) {

        // rooms = []
        console.log(data);

      }
  });

}

function loadRooms(callback){

testRooms = [

  new Room(0, 0, 'you wake up on a... TEST ROOMS', [
    {
      text: 'option 1 is here',
      cmd: 'tp',
      values: [12, 40]
    },
    {
      text: 'option 2 herre',
      cmd: 'tp',
      values: [0, 1]
    },
    {
      text: 'option 2 herre',
      cmd: 'tp',
      values: [0, 1]
    },
    {
      text: 'option 2 herre',
      cmd: 'tp',
      values: [0, 1]
    },

    {
      text: 'option 2 herre yay',
      cmd: 'tp',
      values: [0, 1]
    }

  ]),
//------------------------------------------------
  new Room(0, 1, 'new place omg', [
    {
      text: 'new option 1 herre',
      cmd: 'tp',
      values: [1, 1]
    },
    {
      text: 'new option 2 herre',
      cmd: 'tp',
      values: [1, 1]
    },
    {
      text: 'new option 3 herre',
      cmd: 'info',
      values: ['info info waow!']
    },

  ]),
  new Room(1, 1, 'even newer place', [
    {
      text: 'new option 1 herre',
      cmd: 'tp',
      values: [3, 3]
    },
    {
      text: 'new option 2 herre',
      cmd: 'tp',
      values: [3, 3]
    },
    {
      text: 'new option 3 herre',
      cmd: 'info',
      values: ['info info waow!']
    },
  ])
]  //slut på rooms arrayn

saveRooms(testRooms);
var rooms = new Array();

// callback(testRooms)

jQuery.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'post',
    dataType: 'json',
    data: { action: 'fetch_rooms' },
    success: function(data) {

      rooms = []
      data.forEach(r => {
        var newRoom = new Room(r.x, r.y, r.mainText, r.options);
        rooms.push( newRoom );
      });

      callback(rooms);

    }
});

}
