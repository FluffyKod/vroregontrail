<?php

/**
 * Template Name: Register
 */

 get_header();

 ?>

 <script src="<?php echo get_bloginfo('template_directory') ?>/js/autocomplete.js" charset="utf-8"></script>

 <div class="register-box">

   <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="POST">
     <?php

     // Check if form has been submited
     if (isset($_GET['add_user'])) {

       // Get the msg from the form
       $user_check = $_GET['add_user'];

       // Then check if there has been an error
       if ($user_check == 'empty'){
         echo '<p class="error">Du måste fylla i alla värden!</p>';
       }
       elseif ($user_check == 'noclassfound'){
         echo '<p class="error">Klassen hittades inte!</p>';
       }
       elseif ($user_check == 'invalidemail'){
         echo '<p class="error">Mailaddresesn är inte godtagbar!</p>';
       }
       elseif ($user_check == 'emailexists'){
         echo '<p class="error">Mailaddressen är redan använd!</p>';
       }
       elseif ($user_check == 'invalidyear'){
         echo '<p class="error">Avångsåret stämmer inte!</p>';
       }

     }

     ?>

     <?php
      if (!isset($_GET['first_name'])){
        echo '<input type="text" name="first_name" value="" placeholder="Förnamn..." required>';
      } else {
        echo '<input type="text" name="first_name" value="'. $_GET['first_name'] .'" placeholder="Förnamn..." required>';
      }


      if (!isset($_GET['last_name'])){
        echo '<input type="text" name="last_name" value="" placeholder="Efernamn..." required>';
      } else {
        echo '<input type="text" name="last_name" value="'. $_GET['last_name'] .'" placeholder="Efternamn..." required>';
      }

      ?>
      <div class="autocomplete">
        <input id="class" type="text" name="class_name" value="" placeholder="Klass...">
      </div>

      <?php

      if (!isset($_GET['email'])){
        echo '<input type="email" name="email_address" value="" placeholder="Skolmail..." required>';
      } else {
        echo '<input type="email" name="email_address" value="'. $_GET['email'] .'" placeholder="Skolmail..." required>';
      }
     ?>




     <!-- <input type="number" name="end_year" value="" placeholder="Avgångsår (ex. 2022)..." list="end_years">

     <datalist id="end_years">
       <option value="<?php echo date('Y', strtotime('+3 years')); ?>" />
       <option value="<?php echo date('Y', strtotime('+2 years')); ?>" />
       <option value="<?php echo date('Y', strtotime('+1 years')); ?>" />
       <option value="<?php echo date('Y'); ?>" />
     </datalist> -->

     <input type="password" name="password" value="" placeholder="Lösenord..." required>

    <button type="submit" name="register_new_user" class="btn lg" value="/register">Registrera dig</button>
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

 </div>

 <?php

 get_footer();

  ?>
