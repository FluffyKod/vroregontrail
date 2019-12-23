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

?>

<?php

  get_header();

 ?>


 <section id="forms-test">

   <form action="/test/" method="post">

     <input type="text" name="subject" placeholder="Rubrik..." required>
     <input type="text" name="text" placeholder="Förslag..." required>

     <button class="btn lg" type="submit">Skicka</button>

   </form>

 </section>


 <?php

get_footer();

  ?>

<?php } ?>
