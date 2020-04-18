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

    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/p5.min.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/addons/p5.dom.min.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/addons/p5.sound.min.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/addons/p5.play.js"></script>

    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/helpers.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Main.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-pepe.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-card-game.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-ernst-running.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-flappy-river.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-invaders.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-mountain-jump.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-ddr.js"></script>
    <script src="<?php echo get_bloginfo('template_directory') ?>/p5/code/Minigame-start-end.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  </head>
  <body>

      <button type="button" name="button" onclick="savePlayer()">Save player</button>
      <button type="button" name="button" onclick="getPlayer()">Get player</button>

      <!-- <audio controls autoplay>
        <source src="http://vroregon.local/wp-content/uploads/highlands-ambient.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
      </audio> -->

      <div id="grandparent">


        <p id="game-asset-folder" hidden><?php echo get_bloginfo('template_directory') ?>/game-assets/</p>
        <img id="background-image" src="<?php echo get_bloginfo('template_directory') ?>/game-assets/backgrounds/scottishHiglands.jpg" alt="test" style="width:1920px;height:1080px;position:absolute;top:0px;bottom:0px;">
        <!--<div id="topbox">
        </div>-->

        <div id="parent">

          <!--<div id="imgbox" class="box">
            img.png
          </div> -->

          <div id="textbox" class="box">

          </div>
          <div id="optionbox" class="box">
            <div id="option-1" class = "option">
              option 1
            </div>
            <div id="option-2" class = "option">
              option 2
            </div>
            <div id="option-3" class = "option">
              option 3
            </div>
            <div id="option-4" class = "option">
              option 4
            </div>
            <div id="option-5" class = "option">
              option 5
            </div>

          </div>

      </div>
        <a id="mountain-jump" href="index-minigame-mountain-jump.html"></a>
      </div>

  </body>
</html>

<?php

}

 ?>
