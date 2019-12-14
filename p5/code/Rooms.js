function loadRooms(){

rooms = [

  new room(0, 0, 'you wake up on a...', [
    {
      text: 'option 1 herre',
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
      text: 'option 2 herre',
      cmd: 'tp',
      values: [0, 1]
    },

    {
      text: 'option 2 herre',
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

}
