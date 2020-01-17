<?php

/*****************************************
* Login
*****************************************/

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
  if ($wpdb->update( 'vroregon_testrooms', array( 'rooms' => $str_json ), array( 'id' => 1 ) ) == false){
    echo json_encode(array('msg' => 'failed'));
  } else {
    // Enconde the array into json and return it to the js
    echo json_encode(array('msg' => 'success'));
  }

  // Quit the function
  die();

}
