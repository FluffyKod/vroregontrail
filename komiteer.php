<?php

/**
 * Template Name: Kommiteer
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

    <?php

      // Get all applications
      global $wpdb;

      $results = $wpdb->get_results('SELECT * FROM vro_kommiteer WHERE status = "w"');

     ?>

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
      <section id="dashboard">

        <div class="top-bar">
          <h2>Kommitéer</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <div class="banner">

          <?php if (count($results) == 1){ ?>
            <h3><?php echo count($results); ?> ny förfrågan!</h3>
          <?php } else { ?>
            <h3><?php echo count($results); ?> nya förfrågningar!</h3>
          <?php } ?>

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
                echo '<h4>' . $r->name . '</h4>';
                echo '<div>';
                  echo '<button onclick="showAnswerForm('. $r->id .')">Svara &#8594;</button>';
                echo '</div>';
              echo '</div>';

              echo '<p>' . $r->description . '</p>';

              echo '<div class="answer" id="' . $r->id .'">';

                echo '<hr>';

                echo '<h4>Svar</h4>';

                echo '<form action="/admin/kommiteer/" method="POST">';
                  echo '<textarea name="name" placeholder="Svar..."></textarea>';

                  echo '<button name="accept" value="'. $r->id .'" class="btn" type="submit">Godkänn</button>';
                  echo '<button name="deny" value="'. $r->id .'" class="btn red" type="submit">Avböj</button>';
                echo '</form>';

              echo '</div>';

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
      window.onload = highlightLink('link-kommiteer');
    </script>

    <?php
    // End if admin
    }
    ?>

  </body>
</html>
