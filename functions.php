<?php

// Change login redirect
function custom_login_redirect( $redirect_to, $request, $user ) {
  global $user;

  // Check the user role of logged in user and send them to different default places
  if( isset( $user->roles ) && is_array( $user->roles ) ) {

    // If administrator, send them to wordpress dashboard
    if( in_array( "administrator", $user->roles ) ) {
      return '/wp-admin';
    }

    // If part of elevkåren, send them to the elevkåren admin dashboard
    if( in_array( "elevkaren", $user->roles ) ) {
      return '/admin/dashboard/';
    }

    // Any other role, send home
    return home_url();

  } else {

    // Every other user, send home
    return home_url();
  }
}
add_filter("login_redirect", "custom_login_redirect", 10, 3);

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
