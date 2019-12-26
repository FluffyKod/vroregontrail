<?php

/**
 * Template Name: Admin
 */

// Show this page only to admin or Elevkåren
if (! is_user_logged_in() || !(current_user_can('administrator') || current_user_can('elevkaren') ) ){
  wp_redirect( '/' );
} else {
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta lang="sv">

    <title>VRO Elevkår</title>

    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory') ?>/css/admin.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700&display=swap" rel="stylesheet">
  </head>
  <body>

    <div class="container">

      <!-- ***********************************
      * ADMIN NAVBAR
      *************************************-->
      <?php
        require_once(get_template_directory() . "/parts/navigation-bar.php");
      ?>

      <?php

      // Get access to wordpress database functions
      global $wpdb;

      // Get the number of current visselpipan suggestions
      $visselpipan_amount = count($wpdb->get_results('SELECT * FROM vro_visselpipan WHERE status = "w"'));

      // Get the number of current kommitee aplications
      $kommiteer_amount = count($wpdb->get_results('SELECT * FROM vro_kommiteer WHERE status = "w"'));

      // Get current user
      $user = wp_get_current_user();

       ?>

       <!-- ***********************************
       * DASHBOARD
       *************************************-->
      <section id="dashboard">

        <!-- Display header and current time -->
        <div class="top-bar">
          <h2>Dashboard</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <!-- Display current name, number of visselpipan suggestions and number of kommitée applications -->
        <div class="banner">
          <h3>Välkommen tillbaka <?php echo $user->user_nicename; ?>!</h3>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

        <!-- Basic info -->
        <div class="row">

          <!-- Show visselpipan info-->
          <div class="box green sm update">
            <h4>Visselpipan</h4>
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/whistle.png" alt="">
            <p class="whistle amount"><b><?php echo $visselpipan_amount; ?></b></p>
          </div>

          <!-- show kommitée info -->
          <div class="box green sm update">
            <h4>Kommitéer</h4>
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/folderalert.png" alt="">
            <p class="commit amount"><b><?php echo $kommiteer_amount ?></b></p>
          </div>

          <!-- Box to add a new event -->
          <div class="box white sm alert">
            <button class="add-btn lg">+</button>
            <h4>Skapa nytt event</h4>
          </div>

        </div>


        <div class="row">

          <!-- Classpoints box -->
          <div class="box white sm classpoints">

            <div class="">

              <h4>Ge klasspoäng</h4>

              <input type="text" name="" value="" placeholder="Klass...">
              <input type="number" name="" value="" placeholder="Poäng...">

              <a href="#" class="btn lg">Ge poäng</a>

            </div>

            <div class="first-place">
              <p><b>1</b></p>
              <p><b>Na21c</b></p>

              <img class="trophy" src="<?php echo get_bloginfo('template_directory') ?>/img/bigtrophy.png" alt="">
              <img class="circle"src="<?php echo get_bloginfo('template_directory') ?>/img/circle.png" alt="">
            </div>

          </div>

          <!-- Send message box -->
          <div class="box green md">

            <h4>Skicka Meddelande</h4>


            <textarea name="name" placeholder="Meddelande..."></textarea>

              <input type="radio" name="mail-to" value="" checked> <label>Hela skolan</label><br>
              <input type="radio" name="mail-to" value=""> <label>Årskurs 3</label><br>
              <input type="radio" name="mail-to" value=""> <label>Årskurs 2</label><br>
              <input type="radio" name="mail-to" value=""> <label>Årskurs 1</label><br>

              <a href="#" class="btn lg">Skicka</a>

          </div>

        </div>

        <!-- Search for member -->
        <div class="row">

          <div class="box white lg">

            <h4>Sök medlem</h4>

            <input type="text" name="" value="" placeholder="Namn...">
            <input type="text" name="" value="" placeholder="Klass...">

            <a href="#" class="btn lg">Sök</a>

          </div>

        </div>

      </section>

      <!-- ***********************************
      * STATUS BAR
      *************************************-->
      <?php
        require_once(get_template_directory() . "/parts/status-bar.php");
      ?>

    </div>


  <script src="<?php echo get_bloginfo('template_directory') ?>/js/admin.js" charset="utf-8"></script>
  <script type="text/javascript">
    window.onload = highlightLink('link-dashboard');
  </script>

  <?php
  // End if admin
  }
  ?>

  </body>
</html>
