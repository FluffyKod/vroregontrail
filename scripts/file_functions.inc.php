<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Include helpful functions
include_once('helpful_functions.php');

if (isset($_POST['download-member-list'])) {

  global $wpdb;

  // filename for download
  $filename = "medlemslista.csv";
  $filepath = '../misc/' . $filename;

  $current_date = date('Y-m-d');
  $download_filename = "medlemslista-$current_date.csv";

  // Get all students
  $students = $wpdb->get_results("SELECT * FROM vro_users");

  // The csv column headers
  // $csv_top = "*Förnamn,*Efternamn,*Födelseår,*Kön,*Folkbokförd stad,*Inträdesdatum,*Telefon/mobil,*E-postadress,Utbildningsprogram (Fullt namn),Årskurs (1-3)\n";

  // Download
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="' . $download_filename . '";');

  // Open a new csv file
  $f = fopen( 'php://output', 'w' );

  // fputs( $f, $csv_top );

  // Go through and add a row for each student
  foreach ($students as $s) {

    // Check if student is memebr
    if ($s->status != 'y') {
      continue;
    }

    // Check required field
    if (check_if_empty(array( $s->first_name, $s->last_name, $s->date_member, $s->phonenumber, $s->email, $s->program )) == false) {
      continue;
    }

    $first = $s->first_name;
    $last = $s->last_name;
    $birthyear = ($s->birthyear != NULL) ? $s->birthyear : get_birthyear_by_email( $s->email ); // If no birthyear supplied, generate one from vrg email
    $gender = ($s->gender != NULL) ? $s->gender : 'Annat'; // Default gender to Annat
    $city = ($s->registered_city != NULL) ? $s->registered_city : 'Stockholm'; // Default folkbokförd stad to Stockholm

    // Convert registered date to YYYY-MM-DD format
    $date = strtotime( $s->date_member );
    $registered = date( 'Y-m-d', $date );

    $phonenumber = str($s->phonenumber);
    $email = $s->email;
    $program = $s->program;
    $grade = get_student_grade( $s );

    $student_row = array( $first, $last, $birthyear, $gender, $city, $registered, $phonenumber, $email, $program, $grade );

    fputcsv($f, $student_row, ',');

  }

  // Redirect
  exit();
  //send_header( '/panel/medlemmar' );

} else {
  send_header('/panel/dashboard');
}
