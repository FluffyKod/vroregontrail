<?php

/**
 * Template Name: Hemsidan
 */

// Show this page only to admin
if (! is_user_logged_in() || !(current_user_can('administrator') || current_user_can('elevkaren') ) ){
  wp_redirect( '/' );
} else {

  // Get current user
  $user = wp_get_current_user();
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

      <!--
      * Admin Navbar
      --------------------------------------->
      <?php
        require_once(get_template_directory() . "/parts/admin-navigation-bar.php");
      ?>

      <!-- ***********************************
      * DASHBOARD
      *************************************-->

        <div class="banner">
          <h3>Välkommen tillbaka Anna!</h3>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

        <!-- Display current name, number of visselpipan suggestions and number of kommitée applications -->
        <div class="banner">
          <h3>Välkommen tillbaka <?php echo $user->user_nicename; ?>!</h3>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
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
      window.onload = highlightLink('link-hemsidan');
    </script>

    <?php
    // End if admin
    }
    ?>

  </body>
</html>
