<?php

/**
 * Template Name: Admin
 */

// Show this page only to admin or Elevkåren
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php echo get_bloginfo('template_directory') ?>/js/autocomplete.js" charset="utf-8"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  </head>
  <body>

    <?php if (isset($_GET['register']) && $_GET['register'] == 'success') : ?>
      <script type="text/javascript">
      Swal.fire(
        'Succée!',
        'Du är nu registrerad och kan använda alla funktioner på hemsidan!',
        'success'
        )
      </script>
    <?php endif; ?>

    <?php if (isset($_GET['register']) && $_GET['register'] == 'resuccess') : ?>
      <script type="text/javascript">
      Swal.fire(
        'Succée!',
        'Du har nu uppdaterat ditt medlemsskap och kan fortsätta använda hemsidan!',
        'success'
        )
      </script>
    <?php endif; ?>

    <div class="container">

      <!-- ***********************************
      * NAVBAR
      *************************************-->

      <?php
      // Display a special navbar for admins
      if (!current_user_can('administrator') and !current_user_can('elevkaren') ){
        // Get the members view
        require_once(get_template_directory() . "/scripts/helpful_functions.php");

        require_once(get_template_directory() . "/parts/member-dashboard.php");
      } else {

      require_once(get_template_directory() . "/parts/admin-navigation-bar.php");

      require_once(get_template_directory() . "/scripts/helpful_functions.php");

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
          <h3>Välkommen tillbaka <?php echo get_user_meta($user->ID,'nickname',true); ?>!</h3>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

        <!-- Basic info -->
        <div class="bow">

          <!-- Show visselpipan info-->
          <a href="/panel/visselpipan" class="box green sm update">
              <h4>Visselpipan</h4>
              <div class="content">
                <img src="<?php echo get_bloginfo('template_directory') ?>/img/whistle.png" alt="">
                <p class="amount" data-content="Nya förslag"><b><?php echo $visselpipan_amount; ?></b></p>
              </div>
          </a>

          <!-- show kommitée info -->
          <a href="/panel/kommiteer/" class="box green sm update">
            <h4>Kommittéer</h4>
            <div class="content">
              <img src="<?php echo get_bloginfo('template_directory') ?>/img/folderalert.png" alt="" class="folder">
              <p class="amount" data-content="Nya förfrågningar"><b><?php echo $kommiteer_amount ?></b></p>
            </div>
          </a>

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

                <input type="number" name="add-points" value="" placeholder="+/-Poäng..." required min="-1000" max="1000">
                <input type="text" name="callback" value="/panel/dashboard" hidden>

                <button class="btn lg" type="submit" name="give_class_points">Ge poäng</button>

                <!-- <script>

                function confirmDeletion(button) {
                  Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                  if (result.value) {
                    button.click()
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                  }
                  })
                }
                </script> -->
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

            <h4>Skicka mail till elever</h4>

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
            <h4>Sök elev</h4>

            <input type="search" placeholder="Namn.." name="keyword" id="keyword" onkeyup="fetch()"></input>
            <div id="loader" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>

            <div id="datafetch"></div>

            <script type="text/javascript">
            function fetch(){

                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'post',
                    data: { action: 'data_fetch', keyword: jQuery('#keyword').val() },
                    beforeSend: function() {
                      if (document.getElementById('keyword').value.length == 1){
                        document.getElementById('loader').style.display = 'block';
                      }
                    },
                    success: function(data) {
                        jQuery('#datafetch').html( data );
                    },
                    complete: function() {
                      document.getElementById('loader').style.display = 'none';
                    }
                });

              }
            </script>


          </div>

        </div>

        <?php
          require_once(get_template_directory() . "/parts/dashboard-gadgets.php");
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

<?php get_footer(); ?>
