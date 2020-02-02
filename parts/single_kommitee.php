<?php

// Show this page to all logged in users
if (! is_user_logged_in() ){
  wp_redirect( '/' );
} else {

// Check if this page has been called
if (!isset($_GET['k_id'])) {
  wp_redirect('/panel/kommiteer');
  exit();
}

// Check if an id has been supplied
if (!is_numeric($_GET['k_id'])){
  header('Location: /panel/kommiteer?status=idnan');
  exit();
}

// Get access to the wordpress database
global $wpdb;

$k_id = (int)$_GET['k_id'];

$current_kommitee = $wpdb->get_row('SELECT * FROM vro_kommiteer WHERE id=' . $k_id);

$current_student_id = wp_get_current_user()->ID;

// Get chairman
$chairman_id = $wpdb->get_var('SELECT chairman FROM vro_kommiteer WHERE id = ' . $k_id);
$chairman = $wpdb->get_row('SELECT * FROM wp_users WHERE ID = ' . $chairman_id);

// Check if the logged in user is the chairman
$is_chairman = ($current_student_id == $chairman_id);

// Check if user already has applied / is in
$is_related_to_kommitte = count($wpdb->get_results('SELECT * FROM vro_kommiteer_members WHERE user_id='. $current_student_id .' AND kommitee_id='. $k_id .''));
$is_waiting = count($wpdb->get_results('SELECT * FROM vro_kommiteer_members WHERE user_id='. $current_student_id .' AND kommitee_id='. $k_id .' AND status="w"'));

// get all kommitee members
$all_members = $wpdb->get_results('SELECT * FROM vro_kommiteer_members WHERE kommitee_id=' . $k_id . ' AND status="y"');

?>

<!-- **************************
  BANNER
**************************  -->
<?php

$waiting_members = $wpdb->get_results('SELECT * FROM vro_kommiteer_members where kommitee_id = ' . $k_id . ' AND status = "w"' );

?>

<script src="<?php echo get_bloginfo('template_directory') ?>/js/autocomplete.js" charset="utf-8"></script>

<div class="top-bar">
  <h2><?php echo $current_kommitee->name; ?></h2>
  <p><?php echo current_time('d M Y, D'); ?></p>
</div>

<?php

if (current_user_can('administrator') || current_user_can('elevkaren') || $is_chairman ){

?>

<div class="banner">

  <!-- Change the message depending on singular or plural application number -->
  <?php if (count($waiting_members) == 1){ ?>
    <h3><?php echo count($waiting_members); ?> ny medlemsförfrågan!</h3>
  <?php } else { ?>
    <h3><?php echo count($waiting_members); ?> nya medlemsförfrågningar!</h3>
  <?php } ?>

  <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
  <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
</div>

<?php

// Add a new row and box for every suggestion

foreach ($waiting_members as $wait_member)
{
  $wm = $wpdb->get_row('SELECT * FROM wp_users WHERE ID = ' . $wait_member->user_id);

  ?>
  <div class="row">

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

        <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="POST">
          <textarea name="kommitee_member_answer" placeholder="Svar..."></textarea>
          <input name="kid" value="<?php echo $k_id; ?>" hidden>

          <button name="accept_kommitee_member" value="<?php echo $wm->ID ?>" class="btn" type="submit">Godkänn</button>
          <button name="deny_kommitee_member" value="<?php echo $wm->ID ?>" class="btn red" type="submit">Avböj</button>
        </form>

      </div>

    </div>

  </div>

<?php
} // ENd foreach


} // End is admin, elevkår or chairman
?>

<!-- **************************
  BASIC INFORMATION
**************************  -->
<div class="row">

  <div class="box white lg">
    <?php if (current_user_can('administrator') || current_user_can('elevkaren') || $is_chairman ){?>

        <div class="see-more">
            <h4>Beskrivning</h4>
            <div>
              <button onclick="showAnswerForm('change_description')">Ändra beskrivning &#8594;</button>
            </div>
        </div>

        <p><?php echo $current_kommitee->description; ?></p>

        <div class="answer" id="change_description">

          <hr>

          <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="POST">
            <div class="text-limited-root">
              <textarea name="kommitee_description" placeholder="Ny beskrivning..." required onkeyup="checkForm(this, event_description_char_count, 300)"></textarea>
              <p id="event_description_char_count">300</p>
            </div>
            <input name="k_id" value="<?php echo $k_id; ?>" hidden>

            <button name="change_kommitte_description" class="btn" type="submit">Ändra beskrivning</button>
          </form>

        </div>

    <?php } else { ?>
      <h4>Beskrivning</h4>
      <p><?php echo $current_kommitee->description; ?></p>
    <?php } ?>


  </div>

</div>

<?php
// Only show the event types for admins
if (current_user_can('administrator') || current_user_can('elevkaren') || $is_chairman ){
?>
<div class="kommitee-row">


  <div class="box white" id="chairman">
      <!-- <?php echo get_avatar( $chairman_id ); ?> -->
      <h4><?php echo get_user_meta($chairman_id, 'nickname', true); ?></h4>
      <p>Ordförande</p>

      <button onclick="showAnswerForm('change_chairman')">Ändra ordförande &#8594;</button>

      <div class="answer" id="change_chairman">

        <hr>

        <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="POST">
          <div class="autocomplete">
              <input type="text" name="new_chairman_name" value="" placeholder="Ny ordförande..." id="chairman-field">
          </div>

          <input name="k_id" value="<?php echo $k_id; ?>" hidden>

          <button name="change_chairman" class="btn lg" type="submit">Ändra ordförande</button>
        </form>

      </div>

      <?php

      global $wpdb;

      // Get first and last name from every student
      $first_last_array = array();
      foreach($all_members as $s){
        array_push($first_last_array, get_user_meta( $s->user_id, 'nickname', true));
      }

      echo '<script type="text/javascript">';
      echo 'var jsonstudents = ' . json_encode($first_last_array);
      echo '</script>'

      ?>

      <script>
      // var jsonstudents = getArrayFromColumn(jsonstudents, 'display_name');

      autocomplete(document.getElementById("chairman-field"), jsonstudents, 'Inga medlemmar hittades.');

      </script>
  </div>

  <?php if (current_user_can('administrator') || current_user_can('elevkaren') ){ ?>
  <div class="box white alert" id="add_member">
    <button class="add-btn lg">+</button>
    <h5>Lägg till medlem</h5>
  </div>
<?php } ?>

  <div class="box green" id="send_message">

    <h4>Skicka Notis</h4>

    <!-- SEND MAIL -->
    <!-- <form autocomplete="off" class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/send_mail.inc.php'); ?>" method="post">

      <input type="text" name="subject" value="" placeholder="Ämne...">
      <textarea name="message" placeholder="Meddelande..."></textarea>
      <input type="text" name="k_id" value="<?php echo $k_id; ?>" hidden>

      <?php if (current_user_can('administrator') || current_user_can('elevkaren' ) ) { ?>
        <input type="radio" name="mail-to" value="all_members" checked> <label>Hela kommitéen</label><br>
        <input type="radio" name="mail-to" value="only_chairman"> <label>Endast ordförande</label><br>
      <?php } ?>

      <button name="send_message_kommitte" class="btn lg">Skicka</button>

    </form> -->

    <!-- SEND NOTIFICATION -->
    <form autocomplete="off" class="notis-form" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_notification.inc.php'); ?>" method="post">

      <input type="text" name="title" value="" placeholder="Titel..">
      <textarea name="content" placeholder="Meddelande..."></textarea>

      <div class="datetime-picker">

        <p><b>Datum då notisen går ut:</b></p>

        <div class="date-picker" id="start-datepicker">
          <div class="selected-date"></div>
          <input type="hidden" name="expire-date" value="" id="start_hidden_input"/>

          <div class="dates">
            <div class="month">
              <div class="arrows prev-mth">&lt;</div>
              <div class="mth"></div>
              <div class="arrows next-mth">&gt;</div>
            </div>

            <div class="days">

            </div>

          </div>
        </div>

      </div>

      <input type="text" name="k_id" value="<?php echo $k_id; ?>" hidden>

      <button name="send_notification_kommitte" value="" class="btn lg">Skicka</button>

    </form>

  </div>

</div>

<div class="row">

  <div class="box green lg">

    <?php
    if ($is_waiting) {
      echo '<h4>Dra tillbaka din kommittéförfrågan</h4>';
    }
    elseif ($is_related_to_kommitte){
      echo '<h4>Gå ut ur denna kommitté</h4>';
    } else {
      echo '<h4>Ansök till denna kommitté</h4>';
    }
    ?>

    <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="post">
      <?php // Show error messages

      if (isset($_GET['leave_kommitte'])) {

        $kom_check = $_GET['leave_kommitte'];

        if ($kom_check == 'ischairman') {
          echo '<p class="error">Du måste göra någon annan till ordförande innan du kan lämna kommittéen!</p>';
        }

      }

     ?>

      <input type="text" name="kommitte_id" value="<?php echo $k_id; ?>" hidden>
      <input type="text" name="student_id" value="<?php echo $current_student_id; ?>" hidden>

      <?php
      if ($is_waiting) {
        echo '<button class="btn lg red" type="submit" name="leave_kommitte" onclick="return confirm(\'Är du säker på att du vill dra tillbaka din förfrågan?\');">Klicka för att dra tillbaka din ansökan</button>';
      }
      elseif ($is_related_to_kommitte){
        echo '<button class="btn lg red" type="submit" name="leave_kommitte" onclick="return confirm(\'Är du säker på att du vill gå ut ur kommittén?\');">Klicka för att gå ut ur kommittén</button>';
      } else {
        echo '<button class="btn lg" type="submit" name="apply_for_kommitte">Klicka för att skicka en ansökan!</button>';
      }

      ?>

    </form>
  </div>

</div>

<?php } else { ?>

  <!-- TODO Kommitéeförfrågan -->
  <div class="row">

    <div class="box white sm" id="chairman">
        <!-- <?php echo get_avatar( $user->ID ); ?> -->
        <h4><?php echo get_user_meta($chairman_id, 'nickname', true); ?></h4>
        <p>Ordförande</p>
    </div>

    <div class="box green md">
      <?php
      if ($is_waiting){
        echo '<h4>Dra tillbaka din kommittéansökan</h4>';
      }
      elseif ($is_related_to_kommitte){
        echo '<h4>Gå ut ur denna kommitté</h4>';
      } else {
        echo '<h4>Ansök till denna kommitté</h4>';
      }
      ?>

      <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="post">
        <input type="text" name="kommitte_id" value="<?php echo $k_id; ?>" hidden>
        <input type="text" name="student_id" value="<?php echo $current_student_id; ?>" hidden>

        <?php

        if ($is_waiting) {
          echo '<button class="btn lg red" type="submit" name="leave_kommitte" onclick="return confirm(\'Är du säker på att du vill dra tillbaka din förfrågan?\');">Klicka för att dra tillbaka din ansökan</button>';
        }
        elseif ($is_related_to_kommitte){
          echo '<button class="btn lg red" type="submit" name="leave_kommitte" onclick="return confirm(\'Är du säker på att du vill gå ut ur kommittén?\');">Klicka för att gå ut ur kommittén</button>';
        } else {
          echo '<button class="btn lg" type="submit" name="apply_for_kommitte">Klicka för att skicka en ansökan!</button>';
        }

        ?>

      </form>
    </div>

  </div>

<?php } // End check admin ?>

<!-- **************************
  ALL MEMBERS
**************************  -->
<div class="row">

  <div class="box white lg">
    <h4>Medlemmar</h4>
    <input type="search" placeholder="Medlem...">

    <div class="kommitee_members">

      <?php

      foreach($all_members as $m)
      {

        $member = $wpdb->get_row('SELECT * FROM wp_users WHERE ID = ' . $m->user_id);
      ?>

        <div class="kommitee_member">
          <!-- <div class="kommitee_member_img">
            <?php echo get_avatar( $member->ID ); ?>

            <?php if (current_user_can('administrator') || current_user_can('elevkaren') || $is_chairman ){ ?>
              <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="post">
                <input type="text" name="kommitte_id" value="<?php echo $k_id; ?>" hidden>
                <input type="text" name="student_id" value="<?php echo $member->ID; ?>" hidden>

                <button type="submit" name="leave_kommitte" class="add-btn extra-btn deny">-</button>
              </form>
            <?php } ?>

          </div> -->

          <div>
            <p><b><?php echo get_user_meta($member->ID, 'nickname', true); ?></b></p>
            <p><?php echo ($wpdb->get_row('SELECT * FROM vro_classes WHERE id=' . get_user_meta($member->ID, 'class_id', true)))->name; ?></p>

            <?php if (current_user_can('administrator') || current_user_can('elevkaren') || $is_chairman ){ ?>
              <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="post">
                <input type="text" name="kommitte_id" value="<?php echo $k_id; ?>" hidden>
                <input type="text" name="student_id" value="<?php echo $member->ID; ?>" hidden>

                <button type="submit" name="leave_kommitte" class="add-btn extra-btn deny" onclick="return confirm('Är du säker på att du vill ta bort denna medlem?');">-</button>
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
<?php
// Only show the event types for admins
if (current_user_can('administrator') || current_user_can('elevkaren') ){
?>

<div class="row">
  <div class="box green lg allow-overflow">

    <h4>Lägg till elev i kommittén</h4>

    <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="post">

      <div class="autocomplete">
        <input type="text" name="student_name" value="" placeholder="Elevens namn..." id="student-name-field">
      </div>
      <input type="text" name="kommitte_id" value="<?php echo $k_id; ?>" hidden>

      <button type="submit" class="btn lg" name="add_member">Lägg till</button>

    </form>

  </div>
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

<?php } // End check admin ?>
