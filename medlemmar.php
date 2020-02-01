<?php

/**
 * Template Name: Medlemmar
 */

// CHECK IF LOGGED IN
if (! is_user_logged_in() ){
  wp_redirect( '/' );
} else {

// Get wordpress database functionality
global $wpdb;

// Get all classes
$classes = $wpdb->get_results('SELECT * FROM vro_classes ORDER BY SUBSTRING(name , 3, 2)');

// Get the current student
$current_student_id = get_current_user_id();

// Check if the student is a member in the elevkår
if (metadata_exists('user', $current_student_id, 'status')){
  $status = get_user_meta($current_student_id, 'status', true);
  $is_member = $status != 'n' ? True : False;
} else {
  $is_member = NULL;
}


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  </head>
  <body>

    <div class="container">

      <!--
      * Admin Navbar
      --------------------------------------->
      <?php
      if (current_user_can('administrator') || current_user_can('elevkaren') ){
        require_once(get_template_directory() . "/parts/admin-navigation-bar.php");
      } else {
        require_once(get_template_directory() . "/parts/member-navigation-bar.php");
      }
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

        <?php

        global $wpdb;

        // Get the number of all members
        $user_amount = count(get_users(array(
          'meta_key' => 'class_id'
        )));

        // Get all users that are members in kåren
        $args = array(
            'meta_query' => array(
                array(
                    'key' => 'status',
                    'value' => 'y',
                    'compare' => '=='
                )
            )
        );

        // Get all members
        $member_amount = count(get_users($args));

        // Only do the calculation if there are any students
        if ($user_amount != 0){
          $percentage = round($member_amount / $user_amount * 100);
        } else {
          $percentage = 0;
        }

        ?>

        <?php if (current_user_can('administrator') || current_user_can('elevkaren') ){ ?>

          <?php

          // Get all users that are waiting to become members of kåren
          $args = array(
              'meta_query' => array(
                  array(
                      'key' => 'status',
                      'value' => 'w',
                      'compare' => '=='
                  )
              )
          );

          // Get all members
          $waiting_members = get_users($args);
          ?>

        <div class="banner">

          <?php
            if (count($waiting_members) == 1){
              echo '<h3>1 ny medlemsförfrågan!</h3>';
            } else {
              echo '<h3>'. count($waiting_members) .' nya medlemsförfrågningar!</h3>';
            }
          ?>

          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

        <?php

        // Add a new row and box for every suggestion
        echo '<div class="row">';

        foreach ($waiting_members as $wm)
        {
          ?>

            <div class="box white lg">
              <div class="see-more">
                <h4><?php echo get_user_meta($wm->ID, 'nickname', true); ?></h4>
                  <div>
                  <button onclick="showAnswerForm(<?php echo $wm->ID ?>)">Svara &#8594;</button>
                </div>
              </div>

              <div class="answer" id="<?php echo $wm->ID; ?>">

                <hr>

                <h4>Svar</h4>

                <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="POST">
                  <textarea name="member_answer" placeholder="Svar..."></textarea>
                  <input name="student_id" value="<?php echo $wm->ID; ?>" hidden>

                  <button name="accept_member" class="btn" type="submit">Godkänn</button>
                  <button name="quit_being_member" class="btn red" type="submit">Avböj</button>
                </form>

              </div>

            </div>

        <?php
        } // ENd foreach

        echo '</div>';

        ?>

        <div class="bow">

          <div class="box white sm center">

            <div class="first-place members">
              <p><b><?php echo $percentage; ?>%</b></p>
              <p><b>Medlemmar</b></p>
            </div>

          </div>

          <!-- Send message box -->
          <div class="box green md">

            <h4>Skicka mail till elever</h4>


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

        <div class="row">

          <div class="box white lg">

            <div class="see-more">
              <h4>Klasser</h4>
              <?php if (current_user_can('administrator') || current_user_can('elevkaren') ){
                echo '<h4>Medlemmar i elevkåren</h4>';
              }
              ?>
            </div>

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

              <a href="/panel/medlemmar?c_id=<?php echo $c->id; ?>" class="class">
                <p><?php echo $c->name; ?></p>

                <?php if (current_user_can('administrator') || current_user_can('elevkaren') ){ ?>
                  <div class="member_count">
                    <p><?php echo $student_members; ?></p>
                    <img src="<?php echo get_bloginfo('template_directory') ?>/img/right.png">
                    <p><?php echo $student_non_members; ?></p>
                    <img src="<?php echo get_bloginfo('template_directory') ?>/img/wrong.png">
                  </div>
                <?php } ?>

              </a>

          <?php } ?>


          </div>

        </div>

        <?php if (current_user_can('administrator') || current_user_can('elevkaren') ){ ?>

        <div class="row">

          <div class="box green lg">

            <h4>Skapa ny klass</h4>
            <form class="" method="post" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_classes.inc.php'); ?>">
              <input type="text" name="class-name" value="" placeholder="Klassnamn...">

              <button class="btn lg" type="submit" name="add_class">Skapa klass</button>
            </form>

          </div>

        </div>

      <?php } // end check admin to add new class ?>

      <?php } else { // End check admin ?>

        <?php if (current_user_can('administrator') || current_user_can('elevkaren') ){ ?>
        <div class="row">

          <div class="box white lg center">


            <div class="first-place members">
              <p><b><?php echo $percentage; ?>%</b></p>
              <p><b>Medlemmar</b></p>
            </div>

          </div>

        </div>
        <?php } ?>

      <?php } ?>

      <div class="row">

        <div class="box green lg">


          <?php
          if (!$is_member){
            echo '<h4>Ansök om att bli medlem i elevkåren</h4>';
          } else {
            echo '<h4>Gå ut ur elevkåren</h4>';
          }
          ?>
          <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="post">
            <input type="text" name="student_id" value="<?php echo $current_student_id; ?>" hidden>

            <?php

            if ($is_member){
              echo '<p>Du behöver skicak ett mail till.... för att gå ut</p>';
            } else {
              echo '<button class="btn lg" type="submit" name="apply_for_member">Klicka för att skicka en medlemsansökan!</button>';
            }

            ?>

          </form>

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

<?php get_footer(); ?>
