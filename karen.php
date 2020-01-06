<?php

/**
 * Template Name: Kåren
 */

?>

<?php

// Show this page to all logged in users
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

        <div class="top-bar">
          <h2>Kåren</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <div class="banner">
          <h3>Välkommen tillbaka Anna!</h3>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

        <div class="row">

          <?php

          // Get all events type
          global $wpdb;

          $position_types = $wpdb->get_results('SELECT * FROM vro_position_types');

          foreach ($position_types as $pt) {
            ?>

            <div class="box sm white">
              <h4><?php echo $pt->name; ?></h4>
            </div>

            <?php
          }

          ?>

        </div>

        <div class="row">

          <div class="box green lg">

            <h4>Lägg till ny roll i elevkåren</h4>
            <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_karen.inc.php'); ?>" method="POST">
              <input type="text" name="position_name" value="" placeholder="Namn på rollen..." required>
              <div class="yes-no">
                <label>Kan flera studenter ha denna roll?</label>
                <input type="radio" name="is_unique" value="True" checked> <label>Ja</label>
                <input type="radio" name="is_unique" value="False"> <label>Nej</label>
              </div>

              <div class="yes-no">
                <label>Kommer denna roll vara knytet till ett utskott?</label>
                <input type="radio" name="is_linked_utskott" value="True" checked> <label>Ja</label>
                <input type="radio" name="is_linked_utskott" value="False"> <label>Nej</label>
              </div>

             <button type="submit" name="add_new_position_type" class="btn lg">Skapa ny rolltyp</button>
           </form>

          </div>

        </div>

        <div class="row">

          <div class="box green lg">

            <h4>Lägg till ny elev i roll</h4>
            <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="POST">
              <div class="select-group">

                <label for="">Rolltyp: </label>
                <select name="ae_event_type">
                  <?php

                  // Get all events type
                  global $wpdb;

                  $position_types = $wpdb->get_results('SELECT * FROM vro_position_types');

                  if (empty($position_types)){
                    echo '<option value="none">Inga rolltyper skapade.</option>';
                  } else {

                    foreach ($position_types as $pt) {
                      echo '<option value="'. $pt->id .'">'. $pt->name .'</option>';
                    }

                  }
                  ?>

                </select>
              </div>

              <div class="autocomplete">
                <input type="text" name="student_name" id="student_name" value="" placeholder="Namn..." required>
              </div>


             <button type="submit" name="add_new_user" class="btn lg">Lägg till elev i utskott</button>
           </form>

           <?php

           global $wpdb;

           // Get the number of all members
           $all_students = get_users(array(
             'meta_key' => 'class_id'
           ));

           // Get first and last name from every student
           $first_last_array = array();
           foreach($all_students as $s){
             array_push($first_last_array, get_user_meta( $s->ID, 'nickname', true));
           }

           echo '<script type="text/javascript">';
           echo 'var jsonstudents = ' . json_encode($first_last_array);
           echo '</script>'

           ?>

           <script>
           // var jsonstudents = getArrayFromColumn(jsonstudents, 'display_name');

           autocomplete(document.getElementById("student_name"), jsonstudents, 'Inga elever hittades');
           </script>

          </div>

        </div>

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
      window.onload = highlightLink('link-karen');
    </script>

    <?php
    // End if admin
    }
    ?>

  </body>
</html>
