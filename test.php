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

 <a href="/panel/dashboard/" class="btn lg">Admin</a>



 <script src="<?php echo get_bloginfo('template_directory') ?>/js/autocomplete.js" charset="utf-8"></script>

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

   <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="POST">
     <input style="display:none">
     <input type="text" name="first_name" value="" placeholder="Förnamn..." required>
     <input type="text" name="last_name" value="" placeholder="Efernamn..." required>
     <input type="email" name="email_address" value="" placeholder="Skolmail..." required>
     <input type="password" name="password" value="" placeholder="Lösenord..." required>
    <div class="autocomplete">
      <input id="class" type="text" name="class_name" placeholder="Klass..." required>
    </div>
    <button type="submit" name="add_new_user" class="btn lg">Lägg till användare</button>
  </form>


<?php

global $wpdb;

$results = $wpdb->get_results('SELECT name FROM vro_classes');
echo '<script type="text/javascript">';
echo 'var jsonclasses = ' . json_encode($results);
echo '</script>'

?>

<script>
var classes = getArrayFromColumn(jsonclasses, 'name');

autocomplete(document.getElementById("class"), classes, 'Denna klass är ännu inte skapad');
</script>

 </section>

 <!-- <script src="<?php echo get_bloginfo('template_directory') ?>/js/modal.js" charset="utf-8"></script> -->


 <?php

get_footer();

  ?>

<?php } ?>
