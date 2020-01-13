<?php

require_once ABSPATH . '/wp-admin/includes/taxonomy.php';


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

function check_id( $id, $table_name ) {
  if (empty($id)){
    return array(false, 'empty');
  }

  if (!is_numeric($id)){
    return array(false, 'nan');
  }

  global $wpdb;

  if ( count($wpdb->get_results('SELECT * FROM '. $table_name .' WHERE id="'. $id .'"')) < 1 ) {
    return array(false, 'norecord');
  }

  return array(true, (int)$id);
}

function value_exists_in_table( $value, $column_name, $table_name, $row_id = false ){

  global $wpdb;

  if ($row_id){

    if ( count($wpdb->get_results('SELECT * FROM '. $table_name .' WHERE '. $column_name .'="'. $value .'" AND id <>'. $row_id)) > 0 ) {
      return true;
    } else {
      return false;
    }

  } else {

    if ( count($wpdb->get_results('SELECT * FROM '. $table_name .' WHERE '. $column_name .'="'. $value .'"')) > 0 ) {
      return true;
    } else {
      return false;
    }

  }



}

function is_member( $u_id ){

  global $wpdb;

  $status = get_metadata('user', $u_id, 'status');

  return ($status == 'y') ? true : false;

}

function get_kommitte_cat_ids( $u_id ) {

  global $wpdb;

  $all_kommittes = $wpdb->get_results('SELECT * FROM vro_kommiteer_members WHERE user_id = '. $u_id);

  $cat_array = array();

  foreach ($all_kommittes as $k){
    $cat_name = 'kommitte_' . $k->kommitee_id;

    if ( category_exists( $cat_name ) ){

      $cat_id = get_cat_ID( $cat_name );

      if ( $cat_id != 0 ) {
        array_push( $cat_array, $cat_id );
      }

    }
  }

  return $cat_array;

}
