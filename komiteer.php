<?php

/**
 * Template Name: Kommiteer
 */

// Show this page only to admin
if (! is_user_logged_in() || !(current_user_can('administrator') || current_user_can('elevkaren') ) ){
  wp_redirect( '/' );
} else {

  // Get access to all wordpress database funcitonality
  global $wpdb;

  // Get all kommitéer applications
  $results = $wpdb->get_results('SELECT * FROM vro_kommiteer WHERE status = "w"');

  // Get all acceppted commitees
  $kommiteer = $wpdb->get_results('SELECT * FROM vro_kommiteer WHERE status = "y"');

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

      <!-- **************************
        ADMIN NAVBAR
      **************************  -->
      <?php
        require_once(get_template_directory() . "/parts/navigation-bar.php");
      ?>

      <!-- **************************
        DASHBOARD
      **************************  -->
      <section id="dashboard">

        <?php

        // Check if a single kommitée should be displayed or the dashboard style
        if (isset($_GET['k_id'])){
            // Show the single view
            require_once(get_template_directory() . "/parts/single_kommitee.php");
        } else {

        ?>

        <!-- Show page title and current date -->
        <div class="top-bar">
          <h2>Kommitéer</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <div class="banner">

          <!-- Change the message depending on singular or plural application number -->
          <?php if (count($results) == 1){ ?>
            <h3><?php echo count($results); ?> ny förfrågan!</h3>
          <?php } else { ?>
            <h3><?php echo count($results); ?> nya förfrågningar!</h3>
          <?php } ?>

          <!-- Chatbox images for style -->
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

        <?php

        /************************
        *  Applications
        ************************/

        // Add a new row and box for every suggestion
        foreach ($results as $r)
        {

          ?>
          <div class="row">'
            <div class="box white lg">
              <div class="see-more">
                <h4><?php echo $r->name ?></h4>
                  <div>
                  <button onclick="showAnswerForm(<?php echo $r->id ?>)">Svara &#8594;</button>
                </div>
              </div>

              <p><?php echo $r->description ?></p>

              <div class="answer" id="<?php echo $r->id ?>">

                <hr>

                <h4>Svar</h4>

                <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="POST">
                  <textarea name="name" placeholder="Svar..."></textarea>

                  <button name="accept_kommitee" value="<?php echo $r->id ?>" class="btn" type="submit">Godkänn</button>
                  <button name="deny_kommitee" value="<?php echo $r->id ?>" class="btn red" type="submit">Avböj</button>
                </form>

              </div>

            </div>
          </div>
        <?php
        }

        ?>

        <!-- **************************
          BASIC INFORMATION
        **************************  -->

        <div class="row">

          <div class="box white sm">
            <h4>Kommiteeansvarig</h4>
          </div>

          <div class="box green md">
            <h4>Sök kommiteer</h4>
            <form>

              <input type="text" name="" value="" placeholder="Kommitée...">

              <button type="submit" name="button" class="btn lg">Sök</button>

            </form>

          </div>

        </div>

        <!-- **************************
          ALL KOMMITÉES
        **************************  -->

        <div class="row">

          <div class="box green lg">
            <h4>Alla kommiteer</h4>

            <div class="kommiteer">

              <!-- Always show the add new kommitée card -->
              <div class="kommitee alert">
                  <button class="add-btn lg">+</button>
                  <h5>Skapa ny kommitée</h5>
              </div>

              <?php

              // Go through all accepted kommitées and display their name and member count
              foreach ($kommiteer as $k){

                // Get the member count
                $member_count = count($wpdb->get_results('SELECT * FROM vro_kommiteer_members WHERE kommitee_id=' . $k->id));

              ?>

              <!-- Create new element to hold the information -->
              <div class="kommitee">
                <a href="/admin/kommiteer?k_id=<?php echo $k->id; ?>">
                    <!-- Name -->
                    <h4><?php echo $k->name ?></h4>

                    <?php   // Change heading depening on plural or singular members
                      $member_text = $member_count . ($member_count == 1 ? ' medlem' : ' medlemmar');
                    ?>
                    <p><?php echo $member_text; ?></p>
                </a>

              </div>

            <?php } ?>

            </div>

          </div>

        </div>

        <!-- **************************
          ADD NEW KOMMITÉE
        **************************  -->

        <div class="row">

          <div class="box white lg">

            <h3>Skapa ny kommitée</h3>
            <form>
              <input type="text" name="" value="" placeholder="Namn...">
              <textarea name="name" type=="text" placeholder="Beskrivning..."></textarea>
              <input type="text" name="" value="" placeholder="Ordförande...">

              <button type="submit" name="button" class="btn lg">Skapa</button>
            </form>

          </div>

        </div>

        <?php } ?>

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
      window.onload = highlightLink('link-kommiteer');
    </script>

    <?php
    // End if admin
    }
    ?>

  </body>
</html>
