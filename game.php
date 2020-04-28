<?php
/**
 * Template Name: Game
 */

 // Only show game to logged in users
 if (! is_user_logged_in() ){
   echo "<h1>Du måste vara inloggad för att se spelet</h1>";
   echo '<a href="/wp-login.php">Logga In</a>';
 } else {

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0>
    <style> body {padding: 0; margin: 0;} </style>
    <LINK REL=StyleSheet HREF="<?php echo get_bloginfo('template_directory') ?>/p5/code/style.css" TYPE="text/css" MEDIA=screen>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/p5.min.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/addons/p5.dom.min.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/addons/p5.sound.min.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/addons/p5.play.js"></script>

  </head>
  <body>

    <!-- ***********************************
    * ERROR HANDLING
    *************************************-->
    <?php show_error_alert(); ?>

      <!-- <audio id="audio-holder" hidden autoplay loop src="http://vroregon.local/wp-content/uploads/highlands-ambient.mp3"></audio> -->
      <audio id="textloop-holder" hidden loop src="<?php echo get_bloginfo('template_directory') ?>/game-assets/soundeffects/textloop-long.wav"></audio>
      <audio id="choice-holder" hidden src="<?php echo get_bloginfo('template_directory') ?>/game-assets/soundeffects/choice.wav"></audio>
      <div class="fade"></div>
      <div id="overlay"></div>
      <div class="dim"></div>

      <div id="intro-screen">
        <img id="intro-image" src="<?php echo get_bloginfo('template_directory') ?>/game-assets/backgrounds/beach.png" alt="test">
        <img id="logo" src="<?php echo get_bloginfo('template_directory') ?>/game-assets/curseofthecircle.png" alt="">

        <div class="menu">
            <button id="main-choice" class="blink">[ NEW GAME ]</button>
            <button>[ QUIT ]</button>
        </div>
      </div>

      <div id="grandparent">


        <p id="game-asset-folder" hidden><?php echo get_bloginfo('template_directory') ?>/game-assets/</p>
        <img id="background-image" src="<?php echo get_bloginfo('template_directory') ?>/game-assets/backgrounds/beach.png" alt="test">

        <div id="parent">

          <div id="textbox" class="box"></div>

          <div id="optionbox" class="box">
            <div id="option-1" class = "option"></div>
            <div id="option-2" class = "option"></div>
            <div id="option-3" class = "option"></div>
            <div id="option-4" class = "option"></div>
            <div id="option-5" class = "option"></div>
          </div>

          <div id="dev-box" class="box">

            <h3>Ruminfo</h3>
            <h4 id="room-info"></h4>

            <h3>Inventory</h3>
            <ul id="inventory"></ul>

            <h3>Player stats</h3>
            <div class="player-stats">
              <p>Intellligence: <span id="intelligence"></span></p>
              <p>Charisma: <span id="charisma"></span></p>
              <p>Grit: <span id="grit"></span></p>
              <p>Kindness: <span id="kindness"></span></p>
              <p>Dexterity: <span id="dexterity"></span></p>
            </div>


            <h3>Player Database Functions</h3>
            <button type="button" name="button" onclick="savePlayer()">Save player</button>
            <button type="button" name="button" onclick="getPlayer()">Get player</button>
            <button type="button" name="button" onclick="resetPlayer()">Reset Game</button>

            <h3>Hoppa till koordinat</h3>

            <form>

              <select id="switch-area">
                <option value="">test</option>
                <option value="">intro</option>
                <option value="">highlands</option>
                <option value="">bog</option>
                <option value="">city</option>
                <option value="">mountain</option>
                <option value="">core</option>
              </select>
              <br/>

              <input id="switch-x" type="number" name="" value="" placeholder="x-koor" required>
              <input id="switch-y" type="number" name="" value="" placeholder="y-koor" required>
              <br/>
              <button type="button" name="button" onclick="changeRoomDebug()">Hoppa</button>

            </form>
          </div>

        </div>

      </div>


      <!-- SCRIPTS -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.2/gsap.min.js" charset="utf-8"></script>

      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/helpers.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Main.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/fader.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/introscreen.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-pepe.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-card-game.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-ernst-running.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-flappy-river.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-invaders.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-mountain-jump.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-ddr.js"></script>
      <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-start-end.js"></script>

  </body>
</html>

<?php

}

 ?>
