<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Include helpful functions
include_once('helpful_functions.php');

// Create database entry
if (isset($_POST['add_event_type'])) {

  global $wpdb;

  $name = test_input( $_POST['etName'] );
  $bgColor = test_input( $_POST['etBgColor'] );
  $fgColor = test_input( $_POST['etFgColor'] );

  if ( empty($name) ){
    header("Location: /admin/kalender?event_type=empty");
    exit();
  } else {

    if ( count($wpdb->get_results('SELECT * FROM vro_event_types WHERE name="'. $name .'"')) > 0 ) {
      // Replace the # to %23 so it is safe to send in the url
      $bgColor = '%23' . substr($bgColor, 1);
      $fgColor = '%23' . substr($fgColor, 1);

      header("Location: /admin/kalender?event_type=nametaken&bgColor=$bgColor&fgColor=$fgColor");
      exit();
    }
    // Create a new array that will hold all the arguments to create a new visselpipan suggestion
    $new_et = array();

    $new_et['name'] = $name;
    $new_et['bg_color'] = $bgColor;
    $new_et['fg_color'] = $fgColor;

    // Insert the new suggestion into the database
    if($wpdb->insert(
        'vro_event_types',
        $new_et
    ) == false) {
      wp_die('database insertion failed');
    }

    header("Location: /admin/kalender?event_type=success");
    exit();

    }

}
elseif (isset($_POST['remove_event_type'])) {

  global $wpdb;

  $etId = $_POST['remove_event_type'];

  if (empty($etId)) {
    header("Location: /admin/kalender?remove_event_type=empty");
    exit();
  }

  if (!is_numeric($etId)) {
    header("Location: /admin/kalender?remove_event_type=nan");
    exit();
  }

  // Delete the specified table
  if ($wpdb->delete( 'vro_event_types', array( 'id' => $etId ) ) == false ){
    // If it did not work, send back error
    wp_die('database deletion failed');
  } else {
    // Success!
    header("Location: /admin/kalender?remove_event_type=success");
    exit();
  }
}
elseif (isset($_POST['add_event'])) {

  global $wpdb;

  $event_type = $_POST['ae_event_type'];
  $event_name = $_POST['ae_name'];
  $event_place = $_POST['ae_place'];


  if ($event_type == 'none'){
    header("Location: /admin/kalender?add_event=noeventtype");
    exit();
  }

}

else {
  header("Location: /admin/kalender");
  exit();
}
