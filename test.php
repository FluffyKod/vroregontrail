<?php

/**
 * Template Name: Test
 */

// Show this page only to admin
if (! is_user_logged_in() ){
  wp_redirect( '/' );
} else {

?>

<?php

  get_header();

 ?>

 <a href="/admin/dashboard/" class="btn lg">Admin</a>

 <section id="forms-test">

   <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_visselpipan.inc.php'); ?>" method="post">

     <h2>Visselpipan</h2>

     <?php // Show error messages

     if (isset($_GET['visselpipa'])) {

       $visselpipa_check = $_GET['visselpipa'];

       if ($visselpipa_check == 'empty') {
         echo '<p class="error">Du måste fylla i alla värden!</p>';
       }
       elseif ($visselpipa_check == 'success') {
         echo '<p class="success">Ditt förslag har skickats!</p>';
       }

     }

    ?>

     <input type="text" name="subject" placeholder="Rubrik..." required>
     <textarea name="text" placeholder="Förslag..." required></textarea>

     <button name="new_visselpipa" class="btn lg" type="submit">Skicka</button>

   </form>

   <h2>Kommitéer</h2>
   <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="post">

     <h2>Ny Kommitée</h2>

     <?php // Show error messages

     if (isset($_GET['application'])) {

       $application_check = $_GET['application'];

       if ($application_check == 'empty') {
         echo '<p class="error">Du måste fylla i alla värden!</p>';
       }
       elseif ($application_check == 'nametaken') {
         echo '<p class="error">Kommitéenamnet är redan taget!</p>';
       }
       elseif ($application_check == 'success') {
         echo '<p class="success">Din förfrågan har skickats!</p>';
       }

     }

    ?>

     <input type="text" name="namn" placeholder="Namn..." required>

     <?php

      if (isset($_GET['the_description'])) {
        echo '<textarea name="description" placeholder="Beskrivning..." required>'. $_GET['the_description'] .'</textarea>';
      } else {
        echo '<textarea name="description" placeholder="Beskrivning..." required></textarea>';
      }
     ?>

     <button name="new_kommitee" class="btn lg" type="submit">Skicka</button>

   </form>

 </section>


 <?php

get_footer();

  ?>

<?php } ?>
