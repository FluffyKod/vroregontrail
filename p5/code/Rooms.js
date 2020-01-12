function loadRooms(){

  function reqListener () {
      console.log(this.responseText);
    }

    var oReq = new XMLHttpRequest(); // New request object
    oReq.onload = function() {
        // This is where you handle what to do with the response.
        // The actual data is found on this.responseText
        alert(this.responseText); // Will alert: 42
    };
    oReq.open("get", "rooms.php", true);
    //                               ^ Don't block the rest of the execution.
    //                                 Don't wait until the request finishes to
    //                                 continue.
    oReq.send();

rooms = [

  new room(0, 0, 'you wake up on a...', [
    {
      text: 'option 1 herre',
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
  new room(0, 1, 'new place omg', [
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
  new room(1, 1, 'even newer place', [
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
  ]),
    new room(3, 3, 'even newer place', [
      {
        text: 'new option 1 herre',
        cmd: 'tp',
        values: [3, 4]
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
    new room(3, 4, 'even newer place', [
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

]//slut på rooms arrayn

var roomsString = JSON.stringify(rooms);

request= new XMLHttpRequest()
request.open("POST", "/game", true)
request.setRequestHeader("Content-type", "application/json")
request.send(roomsString)

// console.log(roomsString);
// roomsString_parsed = JSON.parse(roomsString);
// console.log(roomsString_parsed);

}
