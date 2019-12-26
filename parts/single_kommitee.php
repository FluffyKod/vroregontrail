<?php

// Check if this page has been called
if (!isset($_GET['k_id'])) {
  wp_redirect('/admin/kommiteer');
  exit();
}

// Check if an id has been supplied
if (!is_numeric($_GET['k_id'])){
  header('Location: /admin/kommiteer?status=idnan');
  exit();
}

// Get access to the wordpress database
global $wpdb;

$k_id = (int)$_GET['k_id'];

$current_kommitee = $wpdb->get_row('SELECT * FROM vro_kommiteer WHERE id=' . $k_id);

?>

<!-- **************************
  BANNER
**************************  -->
<?php

$waiting_members = $wpdb->get_results('SELECT * FROM vro_kommiteer_members where kommitee_id = ' . $k_id . ' AND status = "w"' );

?>

<div class="top-bar">
  <h2><?php echo $current_kommitee->name; ?></h2>
  <p><?php echo current_time('d M Y, D'); ?></p>
</div>

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
  <div class="row">'
    <div class="box white lg">
      <div class="see-more">
        <h4><?php echo $wm->user_nicename ?></h4>
          <div>
          <button onclick="showAnswerForm(<?php echo $wm->ID ?>)">Svara &#8594;</button>
        </div>
      </div>

      <div class="answer" id="<?php echo $wm->ID ?>">

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
}

?>

<!-- **************************
  BASIC INFORMATION
**************************  -->
<div class="kommitee-row">

  <?php

  // Get chairman
  $chairman_id = $wpdb->get_var('SELECT chairman FROM vro_kommiteer WHERE id = ' . $k_id);
  $chairman = $wpdb->get_row('SELECT * FROM wp_users WHERE ID = ' . $chairman_id);

  ?>

  <div class="box white" id="chairman">
      <img src="https://images.unsplash.com/photo-1491349174775-aaafddd81942?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80" alt="">
      <h4><?php echo $chairman->user_nicename; ?></h4>
      <p>Kommitéeordförande</p>
  </div>

  <div class="box white alert" id="add_member">
    <button class="add-btn lg">+</button>
    <h5>Lägg till medlem</h5>
  </div>

  <div class="box green" id="send_message">

    <h4>Skicka Meddelande</h4>


    <textarea name="name" placeholder="Meddelande..."></textarea>

      <input type="radio" name="mail-to" value="" checked> <label>Hela kommitéen</label><br>
      <input type="radio" name="mail-to" value=""> <label>Endast ordförande</label><br>

      <button class="btn lg">Skicka</button>

  </div>

</div>

<!-- **************************
  ALL MEMBERS
**************************  -->
<div class="row">

  <div class="box white lg">
    <h4>Medlemmar</h4>
    <input type="search" placeholder="Medlem...">

    <div class="kommitee_members">

      <?php

      // get all kommitee members
      $all_members = $wpdb->get_results('SELECT * FROM vro_kommiteer_members WHERE kommitee_id=' . $k_id . ' AND status="y"');

      foreach($all_members as $m)
      {

        $member = $wpdb->get_row('SELECT * FROM wp_users WHERE ID = ' . $m->user_id);
      ?>

        <div class="kommitee_member">
          <div class="kommitee_member_img">
            <img src="https://images.unsplash.com/photo-1491349174775-aaafddd81942?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80" alt="">
            <button class="add-btn extra-btn deny">-</button>
          </div>

          <div>
            <p><b><?php echo $member->user_nicename; ?></b></p>
            <p>Na21b</p>
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
  <div class="box green lg">

    <h4>Lägg till medlem</h4>

    <input type="text" name="" value="" placeholder="Namn...">

    <a href="#" class="btn lg">Lägg till</a>

  </div>
</div>
