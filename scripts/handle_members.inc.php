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
    header("Location: /panel/medlemmar?toggle_member=noclassid");
    exit();
  }

  if ( empty($student_id) ){
    header("Location: /panel/medlemmar/?c_id=$class_id&toggle_member=empty");
    exit();
  } else {

    if(!is_numeric($student_id)){
      header("Location: /panel/medlemmar/?c_id=$class_id&toggle_member=empty");
      exit();
    }

    $status = get_user_meta($student_id, 'status');

    if (!$status[0]){
      header("Location: /panel/medlemmar/?c_id=$class_id&toggle_member=nouser");
      exit();
    }

    $new_status = ($status[0] == 'y') ? 'n' : 'y';

    if (!update_user_meta($student_id, 'status', $new_status)){
      wp_die('meta could not be changed');
    }
    else {
      // Success!
      header("Location: /panel/medlemmar/?c_id=$class_id&toggle_member=success");
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
  $phonenumber = test_input( $_POST['phonenumber'] );

  // $end_year = test_input ( $_POST['end_year'] );
  $password = $_POST['password'];
  $class_id = $_POST['class_id'];

  // INPUT VALIDATION

  // Check if a class id or a class name has been supplied
  if (isset($class_id)) {
    if (!is_numeric($class_id)) {
      header("Location: /panel/medlemmar?add_user=nan");
      exit();
    }
    // Get class with id
    $class = $wpdb->get_row('SELECT * FROM vro_classes WHERE id=' . (int)$class_id);
    $class_name = $class->name;

  } elseif (isset($class_name)) {

    // Make sure the first letter i capitilized
    $class_name = ucfirst( strtolower( $class_name ) );

    // Get class with name
    $class = $wpdb->get_row('SELECT * FROM vro_classes WHERE name="' . $class_name . '"');

  } else {
    // No class name or id supplied
    header("Location: /panel/medlemmar?add_user=noclass");
    exit();
  }

  // Check if a class was found with the given class id or class name
  if (!$class) {
    header("Location: /panel/medlemmar?c_id=$class_id&add_user=noclassfound");
    exit();
  }

  if (!isset($first_name) or !isset($last_name) or !isset($email_address) or !isset($password) or !isset($phonenumber)){
    header("Location: /panel/medlemmar?c_id=$class_id&add_user=empty");
    exit();
  }

  // Check valid mail
  if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
    header("Location: /panel/medlemmar?c_id=$class_id&add_user=invalidemail&first_name=$first_name&last_name=$last_name");
    exit();
  }

  // Check mail ends with vrg.se
  if (! (substr($email_address, -6) == 'vrg.se')){
    header("Location: /panel/medlemmar?c_id=$class_id&add_user=invalidemail&first_name=$first_name&last_name=$last_name");
    exit();
  }

  // IF INPUT END YEAR SELF
  // CHeck the end year is numeric
  // if (!is_numeric($end_year)) {
  //   header("Location: /panel/medlemmar?c_id=$class_id&add_user=invalidyear&first_name=$first_name&last_name=$last_name&email=$email_address");
  //   exit();
  // }
  //
  // // Convert just in case
  // $end_year = (int)$end_year;
  //
  // // Check it is 4 digits
  // if ($end_year < 999 or $end_year > 9999){
  //   header("Location: /panel/medlemmar?c_id=$class_id&add_user=invalidyear&first_name=$first_name&last_name=$last_name");
  //   exit();
  // }

  // Get the end year from the class name
  $yearFromClassName = substr($class_name, 2, 2);

  // Get the year in 4-digit form
  $yearFromClassName = date_create_from_format('y', $yearFromClassName);
  $yearFromClassName = $yearFromClassName->format('Y');

  if (!is_numeric($yearFromClassName)){
    header("Location: /panel/medlemmar?c_id=$class_id&add_user=noyearfound&first_name=$first_name&last_name=$last_name");
    exit();
  }

  // Convert to int
  $end_year = (int)$yearFromClassName;

  // Check it is 4 digits
  if ($end_year < 999 or $end_year > 9999){
    header("Location: /panel/medlemmar?c_id=$class_id&add_user=invalidyear&first_name=$first_name&last_name=$last_name");
    exit();
  }

  if (username_exists( $email_address )){
    // Send error header
    header("Location: /panel/medlemmar?c_id=$class_id&add_user=emailexists");
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

    // Default to not waiting member in the elevkår
    add_user_meta( $user_id, 'status', 'w' );

    // Set the class for the user
    add_user_meta( $user_id, 'class_id', $class->id );

    // Set the end year
    add_user_meta( $user_id, 'end_year', $end_year );

    // Set the phonenumber
    add_user_meta( $user_id, 'phonenumber', $phonenumber );

    // Set user role
    $user = new WP_User( $user_id );
    $user->set_role( 'subscriber' );

    // Mail the user
    // wp_mail( $email_address, 'Välkommen till Viktor Rydberg Odenplans hemsida!', 'Ditt lösenord är: ' . $password . '. Logga in för att ändra lösenordet.' );
    wp_mail( $email_address, 'Välkommen till Viktor Rydberg Odenplans hemsida!', 'Hej '. $first_name .'! Välkommen till Viktor Rydbergs Odenplans hemsida! Gå in på vroelevkar.se för att se matsedeln, ansöka till kommittéer och mycket mer!' );

    //Success!
    header("Location: /panel/medlemmar?c_id=$class->id&add_user=success");
    exit();
  }

}

elseif (isset($_POST['register_new_user'])) {
  global $wpdb;

  $first_name = test_input( $_POST['first_name'] );
  $last_name = test_input( $_POST['last_name'] );
  $email_address = $_POST['email_address'];
  $class_name = test_input( $_POST['class_name'] );
  $phonenumber = test_input( $_POST['phonenumber'] );
  // $end_year = test_input ( $_POST['end_year'] );
  $password = $_POST['password'];

  // INPUT VALIDATION

  // Check if a class id or a class name has been supplied
  if (isset($class_name)) {

    // Make sure the first letter i capitilized
    $class_name = ucfirst( strtolower( $class_name ) );

    // Get class with name
    $class = $wpdb->get_row('SELECT * FROM vro_classes WHERE name="' . $class_name . '"');

  } else {
    // No class name or id supplied
    header("Location: /register?add_user=noclass");
    exit();
  }

  // Check if a class was found with the given class id or class name
  if (!$class) {
    header("Location: /register?add_user=noclassfound");
    exit();
  }

  if (!isset($first_name) or !isset($last_name) or !isset($email_address) or !isset($password) or !isset($phonenumber) ){
    header("Location: /register?class_name=$class_name&add_user=empty");
    exit();
  }

  // Check valid mail
  if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
    header("Location: /register?class_name=$class_name&add_user=invalidemail&first_name=$first_name&last_name=$last_name");
    exit();
  }

  // Check mail ends with vrg.se
  if (! (substr($email_address, -6) == 'vrg.se')){
    header("Location: /register?class_name=$class_name&add_user=invalidemail&first_name=$first_name&last_name=$last_name");
    exit();
  }

  // IF INPUT END YEAR SELF
  // CHeck the end year is numeric
  // if (!is_numeric($end_year)) {
  //   header("Location: /register?class_name=$class_name&add_user=invalidyear&first_name=$first_name&last_name=$last_name&email=$email_address");
  //   exit();
  // }
  //
  // // Convert just in case
  // $end_year = (int)$end_year;
  //
  // // Check it is 4 digits
  // if ($end_year < 999 or $end_year > 9999){
  //   header("Location: /register?class_name=$class_name&add_user=invalidyear&first_name=$first_name&last_name=$last_name");
  //   exit();
  // }

  // Get the end year from the class name
  $yearFromClassName = substr($class_name, 2, 2);

  // Get the year in 4-digit form
  $yearFromClassName = date_create_from_format('y', $yearFromClassName);
  $yearFromClassName = $yearFromClassName->format('Y');

  if (!is_numeric($yearFromClassName)){
    header("Location: /register?class_name=$class_name&add_user=noyearfound&first_name=$first_name&last_name=$last_name");
    exit();
  }

  // Convert to int
  $end_year = (int)$yearFromClassName;

  // Check it is 4 digits
  if ($end_year < 999 or $end_year > 9999){
    header("Location: /register?class_name=$class_name&add_user=invalidyear&first_name=$first_name&last_name=$last_name");
    exit();
  }

  if (username_exists( $email_address )){
    // Send error header
    header("Location: /register?class_name=$class_name&add_user=emailexists");
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

    // Set the end year
    add_user_meta( $user_id, 'end_year', $end_year );

    // Set the phonenumber
    add_user_meta( $user_id, 'phonenumber', $phonenumber );

    // Set user role
    $user = new WP_User( $user_id );
    $user->set_role( 'subscriber' );

    // Mail the user
    // wp_mail( $email_address, 'Välkommen till Viktor Rydberg Odenplans hemsida!', 'Ditt lösenord är: ' . $password . '. Logga in för att ändra lösenordet.' );
    wp_mail( $email_address, 'Välkommen till Viktor Rydberg Odenplans hemsida!', 'Hej '. $first_name .'! Välkommen till Viktor Rydbergs Odenplans hemsida! Gå in på vroelevkar.se för att se matsedeln, ansöka till kommittéer och mycket mer!' );

    // Login user
    wp_set_current_user( $user_id, $user->user_login );
    wp_set_auth_cookie( $user_id );
    do_action( 'wp_login', $user->user_login );

    //Success!
    header("Location: /panel/dashboard?register=success");
    exit();
  }

}

elseif(isset($_POST['quit_being_member'])) {

  // Get the user id
  $u_id = test_input( $_POST['student_id'] );

  if (empty($u_id) or !is_numeric($u_id)){
    header("Location: /panel/medlemmar?quitmember=baduid");
    exit();
  }

  $u_id = (int)$u_id;

  $member_answer = test_input( $_POST['member_answer'] );

  // Update their status to n, so they are not part of elevkåren any longer
  if (!update_user_meta($u_id, 'status', 'n')) {
    header("Location: /panel/medlemmar?quitmember=updatefailed");
    exit();
  } else {
    if (!empty($member_answer)){
      if ($student = get_user_by('id', $u_id)) {
        // Send the mail
        $email_address = $student->user_email;
        wp_mail( $email_address, 'Din medlemsansökan har nekats', $member_answer);
      }
    }

    header("Location: /panel/medlemmar?quitmember=success");
    exit();
  }

}

elseif(isset($_POST['apply_for_member'])) {

  // Get the user id
  $u_id = test_input( $_POST['student_id'] );

  if (empty($u_id) or !is_numeric($u_id)){
    header("Location: /panel/medlemmar?applymember=baduid");
    exit();
  }

  $u_id = (int)$u_id;

  // Update their status to n, so they are not part of elevkåren any longer
  if (!update_user_meta($u_id, 'status', 'w')) {
    header("Location: /panel/medlemmar?applymember=updatefailed");
    exit();
  } else {
    header("Location: /panel/medlemmar?applymember=success");
    exit();
  }

}

elseif(isset($_POST['accept_member'])) {

  // Get the user id
  $u_id = test_input( $_POST['student_id'] );

  if (empty($u_id) or !is_numeric($u_id)){
    header("Location: /panel/medlemmar?applymember=baduid");
    exit();
  }

  $u_id = (int)$u_id;

  $member_answer = test_input( $_POST['member_answer'] );

  // Update their status to n, so they are not part of elevkåren any longer
  if (!update_user_meta($u_id, 'status', 'y')) {
    header("Location: /panel/medlemmar?acceptmember=acceptfailed");
    exit();
  } else {
    if (!empty($member_answer)){
      if ($student = get_user_by('id', $u_id)) {
        // Send the mail
        $email_address = $student->user_email;
        wp_mail( $email_address, 'Din medlemsansökan har godkänts', $member_answer);
      }
    }

    header("Location: /panel/medlemmar?acceptmember=success");
    exit();
  }

}

else {
  header("Location: /panel/medlemmar?add_user=error");
  exit();
} // End post
