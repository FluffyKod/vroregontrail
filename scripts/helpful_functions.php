<?php

// Form validation function
function test_input( $data ){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function emptyToNull( $data ){
  if ($data == '') {
    return null;
  } else {
    return $data;
  }
}

function translateWeekday($day){
  $english = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
  $swedish = array('Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag', 'Söndag');

  return $swedish[array_search($day, $english)];
}
