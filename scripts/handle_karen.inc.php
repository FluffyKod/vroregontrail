<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Include helpful functions
include_once('helpful_functions.php');

// Create database entry
if (isset($_POST['add_new_position_type'])) {

  global $wpdb;

  $position_name = test_input( $_POST['position_name'] );
  $is_unique = test_input( $_POST['is_unique'] );
  $is_linked_utskott = test_input( $_POST['is_linked_utskott'] );

  if ( empty($position_name) || empty($is_unique) || empty($is_linked_utskott) ){
    header("Location: /panel/karen?new_position_type=empty");
    exit();
  } else {

    if ( ($is_unique != 'True' and $is_unique != 'False') or ($is_linked_utskott != 'True' and $is_linked_utskott != 'False') ){
      header("Location: /panel/karen?new_position_type=nottruefalse");
      exit();
    }

    // Create a new array that will hold all the arguments to create a new visselpipan suggestion
    $position_type = array();

    $position_type['name'] = $position_name;
    $position_type['is_unique'] = $is_unique;
    $position_type['is_linked_utskott'] = $is_linked_utskott;

    // Insert the new suggestion into the database
    if($wpdb->insert(
        'vro_position_types',
        $position_type
    ) == false) {
      wp_die('database insertion failed');
    }

    header("Location: /panel/karen?new_position_type=success");
    exit();

  }

} else {
  header("Location: /panel/karen?new_position_type=error");
  exit();
} // End post
