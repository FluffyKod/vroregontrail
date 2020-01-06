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

function getStudentsInYear($year, $students) {
  // Check if the year is numeric
  if (!is_numeric($year)){
    return false;
  } else {
    $year = (int)$year;
  }

  // Check if the year supplied is 1, 2 or 3
  if (  !in_array($year, array(1, 2, 3)) ) {
    return false;
  }

  // Get the current year
  $current_year = date('Y');

  // Get the current month
  $current_month = date('m');

  // DEBUG
  // $current_month = date('m', strtotime('+6 months'));
  //
  // echo $current_year . ' ' . $current_month;

  // If it is before july, act as the year is the previous one
  if ((int)$current_month < 7){
    $current_year = (int)$current_year - 1;
  } else {
    $current_year = (int)$current_year;
  }

  $yearArray = array();

  foreach ($students as $s) {
    // check if end year meta data exists
    if (metadata_exists( 'user', $s->ID, 'end_year' )){

      // Get the difference, a.k.a the number of years left for this student
      $years_left =  get_user_meta($s->ID, 'end_year', true) - $current_year;

      // Get the grade they are in. ex. 3 years left means you are a 1:st grader, therefore 4 - 3 = 1, 4 - 2 years left = 2 etc.
      $grade = 4 - $years_left;

      // Check if this was the year asked for
      if ($grade == $year){
        array_push($yearArray, $s);
      }
    }
  }

  return $yearArray;
}
