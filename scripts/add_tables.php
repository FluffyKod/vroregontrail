<?php

function createTable( $table_name, $sql ) {

  // Get access to wordpress database functions
  global $wpdb;

  // Check if table already exists
  $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
  if ( ! $wpdb->get_var( $query ) == $table_name ) {

    // Get essential funcitons
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute SQL
    dbDelta($sql);

  } // End check table name
}

/*****************************************
* Database
*****************************************/
function vro_setup() {

  // Set prefix
  $prefix = 'vro_';

  /*  status arguments described:
        y - accepted (yes)
        n - denied (no)
        w - waiting to be handled
  */

  /*****************************************
  * VISSELPIPAN
  *****************************************/

  $table_name = $prefix . 'visselpipan';

  $sql_visselpipan = 'CREATE TABLE ' . $table_name . '(
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

  createTable($table_name, $sql_visselpipan);

  /*****************************************
  * KOMMITEER
  *****************************************/

  // Main Kommitee table
  $table_name = $prefix . 'kommiteer';

  // Set fields
  $sql_kommiteer = 'CREATE TABLE ' . $table_name . '(
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

  createTable($table_name, $sql_kommiteer);

  // Kommitee + users junction table
  $table_name = $prefix . 'kommiteer_members';

  // Set fields
  $sql_komiteer_members = 'CREATE TABLE ' . $table_name . '(
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

  createTable($table_name, $sql_komiteer_members);

  /*****************************************
  * CLASSES
  *****************************************/

  // Main Kommitee table
  $table_name = $prefix . 'classes';

  // Set fields
  $sql_classes = 'CREATE TABLE ' . $table_name . '(
    id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    name VARCHAR(50) NOT NULL,
    points INTEGER(10) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
  )';

  createTable($table_name, $sql_classes);

  /*****************************************
  * ELEVKÅREN
  *****************************************/

  // Utskott table
  $table_name = $prefix . 'utskott';

  // Set fields
  $sql_utskott = 'CREATE TABLE ' . $table_name . '(
    id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(300),
    chairman BIGINT(20) UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (chairman) REFERENCES wp_users(ID)
  )';

  createTable($table_name, $sql_utskott);

  // Positions table
  // $table_name = $prefix . 'position_types';
  //
  // // Set fields
  // $sql_positions = 'CREATE TABLE ' . $table_name . '(
  //   id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  //   created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  //   last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  //   name VARCHAR(100) NOT NULL,
  //   is_unique BIT NOT NULL DEFAULT 0,
  //   is_linked_utskott BIT NOT NULL DEFAULT 0,
  //   PRIMARY KEY (id)
  // )';
  //
  // createTable($table_name, $sql_positions);

  // Main karen table
  // $table_name = $prefix . 'karen';

  // Set fields
  // $sql_karen = 'CREATE TABLE ' . $table_name . '(
  //   id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  //   created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  //   last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  //   position_id INTEGER(10) UNSIGNED NOT NULL,
  //   student BIGINT(20) UNSIGNED,
  //   utskott_id INTEGER(10) UNSIGNED,
  //   PRIMARY KEY (id),
  //   FOREIGN KEY (student) REFERENCES wp_users(ID),
  //   FOREIGN KEY (utskott_id) REFERENCES vro_utskott(id),
  //   FOREIGN KEY (position_id) REFERENCES vro_positions(id)
  // )';

  $table_name = $prefix . 'styrelsen';

  $sql_karen = 'CREATE TABLE ' . $table_name . '(
    id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    position_name VARCHAR(100) NOT NULL,
    student BIGINT(20) UNSIGNED,
    PRIMARY KEY (id)
  )';

  createTable($table_name, $sql_karen);

  /*****************************************
  * EVENTS
  *****************************************/

  // Events type
  $table_name = $prefix . 'event_types';

  /*  color Arguments described
        bg_color - background color of event (will show up color coded in calendar)
        fg_color - foreground color or text color of event
  */

  // Set fields
  $sql_event_type = 'CREATE TABLE ' . $table_name . '(
    id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    name VARCHAR(100) NOT NULL,
    symbol VARCHAR(5) DEFAULT "",
    bg_color VARCHAR(40) NOT NULL DEFAULT "#ffffff",
    fg_color VARCHAR(40) NOT NULL DEFAULT "#000000",
    status VARCHAR(5) NOT NULL DEFAULT "y",
    PRIMARY KEY (id)
  )';

  createTable($table_name, $sql_event_type);

  // Main events
  $table_name = $prefix . 'events';

  // Set fields
  /*  Type arguments described:
        u - only the hosting utskott
        e - only elevkåren
        m - only members of elevkåren
        k - only specified kommitée
        l - all logged in users
        a - all visitors
  */

  $sql_events = 'CREATE TABLE ' . $table_name . '(
    id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    name VARCHAR(100) NOT NULL,
    start DATETIME NOT NULL,
    end DATETIME NOT NULL,
    place VARCHAR(100),
    type INTEGER(10) UNSIGNED NOT NULL,
    description VARCHAR(300),
    host VARCHAR(100),
    kommitte_host_id INTEGER(10) UNSIGNED,
    visibility VARCHAR(5) NOT NULL DEFAULT "e",
    FOREIGN KEY (type) REFERENCES vro_event_types(id),
    FOREIGN KEY (kommitte_host_id) REFERENCES vro_kommiteer(id),
    PRIMARY KEY (id)
  )';

  createTable($table_name, $sql_events);

  /*****************************************
  * LOGGING TABLE
  *****************************************/

  $table_name = 'vro_log';

  $sql_log = 'CREATE TABLE ' . $table_name . '(
    id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    log_source VARCHAR(100) NOT NULL,
    description VARCHAR(300) NOT NULL,
    user_id BIGINT(20) UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES wp_users(ID)
  )';

  createTable($table_name, $sql_log);

  /*****************************************
  * VROREGON
  *****************************************/

  $table_name = 'vroregon_testrooms';

  $sql_regon = 'CREATE TABLE ' . $table_name . '(
    id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    rooms JSON,
    PRIMARY KEY (id)
  )';

  createTable($table_name, $sql_regon);



} // End vro_setup()
add_action( 'after_setup_theme', 'vro_setup' );
