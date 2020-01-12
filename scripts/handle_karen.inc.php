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

}

elseif (isset($_POST['add_new_styrelse_post'])) {

  $styrelse_post = test_input( $_POST['styrelsepost'] );
  $student_name = test_input( $_POST['student_name'] );

  if (empty($styrelse_post)){
    header("Location: /panel/karen?new_styrelse_poste=empty");
    exit();
  }

  $styrelse = array();

  $styrelse['position_name'] = $styrelse_post;

  if (!empty($student_name)){

    // Get the student with the supplied nickname
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'nickname',
                'value' => $student_name,
                'compare' => '=='
            )
        )
    );

    // Get the student
    $student = get_users($args);

    // If there is a student
    if (count($student) > 0){
      $styrelse['student'] = $student[0]->ID;
    }

  }

  // Insert the new suggestion into the database
  if($wpdb->insert(
      'vro_styrelsen',
      $styrelse
  ) == false) {
    wp_die('database insertion failed');
  }

  header("Location: /panel/karen?new_styrelse_poste=success");
  exit();

}

elseif (isset($_POST['add_new_utskott'])){

  $utskott_name = test_input( $_POST['utskott_name'] );
  $student_name = test_input( $_POST['student_name'] );
  $description = test_input( $_POST['description'] );

  if (empty($utskott_name) ){
    header("Location: /panel/karen?new_utskott=empty");
    exit();
  }

  $utskott = array();

  $utskott['name'] = $utskott_name;

  if (!empty($student_name)){

    // Get the student with the supplied nickname
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'nickname',
                'value' => $student_name,
                'compare' => '=='
            )
        )
    );

    // Get the student
    $student = get_users($args);

    // If there is a student
    if (count($student) > 0){
      $utskott['student'] = $student[0]->ID;
    }

  }

  if (!empty($description)){
    $utskott['description'] = $description;
  }

  // Insert the new suggestion into the database
  if($wpdb->insert(
      'vro_utskott',
      $utskott
  ) == false) {
    wp_die('database insertion failed');
  }

  header("Location: /panel/karen?new_utskott=success");
  exit();
}

elseif (isset($_POST['update_styrelse_post'])){

  $styrelse_post = test_input( $_POST['position_name'] );
  $student_name = test_input( $_POST['student_name'] );
  $position_id = test_input( $_POST['position_id'] );

  if (empty($styrelse_post)){
    header("Location: /panel/karen?alter_styrelse_post=empty");
    exit();
  }

  // CHeck id
  $id_response = check_id( $position_id, 'vro_styrelsen' );

  if ($id_response[0] == false){
    header("Location: /panel/karen?alter_styrelse_post=". $id_response[1]);
    exit();
  }

  $position_id = (int)$position_id;

  if (value_exists_in_table( $styrelse_post, 'position_name', 'vro_styrelsen', $position_id )){
    header("Location: /panel/karen?alter_styrelse_post=nameexists");
    exit();
  }

  $styrelse = array();

  $styrelse['position_name'] = $styrelse_post;

  if (!empty($student_name)){

    // Get the student with the supplied nickname
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'nickname',
                'value' => $student_name,
                'compare' => '=='
            )
        )
    );

    // Get the student
    $student = get_users($args);

    // If there is a student
    if (count($student) > 0){
      $styrelse['student'] = $student[0]->ID;
    } else {
      $styrelse['student'] = NULL;
    }

  } else {
    $styrelse['student'] = NULL;
  }

  // Insert the new suggestion into the database
  if ( !$wpdb->query( $wpdb->prepare('UPDATE vro_styrelsen SET position_name = %s, student = %s WHERE id = %s', $styrelse['position_name'], $styrelse['student'], $position_id) ) ){
    wp_die('database alterartion failed. Alter styrelse member');
  } else{
    //

    header("Location: /panel/karen?alter_styrelse_post=success");
    exit();
  }


}

elseif (isset($_POST['delete_styrelse_post'])) {

  $position_id = test_input( $_POST['position_id'] );

  // CHeck id
  $id_response = check_id( $position_id, 'vro_styrelsen' );

  if ($id_response[0] == false){
    header("Location: /panel/karen?remove_styrelse_post=". $id_response[1]);
    exit();
  }

  $position_id = (int)$position_id;

  if (!$wpdb->delete( 'vro_styrelsen', array( 'id' => $position_id ) ) ) {
    wp_die('could not delete styrelse post');
  } else {
    header("Location: /panel/karen?remove_styrelse_post=success");
    exit();
  }

}

elseif (isset($_POST['edit_utskott'])){

  $utskott_name = test_input( $_POST['utskott_name'] );
  $chairman_name = test_input( $_POST['chairman_name'] );
  $utskott_id = test_input( $_POST['utskott_id'] );
  $utskott_description = test_input( $_POST['utskott_description'] );

  if (empty($utskott_name)){
    header("Location: /panel/karen?edit_utskott=empty");
    exit();
  }

  // CHeck id
  $id_response = check_id( $utskott_id, 'vro_utskott' );

  if ($id_response[0] == false){
    header("Location: /panel/karen?edit_utskott=". $id_response[1]);
    exit();
  }

  $utskott_id = (int)$utskott_id;

  if (value_exists_in_table( $utskott_name, 'name', 'vro_utskott', $utskott_id )){
    header("Location: /panel/karen?edit_utskott=nameexists");
    exit();
  }

  $utskott = array();

  $utskott['name'] = $utskott_name;

  if (!empty($chairman_name)){

    // Get the student with the supplied nickname
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'nickname',
                'value' => $chairman_name,
                'compare' => '=='
            )
        )
    );

    // Get the student
    $chairman = get_users($args);

    // If there is a student
    if (count($chairman) > 0){
      $utskott['chairman'] = $chairman[0]->ID;
    } else {
      $utskott['chairman'] = NULL;
    }

  } else {
    $utskott['chairman'] = NULL;
  }

  if (empty($utskott_description)){
    $utskott['description'] = '';
  } else {
    $utskott['description'] = $utskott_description;
  }

  // Insert the new suggestion into the database

  if ( !$wpdb->update('vro_utskott', array('name' => ''. $utskott['name'] .'', 'description' => ''. $utskott['description'] .'', 'chairman' => $utskott['chairman']), array('id' => $utskott_id)) ){
    wp_die('edit utskott failed');
  } else{
    //

    header("Location: /panel/karen?edit_utskott=success");
    exit();
  }

}

elseif (isset($_POST['delete_utskott'])){

  $utskott_id = test_input( $_POST['utskott_id'] );

  // CHeck id
  $id_response = check_id( $utskott_id, 'vro_utskott' );

  if ($id_response[0] == false){
    header("Location: /panel/karen?remove_utskott=". $id_response[1]);
    exit();
  }

  $position_id = (int)$position_id;

  if (!$wpdb->delete( 'vro_utskottn', array( 'id' => $utskott_id ) ) ) {
    wp_die('could not delete utskott');
  } else {
    header("Location: /panel/karen?remove_utskott=success");
    exit();
  }

}

else {
  header("Location: /panel/karen?new_position_type=error");
  exit();
} // End post
