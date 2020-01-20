<?php

/**
 * Template Name: Arkiv
 */

// Show this page only to admin or Elevkåren
if (! is_user_logged_in() ){
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php echo get_bloginfo('template_directory') ?>/js/autocomplete.js" charset="utf-8"></script>
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

      require_once(get_template_directory() . "/scripts/helpful_functions.php");
      ?>

       <!-- ***********************************
       * DASHBOARD
       *************************************-->
      <section id="dashboard">

        <!-- Display header and current time -->
        <div class="top-bar">
          <h2>Arkiv</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <div class="archive-links">
          <a class="btn" href="#karbrev">Se alla kårbrev</a>
          <a class="btn" href="#kommitte">Se alla kommitténotiser</a>
          <a class="btn" href="#">Se alla bilder</a>
        </div>


        <h2 id="karbrev" class="archive-title">Kårbrev</h2>

        <?php display_karbrev( 0, false ); ?>

        <h2 id="kommitte" class="archive-title">Kommittéenotiser</h2>

        <?php

        display_kommitte_notifications( 0, false );

        ?>

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
