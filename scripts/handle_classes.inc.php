<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Include helpful functions
include_once('helpful_functions.php');

// Create database entry
if (isset($_POST['add_class'])) {

  global $wpdb;

  $class_name = test_input( $_POST['class-name'] );

  if ( empty($class_name) ){
    header("Location: /panel/medlemmar?new_class=noname");
    exit();
  } else {

    // Capitalise first letter
    $class_name = ucfirst($class_name);

    // Check if there already is a class with that name
    if ( count($wpdb->get_results('SELECT * FROM vro_classes WHERE name="'. $class_name .'"')) > 0 ) {
      header("Location: /panel/medlemmar?=new_class=nametaken");
      exit();
    } else {

    // Create a new array that will hold all the arguments to create a new visselpipan suggestion
      $new_class = array();

      $new_class['name'] = $class_name;

      // Insert the new suggestion into the database
      if($wpdb->insert(
          'vro_classes',
          $new_class
      ) == false) {
        wp_die('database insertion failed');
      }

      header("Location: /panel/medlemmar?new_class=success");
      exit();

    }

  }

}
elseif (isset($_POST['give_class_points'])) {

  global $wpdb;

  $class_name = test_input( $_POST['class-name'] );
  $class_points = test_input( $_POST['add-points'] );
  $callback = test_input( $_POST['callback'] );

  if (empty($callback)){
    $callback = '/panel/dashboard';
  }

  if ( empty($class_name) || empty($class_points)){
    header("Location: $callback?class_points=empty");
    exit();
  } else {

    if (!is_numeric($class_points)) {
      header("Location: $callback?class_points=nan&class_name=$class_name");
      exit();
    }

    // Capitalise first letter
    $class_name = ucfirst($class_name);

    $class_record = $wpdb->get_row('SELECT * FROM vro_classes WHERE name="'. $class_name .'"');

    // Check if there already is a class with that name
    if ( !$class_record ) {
      header("Location: $callback?class_points=noclassfound");
      exit();
    } else {

      // Create a new array that will hold all the arguments to create a new visselpipan suggestion
      $current_points = (int)$class_record->points;

      $new_points = $current_points + (int)$class_points;

      if ($wpdb->update( 'vro_classes', array( 'points' => $new_points ), array( 'id' => $class_record->id) ) == false){
        wp_die('add class points failed');
      } else {

        header("Location: $callback?class_points=success");
        exit();

      }
    }

  }

}
elseif (isset($_POST['give_classpoints_internal'])){
  global $wpdb;

  $class_id = test_input( $_POST['c_id'] );
  $class_points = test_input( $_POST['add-points'] );

  if (empty( $class_id ) or !is_numeric( $class_id )){
    header("Location: /panel/medlemmar?give_classpoints=noclassid");
    exit();
  }

  if ( empty($class_points)){
    header("Location: /panel/medlemmar/?c_id=$class_id&give_classpoints=empty");
    exit();
  } else {

    if (!is_numeric($class_points)) {
      header("Location: /panel/medlemmar/?c_id=$class_id&give_classpoints=nan");
      exit();
    }

    // Capitalise first letter

    $class_record = $wpdb->get_row('SELECT * FROM vro_classes WHERE id=' . $class_id);

    // Check if there already is a class with that name
    if ( !$class_record ) {
      header("Location: /panel/medlemmar/?c_id=$class_id&give_classpoints=noclassfound");
      exit();
    } else {

      // Create a new array that will hold all the arguments to create a new visselpipan suggestion
      $current_points = (int)$class_record->points;

      $new_points = $current_points + (int)$class_points;

      if ($wpdb->update( 'vro_classes', array( 'points' => $new_points ), array( 'id' => $class_record->id) ) == false){
        wp_die('add class points failed');
      } else {

        header("Location: /panel/medlemmar/?c_id=$class_id&give_classpoints=success");
        exit();

      }
    }

  }
}

else {
  header("Location: /panel/medlemmar?new_class=error");
  exit();
} // End post
