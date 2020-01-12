<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");
require_once ABSPATH . '/wp-admin/includes/taxonomy.php';

// Include helpful functions
include_once('helpful_functions.php');

// Create database entry
if (isset($_POST['send_notification_kommitte'])) {

  global $wpdb;

  $title = test_input( $_POST['title'] );
  $content = test_input( $_POST['content'] );
  $k_id = test_input( $_POST['k_id'] );

  if (empty($k_id) || !is_numeric($k_id) ){
    header("Location: /panel/kommiteer?send_notification=badk_id");
    exit();
  }

  if ( empty($title) || empty($content) ){
    header("Location: /panel/kommiteer?k_id=$k_id&send_notificatione=empty");
    exit();
  } else {

    // Set a category name
    $cat_name = 'kommitte_' . $k_id;

    // Create new category for this kommitté if it does not already exist
    if ( !category_exists( $cat_name ) ) {
      // Create a new category and get the category id
      $cat_id = wp_create_category( $cat_name );

    } else {

      // Get the id of the category
      $cat_id = get_cat_ID( $cat_name );
    }

    // If cat_id is 0, then it could not create the category
    if ( $cat_id == 0 ){
      header("Location: /panel/kommiteer?k_id=$k_id&send_notificatione=errorcreatecategory");
      exit();
    }

    // Get all memeber
    $post_args = array(
        'post_title' => $title,
        'post_content' => $content,
        'post_category' => array( $cat_id ),
        'post_status' => 'publish'
    );

    // insert the post
    if ( !$post_id = wp_insert_post( $post_args, $error ) ){
      wp_die( $error );
    } else {

      // Add post meta
      $kom_name = $wpdb->get_row('SELECT * FROM vro_kommiteer WHERE id=' . $k_id)->name;

      add_post_meta( $post_id, 'kommitte_name', $kom_name );

      // SUccess
      header("Location: /panel/kommiteer?k_id=$k_id&send_notification=success");
      exit();

    }
  }

}

else {
  header("Location: /panel/kommiteer?send_notification=error");
  exit();
} // End post
