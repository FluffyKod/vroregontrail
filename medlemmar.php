<?php

/**
 * Template Name: Medlemmar
 */

// Show this page only to admin
iif (! is_user_logged_in() || !(current_user_can('administrator') || current_user_can('elevkaren') ) ){
  wp_redirect( '/' );
} else {

// Get wordpress database functionality
global $wpdb;

// Get all classes
$classes = $wpdb->get_results('SELECT * FROM vro_classes');

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
      <section id="dashboard">

        <?php
        // Check if a single class should be displayed
        if (isset($_GET['c_id'])){
          // Load the single_class template to show specific class information
          require_once(get_template_directory() . "/parts/single_class.php");
        } else {

        ?>

        <div class="top-bar">
          <h2>Medlemmar</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <div class="banner">
          <h3>0 nya förfrågningar!</h3>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

        <div class="row">

          <div class="box white sm center">

            <h2 class="gt">97% medlemmar!</h2>

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

        <div class="row">

          <div class="box white lg">

            <h4>Klasser</h4>

            <?php

            foreach($classes as $c){
              // Setup counters for all members and non-members
              $student_members = 0;
              $student_non_members = 0;

              // Setup to get all students for that class
              $args = array(
                  'meta_query' => array(
                      array(
                          'key' => 'class_id',
                          'value' => $c->id,
                          'compare' => '=='
                      )
                  )
              );

              // Get all students for that class
              $member_arr = get_users($args);
              if ($member_arr) {
                // Go throught every student
                foreach ($member_arr as $user) {

                  // Check if each student is member in the elevkår
                  $status = get_metadata('user', $user->ID, 'status');

                  // check if the status meta data is set
                  if (empty($status)) {
                    continue;
                  }

                  // Count the members
                  if ($status[0] == 'y'){
                    $student_members += 1;
                  } else {
                    $student_non_members += 1;
                  }
                }
              }

            ?>

              <a href="/admin/medlemmar?c_id=<?php echo $c->id; ?>" class="class">
                <p><?php echo $c->name; ?></p>
                <div class="member_count">
                  <p><?php echo $student_members; ?></p>
                  <img src="<?php echo get_bloginfo('template_directory') ?>/img/right.png">
                  <p><?php echo $student_non_members; ?></p>
                  <img src="<?php echo get_bloginfo('template_directory') ?>/img/wrong.png">
                </div>


            </a>

          <?php } ?>


          </div>

        </div>

      <?php } // End show single_class or overview ?>

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
      window.onload = highlightLink('link-medlemmar');
    </script>

    <?php
    // End if admin
    }
    ?>

  </body>
</html>
