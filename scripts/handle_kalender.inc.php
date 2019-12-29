<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Include helpful functions
include_once('helpful_functions.php');

// Create database entry
if (isset($_POST['add_event_type'])) {

  global $wpdb;

  $name = test_input( $_POST['etName'] );
  $symbol = urlencode( test_input( $_POST['etSymbol'] ) );
  $bgColor = test_input( $_POST['etBgColor'] );
  $fgColor = test_input( $_POST['etFgColor'] );

  if ( empty($name) ){
    header("Location: /admin/kalender?event_type=empty");
    exit();
  } else {

    if ( count($wpdb->get_results('SELECT * FROM vro_event_types WHERE name="'. $name .'"')) > 0 ) {
      // Replace the # to %23 so it is safe to send in the url
      $bgColor = '%23' . substr($bgColor, 1);
      $fgColor = '%23' . substr($fgColor, 1);

      header("Location: /admin/kalender?event_type=nametaken&symbol=$symbol&bgColor=$bgColor&fgColor=$fgColor");
      exit();
    }
    // Create a new array that will hold all the arguments to create a new visselpipan suggestion
    $new_et = array();

    $new_et['name'] = $name;
    $new_et['bg_color'] = $bgColor;
    $new_et['fg_color'] = $fgColor;

    // Insert the new suggestion into the database
    if($wpdb->insert(
        'vro_event_types',
        $new_et
    ) == false) {
      wp_die('database insertion failed');
    }

    header("Location: /admin/kalender?event_type=success");
    exit();

    }

}
elseif (isset($_POST['show_add_event_type'])) {
  header("Location: /admin/kalender?event_type=open");
  exit();
}

elseif (isset($_POST['remove_event_type'])) {

  global $wpdb;

  $etId = $_POST['remove_event_type'];

  if (empty($etId)) {
    header("Location: /admin/kalender?remove_event_type=empty");
    exit();
  }

  if (!is_numeric($etId)) {
    header("Location: /admin/kalender?remove_event_type=nan");
    exit();
  }

  // Delete the specified table
  if ($wpdb->delete( 'vro_event_types', array( 'id' => $etId ) ) == false ){
    // If it did not work, send back error
    wp_die('database deletion failed');
  } else {
    // Success!
    header("Location: /admin/kalender?remove_event_type=success");
    exit();
  }
}
elseif (isset($_POST['alter_event_type'])) {

  global $wpdb;

  $etId = $_POST['alter_event_type'];

  if (empty($etId)) {
    header("Location: /admin/kalender?alter_event_type=noid");
    exit();
  }

  if (!is_numeric($etId)) {
    header("Location: /admin/kalender?alter_event_type=nan");
    exit();
  }

  $name = test_input( $_POST['etName'] );
  $symbol = test_input( $_POST['etSymbol'] );
  $bgColor = test_input( $_POST['etBgColor'] );
  $fgColor = test_input( $_POST['etFgColor'] );

  if ( empty($name) ){
    header("Location: /admin/kalender?alter_event_type=empty");
    exit();
  }

  // Check that no other event type has the same name
  if ( count($wpdb->get_results('SELECT * FROM vro_event_types WHERE name="'. $name .'" AND id != '. $etId .' ')) > 0 ) {
    // Replace the # to %23 so it is safe to send in the url
    $bgColor = '%23' . substr($bgColor, 1);
    $fgColor = '%23' . substr($fgColor, 1);
    $symbol = urlencode( $symbol );

    header("Location: /admin/kalender?alter_event_type=nametaken&id=$etId&symbol=$symbol&bgColor=$bgColor&fgColor=$fgColor");
    exit();
  }

  $updated_event = array(
    'name' => $name,
    'symbol' => $symbol,
    'bg_color' => $bgColor,
    'fg_color' => $fgColor
  );

  if ($wpdb->update( 'vro_event_types', $updated_event, array( 'id' => $etId ) ) == false){
    wp_die('database alter event type failed');
  } else {
    // Success!
    header("Location: /admin/kalender?alter_event_type=success");
    exit();
  }

}

elseif (isset($_POST['show_alter_event_type'])) {

  global $wpdb;

  $et_id = $_POST['show_alter_event_type'];

  // Check if there is an event type id
  if (empty($et_id)){
    header("Location: /admin/kalender?show_alter_event_type=noetid");
    exit();
  }

  // Check if the event type id is a number
  if (!is_numeric($et_id)) {
    header("Location: /admin/kalender?show_alter_event_type=nan");
    exit();
  }

  // Safe to use it in db call
  $selected_et = $wpdb->get_row('SELECT * FROM vro_event_types WHERE id=' . $et_id);

  if (!$selected_et){
    header("Location: /admin/kalender?show_alter_event_type=noetfound");
    exit();
  }

  // Send back all values to front page
  $bg_color = '%23' . substr($selected_et->bg_color, 1);
  $fg_color = '%23' . substr($selected_et->fg_color, 1);

  header("Location: /admin/kalender?show_alter_event_type=open&id=$selected_et->id&type_name=$selected_et->name&symbol=$selected_et->symbol&bgColor=$bg_color&fgColor=$fg_color");
  exit();

}

elseif (isset($_POST['add_event'])) {

  global $wpdb;

  $event_type = $_POST['ae_event_type'];
  $event_name = $_POST['ae_name'];
  $event_place = emptyToNull( $_POST['ae_place'] );
  $event_host = emptyToNull( $_POST['ae_host'] );

  $event_start_date = $_POST['ae_start_date'];
  $event_start_time = $_POST['ae_start_time'];
  $event_end_date = $_POST['ae_end_date'];
  $event_end_time = $_POST['ae_end_time'];

  $event_description = emptyToNull( $_POST['ae_description'] );
  $event_visibility = $_POST['ae_visibility'];

  if ($event_type == 'none'){
    header("Location: /admin/kalender?add_event=noeventtype");
    exit();
  }

  if (empty($event_name)) {
    header("Location: /admin/kalender?add_event=noname");
    exit();
  }

  // TODO: check if end is before start

  // TODO: check if host exists if it is set

  // TODO: check if host exists if the visibility is set to utskott only

  // TODO: check if event type exists

  // Create a new array that will hold all the arguments to create a new vevent
  $new_event =  array();

  $new_event['type'] = $event_type;
  $new_event['name'] = $event_name;
  $new_event['place'] = $event_place;
  $new_event['host'] = $event_host;
  $new_event['start'] = $event_start_date . ' ' . $event_start_time;
  $new_event['end'] = $event_end_date . ' ' . $event_end_time;
  $new_event['description'] = $event_description;
  $new_event['visibility'] = $event_visibility;

  // echo $new_event['type'] . ' --- ' . $new_event['name'] . ' --- ' . $new_event['place'] . ' --- ' . $new_event['host'] . ' --- ' . $new_event['start'] . ' --- ' . $new_event['end'] . ' --- ' . $new_event['description'] . ' --- ' . $new_event['visibility'];

  // Insert the new suggestion into the database
  if($wpdb->insert(
      'vro_events',
      $new_event
  ) == false) {
    wp_die('database insertion failed');
  }

  header("Location: /admin/kalender?add_event=success");
  exit();


}
else {
  header("Location: /admin/kalender");
  exit();
}
