<?php

/**
 * Template Name: Projektgrupper
 */

 // CHECK IF LOGGED IN SND ADMIN
 if (! is_user_logged_in() || !(current_user_can('administrator') || current_user_can('elevkaren') ) ){
   wp_redirect( '/panel' );
 } else {

  // Get access to all wordpress database funcitonality
  global $wpdb;

  // Get all projektgrupper
  $projektgrupper = $wpdb->get_results('SELECT * FROM vro_projektgrupper ORDER BY name');

  require_once(get_template_directory() . "/scripts/helpful_functions.php");

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
    <script src="<?php echo get_bloginfo('template_directory') ?>/js/forms.js" charset="utf-8"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/js/autocomplete.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
      <!-- **************************
        DASHBOARD
      **************************  -->
      <section id="dashboard">

        <?php

        // Check if a single kommitée should be displayed or the dashboard style
        if (isset($_GET['p_id'])){
            // Show the single view
            require_once(get_template_directory() . "/parts/single_projektgrupp.php");
        } else {

        ?>

        <!-- Show page title and current date -->
        <div class="top-bar">
          <h2>Projektgrupper</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <p>Här kan man se och gå med i projektgrupper!</p>

        <!-- **************************
          ALLA PROJEKTGRUPPER
        **************************  -->

        <div class="row">

          <div class="box green lg">
            <h4>Alla projektgrupper</h4>

            <div class="kommiteer">

              <!-- Always show the add new kommitée card -->
              <div class="kommitee alert">
                  <a href="#new-projektgrupp" class="add-btn lg">+</a>
                  <h5>Skapa ny projektgrupp</h5>
              </div>

              <?php

              // Go through all accepted kommitées and display their name and member count
              foreach ($projektgrupper as $p){

              ?>

              <!-- Create new element to hold the information -->
              <div class="kommitee">
                <a href="/panel/projektgrupper?p_id=<?php echo $p->id; ?>">
                    <!-- Name -->
                    <h4><?php echo $p->name ?></h4>
                    <?php
                    // Check if current user is member in this kommitté,
                        // if they have joined --> display Jag är medlem,
                        // if they are not member att all --> display nothing

                    $member_check = $wpdb->get_row('SELECT * FROM vro_kommiteer_members WHERE kommitee_id = '. $k->id . ' AND user_id = '. get_current_user_id() );

                    if ($member_check != NULL){
                      echo '<p>Jag är med!</p>';
                    }

                    ?>
                </a>

              </div>

            <?php } ?>

            </div>

          </div>

        </div>


        <!-- **************************
          ADD NEW KOMMITÉE
        **************************  -->

        <div class="row" id="new-projektgrupp">

          <div class="box white lg allow-overflow">

            <h3>Skapa ny projektgrupp</h3>
            <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_projektgrupper.inc.php'); ?>" method="post" autocomplete="off">
              <input type="text" name="p_name" value="" placeholder="Namn på projektgruppen..." required>
              <div class="text-limited-root">
                <textarea name="p_description" placeholder="Beskrivning av projektgruppen..." required onkeyup="checkForm(this, projektgrupp_description_char_count, 300)"></textarea>
                <p id="projektgrupp_description_char_count">300</p>
              </div>

              <button type="submit" name="add_new_projektgrupp" class="btn lg">Skapa</button>
            </form>

          </div>

        </div>




      <?php

    } // End show single kommitté

    }// End if admin ?>


    </section>


      <!-- **************************
        STATUS BAR
      **************************  -->
      <?php
        require_once(get_template_directory() . "/parts/status-bar.php");
      ?>

    </div>

    <script src="<?php echo get_bloginfo('template_directory') ?>/js/admin.js" charset="utf-8"></script>
    <script type="text/javascript">
      window.onload = highlightLink('link-projektgrupper');
    </script>

<?php get_footer(); ?>
