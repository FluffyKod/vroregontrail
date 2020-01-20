<?php


$ouput = '';

if (isset($_POST['query'])){
  $search = $_POST['query'];

  global $wpdb;

  // Create a new array that will hold all the arguments to create a new visselpipan suggestion
  $results = $wpdb->get_results( 'SELECT * FROM wp_users WHERE user_nicename LIKE CONCAT("' . $search . '",?,"' . $search . '") OR last_name LIKE CONCAT"' . $search . '",?,"' . $search . '")');
} else {
  $results = $wpdb->get_results( 'SELECT * FROM wp_users');
}

if (!empty( $results )){
  foreach($results as $row){
    $output .= 'hello';
  }

  echo $output;
} else {
  echo '<p> Nu resultz</p>';
}
