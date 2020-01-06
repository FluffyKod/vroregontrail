<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Include helpful functions
include_once('helpful_functions.php');

// Create database entry
if (isset($_POST['send_message_school'])) {

  global $wpdb;

  $subject = test_input( $_POST['subject'] );
  $message = test_input( $_POST['message'] );
  $mail_to = test_input( $_POST['mail-to'] );

  if ( empty($message) || empty($mail_to) || empty($subject) ){
    header("Location: /panel/dashboard?send_message=empty");
    exit();
  } else {

    // Get all students
    $students = get_users(array(
      'meta_key' => 'class_id'
    ));

    // Check if a year has been specified
    if (is_numeric($mail_to)){
      $mail_to = (int)$mail_to;

      if ($mail_to < 1 or $mail_to > 3){
        header("Location: /panel/dashboard?send_message=invalidyear");
        exit();
      }

      // Get only the students in that year
      $students = getStudentsInYear($mail_to, $students);
    }

    // Mail all students the message
    foreach ($students as $s) {
      // Get the students email
      $email_address = $s->user_email;

      // Check that there is a valid email
      if (filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        // Send the mail!
        wp_mail( $email_address, $subject, $message );
      }

    }

    header("Location: /panel/dashboard?send_message=success");
    exit();

  }

}
elseif (isset($_POST['send_message_kommitte'])){

  global $wpdb;

  $subject = test_input( $_POST['subject'] );
  $message = test_input( $_POST['message'] );
  $mail_to = test_input( $_POST['mail-to'] );
  $k_id = test_input( $_POST['k_id'] );

  if (empty($k_id) || !is_numeric($k_id) ){
    header("Location: /panel/kommiteer?send_message=empty");
    exit();
  }

  if ( empty($message) || empty($subject) ){
    header("Location: /panel/kommiteer?k_id=$k_id&send_message=empty");
    exit();
  } else {

    // Get all memeber
    $member_ids_sql = $wpdb->get_results('SELECT user_id FROM vro_kommiteer_members WHERE kommitee_id=' . $k_id );
    $member_ids = array();

    foreach ($member_ids_sql as $mi) {
      array_push($member_ids, $mi->user_id);
    }

    // CH
    if ( isset($mail_to) && $mail_to == 'only_chairman'){
      // Only mail to the chairman
      $member_ids = $wpdb->get_row('SELECT * FROM vro_kommiteer WHERE id=' . $k_id);
    }

    // Mail all students the message
    foreach ($member_ids as $m) {
      $m = (int)$m;

      // GET USER
      $member = get_user_by('id', $m);

      // Get the students email
      $email_address = $member->user_email;

      // Check that there is a valid email
      if (filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        // Send the mail!
        wp_mail( $email_address, $subject, $message );
      }

    }

    // SUccess
    header("Location: /panel/kommiteer?k_id=$k_id&send_message=success");
    exit();

  }

}

else {
  header("Location: /panel/kommiteer?send_message=error");
  exit();
} // End post
