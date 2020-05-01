<!--
* Member Navbar
--------------------------------------->

<?php

global $wpdb;

// Check if chairman
$kommitees = $wpdb->get_results('SELECT * FROM vro_kommiteer WHERE chairman = ' . get_current_user_id() );

if (count($kommitees) == 0){
  $kommitee_applications = 0;
} else {

  $kommitee_applications = 0;

  foreach ($kommitees as $k) {
    // Get the number of current kommitee aplications
    $kommitee_applications += count($wpdb->get_results('SELECT * FROM vro_kommiteer_members WHERE kommitee_id = '. $k->id .' AND status = "w"'));
  }

}

?>

<section id="navigation-bar" class="closed">

  <div class="nav-header">
    <a href="/"><img src="<?php echo get_bloginfo('template_directory') ?>/img/vitfluga.png" alt=""></a>
    <a href="/panel/dashboard"><h2>Panel</h2></a>

    <button class="icon" onclick="toggleNavbar('navigation-bar')">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/menu.png" alt="">
    </button>

  </div>

  <nav id="navbar-nav">

    <a href="/panel/dashboard/" class="nav-item active" id="link-dashboard">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/hemsida.png" alt="" class="nav-icon">
      <p>Dashboard</p>
    </a>

    <a href="/panel/karkortet" class="nav-item" id="link-karkortet">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/karkortet-icon.png" alt="" class="nav-icon">
      <p>Kårkortet</p>
    </a>

    <a href="/panel/visselpipan/" class="nav-item" id="link-visselpipan">

      <img src="<?php echo get_bloginfo('template_directory') ?>/img/chat.png" alt="" class="nav-icon ">
      <p>Visselpipan</p>
    </a>

    <a href="/panel/kommiteer/" class="nav-item" id="link-kommiteer">

      <!-- Check if there are any new kommitée applications, if so -> add a notification circle -->
      <?php if ($kommitee_applications > 0) { ?>
      <div class="notification">
        <img src="<?php echo get_bloginfo('template_directory') ?>/img/folder.png" alt="" class="nav-icon">
        <span><?php echo $kommitee_applications; ?></span>
      </div>
      <?php } else { ?>
        <img src="<?php echo get_bloginfo('template_directory') ?>/img/folder.png" alt="" class="nav-icon">
      <?php } ?>

      <p>Kommittéer</p>
    </a>

    <a href="/panel/projektgrupper/" class="nav-item" id="link-projektgrupper">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/edit.png" alt="" class="nav-icon">
      <p>Projektgrupper</p>
    </a>

    <a href="/panel/kalender/" class="nav-item" id="link-kalender">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/calendar.png" alt="" class="nav-icon">
      <p>Kalender</p>
    </a>

    <a href="/panel/klasspokalen/" class="nav-item" id="link-klasspokalen">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/trophy.png" alt="" class="nav-icon">
      <p>Klasspokalen</p>
    </a>

    <a href="/panel/karen/" class="nav-item" id="link-karen">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/bowtie.png" alt="" class="nav-icon">
      <p>Kåren</p>
    </a>

    <!-- TEXT ADVENTURE GAME -->
    <a href="game" class="nav-item" id="link-game">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/cursecircle.png" alt="" class="nav-icon">
      <p>Textäventyr</p>
    </a>

    <a href="/panel/arkiv" class="nav-item" id="link-arkiv">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/folder.png" alt="" class="nav-icon">
      <p>Arkiv</p>
    </a>

  </nav>

</section>

<script>
  function toggleNavbar(id) {
    var navbar = document.getElementById(id);

    navbar.classList = (navbar.classList == 'closed') ? 'open' : 'closed';
  }
</script>
