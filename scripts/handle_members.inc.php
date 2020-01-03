<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Include helpful functions
include_once('helpful_functions.php');

// Create database entry
if (isset($_POST['toggle_member'])) {

  global $wpdb;

  $student_id = test_input( $_POST['toggle_member'] );
  $class_id = test_input( $_POST['c_id'] );

  if (empty( $class_id ) or !is_numeric( $class_id )){
    header("Location: /admin/medlemmar?toggle_member=noclassid");
    exit();
  }

  if ( empty($student_id) ){
    header("Location: /admin/medlemmar/?c_id=$class_id&toggle_member=empty");
    exit();
  } else {

    if(!is_numeric($student_id)){
      header("Location: /admin/medlemmar/?c_id=$class_id&toggle_member=empty");
      exit();
    }

    $status = get_user_meta($student_id, 'status');

    if (!$status[0]){
      header("Location: /admin/medlemmar/?c_id=$class_id&toggle_member=nouser");
      exit();
    }

    $new_status = ($status[0] == 'y') ? 'n' : 'y';

    if (!update_user_meta($student_id, 'status', $new_status)){
      wp_die('meta could not be changed');
    }
    else {
      // Success!
      header("Location: /admin/medlemmar/?c_id=$class_id&toggle_member=success");
      exit();
    }

  }

}
// ADD NEW USER
elseif (isset($_POST['add_new_user'])) {
  global $wpdb;

  $first_name = test_input( $_POST['first_name'] );
  $last_name = test_input( $_POST['last_name'] );
  $email_address = $_POST['email_address'];
  $class_name = test_input( $_POST['class_name'] );
  $password = $_POST['password'];
  $class_id = $_POST['class_id'];

  // INPUT VALIDATION

  // Check if a class id or a class name has been supplied
  if (isset($class_id)) {
    if (!is_numeric($class_id)) {
      header("Location: /admin/medlemmar?add_user=nan");
      exit();
    }
    // Get class with id
    $class = $wpdb->get_row('SELECT * FROM vro_classes WHERE id=' . (int)$class_id);

  } elseif (isset($class_name)) {

    // Make sure the first letter i capitilized
    $class_name = ucfirst( strtolower( $class_name ) );

    // Get class with name
    $class = $wpdb->get_row('SELECT * FROM vro_classes WHERE name="' . $class_name . '"');

  } else {
    // No class name or id supplied
    header("Location: /admin/medlemmar?add_user=noclass");
    exit();
  }

  // Check if a class was found with the given class id or class name
  if (!$class) {
    header("Location: /admin/medlemmar?c_id=$class_id&add_user=noclassfound");
    exit();
  }

  if (!isset($first_name) or !isset($last_name) or !isset($email_address) or !isset($password)){
    header("Location: /admin/medlemmar?c_id=$class_id&add_user=valuemissing");
    exit();
  }

  // Check valid mail

  // Check mail ends with vrg.se

  if (username_exists( $email_address )){
    // Send error header
    header("Location: /admin/medlemmar?c_id=$class_id&add_user=emailexists");
    exit();
  } else {
    // Generate a 15 character long password with special characters
    // $password = wp_generate_password(16, true);

    $user_id = wp_create_user($email_address, $password, $email_address);

    wp_update_user(
      array(
        'ID'       => $user_id,
        'nickname' => $first_name . ' ' . $last_name
      )
    );

    // Default to not a member in the elevkår
    add_user_meta( $user_id, 'status', 'n' );

    // Set the class for the user
    add_user_meta( $user_id, 'class_id', $class->id );

    // Set user role
    $user = new WP_User( $user_id );
    $user->set_role( 'subscriber' );

    // Mail the user
    // wp_mail( $email_address, 'Välkommen till Viktor Rydberg Odenplans hemsida!', 'Ditt lösenord är: ' . $password . '. Logga in för att ändra lösenordet.' );
    wp_mail( $email_address, 'Välkommen till Viktor Rydberg Odenplans hemsida!', 'Hej! Välkommen till Viktor Rydbergs Odenplans hemsida! Gå in på vroelevkar.se för att se matsedeln, ansöka till kommittéer och mycket mer!' );

    //Success!
    header("Location: /admin/medlemmar?c_id=$class->id&add_user=success");
    exit();
  }

}

else {
  header("Location: /admin/medlemmar?add_user=error");
  exit();
} // End post
