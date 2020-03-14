<?php

  // Include wp_core
  require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

  // Include helpful functions
  include_once('helpful_functions.php');

  global $wpdb;

  if (got_post('add_new_projektgrupp')) {

    // Set the return location
    $return = '/panel/projektgrupper?add_projektgrupp';

    // Get the submittet values
    $p_name = check_post( $_POST['p_name'], $return . '=empty' );
    $p_description = check_post( $_POST['p_description'], $return . '=empty' );

    // Check if projektgrupp already exists
    check_if_entry_exists( 'vro_projektgrupper', 'name', $p_name );

    // Insert the new one
    $projektgrupp = array();
    $projektgrupp['name'] = $p_name;
    $projektgrupp['description'] = $p_description;

    insert_record( 'vro_projektgrupper', $projektgrupp, 'DB insertion failed: Failed to add projektgrupp in add_new_projektgrupp' );

    send_header( $return . '=success' );
  }

  elseif (got_post('remove_projektgrupp')){

    // Set the return location
    $return = '/panel/projektgrupper?remove_projektgrupp';

    $p_id = $_POST['p_id'];
    $p_id = check_number_value( $p_id, $return );

    // Remoe all student records in the kommitt+r
    remove_record( 'vro_projektgrupper_members', 'projektgrupp_id', $p_id, 'DB deletion failed: failed to remove member in remove_projektgrupp' );

    // Remove the actual kommitt+e
    remove_record( 'vro_projektgrupper', 'id', $p_id, 'DB deletion failed: failed to remove projektgrupp in remove_projektgrupp' );

    // Duccess!
    send_header( $return . '=success' );

  }

  elseif (got_post('join_projektgrupp')) {

    // Set the return location
    $return = '/panel/projektgrupper?join_projektgrupp';

    $p_id = check_number_value( test_input( $_POST['p_id'] ), $return);

    // If p_id eists, change the return
    $return = "/panel/projektgrupper?p_id=$p_id&join_projektgrupp";

    $u_id = check_number_value( test_input( $_POST['u_id'] ), $return);

    // Add student to projektgrupp
    $member_projektgrupp = array();
    $member_projektgrupp['user_id'] = $u_id;
    $member_projektgrupp['projektgrupp_id'] = $p_id;

    insert_record('vro_projektgrupper_members', $member_projektgrupp, 'DB insertion failed: Failed to add student to projektgrupp in join_projektgrupp');

    send_header( $return . '=success' );

  }

  elseif (got_post('leave_projektgrupp')) {

    // Set the return location
    $return = '/panel/projektgrupper?leave_projektgrupp';

    $p_id = check_number_value( test_input( $_POST['p_id'] ), $return);

    // If p_id eists, change the return
    $return = "/panel/projektgrupper?p_id=$p_id&leave_projektgrupp";

    $u_id = check_number_value( test_input( $_POST['u_id'] ), $return);

    // Delete the student from the record
    delete_record('vro_projektgrupper_members', array( 'projektgrupp_id' => $p_id, 'user_id' => $u_id ), 'DB deletion failed: Failed to remove student from projektgrupp in leave_projektgrupp');

    send_header( $return . '=success' );
  }

  elseif (got_post('add_student')) {

    global $wpdb;

    $return = '/panel/projektgrupper?add_student';
    $p_id = check_number_value( test_input( $_POST['p_id'] ), $return);

    $return = "/panel/projektgrupper?p_id=$p_id&add_member";
    $student_name = check_post( $_POST['student_name'], $return );

    if (!check_if_entry_exists('vro_projektgrupper', 'id', $p_id)) {
      send_header($return . '=noprojektgruppfound');
    }

    // Get the student with the supplied nickname
    $student = get_student_from_nickname($student_name, $return . "=nostudentfound");

    // Check if student already exists
    if (count($wpdb->get_results('SELECT * FROM vro_projektgrupper_members WHERE projektgrupp_id = ' . $p_id . ' AND user_id = '. $student[0]->ID)) > 0){
      send_header($return . '=studentalreadyadded');
    }

    // Add student to kommitté
    $new_member = array();

    $new_member['user_id'] = $student[0]->ID;
    $new_member['projektgrupp_id'] = $p_id;

    // Insert the new suggestion into the database
    insert_record('vro_projektgrupper_members', $new_member, "DB insertion failed: failed to add new student in add_student in projektgrupper");

    // Logg action
    $log_description = $student[0]->ID . ' lades till i projektgrupen ' . $p_id;
    add_log( 'Projektgrupper', $log_description, get_current_user_id() );

    send_header($return . '=success');

  }
