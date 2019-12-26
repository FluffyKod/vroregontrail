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
      header("Location: /test?application=empty");
      exit();
    } else {

      // Check if there already is a kommitée with that name
      if ( count($wpdb->get_results('SELECT * FROM vro_kommiteer WHERE name="'. $new_name .'"')) > 0 ) {
        header("Location: /test?application=nametaken&the_description=$new_description");
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

            header("Location: /test?application=success");
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

      // Reload the page
      // wp_redirect($_SERVER['HTTP_REFERER']);
      header("Location: /admin/kommiteer?change=success");
      exit();

    }

    // Check if eny buttons are pressed
    elseif (isset($_POST['deny_kommitee']) && !empty($_POST['deny_kommitee']) ){

      // Change the specified kommitée to be denied
      $wpdb->query( $wpdb->prepare('UPDATE vro_kommiteer SET status = "n" WHERE id = %s', $_POST['deny_kommitee']));

      // Reload the page
      // wp_redirect($_SERVER['HTTP_REFERER']);
      header("Location: /admin/kommiteer?change=success");
      exit();

    }

  }

  else {
    header("Location: /test?application=error");
    exit();
  } // End post
