<?php

// Check if this page has been called
if (!isset($_GET['c_id'])) {
  wp_redirect('/admin/medlemmar');
  exit();
}

// Check if an id has been supplied
if (!is_numeric($_GET['c_id'])){
  header('Location: /admin/medlemmar?status=idnan');
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
      <input style="display:none">
      <input type="text" name="first_name" value="" placeholder="Förnamn..." required>
      <input type="text" name="last_name" value="" placeholder="Efernamn..." required>
      <input type="email" name="email_address" value="" placeholder="Skolmail..." required>
      <input type="password" name="password" value="" placeholder="Lösenord..." required>

      <input id="class" hidden type="text" name="class_id" value="<?php echo $c_id; ?>">
     <button type="submit" name="add_new_user" class="btn lg">Skapa ny elev</button>
   </form>

  </div>

</div>
