function loadRooms(){

rooms = [

  new room(0, 0, 'you wake up on a...', [
    {
      text: 'option 1 herre',
      cmd: 'tp',
      values: [1, 0]
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
      values: [0, 0]
    },
    {
      text: 'new option 2 herre',
      cmd: 'tp',
      values: [0, 0]
    },
    {
      text: 'new option 3 herre',
      cmd: 'info',
      values: ['info info waow!']
    },

  ])

]

}
