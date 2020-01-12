<?php

// Check if this page has been called
if (!isset($_GET['c_id'])) {
  wp_redirect('/panel/medlemmar');
  exit();
}

// Check if an id has been supplied
if (!is_numeric($_GET['c_id'])){
  header('Location: /panel/medlemmar?status=idnan');
  exit();
}

// Get access to the wordpress database
global $wpdb;

$c_id = (int)$_GET['c_id'];

$current_class = $wpdb->get_row('SELECT * FROM vro_classes WHERE id=' . $c_id);


?>

<div class="top-bar">
  <h2><?php echo $current_class->name ?></h2>
  <p><?php echo current_time('d M Y, D'); ?></p>
</div>

<div class="banner">
  <h3>Totalt <?php echo $current_class->points ?> poäng!</h3>
  <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
  <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
</div>

<div class="row">

  <div class="box white lg">

    <div class="see-more">
      <h4>Elever</h4>
      <h4>Växla medlem</h4>
    </div>


    <?php

    // Setup to get all students for this class
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'class_id',
                'value' => $c_id,
                'compare' => '=='
            )
        )
    );

      // Get all students for that class
      $student_arr = get_users($args);
      if ($student_arr) {
        // Go throught every student
        foreach ($student_arr as $student) {

          // Check if each student is member in the elevkår
          $s_status = get_metadata('user', $student->ID, 'status');

          // Check if status not set
          if ($s_status[0] == 'n'){
          ?>
            <div class="student no-member">
              <p><?php echo get_user_meta($student->ID,'nickname',true); ?></p>
              <form class="student_actions" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="post">
                <input hidden type="text" name="c_id" value="<?php echo $c_id; ?>">
                <input class="student-email" name="" value="<?php echo get_userdata($c_id)->user_email; ?>" hidden>
                <button name="toggle_member" value="<?php echo $student->ID; ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/right.png"></button>
              </form>
            </div>
          <?php
        } elseif ($s_status[0] == 'w'){
          // Check if student is waiting to become a member
          ?>
            <div class="student waiting">
              <p><?php echo get_user_meta($student->ID,'nickname',true); ?></p>
              <form class="student_actions" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="post">
                <button name="toggle_member" value="<?php echo $student->ID; ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/right.png"></button>
                <button name="toggle_member" value="<?php echo $student->ID; ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/wrong.png"></button>
                <input hidden type="text" name="c_id" value="<?php echo $c_id; ?>">
              </form>
            </div>
          <?php
        } elseif ($s_status[0] == 'y'){
          // Check if student is a member
          ?>
            <div class="student">
              <p><?php echo get_user_meta($student->ID,'nickname',true); ?></p>
              <form class="student_actions" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="post">
                <button name="toggle_member" value="<?php echo $student->ID; ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/wrong.png"></button>
                <input hidden type="text" name="c_id" value="<?php echo $c_id; ?>">
              </form>
            </div>
          <?php
        }



      }
    }

    ?>

  </div>

</div>

<div class="row">

  <div class="box green lg">

    <h4>Lägg till / ta bort poäng</h4>
    <form class="" method="post" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_classes.inc.php'); ?>">
      <input type="number" name="add-points" value="" placeholder="+/-Poäng..." required>
      <input hidden type="text" name="c_id" value="<?php echo $c_id; ?>">

      <button class="btn lg" type="" name="give_classpoints_internal">Ge poäng</button>
    </form>

  </div>

</div>

<div class="row">

  <div class="box green lg">

    <h4>Lägg till ny elev</h4>
    <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="POST">
      <?php

      // Check if form has been submited
      if (isset($_GET['add_user'])) {

        // Get the msg from the form
        $user_check = $_GET['add_user'];

        // Then check if there has been an error
        if ($user_check == 'empty'){
          echo '<p class="error">Du måste fylla i alla värden!</p>';
        }
        elseif ($user_check == 'noclassfound'){
          echo '<p class="error">Klassen hittades inte!</p>';
        }
        elseif ($user_check == 'invalidemail'){
          echo '<p class="error">Mailaddresesn är inte godtagbar!</p>';
        }
        elseif ($user_check == 'emailexists'){
          echo '<p class="error">Mailaddressen är redan använd!</p>';
        }
        elseif ($user_check == 'invalidyear'){
          echo '<p class="error">Avångsåret stämmer inte!</p>';
        }

      }

      ?>

      <?php
       if (!isset($_GET['first_name'])){
         echo '<input type="text" name="first_name" value="" placeholder="Förnamn..." required>';
       } else {
         echo '<input type="text" name="first_name" value="'. $_GET['first_name'] .'" placeholder="Förnamn..." required>';
       }


       if (!isset($_GET['last_name'])){
         echo '<input type="text" name="last_name" value="" placeholder="Efernamn..." required>';
       } else {
         echo '<input type="text" name="last_name" value="'. $_GET['last_name'] .'" placeholder="Efternamn..." required>';
       }

       if (!isset($_GET['email'])){
         echo '<input type="email" name="email_address" value="" placeholder="Skolmail..." required>';
       } else {
         echo '<input type="email" name="email_address" value="'. $_GET['email'] .'" placeholder="Skolmail..." required>';
       }
      ?>


      <!-- <input type="number" name="end_year" value="" placeholder="Avgångsår (ex. 2022)..." list="end_years">

      <datalist id="end_years">
        <option value="<?php echo date('Y', strtotime('+3 years')); ?>" />
        <option value="<?php echo date('Y', strtotime('+2 years')); ?>" />
        <option value="<?php echo date('Y', strtotime('+1 years')); ?>" />
        <option value="<?php echo date('Y'); ?>" />
      </datalist> -->

      <input type="password" name="password" value="" placeholder="Lösenord..." required>

      <input id="class" hidden type="text" name="class_id" value="<?php echo $c_id; ?>">
     <button type="submit" name="add_new_user" class="btn lg" value="/panel/medlemmar">Skapa ny elev</button>
   </form>

  </div>

</div>
