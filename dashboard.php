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
        <div class="bow">

          <!-- Show visselpipan info-->
          <div class="box green sm update">
              <h4>Visselpipan</h4>
              <div class="content">
                <img src="<?php echo get_bloginfo('template_directory') ?>/img/whistle.png" alt="">
                <p class="amount" data-content="Nya förslag"><b><?php echo $visselpipan_amount; ?></b></p>
              </div>
          </div>

          <!-- show kommitée info -->
          <div class="box green sm update">
            <h4>Kommitéer</h4>
            <div class="content">
              <img src="<?php echo get_bloginfo('template_directory') ?>/img/folderalert.png" alt="" class="folder">
              <p class="amount" data-content="Nya förfrågningar"><b><?php echo $kommiteer_amount ?></b></p>
            </div>
          </div>

          <!-- Box to add a new event -->
          <div class="box white sm alert">
            <button class="add-btn lg"><a href="/panel/kalender#datetime-box">+</a></button>
            <h4>Skapa nytt event</h4>
          </div>

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

        <!-- Search for member -->
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

        <div class="bow">

          <?php

          $odenplan_frescati_url = 'https://api.sl.se/api2/TravelplannerV3_1/trip.json?key=471f7b533072422587300653963192ad&originExtId=9117&destExtId=9203&products=8&lines=50';
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $odenplan_frescati_url);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          $result = curl_exec($curl);
          curl_close($curl);

          $json_odenplan_frescati = json_decode($result, true);

          $frescait_odenplan_url = 'https://api.sl.se/api2/TravelplannerV3_1/trip.json?key=471f7b533072422587300653963192ad&originExtId=9203&destExtId=9117&products=8&lines=50';
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $frescait_odenplan_url);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          $result = curl_exec($curl);
          curl_close($curl);

          $json_frescati_odenplan = json_decode($result, true);

          ?>

          <div class="box green hl frescati">
            <div class="see-more">
              <h3>Nästa buss Frescati</h3>
              <button onclick="toggleClass('frescatis', 'all', 'one');">See alla &#8594;</button>
            </div>


            <div id="frescatis" class="one">

              <?php foreach ($json_odenplan_frescati['Trip'] as $key => $trip) { ?>
                <div class="frescati-time">
                  <hr>
                  <p><b><?php echo $trip['LegList']['Leg'][0]['Origin']['name']; ?>: </b> <?php echo $trip['LegList']['Leg'][0]['Origin']['time']?></p>
                  <p><b><?php echo $trip['LegList']['Leg'][0]['Destination']['name']; ?>: </b> <?php echo $trip['LegList']['Leg'][0]['Destination']['time']?></p>
                </div>
              <?php } ?>
          </div>

        </div>

        <div class="box white hl frescati">
          <div class="see-more">
            <h3>Nästa buss Odenplan</h3>
            <button onclick="toggleClass('odenplans', 'all', 'one');">See alla &#8594;</button>
          </div>


          <div id="odenplans" class="one">

            <?php foreach ($json_frescati_odenplan['Trip'] as $key => $trip) { ?>
              <div class="frescati-time">
                <hr>
                <p><b><?php echo $trip['LegList']['Leg'][0]['Origin']['name']; ?>: </b> <?php echo $trip['LegList']['Leg'][0]['Origin']['time']?></p>
                <p><b><?php echo $trip['LegList']['Leg'][0]['Destination']['name']; ?>: </b> <?php echo $trip['LegList']['Leg'][0]['Destination']['time']?></p>
              </div>
            <?php } ?>
        </div>

      </div>

      <div class="box white sm">
        <h3>Dagens lunch</h3>
        <p><b>Huvudrätt: </b>Pannbiff med gräddsås, inlagd gurka och kokt potatis</p>
        <p><b>Vegetarisk: </b>Tofu- och grönsaker i kokoscurry serveras med basmatiris</p>
      </div>

      <div class="box white sm classpoints smaller">
        <h3>Klasspokalen</h3>
        <div class="first-place">
          <p><b>1</b></p>
          <p><b><?php echo $top_class->name; ?></b></p>

          <img class="trophy" src="<?php echo get_bloginfo('template_directory') ?>/img/bigtrophy.png" alt="">
          <img class="circle"src="<?php echo get_bloginfo('template_directory') ?>/img/circle.png" alt="">
        </div>

      </div>

        </div>

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
