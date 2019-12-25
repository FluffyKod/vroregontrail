<?php

/*****************************************
* Database
*****************************************/
function vro_setup() {

  global $wpdb;

  // Set prefix
  $prefix = 'vro_';

  // VISSELPIPAN TABLE
  $table_name = $prefix . 'visselpipan';

  // Check if table already exists
  $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
  if ( ! $wpdb->get_var( $query ) == $table_name ) {

    // Set fields
    $sql = 'CREATE TABLE ' . $table_name . '(
      id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
      last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
      user_id BIGINT(20) UNSIGNED NOT NULL,
      subject VARCHAR(100) NOT NULL,
      text VARCHAR(300) NOT NULL,
      status VARCHAR(5) NOT NULL DEFAULT "w",
      PRIMARY KEY (id),
      FOREIGN KEY (user_id) REFERENCES wp_users(ID)
    )';

    // Get essential funcitons
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute SQL
    dbDelta($sql);

    // Set database option
    add_option('vro_database_version', '1.1');

  } // End check table name

  // KOMMITÈER TABLES

  // Main Kommitee table
  $table_name = $prefix . 'kommiteer';

  // Check if table already exists
  $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
  if ( ! $wpdb->get_var( $query ) == $table_name ) {

    // Set fields
    $sql = 'CREATE TABLE ' . $table_name . '(
      id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
      last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
      name VARCHAR(100) NOT NULL,
      description VARCHAR(300) NOT NULL,
      chairman BIGINT(20) UNSIGNED NOT NULL,
      status VARCHAR(5) NOT NULL DEFAULT "w",
      PRIMARY KEY (id),
      FOREIGN KEY (chairman) REFERENCES wp_users(ID)
    )';

    // Get essential funcitons
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute SQL
    dbDelta($sql);

  } // End check table name

  // Kommitee + users junction table
  $table_name = $prefix . 'kommiteer_members';

  // Check if table already exists
  $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
  if ( ! $wpdb->get_var( $query ) == $table_name ) {

    // Set fields
    $sql = 'CREATE TABLE ' . $table_name . '(
      id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
      last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
      user_id BIGINT(20) UNSIGNED NOT NULL,
      kommitee_id INTEGER(10) UNSIGNED NOT NULL,
      status VARCHAR(5) NOT NULL DEFAULT "w",
      PRIMARY KEY (id),
      FOREIGN KEY (user_id) REFERENCES wp_users(ID),
      FOREIGN KEY (kommitee_id) REFERENCES vro_kommiteer(id)
    )';

    // Get essential funcitons
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute SQL
    dbDelta($sql);

  } // End check table name


} // End vro_setup()
add_action( 'after_setup_theme', 'vro_setup' );
