function ddr_getLevel(){
  let level =
  [
  [1,0,0,0],  //1
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,1,0,0],  //2
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,1,0],  //3
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],  //4
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [1,0,0,0],  //5
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,1,0],  //6
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,1,0,0],  //7
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],  //8
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [1,0,0,0],  //9  00:09
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,1,0,0],  //10
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,1,0],  //11
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,1,0],  //13 00:20
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,1,0,0],  //14 //DIDU
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],  //2
  [0,0,1,0],  //15 //DIDU
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,1],  //16 //diduuu
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,1,0,1],  //17 00:27
  [0,0,0,0],
  [1,0,0,0],
  [0,0,0,0],
  [0,1,0,1],  //18
  [1,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [1,0,1,0],  //19 //00:30
  [0,0,0,1],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],  //20
  [0,1,0,1],
  [0,0,0,0],
  [0,1,1,0],  //8
  [0,0,0,0],
  [0,0,1,0],
  [0,0,0,0],
  [1,0,0,0],  //9
  [0,0,0,0],
  [0,0,1,0],
  [0,0,0,0],
  [0,0,0,1],  //10
  [0,0,0,0],
  [0,1,0,0],
  [0,0,0,0],
  [0,1,0,0],  //11
  [1,0,0,0],
  [1,0,0,0],
  [1,0,0,0],
  [1,0,0,0],
  [1,0,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [1,0,0,0],  //1
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,1,0,0],  //2
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,1,0],  //3
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],  //4
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [1,0,0,0],  //5
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,1,0],  //6
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,1,0,0],  //7
  [0,0,0,0],
  [0,1,0,1],
  [0,0,0,0],
  [0,1,1,0],  //8
  [0,0,0,0],
  [0,0,1,0],
  [0,0,0,0],
  [1,0,0,0],  //9
  [0,0,0,0],
  [0,0,1,0],
  [0,0,0,0],
  [0,0,0,1],  //10
  [0,0,0,0],
  [0,1,0,0],
  [0,0,0,0],
  [0,1,0,0],  //11
  [1,0,0,0],
  [1,0,0,0],
  [1,0,0,0],
  [1,0,0,0],
  [1,0,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [1,0,0,0],  //1
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,1,0,0],  //2
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,1,0],  //3
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],  //4
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [1,0,0,0],  //5
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,0,1,0],  //6
  [0,0,0,0],
  [0,0,0,0],
  [0,0,0,0],
  [0,1,0,0],  //7
  [0,0,0,0],
  [0,1,0,1],
  [0,0,0,0],
  [0,1,1,0],  //8
  [0,0,0,0],
  [0,0,1,0],
  [0,0,0,0],
  [1,0,0,0],  //9
  [0,0,0,0],
  [0,0,1,0],
  [0,0,0,0],
  [0,0,0,1],  //10
  [0,0,0,0],
  [0,1,0,0],
  [0,0,0,0],
  [0,1,0,0],  //11
  [1,0,0,0],
  [1,0,0,0],
  [1,0,0,0],
  [1,0,0,0],
  [1,0,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [0,1,0,0],
  [0,1,0,0]
  ]
//   let level = [[1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// [1,0,0,0],
// ]
  return level;
}
