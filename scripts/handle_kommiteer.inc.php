<?php

  // Include wp_core
  require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

  // Include helpful functions
  include_once('helpful_functions.php');

  /*****************************************
  * Create new kommitee application
  *****************************************/

  // Create database entry
  if (isset($_POST['new_kommitee'])) {

    global $wpdb;

    $new_name = test_input( $_POST['namn'] );
    $new_description = test_input( $_POST['description'] );

    if ( empty($new_name) || empty($new_description) ){
      header("Location: /panel/kommiteer?application=empty");
      exit();
    } else {

      // Check if there already is a kommitée with that name
      if ( count($wpdb->get_results('SELECT * FROM vro_kommiteer WHERE name="'. $new_name .'"')) > 0 ) {
        header("Location: /panel/kommiteer?application=nametaken&the_description=$new_description");
        exit();
      } else {

        // Create a new array that will hold all the arguments to create a new kommitee
        $kommitee = array();

        $kommitee['name'] = $new_name;
        $kommitee['description'] = $new_description;
        $kommitee['chairman'] = get_current_user_id();

        if($wpdb->insert(
              'vro_kommiteer',
              $kommitee
          ) == false) {
            wp_die('database insertion failed');
        } else {

            // Set the chairman as a new member
            $new_kommitee = $wpdb->get_results('SELECT * FROM vro_kommiteer WHERE name="'. $new_name .'"');

            $kommitee = array();

            $kommitee['user_id'] = get_current_user_id();
            $kommitee['kommitee_id'] = $new_kommitee[0]->id;
            $kommitee['status'] = 'y';

            // Insert the new suggestion into the database
            if($wpdb->insert(
                'vro_kommiteer_members',
                $kommitee
            ) == false) {
              wp_die('database insertion failed');
            }

            header("Location: /panel/kommiteer?application=success");
            exit();

          } // End wpdb->insert

      }

    }

  }

  elseif (isset($_POST['accept_kommitee']) || isset($_POST['deny_kommitee'])) {

    /*****************************************
    * Change status
    *****************************************/

    global $wpdb;

    // Check if accept button is pressed for a kommitée application
    if (isset($_POST['accept_kommitee']) && !empty($_POST['accept_kommitee'])){

      // Change the specified kommitée to official
      $wpdb->query( $wpdb->prepare('UPDATE vro_kommiteer SET status = "y" WHERE id = %s', $_POST['accept_kommitee']));

      // Send mail
      $chairman_id = 

      // Redirect with success message
      header("Location: /panel/kommiteer?change=success");
      exit();

    }

    // Check if eny buttons are pressed
    elseif (isset($_POST['deny_kommitee']) && !empty($_POST['deny_kommitee']) ){

      // Change the specified kommitée to be denied
      $wpdb->query( $wpdb->prepare('UPDATE vro_kommiteer SET status = "n" WHERE id = %s', $_POST['deny_kommitee']));

      // Redirect with success message
      header("Location: /panel/kommiteer?change=success");
      exit();

    }

  }

  elseif (isset($_POST['accept_kommitee_member']) || isset($_POST['deny_kommitee_member'])) {

    /*****************************************
    * Change status
    *****************************************/

    global $wpdb;

    // Check kommité id
    $k_id = $_POST['kid'];

    $member_message = test_input( $_POST['kommitee_member_answer'] );

    if (!is_numeric($k_id)){
      header("Location: /panel/kommiteer?komitte_member=nokid");
      exit();
    }

    $k_id = (int)$k_id;

    // Get the kommitté name
    $kommitte_name = ($wpdb->get_row('SELECT * FROM vro_kommiteer WHERE id='. $k_id))->name;

    // Check if accept button is pressed for a kommitée application
    if (isset($_POST['accept_kommitee_member']) && !empty($_POST['accept_kommitee_member']) && isset($_POST['kid'])) {

      $u_id = $_POST['accept_kommitee_member'];

      if (!is_numeric($u_id)){
        header("Location: /panel/kommiteer?k_id=$k_id&komitte_member=nan");
        exit();
      }

      $u_id = (int)$u_id;

      // Change the specified wanting member to official member
      $accept_sql = 'UPDATE vro_kommiteer_members SET status = "y" WHERE kommitee_id= '. $k_id .' AND user_id = '. $u_id;
      $wpdb->query( $wpdb->prepare( $accept_sql ) );

      // Check if there was a message
      if (!empty($member_message) && !empty($kommitte_name)){
        // Get the applying student
        if ($student = get_user_by('id', $u_id)) {
          // Send the mail
          $email_address = $student->user_email;
          wp_mail( $email_address, 'Din ansökan till '. $kommitte_name .' har godkänts', $member_message );
        }
      }

      // Redirect with success message
      header("Location: /panel/kommiteer?k_id=$k_id&komitte_member=success");
      exit();

    }

    // Check if eny buttons are pressed
    elseif (isset($_POST['deny_kommitee_member']) && !empty($_POST['deny_kommitee_member']) && isset($_POST['kid']) ){

      $u_id = $_POST['deny_kommitee_member'];

      if (!is_numeric($u_id)){
        header("Location: /panel/kommiteer?k_id=$k_id&komitte_member=nan");
        exit();
      }

      $u_id = (int)$u_id;

      // Change the specified wanting member to official member
      $deny_sql = 'UPDATE vro_kommiteer_members SET status = "n" WHERE kommitee_id= '. $k_id .' AND user_id = '. $u_id;
      $wpdb->query( $wpdb->prepare( $deny_sql ) );

      // Check if there was a message
      if (!empty($member_message) && !empty($kommitte_name)){
        // Get the applying student
        if ($student = get_user_by('id', $u_id)) {
          // Send the mail
          $email_address = $student->user_email;
          wp_mail( $email_address, 'Din ansökan till '. $kommitte_name .' har nekats', $member_message );
        }
      }

      //Redirect with success message
      header("Location: /panel/kommiteer?k_id=$k_id&komitte_member=success");
      exit();

    }



  }

  elseif (isset($_POST['apply_for_kommitte'])){

    global $wpdb;

    // Get the id's
    $k_id = test_input( $_POST['kommitte_id'] );
    $student_id = test_input( $_POST['student_id'] );

    // INPUT VALIDATION
    if (empty($k_id)){
      header("Location: /panel/kommiteer?apply_kommitte=nokid");
      exit();
    }

    if (!is_numeric($k_id)){
      header("Location: /panel/kommiteer?apply_kommitte=nan");
      exit();
    }

    $k_id = (int)$k_id;

    if (empty($student_id)){
      header("Location: /panel/kommiteer?k_id=$k_id&apply_kommitte=empty");
      exit();
    }

    if (!is_numeric($student_id)){
      header("Location: /panel/kommiteer?k_id=$k_id&apply_kommitte=nan");
      exit();
    }

    $student_id = (int)$student_id;

    // Check if this user already has sent an application
    if ( count($wpdb->get_results('SELECT * FROM vro_kommiteer_members WHERE user_id='. $student_id .' AND kommitee_id='. $k_id .'')) > 0 ) {
      header("Location: /panel/kommiteer?k_id=$k_id&apply_kommitte=alreadythere");
      exit();
    } else {

      // Insert an application
      $new_application = array();

      $new_application['user_id'] = $student_id;
      $new_application['kommitee_id'] = $k_id;
      $new_application['status'] = 'w';

      // Insert the new suggestion into the database
      if($wpdb->insert(
          'vro_kommiteer_members',
          $new_application
      ) == false) {
        wp_die('database insertion failed');
      } else {
        header("Location: /panel/kommiteer?k_id=$k_id&apply_kommitte=success");
        exit();
      }

    }

  }

  elseif (isset($_POST['leave_kommitte'])){
    global $wpdb;

    // Get the id's
    $k_id = test_input( $_POST['kommitte_id'] );
    $student_id = test_input( $_POST['student_id'] );

    // INPUT VALIDATION
    if (empty($k_id)){
      header("Location: /panel/kommiteer?leave_kommitte=nokid");
      exit();
    }

    if (!is_numeric($k_id)){
      header("Location: /panel/kommiteer?leave_kommitte=nan");
      exit();
    }

    $k_id = (int)$k_id;

    if (empty($student_id)){
      header("Location: /panel/kommiteer?k_id=$k_id&leave_kommitte=empty");
      exit();
    }

    if (!is_numeric($student_id)){
      header("Location: /panel/kommiteer?k_id=$k_id&leave_kommitte=nan");
      exit();
    }

    $student_id = (int)$student_id;

    $kommitte = $wpdb->get_row('SELECT * FROM vro_kommiteer WHERE id='. $k_id );

    //Check if chairman
    if ($student_id == $kommitte->chairman) {
      header("Location: /panel/kommiteer?k_id=$k_id&leave_kommitte=ischairman");
      exit();
    }

    // Delete the student from the record
    $wpdb->delete( 'vro_kommiteer_members', array( 'kommitee_id' => $k_id, 'user_id' => $student_id ) );

    header("Location: /panel/kommiteer?k_id=$k_id&leave_kommitte=success");
    exit();
  }

  elseif (isset($_POST['change_kommitte_description'])){

    global $wpdb;

    $new_description = test_input( $_POST['kommitee_description'] );
    $k_id = test_input( $_POST['k_id'] );

    if (empty($k_id) or !is_numeric($k_id)){
      header("Location: /panel/kommiteer?alter_description=emptyornan");
      exit();
    }

    $k_id = (int)$k_id;

    if (empty($new_description)){
      header("Location: /panel/kommiteer?k_id=$k_id&alter_description=empty");
      exit();
    }

    // Update the description
    if (!$wpdb->query( $wpdb->prepare('UPDATE vro_kommiteer SET description = %s WHERE id = %s', $new_description, $k_id))) {
      header("Location: /panel/kommiteer?k_id=$k_id&alter_description=failed");
      exit();
    } else {
      header("Location: /panel/kommiteer?k_id=$k_id&alter_description=success");
      exit();
    }
  }

  elseif (isset($_POST['change_chairman'])){

    global $wpdb;

    $k_id = test_input( $_POST['k_id'] );
    $new_chairman_name = test_input( $_POST['new_chairman_name'] );

    if (empty($k_id) or !is_numeric($k_id)){
      header("Location: /panel/kommiteer?alter_chairman=emptyornan");
      exit();
    }

    $k_id = (int)$k_id;

    if (empty($new_chairman_name)){
      header("Location: /panel/kommiteer?k_id=$k_id&alter_chairman=empty");
      exit();
    }

    // Get the student with the supplied nickname
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'nickname',
                'value' => $new_chairman_name,
                'compare' => '=='
            )
        )
    );

    // Get the student
    $student = get_users($args);

    if (count($student) < 1) {
      header("Location: /panel/kommiteer?k_id=$k_id&alter_chairman=nostudentfound");
      exit();
    }

    if (!$wpdb->query( $wpdb->prepare('UPDATE vro_kommiteer SET chairman = %s WHERE id = %s', $student[0]->ID, $k_id))) {
      header("Location: /panel/kommiteer?k_id=$k_id&alter_chairman=failed");
      exit();
    } else {
      header("Location: /panel/kommiteer?k_id=$k_id&alter_chairman=success");
      exit();
    }

  }

  else {
    header("Location: /panel/kommiteer?kommitte=error");
    exit();
  } // End post
