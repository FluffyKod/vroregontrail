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

    <h4>Elever</h4>

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
              <p><?php echo $student->user_nicename; ?></p>
            </div>
          <?php
        } elseif ($s_status[0] == 'w'){
          // Check if student is waiting to become a member
          ?>
            <div class="student waiting">
              <p><?php echo $student->user_nicename; ?></p>
            </div>
          <?php
        } elseif ($s_status[0] == 'y'){
          // Check if student is a member
          ?>
            <div class="student">
              <p><?php echo $student->user_nicename; ?></p>
              <form class="student_actions" action="index.html" method="post">

              </form>
            </div>
          <?php
        }



      }
    }

    ?>

  </div>

</div>
