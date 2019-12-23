<?php

/**
 * Template Name: Visselpipan
 */

?>

<?php

// Show this page only to admin
if (! is_user_logged_in() || ! current_user_can('administrator') ){
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

      <!--
      * Admin Navbar
      --------------------------------------->
      <?php
        require_once(get_template_directory() . "/parts/navigation-bar.php");
      ?>

      <!--
      * Dashboard
      --------------------------------------->

      <?php

        // Get all suggestions
        global $wpdb;

        $results = $wpdb->get_results('SELECT * FROM vro_visselpipan WHERE status = "w"');

       ?>

      <section id="dashboard">

        <div class="top-bar">
          <h2>Visselpipan</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <div class="banner">
          <h3><?php echo count($results); ?> nya förslag!</h3>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

          <?php

          // Add a new row and box for every suggestion
          foreach ($results as $r)
          {
            echo '<div class="row">';
              echo '<div class="box white lg">';
                echo '<div class="see-more">';
                  echo '<h4>' . $r->subject . '</h4>';
                  echo '<div>';
                    echo '<a href="#">Svara &#8594;</a>';
                  echo '</div>';
                echo '</div>';

                echo '<p>' . $r->text . '</p>';

              echo '</div>';
            echo '</div>';

          }

          ?>

      </section>

      <!--
      * Status View
      --------------------------------------->
      <?php
        require_once(get_template_directory() . "/parts/status-bar.php");
      ?>

    </div>

    <script src="<?php echo get_bloginfo('template_directory') ?>/js/admin.js" charset="utf-8"></script>
    <script type="text/javascript">
      window.onload = highlightLink('link-visselpipan');
    </script>

    <?php
    // End if admin
    }
    ?>

  </body>
</html>
