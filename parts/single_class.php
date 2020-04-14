<?php

// Check if admin
if (!current_user_can('administrator') and !current_user_can('elevkaren') ){
  wp_redirect('/panel/medlemmar');
}

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

<div class="modal" id="student-modal">
  <div class="modal-header">
    <div class="title">
      Namn
    </div>
    <button data-close-button class="close-button" type="button" name="button">&times;</button>
  </div>
  <div class="modal-body">
    <form autocomplete="off" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_medlemmar.inc.php'); ?>" method="post">

      <label><b>Elevens förnamn</b></label>
      <input type="text" name="new-first-name" value="" placeholder="Förnamn..." id="first-name-field">

      <label><b>Elevens efternamn</b></label>
      <input type="text" name="new-last-name" value="" placeholder="Efternamn..." id="last-name-field">

      <input type="text" name="student-id" id="student-id" hidden>

      <div class="button-group">
        <button class="btn lg" type="submit" name="update-student-information" id="submit-button">Ändra</button>
        <button class="btn lg red" type="submit" name="" id="remove-student" onclick="return confirm('Är du säker på att du vill ta bort denna elev?')">-</button>
      </div>

    </form>
  </div>
</div>

<div id="overlay"></div>

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

  <div class="box white lg" id="student-root">

    <div class="see-more">
      <h4>Elever</h4>
      <h4>Växla medlem</h4>
    </div>


    <?php

    // Setup to get all students for this class

      // Get all students for that class
      $student_arr = $wpdb->get_results("SELECT * FROM vro_users WHERE class_id = $c_id");
      if ($student_arr) {
        // Go throught every student
        foreach ($student_arr as $student) {

          $student_classes = 'student';

          $student_classes .= ($student->status == 'n') ? ' no-member' : '';
          $student_classes .= ($student->status == 'w') ? ' waiting' : '';
          $phone = ($student->phonenumber == NULL) ? '' : $student->phonenumber;

          ?>
          <div class="<?php echo $student_classes; ?>" id="student_<?php echo $student->id; ?>">
            <button class="edit-btn" type="button" name="button" onclick="event.stopPropagation();"><img src="<?php echo get_bloginfo('template_directory'); ?>/img/editcircle.png"></button>
            <p><span class="first-name"><?php echo $student->first_name; ?></span> <span class="last-name"><?php echo $student->last_name; ?></span></p>
            <p><?php echo $student->email; ?></p>
            <p><?php echo $phone ?></p>
          <?php

          if ($student->status == 'n') {
            ?>
            <form class="student_actions" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="post">
              <input hidden type="text" name="c_id" value="<?php echo $c_id; ?>">
              <input class="student-email" name="" value="<?php echo $student->email; ?>" hidden>
              <button name="toggle_member" value="<?php echo $student->id; ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/right.png"></button>
            </form>
            <?php
          }
          elseif ($student->status == 'w') {
            ?>
            <form class="student_actions" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="post">
              <button name="toggle_member" value="<?php echo $student->id; ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/right.png"></button>
              <button name="toggle_member" value="<?php echo $student->id; ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/wrong.png"></button>
              <input hidden type="text" name="c_id" value="<?php echo $c_id; ?>">
            </form>
            <?php
          }
          elseif ($student->status == 'y') {
            ?>
            <form class="student_actions" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>" method="post">
              <button name="toggle_member" value="<?php echo $student->id; ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/wrong.png"></button>
              <input hidden type="text" name="c_id" value="<?php echo $c_id; ?>">
            </form>
            <?php

          }

          echo '</div>';

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

      <h4>Skapa nytt elevskal</h4>
      <form autocomplete="off" method="post" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_members.inc.php'); ?>">
        <input type="text" name="first-name" value="" placeholder="*Förnamn..." required>
        <input type="text" name="last-name" value="" placeholder="*Efternamn..." required>
        <input type="email" name="email" value="" placeholder="*Skolmail..." required>
        <input id="class-name-field2" hidden type="text" name="class-name" value="<?php echo $wpdb->get_var("SELECT name FROM vro_classes WHERE id = $c_id"); ?>">
        <input id="program-name-field2" type="text" name="program" value="" placeholder="*Utbildningsprogram..." required>
        <input type="text" name="phonenumber" value="" placeholder="Telefonnummer...">
        <input type="text" name="birthyear" value="" placeholder="Födelseår...">
        <input type="text" name="registered-city" value="Stockholm" placeholder="Folkbokförd stad...">

        <select class="form-select" name="gender">
          <option value="">- Kön -</option>
          <option value="Kvinna">Kvinna</option>
          <option value="Man">Man</option>
          <option value="Annat">Annat</option>
        </select>

        <button class="btn lg" type="submit" name="add_studentshell">Skapa elevskal</button>
      </form>

  </div>

</div>

<div class="row">
  <form class="expand" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_classes.inc.php'); ?>" method="post">
    <input type="text" name="c_id" value=<?php echo $c_id; ?> hidden>
    <button class="btn lg red" type="submit" name="remove_class" onclick="event.stopPropagation(); return confirm('Är du säker på att du vill ta bort denna klass?');">Ta bort denna klass</button>
  </form>
</div>

<script src="<?php echo get_bloginfo('template_directory') ?>/js/modal.js" charset="utf-8"></script>
<script type="text/javascript">
  fillProgramName('class-name-field2', 'program-name-field2');

  var studentDivs = document.querySelectorAll('#student-root .student');

  studentDivs.forEach( (studentDiv) => {

    let editButton = studentDiv.querySelector('.edit-btn');

    editButton.addEventListener('click', function() {

      let modal = document.querySelector('#student-modal');

      let firstName = studentDiv.querySelector('span.first-name').innerText;
      let lastName = studentDiv.querySelector('span.last-name').innerText;

      // Change the modal header
      modal.querySelector('.modal-header .title').textContent = firstName + ' ' + lastName;

      modal.querySelector('.modal-body #first-name-field').value = firstName;
      modal.querySelector('.modal-body #last-name-field').value = lastName;

      // OPen the modal
      openModal(modal);
    });

  });
</script>
