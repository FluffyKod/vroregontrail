<?php

require_once ABSPATH . '/wp-admin/includes/taxonomy.php';


// Form validation function
function test_input( $data ){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function emptyToNull( $data ){
  if ($data == '') {
    return null;
  } else {
    return $data;
  }
}

function translateWeekday($day){
  $english = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
  $swedish = array('Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag', 'Söndag');

  return $swedish[array_search($day, $english)];
}

function getStudentsInYear($year, $students) {
  // Check if the year is numeric
  if (!is_numeric($year)){
    return false;
  } else {
    $year = (int)$year;
  }

  // Check if the year supplied is 1, 2 or 3
  if (  !in_array($year, array(1, 2, 3)) ) {
    return false;
  }

  // Get the current year
  $current_year = date('Y');

  // Get the current month
  $current_month = date('m');

  // DEBUG
  // $current_month = date('m', strtotime('+6 months'));
  //
  // echo $current_year . ' ' . $current_month;

  // If it is before july, act as the year is the previous one
  if ((int)$current_month < 7){
    $current_year = (int)$current_year - 1;
  } else {
    $current_year = (int)$current_year;
  }

  $yearArray = array();

  foreach ($students as $s) {
    // check if end year meta data exists
    if (metadata_exists( 'user', $s->ID, 'end_year' )){

      // Get the difference, a.k.a the number of years left for this student
      $years_left =  get_user_meta($s->ID, 'end_year', true) - $current_year;

      // Get the grade they are in. ex. 3 years left means you are a 1:st grader, therefore 4 - 3 = 1, 4 - 2 years left = 2 etc.
      $grade = 4 - $years_left;

      // Check if this was the year asked for
      if ($grade == $year){
        array_push($yearArray, $s);
      }
    }
  }

  return $yearArray;
}

function check_id( $id, $table_name ) {
  if (empty($id)){
    return array(false, 'empty');
  }

  if (!is_numeric($id)){
    return array(false, 'nan');
  }

  global $wpdb;

  if ( count($wpdb->get_results('SELECT * FROM '. $table_name .' WHERE id="'. $id .'"')) < 1 ) {
    return array(false, 'norecord');
  }

  return array(true, (int)$id);
}

function value_exists_in_table( $value, $column_name, $table_name, $row_id = false ){

  global $wpdb;

  if ($row_id){

    if ( count($wpdb->get_results('SELECT * FROM '. $table_name .' WHERE '. $column_name .'="'. $value .'" AND id <>'. $row_id)) > 0 ) {
      return true;
    } else {
      return false;
    }

  } else {

    if ( count($wpdb->get_results('SELECT * FROM '. $table_name .' WHERE '. $column_name .'="'. $value .'"')) > 0 ) {
      return true;
    } else {
      return false;
    }

  }



}

function is_member( $u_id ){

  global $wpdb;

  $status = get_metadata('user', $u_id, 'status');

  return ($status[0] == 'y') ? true : false;

}

function get_kommitte_cat_ids( $u_id ) {

  global $wpdb;

  $all_kommittes = $wpdb->get_results('SELECT * FROM vro_kommiteer_members WHERE user_id = '. $u_id . ' AND status="y"');

  $cat_array = array();

  foreach ($all_kommittes as $k){
    $cat_name = 'kommitte_' . $k->kommitee_id;

    if ( category_exists( $cat_name ) ){

      $cat_id = get_cat_ID( $cat_name );

      if ( $cat_id != 0 ) {
        array_push( $cat_array, $cat_id );
      }

    }
  }

  return $cat_array;

}

function display_karbrev( $amount = 0, $header = true, $edit = true ){

  require_once ABSPATH . '/wp-admin/includes/taxonomy.php';

  if (category_exists( 'karbrev' ) ) {
    $catArray = array( get_cat_ID('karbrev') );
  }

  if (count($catArray) > 0){

    $args = array(
        'category__in' => $catArray,
        'post_status' => 'publish',
        'post_type' => 'post',
        'orderby' => 'post_date',
        'posts_per_page' => $amount
    );

    // The Query
    $the_query = new WP_Query( $args );

      if ( $the_query->have_posts() ) : ?>

          <?php if ( $header ): ?>
          <div class="see-more blogposts-header">
            <h2>Kårbrev</h2>
            <div class="">
              <a href="/panel/arkiv#karbrev">See alla kårbrev &#8594;</a>
            </div>
          </div>
          <?php endif; ?>

          <?php while ( $the_query->have_posts() ) {
              $the_query->the_post();

              get_template_part( 'content' );
          } ?>
      <?php endif;
    /* Restore original Post Data */
      wp_reset_postdata();

  }

}

function display_kommitte_notifications( $amount = 0, $header = true ) {
  $cat_array = get_kommitte_cat_ids( get_current_user_id() );

  if (count($cat_array) > 0) {

    $args = array(
        'category__in' => $cat_array,
        'post_status' => 'publish',
        'post_type' => 'post',
        'orderby' => 'post_date',
    );

    // The Query
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) : ?>

        <?php if ( $header ): ?>
        <div class="see-more blogposts-header">
          <h2>Nya notiser</h2>
          <div class="">
            <a href="/panel/arkiv#kommitte">See alla notiser &#8594;</a>
          </div>
        </div>
      <?php endif; ?>

        <?php while ( $the_query->have_posts() ) {
            $the_query->the_post();

            get_template_part( 'content' );
        } ?>
    <?php endif;
    /* Restore original Post Data */
    wp_reset_postdata();

  } // End if current student is part of any kommittées
}

function display_karen( $edit = false ){

  ?>

  <h2>Styrelsen</h2>
  <div class="row styrelsen" id="styrelsen">

    <?php

    // Get all events type
    global $wpdb;

    $styrelsen = $wpdb->get_results('SELECT * FROM vro_styrelsen');

    foreach ($styrelsen as $s) {
      ?>

      <?php
        if ($edit) {
          echo '<div class="box white chairman sm clickable">';
        } else {
          echo '<div class="box white chairman sm">';
        }
      ?>

        <?php if ($edit) { ?>
        <div class="edit-image">
          <?php echo get_avatar( $s->ID ); ?>
          <button type="button" name="button" class="edit-styrelse"><img src="<?php echo get_bloginfo('template_directory'); ?>/img/editcircle.png"></button>
        </div>
      <?php } else {
            echo get_avatar( $s->ID );
          }
        ?>

          <h3><?php echo $s->position_name; ?></h3>
          <p><?php echo get_user_meta($s->student, 'nickname', true); ?></p>
          <input type="text" name="" value="<?php echo $s->id; ?>" hidden>
          <input class="position-student-email" name="" value="<?php echo get_userdata($s->student)->user_email; ?>" hidden>
      </div>

      <?php
    }

    ?>
  </div>

  <h2>Utskotten</h2>
  <div class="row styrelsen" id="utskotten">

    <?php

    // Get all events type
    global $wpdb;

    $utskotten = $wpdb->get_results('SELECT * FROM vro_utskott');

    foreach ($utskotten as $u) {
      ?>

      <?php
        if ($edit) {
          echo '<div class="box white chairman sm clickable">';
        } else {
          echo '<div class="box white chairman sm">';
        }
      ?>

          <?php if ($edit) { ?>
            <div class="edit-image">
              <?php echo get_avatar( $u->ID ); ?>
              <button type="button" name="button" class="edit"><img src="<?php echo get_bloginfo('template_directory'); ?>/img/editcircle.png"></button>
            </div>
          <?php } else {
            echo get_avatar( $u->ID );
          } ?>

          <h3><?php echo $u->name; ?></h3>
          <p>Ordförande: <?php echo get_user_meta($u->chairman, 'nickname', true); ?></p>
          <input class="utskott-id" type="text" name="" value="<?php echo $u->id; ?>" hidden>
          <input class="utskott-description" type="text" name="" value="<?php echo $u->description; ?>" hidden>
          <input class="utskott-chairman-email" name="" value="<?php echo get_userdata($u->chairman)->user_email; ?>" hidden>
      </div>

      <?php
    }

    ?>
  </div>

  <?php

}


// META DATA
function update_or_add_meta( $u_id, $key, $value ) {

  //CHeck if meta data exists
  if (metadata_exists( 'user', $u_id, $key )){

    // If so, update its value
    if ( update_user_meta( $u_id, $key, $value ) == false ){
      return false;
    }
  } else {
    // Otherwise, add a user meta with the supplied value

    if ( add_user_meta( $u_id, $key, $value ) == false){
      return false;
    }
  }

  return true;
}
