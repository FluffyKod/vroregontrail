<!--
* Admin Navbar
--------------------------------------->
<section id="navigation-bar">

  <div class="nav-header">
    <img src="<?php echo get_bloginfo('template_directory') ?>/img/vitfluga.png" alt="">
    <h2>Admin</h2>
  </div>

  <nav>

    <a href="/admin/dashboard/" class="nav-item active">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/hemsida.png" alt="" class="nav-icon">
      <p>Dashboard</p>
    </a>

    <a href="/admin/visselpipan/" class="nav-item">

      <div class="notification">
        <img src="<?php echo get_bloginfo('template_directory') ?>/img/chat.png" alt="" class="nav-icon ">
        <span>2</span>
      </div>

      <p>Visselpipan</p>
    </a>

    <a href="/admin/kommiteer/" class="nav-item">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/folder.png" alt="" class="nav-icon">
      <p>Kommitéer</p>
    </a>

    <a href="/admin/kalender/" class="nav-item">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/calendar.png" alt="" class="nav-icon">
      <p>Kalender</p>
    </a>

    <a href="/admin/klasspokalen/" class="nav-item">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/trophy.png" alt="" class="nav-icon">
      <p>Klasspokalen</p>
    </a>

    <a href="/admin/karen/" class="nav-item">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/bowtie.png" alt="" class="nav-icon">
      <p>Kåren</p>
    </a>

    <a href="/admin/medlemmar/" class="nav-item">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/members.png" alt="" class="nav-icon">
      <p>Medlemmar</p>
    </a>

    <a href="/admin/hemsidan/" class="nav-item">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/edit.png" alt="" class="nav-icon">
      <p>Hemsidan</p>
    </a>

    <a href="/admin/installningar/" class="nav-item">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/cog.png" alt="" class="nav-icon">
      <p>Inställningar</p>
    </a>

  </nav>

  <div class="drive">

    <img src="<?php echo get_bloginfo('template_directory') ?>/img/protocolfolder.png" alt="">
    <p>Öppna <strong>DRIVE</strong> för att se de senaste protokollen!</p>

    <a href="#" class="btn sm">Drive</a>

  </div>

</section>
