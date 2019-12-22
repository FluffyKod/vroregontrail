<?php

/**
 * Template Name: Admin
 */

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta lang="sv">

    <title>VRO Elevkår</title>

    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory') ?>/css/admin.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700&display=swap" rel="stylesheet">
  </head>
  <body>

    <div class="container">

      <!--
      * Admin Navbar
      --------------------------------------->
      <section id="navigation-bar">

        <div class="nav-header">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/vitfluga.png" alt="">
          <h2>Admin</h2>
        </div>

        <nav>

          <a href="#" class="nav-item active">
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/hemsida.png" alt="" class="nav-icon">
            <p>Dashboard</p>
          </a>

          <a href="visselpipan.html" class="nav-item">

            <div class="notification">
              <img src="<?php echo get_bloginfo('template_directory') ?>/img/chat.png" alt="" class="nav-icon ">
              <span>2</span>
            </div>

            <p>Visselpipan</p>
          </a>

          <a href="#" class="nav-item">
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/folder.png" alt="" class="nav-icon">
            <p>Kommitéer</p>
          </a>

          <a href="#" class="nav-item">
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/calendar.png" alt="" class="nav-icon">
            <p>Kalender</p>
          </a>

          <a href="#" class="nav-item">
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/trophy.png" alt="" class="nav-icon">
            <p>Klasspokalen</p>
          </a>

          <a href="#" class="nav-item">
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/bowtie.png" alt="" class="nav-icon">
            <p>Kåren</p>
          </a>

          <a href="#" class="nav-item">
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/members.png" alt="" class="nav-icon">
            <p>Medlemmar</p>
          </a>

          <a href="#" class="nav-item">
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/edit.png" alt="" class="nav-icon">
            <p>Hemsidan</p>
          </a>

          <a href="#" class="nav-item">
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

      <!--
      * Dashboard
      --------------------------------------->
      <section id="dashboard">

        <div class="top-bar">
          <h2>Dashboard</h2>
          <p>17 Jan 2019, Fredag</p>
        </div>

        <div class="banner">
          <h3>Välkommen tillbaka Anna!</h3>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

        <div class="row">

          <div class="box green sm update">
            <h4>Visselpipan</h4>
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/whistle.png" alt="">
            <p class="whistle amount"><b>4</b></p>
          </div>

          <div class="box green sm update">
            <h4>Kommitéer</h4>
            <img src="<?php echo get_bloginfo('template_directory') ?>/img/folderalert.png" alt="">
            <p class="commit amount"><b>2</b></p>
          </div>

          <div class="box white sm alert">
            <button class="add-btn lg">+</button>
            <h4>Skapa nytt event</h4>
          </div>

        </div>


        <div class="row">

          <div class="box white sm classpoints">

            <div class="">

              <h4>Ge klasspoäng</h4>

              <input type="text" name="" value="" placeholder="Klass...">
              <input type="number" name="" value="" placeholder="Poäng...">

              <a href="#" class="btn lg">Ge poäng</a>

            </div>

            <div class="first-place">
              <p><b>1</b></p>
              <p><b>Na21c</b></p>

              <img class="trophy" src="<?php echo get_bloginfo('template_directory') ?>/img/bigtrophy.png" alt="">
              <img class="circle"src="<?php echo get_bloginfo('template_directory') ?>/img/circle.png" alt="">
            </div>

          </div>

          <div class="box green md">

            <h4>Skicka Meddelande</h4>


            <textarea name="name" placeholder="Meddelande..."></textarea>

              <input type="radio" name="mail-to" value="" checked> <label>Hela skolan</label><br>
              <input type="radio" name="mail-to" value=""> <label>Årskurs 3</label><br>
              <input type="radio" name="mail-to" value=""> <label>Årskurs 2</label><br>
              <input type="radio" name="mail-to" value=""> <label>Årskurs 1</label><br>

              <a href="#" class="btn lg">Skicka</a>

          </div>

        </div>

        <div class="row">

          <div class="box white lg">

            <h4>Sök medlem</h4>

            <input type="text" name="" value="" placeholder="Namn...">
            <input type="text" name="" value="" placeholder="Klass...">

            <a href="#" class="btn lg">Sök</a>

          </div>

        </div>

      </section>

      <!--
      * Status View
      --------------------------------------->
      <section id="status">

        <a href="#" class="logout">
          <p><b>Logga ut</b></p>
          <img src="img/logout.png" alt="">
        </a>

        <div class="profile">
          <div class="profile-img">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80" alt="">
            <button class="add-btn">+</button>
          </div>

          <p><b>Anna Morrison</b></p>
          <p>Na21d</p>
        </div>

        <div class="upcoming">

          <div class="see-more">
            <h4>Kommande</h4>
            <div>
              <a href="#">Se alla events &#8594;</a>
            </div>
          </div>


          <div class="event">
            <div class="icon">
              <p>$</p>
            </div>

            <div class="info">
              <h5>Försäljning Catchergames</h5>
              <p>12:10 - 13:00</p>
              <p>14 Jan 2019, Fredag</p>
            </div>

          </div>

          <div class="event">
            <div class="icon">
              <p>$</p>
            </div>

            <div class="info">
              <h5>Försäljning Catchergames</h5>
              <p>12:10 - 13:00</p>
              <p>14 Jan 2019, Fredag</p>
            </div>

          </div>

          <div class="event">
            <div class="icon">
              <p>$</p>
            </div>

            <div class="info">
              <h5>Försäljning Catchergames</h5>
              <p>12:10 - 13:00</p>
              <p>14 Jan 2019, Fredag</p>
            </div>

          </div>

        </div>

      </section>

    </div>

  </body>
</html>
