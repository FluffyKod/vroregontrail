<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// INclude heplful functions
require_once(get_template_directory() . "/scripts/helpful_functions.php");

/*****************************************
* Login
*****************************************/

// Custom Login
function my_custom_login() {
  echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/css/custom-login-style.css" />';
}
add_action('login_head', 'my_custom_login');

add_filter( 'register_url', 'my_register_url' );
function my_register_url( $url ) {
    return '/register';
}

// Change logo url
function custom_login_logo_url() {
  return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_login_logo_url' );

// Change login title
function custom_login_logo_url_title() {
  return 'Viktor Rydberg Odenplan';
}
add_filter( 'login_headertitle', 'custom_login_logo_url_title' );

// Change login redirect
function custom_login_redirect( $redirect_to, $request, $user ) {
  global $user;

  // Check the user role of logged in user and send them to different default places
  if( isset( $user->roles ) && is_array( $user->roles ) ) {

    // If administrator, send them to wordpress dashboard
    if( in_array( "administrator", $user->roles ) ) {
      // return '/wp-admin';
      return '/panel/dashboard/';
    }

    // If part of elevkåren, send them to the elevkåren admin dashboard
    // if( in_array( "elevkaren", $user->roles ) ) {
    //   return '/panel/dashboard/';
    // }

    // Any other role, send to startscreen
    return '/panel/dashboard/';

  } else {

    // Send to the startscreen
    return '/panel/dashboard/';
  }
}
add_filter("login_redirect", "custom_login_redirect", 10, 3);

// Add custom meta data on login
// function save_custom_meta_data( $user_id ) {
//   // Set user as member of elevkåren
//   add_user_meta( $user_id, 'status', 'y' );
//
//   // Set the class for the user
//   add_user_meta( $user_id, 'class_id', 1 );
// }
// add_action('user_register', 'save_custom_meta_data');

/*****************************************
* Roles
*****************************************/

// Add elevkåren role and configure it's capabilities
add_role( 'elevkaren', 'Elevkåren', array(
  'read' => true,
  'activate_plugins' => false,
  'edit_plugins' => false,
  'install_plugins' => false,
  'edit_users' => false,
  'manage_options' => false,
  'promote_users' => false,
  'remove_users' => false,
  'switch_themes' => false,
  'delete_site' => false,
  'edit_dashboard' => false
) );

/*****************************************
* Database
*****************************************/
require_once(get_template_directory() . "/scripts/add_tables.php");

/*****************************************
* Ajax search
*****************************************/
// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){

    global $wpdb;

    $keyword = esc_attr( $_POST['keyword'] );

    // Get the number of all members
    $users = get_users(array(
      'meta_key' => 'class_id',
    ));


    foreach( $users as $u ) {
      $nickname = get_user_meta($u->ID,'nickname',true);
      if (stripos($nickname, $keyword) !== false ) {

        $email = $u->user_email;
        // Get class name
        $display_class_name = '';

        // Check if a class has been set for this student
        if (metadata_exists('user', $u->ID, 'class_id')){
          // Get the class id
          $user_class_id = get_user_meta($u->ID, 'class_id', true);

          // Check if there is a class with that class id
          if ($user_class = $wpdb->get_row('SELECT * FROM vro_classes WHERE id='. $user_class_id)) {
            // if so, get the class name
            $display_class_name = $user_class->name;
          }

        }

        if (get_user_meta($u->ID, 'status', true) == 'y'){ ?>
          <a href="/panel/medlemmar/?c_id=<?php echo $user_class_id; ?>#student_<?php echo $u->ID; ?>">
            <p class="member">
              <span><?php echo $nickname; ?></span>
              <span><?php echo $email; ?></span>
              <?php if (metadata_exists( 'user', $u->ID, 'phonenumber' )) : ?>
                  <span><?php echo get_user_meta($u->ID, 'phonenumber', true); ?></span>
              <?php endif; ?>
              <span><?php echo $display_class_name; ?></span>
            </p>
          </a>
        <?php } else { ?>
          <a href="/panel/medlemmar/?c_id=<?php echo $user_class_id; ?>#student_<?php echo $u->ID; ?>">
            <p class="not-member">
              <span><?php echo $nickname; ?></span>
              <span><?php echo $email; ?></span>
              <span><?php echo $display_class_name; ?></span>
            </p>
          </a>
        <?php }

      }
    }

    die();
}

add_action('wp_ajax_kommitte_data_fetch' , 'kommitte_data_fetch');
add_action('wp_ajax_nopriv_kommitte_data_fetch','kommitte_data_fetch');
function kommitte_data_fetch(){

    global $wpdb;

    $keyword = esc_attr( $_POST['keyword'] );

    // Get the number of all members
    $kommitter = $wpdb->get_results('SELECT * FROM vro_kommiteer WHERE status = "y"');


    foreach( $kommitter as $k ) {
      if (stripos($k->name, $keyword) !== false ) {
          ?>
            <a href="/panel/kommiteer/?k_id=<?php echo $k->id; ?>">
              <p class="member">
                <span><?php echo $k->name; ?></span>
              </p>
            </a>
         <?php
      }
    }

    die();
}

// the ajax function
add_action('wp_ajax_fetch_rooms' , 'fetch_rooms');
add_action('wp_ajax_nopriv_fetch_rooms','fetch_rooms');
function fetch_rooms(){

  // Access the wordpress database functions
  global $wpdb;

  // Get the rooms stored in the database in a long string
  $rooms_string = $wpdb->get_var('SELECT rooms FROM vroregon_testrooms');

  // Create an array by decoding the string
  $rooms_array = json_decode($rooms_string, true);

  // Enconde the array into json and return it to the js
  echo json_encode($rooms_array);

  // Quit the function
  die();

}

// the ajax function
add_action('wp_ajax_save_rooms' , 'save_rooms');
add_action('wp_ajax_nopriv_fetch_rooms','save_rooms');
function save_rooms(){

  // Access the wordpress database functions
  global $wpdb;

  // Get the rooms stored in the database in a long string
  $str_json = $_POST['rooms_string'];
  $str_json = stripslashes($str_json);

  // Create a new array that will hold all the arguments to create a new visselpipan suggestion
  if ($wpdb->update( 'vroregon_testrooms', array( 'rooms' => $str_json ), array( 'id' => get_current_user_id() ) ) == false){
    echo json_encode(array('msg' => 'failed'));
  } else {
    // Enconde the array into json and return it to the js
    echo json_encode(array('msg' => 'success'));
  }

  // Quit the function
  die();

}


// the ajax function
add_action('wp_ajax_save_player' , 'save_player');
add_action('wp_ajax_nopriv_fetch_player','save_player');
function save_player(){

  // Access the wordpress database functions
  global $wpdb;

  // Get the rooms stored in the database in a long string
  $str_json = $_POST['player_string'];
  $str_json = stripslashes($str_json);

  $current_uid = get_current_user_id();

  // IF player already exists, update record, else create a new one
  if ( count($wpdb->get_results("SELECT * FROM vroregon_players WHERE user_id = $current_uid")) > 0 ) {

    // Create a new array that will hold all the arguments to create a new visselpipan suggestion
    if ($wpdb->update( 'vroregon_players', array( 'player' => $str_json ), array( 'user_id' => $current_uid ) ) == false){
      echo json_encode(array('msg' => 'failed in save player'));
    } else {
      // Enconde the array into json and return it to the js
      echo json_encode(array('msg' => 'success'));
    }

  } else {

    $newPlayer = array();
    $newPlayer['user_id'] = $current_uid;
    $newPlayer['player'] = $str_json;

    if ($wpdb->insert( 'vroregon_players', $newPlayer ) == false ){
      echo json_encode(array('msg' => 'failed in save player add instert new record'));
    } else {
      echo json_encode(array('msg' => 'success!'));
    }

  }

  // Quit the function
  die();

}

add_action('wp_ajax_get_saved_player' , 'get_saved_player');
add_action('wp_ajax_nopriv_get_saved_player','get_saved_player');
function get_saved_player() {

  global $wpdb;

  $u_id = get_current_user_id();
  if ( $u_id == 0){
    echo json_encode( array('error' => 'no user id') );
  } else {

    // Get
    $test = 'test';

  }

  echo json_encode( array('player' => 'hejhej') );

  die();

}
