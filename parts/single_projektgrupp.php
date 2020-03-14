<?php

// Show this page to all logged in users and is admin
if (! is_user_logged_in() || !(current_user_can('administrator') || current_user_can('elevkaren') ) ){
  wp_redirect( '/panel' );
} else {

// Check if this page has been called
if (!isset($_GET['p_id'])) {
  wp_redirect('/panel/projektgrupper');
  exit();
}

// Check if an id has been supplied
if (!is_numeric($_GET['p_id'])){
  header('Location: /panel/projektgrupper?status=idnan');
  exit();
}

require_once(get_template_directory() . "/scripts/helpful_functions.php");

// Get access to the wordpress database
global $wpdb;

$p_id = (int)$_GET['p_id'];

$current_projektgrupp = $wpdb->get_row('SELECT * FROM vro_projektgrupper WHERE id=' . $p_id);

$current_student_id = wp_get_current_user()->ID;

// get all kommitee members
$all_members = $wpdb->get_results('SELECT * FROM vro_projektgrupper_members WHERE projektgrupp_id=' . $p_id);

// Check if the $current student is in this projektgrupp
if (check_if_entry_exists('vro_projektgrupper_members', 'user_id', $current_student_id)) {
  $in_projektgrupp = true;
} else {
  $in_projektgrupp = false;
}

?>

<!-- **************************
  BANNER
**************************  -->
<script src="<?php echo get_bloginfo('template_directory') ?>/js/autocomplete.js" charset="utf-8"></script>

<div class="top-bar">
  <h2><?php echo $current_projektgrupp->name; ?></h2>
  <p><?php echo current_time('d M Y, D'); ?></p>
</div>

<!-- **************************
  BASIC INFORMATION
**************************  -->
<div class="row">

  <div class="box white lg">

        <div class="see-more">
            <h4>Beskrivning</h4>
            <div>
              <button onclick="showAnswerForm('change_description')">Ändra beskrivning &#8594;</button>
            </div>
        </div>

        <p><?php echo $current_projektgrupp->description; ?></p>

        <div class="answer" id="change_description">

          <hr>

          <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="POST">
            <div class="text-limited-root">
              <textarea name="kommitee_description" placeholder="Ny beskrivning..." required onkeyup="checkForm(this, event_description_char_count, 300)"></textarea>
              <p id="event_description_char_count">300</p>
            </div>
            <input name="p_id" value="<?php echo $p_id; ?>" hidden>

            <button name="change_kommitte_description" class="btn" type="submit">Ändra beskrivning</button>
          </form>

        </div>

  </div>

</div>

  <div class="row">

    <div class="box green lg">
      <?php
      if ($in_projektgrupp){
        echo '<h4>Gå ut ur denna projektgrupp</h4>';
      }
      else {
        echo '<h4>Gå med i denna projektgrupp</h4>';
      }
      ?>

      <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_projektgrupper.inc.php'); ?>" method="post">
        <input type="text" name="p_id" value="<?php echo $p_id; ?>" hidden>
        <input type="text" name="u_id" value="<?php echo $current_student_id; ?>" hidden>

        <?php

        if ($in_projektgrupp) {
          echo '<button class="btn lg red" type="submit" name="leave_projektgrupp" onclick="return confirm(\'Är du säker på att du vill gå ut ur denna projektgrupp?\');">Klicka för att gå ut ur denna projektgrupp</button>';
        }
        else {
          echo '<button class="btn lg" type="submit" name="join_projektgrupp">Klicka för att gå med i denna projektgrupp!</button>';
        }

        ?>

      </form>
    </div>

  </div>

<!-- **************************
  ALL MEMBERS
**************************  -->
<div class="row">

  <div class="box white lg">
    <h4>Elever i projektgruppen</h4>
    <input type="search" placeholder="Elev...">

    <div class="kommitee_members">

      <?php

      foreach($all_members as $m)
      {

        $member = $wpdb->get_row('SELECT * FROM wp_users WHERE ID = ' . $m->user_id);
      ?>

        <div class="kommitee_member">
          <div>
            <p><b><?php echo get_user_meta($member->ID, 'nickname', true); ?></b></p>
            <p><?php echo ($wpdb->get_row('SELECT * FROM vro_classes WHERE id=' . get_user_meta($member->ID, 'class_id', true)))->name; ?></p>

            <?php if (current_user_can('administrator') || current_user_can('elevkaren') || $is_chairman ){ ?>
              <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_projektgrupper.inc.php'); ?>" method="post">
                <input type="text" name="p_id" value="<?php echo $p_id; ?>" hidden>
                <input type="text" name="u_id" value="<?php echo $member->ID; ?>" hidden>

                <button type="submit" name="leave_projektgrupp" class="add-btn extra-btn deny" onclick="return confirm('Är du säker på att du vill ta bort denna elev ur projektgruppen?');">-</button>
              </form>
            <?php } ?>
          </div>
        </div>

      <?php } ?>

    </div>
  </div>

</div>

<!-- **************************
  ADD NEW MEMBER
**************************  -->

<div class="row">
  <div class="box green lg allow-overflow" id="addNewMember">

    <h4>Lägg till elev i projektgruppen</h4>

    <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_projektgrupper.inc.php'); ?>" method="post">

      <div class="autocomplete">
        <input type="text" name="student_name" value="" placeholder="Elevens namn..." id="student-name-field">
      </div>
      <input type="text" name="p_id" value="<?php echo $p_id; ?>" hidden>

      <button type="submit" class="btn lg" name="add_student">Lägg till</button>

    </form>

  </div>
</div>

<div class="row">
  <form class="expand" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_projektgrupper.inc.php'); ?>" method="post">
    <input type="text" name="p_id" value=<?php echo $p_id; ?> hidden>
    <button class="btn lg red" type="submit" name="remove_projektgrupp" onclick="event.stopPropagation(); return confirm('Är du säker på att du vill ta bort denna projektgrupp?');">Ta bort denna projektgrupp</button>
  </form>
</div>

<?php

// Get the number of all members
$all_students = get_users(array(
  'meta_key' => 'class_id'
));

// Get first and last name from every student
$first_last_array_full = array();
foreach($all_students as $s){
  array_push($first_last_array_full, get_user_meta( $s->ID, 'nickname', true));
}

echo '<script type="text/javascript">';
echo 'var jsonstudentsall = ' . json_encode($first_last_array_full);
echo '</script>'

?>

<script type="text/javascript">

  autocomplete(document.getElementById("student-name-field"), jsonstudentsall, 'Inga elever hittades.');
</script>
<script src="<?php echo get_bloginfo('template_directory') ?>/js/datepicker.js" charset="utf-8"></script>

<?php } // End check admin ?>
