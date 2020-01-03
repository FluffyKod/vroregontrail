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
    header("Location: /admin/dashboard?send_message=empty");
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
        header("Location: /admin/dashboard?send_message=invalidyear");
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

    header("Location: /admin/dashboard?send_message=success");
    exit();

  }

} else {
  header("Location: /test?visselpipa=error");
  exit();
} // End post
