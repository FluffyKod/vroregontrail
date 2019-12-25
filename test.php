<?php

/**
 * Template Name: Test
 */

?>

<?php

// Show this page only to admin
if (! is_user_logged_in() ){
  wp_redirect( '/' );
} else {


  // Create database entry
  if ($_POST['subject'] and $_POST['subject'] != '' && $_POST['text'] && $_POST['text'] != '' ) {

    global $wpdb;

    // Create a new array that will hold all the arguments to create a new visselpipan suggestion
    $suggestion = array();

    $suggestion['user_id'] = get_current_user_id();
    $suggestion['subject'] = $_POST['subject'];
    $suggestion['text'] = $_POST['text'];

    // Insert the new suggestion into the database
    if($wpdb->insert(
        'vro_visselpipan',
        $suggestion
    ) == false) {
      wp_die('database insertion failed');
    }

  }

  // Create database entry
  if ($_POST['namn'] and $_POST['namn'] != '' && $_POST['description'] && $_POST['description'] != '' ) {

    global $wpdb;

    // Create a new array that will hold all the arguments to create a new kommitee
    $kommitee = array();

    $kommitee['name'] = $_POST['namn'];
    $kommitee['description'] = $_POST['description'];
    $kommitee['chairman'] = get_current_user_id();

    // Insert the new suggestion into the database
    if($wpdb->insert(
        'vro_kommiteer',
        $kommitee
    ) == false) {
      wp_die('database insertion failed');
    } else {

      // Set the chairman as a new member
      $new_kommitee = $wpdb->get_results('SELECT * FROM vro_kommiteer WHERE name="'. $_POST['namn'] .'"');

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

    }

  }

?>

<?php

  get_header();

 ?>

 <a href="/admin/dashboard/" class="btn lg">Admin</a>

 <section id="forms-test">

   <form action="/test/" method="post">

     <h2>Visselpipan</h2>
     <input type="text" name="subject" placeholder="Rubrik..." required>
     <textarea name="text" placeholder="Förslag..." required></textarea>

     <button class="btn lg" type="submit">Skicka</button>

   </form>

   <h2>Kommitéer</h2>
   <form action="/test/" method="post">

     <h2>Ny Kommitée</h2>
     <input type="text" name="namn" placeholder="Namn..." required>
     <textarea name="description" placeholder="Beskrivning..." required></textarea>

     <button class="btn lg" type="submit">Skicka</button>

   </form>

 </section>


 <?php

get_footer();

  ?>

<?php } ?>
