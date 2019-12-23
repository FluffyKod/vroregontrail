<?php

// Change login redirect
function custom_login_redirect( $redirect_to, $request, $user ) {
  global $user;
  if( isset( $user->roles ) && is_array( $user->roles ) ) {
    if( in_array( "administrator", $user->roles ) ) {
      return '/admin/dashboard';
    } else {
      return home_url();
    }
  } else {
    return home_url();
  }
}
add_filter("login_redirect", "custom_login_redirect", 10, 3);

/*****************************************
* Database
*****************************************/
function vro_setup() {

  global $wpdb;

  // Set prefix
  $prefix = 'vro_';

  // Create visselpipan table
  $table_name = $prefix . 'visselpipan';

  // Check if table already exists
  $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
  if ( ! $wpdb->get_var( $query ) == $table_name ) {

    // Set fields
    $sql = 'CREATE TABLE ' . $table_name . '(
      id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      user_id BIGINT(20) UNSIGNED NOT NULL,
      subject VARCHAR(100) NOT NULL,
      text VARCHAR(300) NOT NULL,
      status VARCHAR(5) NOT NULL DEFAULT "w",
      PRIMARY KEY (id),
      FOREIGN KEY (user_id) REFERENCES wp_users(ID)
    )';

    // Get essential funcitons
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Set database option
    add_option('vro_database_version', '1.1');

  } // End check table name

} // End vro_setup()
add_action( 'after_setup_theme', 'vro_setup' );
