<?php

/**
 * Template Name: Kåren
 */

?>

<?php

// Show this page to all logged in users
if (! is_user_logged_in() ){
  wp_redirect( '/wp-login.php' );
} else {
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta lang="sv">
    <meta name="viewport" content="width=device-width; initial-scale=1.0;">

    <title>VRO Elevkår</title>

    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory') ?>/css/admin.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700&display=swap" rel="stylesheet">
     <script src="<?php echo get_bloginfo('template_directory') ?>/js/autocomplete.js" charset="utf-8"></script>
       <script src="<?php echo get_bloginfo('template_directory') ?>/js/forms.js" charset="utf-8"></script>
  </head>
  <body>

    <div class="container">

      <!-- ***********************************
      * NAVBAR
      *************************************-->

      <?php
      // Display a special navbar for admins
      if (current_user_can('administrator') || current_user_can('elevkaren') ){
        require_once(get_template_directory() . "/parts/admin-navigation-bar.php");
      } else {
        require_once(get_template_directory() . "/parts/member-navigation-bar.php");
      }
      ?>

      <!--
      * Dashboard
      --------------------------------------->
      <section id="dashboard">

        <div class="top-bar">
          <h2>Kåren</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <div class="modal" id="modal">
          <div class="modal-header">
            <div class="title">
              Titel
            </div>
            <button data-close-button class="close-button" type="button" name="button">&times;</button>
          </div>
          <div class="modal-body">
            <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_karen.inc.php'); ?>" method="post">

              <label><b>Namn på styrelseposten</b></label>
              <input type="text" name="position_name" value="" placeholder="Styrelsepositionens namn..." id="position-name-field">

              <label><b>Eleven på denna post</b></label>
              <div class="autocomplete">
                <input type="text" name="student_name" value="" placeholder="Elevens namn..." id="student-name-field">
              </div>

              <input type="text" name="position_id" value="" id="position-id" hidden>

              <div class="button-group">
                <button class="btn lg" type="submit" name="" id="submit-button">Ändra</button>
                <button class="btn lg red" type="submit" name="" id="delete-button" onclick="return confirm('Är du säker på att du vill ta bort denna post?')">-</button>
              </div>

            </form>
          </div>
        </div>

        <div class="modal" id="modal-change-utskott">
          <div class="modal-header">
            <div class="title">
              Exempeltitel
            </div>
            <button data-close-button class="close-button" type="button" name="button">&times;</button>
          </div>
          <div class="modal-body">
            <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_karen.inc.php'); ?>" method="post">

              <label><b>Namn på utskottet</b></label>
              <input type="text" name="utskott_name" value="" placeholder="Utskottets namn..." id="utskott-name-field">

              <label><b>Beskrivning av utskottet</b></label>
              <input type="text" name="utskott_description" value="" placeholder="Beskrivning av utskottet..." id="utskott-description-field">

              <label><b>Ordförande för detta utskottt</b></label>
              <div class="autocomplete">
                <input type="text" name="chairman_name" value="" placeholder="Elevens namn..." id="chairman-name-field">
              </div>

              <input type="text" name="utskott_id" value="" id="utskott-id" hidden>

              <div class="button-group">
                <button class="btn lg" type="submit" name="edit_utskott" >Ändra</button>
                <button class="btn lg red" type="submit" name="delete_utskott" onclick="return confirm('Är du säker på att du vill ta bort detta utskott?')">-</button>
              </div>

            </form>
          </div>
        </div>

        <div class="modal" id="modal-moreinfo">
          <div class="modal-header">
            <div class="title">
              Utskottets namn
            </div>
            <button data-close-button class="close-button" type="button" name="button">&times;</button>
          </div>
          <div class="modal-body">
            <p id="description-field">Utskottsbeskrivning</p>
            <p id="chairman-field">Utskottsordförande</p>
          </div>
        </div>

        <div id="overlay"></div>

        <?php

        // If admin --> able to edit the karen positions
        if (current_user_can('administrator') || current_user_can('elevkaren') ){
          display_karen( true );
        } else {
          display_karen( false );
        }

        ?>

      <?php if (current_user_can('administrator') || current_user_can('elevkaren') ): ?>
        <div class="row">

          <div class="box green lg">

            <h4>Komponera nytt kårbrev</h4>
            <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_karen.inc.php'); ?>" method="POST">

              <input type="text" name="letter_title" placeholder="Titel...">

              <textarea name="letter_content" placeholder="Kårbrevet..."></textarea>

             <button type="submit" name="publish_karbrev" class="btn lg">Publicera kårbrev</button>
           </form>

          </div>

        </div>

        <div class="row">

          <div class="box white lg">

            <h4>Lägg till nytt utskott</h4>
            <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_karen.inc.php'); ?>" method="POST">

              <input type="text" name="utskott_name" value="" placeholder="Namn på utskottet..." required>

              <div class="text-limited-root">
                <textarea name="description" placeholder="Beskrivning av utskottet..." required onkeyup="checkForm(this, event_description_char_count, 300)"></textarea>
                <p id="event_description_char_count">300</p>
              </div>

              <div class="autocomplete">
                <input type="text" name="student_name" id="chairman_name" value="" placeholder="Ordförande...">
              </div>


             <button type="submit" name="add_new_utskott" class="btn lg">Lägg till utskott</button>
           </form>

        </div>

      </div>

        <div class="row">

          <div class="box green lg">

            <h4>Lägg till ny styrelsepost</h4>
            <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_karen.inc.php'); ?>" method="POST">

              <input type="text" name="styrelsepost" value="" placeholder="Namn på styrelseposten (ex. Ordförande)..." required>
              <div class="autocomplete">
                <input type="text" name="student_name" id="student_name" value="" placeholder="Elev...">
              </div>


             <button type="submit" name="add_new_styrelse_post" class="btn lg">Lägg till posten</button>
           </form>

        </div>

      </div>
    <?php endif; //Check if admin ?>



      <?php

      global $wpdb;

      // Get the number of all members
      $all_students = get_users(array(
        'meta_key' => 'class_id'
      ));

      // Get first and last name from every student
      $first_last_array = array();
      foreach($all_students as $s){
        array_push($first_last_array, get_user_meta( $s->ID, 'nickname', true));
      }

      echo '<script type="text/javascript">';
      echo 'var jsonstudents = ' . json_encode($first_last_array);
      echo '</script>'

      ?>

      <script>
      // var jsonstudents = getArrayFromColumn(jsonstudents, 'display_name');

      autocomplete(document.getElementById("student_name"), jsonstudents, 'Inga elever hittades');
      autocomplete(document.getElementById("chairman_name"), jsonstudents, 'Inga elever hittades');
      autocomplete(document.getElementById("student-name-field"), jsonstudents, 'Inga elever hittades');
      autocomplete(document.getElementById("chairman-name-field"), jsonstudents, 'Inga elever hittades');
      </script>

      </section>

      <!--
      * Status View
      --------------------------------------->
      <?php
        require_once(get_template_directory() . "/parts/status-bar.php");
      ?>

    </div>

    <script src="<?php echo get_bloginfo('template_directory') ?>/js/admin.js" charset="utf-8"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/js/modal.js" charset="utf-8"></script>
    <script type="text/javascript">
      window.onload = function() {
        highlightLink('link-karen');

        // Check if admin
        <?php if (current_user_can('administrator') || current_user_can('elevkaren') ){ ?>
          var isAdmin = true;
        <?php } else {?>
          var isAdmin = false;
        <?php } ?>

        // make one able to click every one in styrelsen to change them
        var styrelsenRoot = document.getElementById('styrelsen');
        var styrelsePositions = styrelsenRoot.querySelectorAll('.chairman');

        styrelsePositions.forEach( (position) => {

          position.addEventListener('click', function() {

            let modal = document.querySelector('#modal-moreinfo');
            let position_name = position.querySelector('h3').innerText;
            // Also remove the Ordförande: part
            let student_name = position.querySelector('p').innerText;
            let student_mail = position.querySelector('input.position-student-email').value;

            // Change the modal header
            document.querySelector('#modal-moreinfo .modal-header .title').textContent = position_name;

            document.querySelector('#modal-moreinfo .modal-body #chairman-field').innerText = student_name + ' - ' + student_mail;

            document.querySelector('#modal-moreinfo .modal-body #description-field').innerText = '';

            // OPen the modal
            openModal(modal);
          });

          if (isAdmin){

            position.querySelector('.edit-image button').addEventListener('click', function() {
              let modal = document.querySelector('#modal');
              let position_name = position.querySelector('h3').innerText;
              let student_name = position.querySelector('p').innerText;
              let position_id = position.querySelector('input').value;

              // Change the modal header
              document.querySelector('#modal .modal-header .title').textContent = 'Ändra styrelsepositionen ' + position_name;

              document.querySelector('#modal .modal-body form #position-name-field').value = position_name;

              document.querySelector('#modal .modal-body form #position-id').value = position_id;

              document.querySelector('#modal .modal-body form .autocomplete #student-name-field').value = student_name;

              document.querySelector('#modal .modal-body form .button-group #submit-button').name = 'update_styrelse_post';

              document.querySelector('#modal .modal-body form .button-group #delete-button').name = 'delete_styrelse_post';

              // OPen the modal
              openModal(modal);
            });

          }

        });

        var utskottRoot = document.getElementById('utskotten');
        var utskotten = utskottRoot.querySelectorAll('.chairman');

        for(const utskott of utskotten){

          utskott.addEventListener('click', function() {

            let modal = document.querySelector('#modal-moreinfo');
            let utskott_name = utskott.querySelector('h3').innerText;
            // Also remove the Ordförande: part
            let chairman_name = utskott.querySelector('p').innerText.replace('Ordförande:', '');
            let utskott_description = utskott.querySelector('input.utskott-description').value;
            let chairman_mail = utskott.querySelector('input.utskott-chairman-email').value;

            // Change the modal header
            document.querySelector('#modal-moreinfo .modal-header .title').textContent = utskott_name;

            document.querySelector('#modal-moreinfo .modal-body #description-field').innerHTML = '<b>Beskrivning: </b>' + utskott_description + '<br>';

            document.querySelector('#modal-moreinfo .modal-body #chairman-field').innerHTML = '<b>Ordförande: </b>' + chairman_name + ' - ' + chairman_mail;

            // OPen the modal
            openModal(modal);
          });

          if (isAdmin) {

            utskott.querySelector('.edit-image button').addEventListener('click', function() {
              let modal = document.querySelector('#modal-change-utskott');
              let utskott_name = utskott.querySelector('h3').innerText;
              // Also remove the Ordförande: part
              let chairman_name = utskott.querySelector('p').innerText.substring(12);
              let utskott_id = utskott.querySelector('input.utskott-id').value;
              let utskott_description = utskott.querySelector('input.utskott-description').value;


              // Change the modal header
              document.querySelector('#modal-change-utskott .modal-header .title').textContent = 'Ändra utskottet ' + utskott_name;

              document.querySelector('#modal-change-utskott .modal-body form #utskott-name-field').value = utskott_name;

              document.querySelector('#modal-change-utskott .modal-body form #utskott-id').value = utskott_id;

              document.querySelector('#modal-change-utskott .modal-body form #utskott-description-field').value = utskott_description;

              document.querySelector('#modal-change-utskott .modal-body form .autocomplete #chairman-name-field').value = chairman_name;

              // OPen the modal
              openModal(modal);

              event.stopPropagation();
            });

          }

        }
      }

    </script>

    <?php
    // End if admin
    }
    ?>

<?php get_footer(); ?>
