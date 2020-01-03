<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Include helpful functions
include_once('helpful_functions.php');

// Create database entry
if (isset($_POST['new_visselpipa'])) {

  global $wpdb;

  $subject = test_input( $_POST['subject'] );
  $text = test_input( $_POST['text'] );

  if ( empty($subject) || empty($text) ){
    header("Location: /panel/visselpipan?visselpipa=empty");
    exit();
  } else {

    // Create a new array that will hold all the arguments to create a new visselpipan suggestion
    $suggestion = array();

    $suggestion['user_id'] = get_current_user_id();
    $suggestion['subject'] = $subject;
    $suggestion['text'] = $text;

    // Insert the new suggestion into the database
    if($wpdb->insert(
        'vro_visselpipan',
        $suggestion
    ) == false) {
      wp_die('database insertion failed');
    }

    header("Location: /panel/visselpipan?visselpipa=success");
    exit();

  }

} else {
  header("Location: /panel/visselpipan?visselpipa=error");
  exit();
} // End post
