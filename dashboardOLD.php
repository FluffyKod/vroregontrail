<?php

/**
 * Template Name: Admin
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
    <script src="<?php echo get_bloginfo('template_directory') ?>/js/autocomplete.js" charset="utf-8"></script>
  </head>
  <body>

    <div class="container">

      <!-- ***********************************
      * NAVBAR
      *************************************-->

      <?php
      // Display a special navbar for admins
      if (!current_user_can('administrator') and !current_user_can('elevkaren') ){
        // Get the members view
        require_once(get_template_directory() . "/parts/member-dashboard.php");
      } else {

      require_once(get_template_directory() . "/parts/admin-navigation-bar.php");

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
            <p class="amount" data-content="Nya förslag"><b><?php echo $visselpipan_amount; ?></b></p>
          </div>

          <!-- show kommitée info -->
          <div class="box green sm update">
            <h4>Kommitéer</h4>
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/folderalert.png" alt="">
            <p class="amount" data-content="Nya förfrågningar"><b><?php echo $kommiteer_amount ?></b></p>
          </div>

          <!-- Box to add a new event -->
          <div class="box white sm alert">
            <button class="add-btn lg"><a href="/panel/kalender#datetime-box">+</a></button>
            <h4>Skapa nytt event</h4>
          </div>

        </div>


        <div class="row">

          <!-- Classpoints box -->
          <div class="box white sm classpoints">

            <div class="">

              <h4>Ge klasspoäng</h4>

              <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_classes.inc.php'); ?>" method="post" autocomplete="off">
                <?php

                if (isset($_GET['class_points'])) {

                  $class_point_check = $_GET['class_points'];

                  if ($class_point_check == 'empty') {
                    echo '<p class="error">Du måste fylla i alla värden!</p>';
                  }
                  elseif ($class_point_check == 'noclassfound') {
                    echo '<p class="error">Ingen klass hittades!</p>';
                  }
                  elseif ($class_point_check == 'success') {
                    echo '<p class="success">Poängen har lagts till!</p>';
                  }

                }

                ?>

                <div class="autocomplete">
                  <input id="class-name" type="text" name="class-name" value="" placeholder="Klass..." required>
                </div>

                <input type="number" name="add-points" value="" placeholder="+/-Poäng..." required>
                <input type="text" name="callback" value="/panel/dashboard" hidden>

                <button class="btn lg" type="submit" name="give_class_points">Ge poäng</button>
              </form>



              <?php
              // AUTOCOMPLETE
              global $wpdb;

              $results = $wpdb->get_results('SELECT name FROM vro_classes ORDER BY points DESC');

              if (count($results) > 0){
                $top_class = $results[0];
              }

              echo '<script type="text/javascript">';
              echo 'var jsonclasses = ' . json_encode($results);
              echo '</script>'

              ?>

              <script>
              var classes = getArrayFromColumn(jsonclasses, 'name');

              autocomplete(document.getElementById("class-name"), classes, 'Denna klass är ännu inte skapad');
              </script>

            </div>

            <div class="first-place">
              <p><b>1</b></p>
              <p><b><?php echo $top_class->name; ?></b></p>

              <img class="trophy" src="<?php echo get_bloginfo('template_directory') ?>/img/bigtrophy.png" alt="">
              <img class="circle"src="<?php echo get_bloginfo('template_directory') ?>/img/circle.png" alt="">
            </div>

          </div>

          <!-- Send message box -->
          <div class="box green md">

            <h4>Skicka Meddelande</h4>

            <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/send_mail.inc.php'); ?>" method="post">

              <input type="text" name="subject" value="" placeholder="Ämne...">
              <textarea name="message" placeholder="Meddelande..."></textarea>

              <input type="radio" name="mail-to" value="all" checked> <label>Hela skolan</label><br>
              <input type="radio" name="mail-to" value="3"> <label>Årskurs 3</label><br>
              <input type="radio" name="mail-to" value="2"> <label>Årskurs 2</label><br>
              <input type="radio" name="mail-to" value="1"> <label>Årskurs 1</label><br>

              <button name="send_message_school" class="btn lg">Skicka</button>

            </form>

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

        <?php

        $args = array(
            // 'category_name' => $catString,
            // 'category__in' => $catArray,
            'post_status' => 'publish',
            'post_type' => 'post',
            'orderby' => 'post_date',
            'posts_per_page' => 2
        );

        // The Query
        $the_query = new WP_Query( $args );

        // The Loop
        if ( $the_query->have_posts() ) : ?>

            <div class="see-more blogposts-header">
              <h2>Senaste nytt</h2>
              <div class="">
                <a href="">See alla inlägg &#8594;</a>
              </div>
            </div>

            <?php while ( $the_query->have_posts() ) {
                $the_query->the_post();

                get_template_part( 'content' );
            } ?>
        <?php endif;
        /* Restore original Post Data */
        wp_reset_postdata();

        ?>

      </section>

    <?php } // End show member dashboard or admin dashboard ?>

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
