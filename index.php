<?php

get_header();

?>

<nav class="main-nav">
  <img src="<?php echo get_bloginfo('template_directory') ?>/img/logo-white.png" alt="">
  <a><img src="<?php echo get_bloginfo('template_directory') ?>/img/menu.png" alt=""></a>
</nav>

<div class="banner">

  <h3>Viktor Rydberg</h3>
  <video autoplay muted loop>
    <source src="<?php echo get_bloginfo('template_directory') ?>/img/video.mp4" type="video/mp4">
  </video>
  <h2>Odenplan</h2>

  <a class="login login-btn" href="/wp-login.php">
    <span>Logga In</span>
  </a>
</div>

<section class="green" id="info">
  <h3>Viktor Rydberg Odenplans Elevkår</h3>
  <p>Viktor Rydberg Odenplans Elevkår är Viktor Rydberg Gymnasium Odenplans största förening, till vilken nästan 100 % av skolans elever aktivt valt att ansluta sig. Elevkåren samlar och engagerar elever från alla årskurser, program och klasser för att tillsammans förgylla skoltiden för kårens medlemmar. För oss i kåren är målet enkelt: medlemmarna ska leva sin gymnasietid, inte bara överleva den.</p>
</section>

<section>
  <h4>Textäventyr</h4>
  <p>Klicka på länken nedan för att komma till textäventyr!</p>
  <a class="login-btn" href="/game">
    <span>Till Äventyret!</span>
  </a>
</section>

<section id="matsedeln">
  <h3>Matsedeln</h3>

  <div class="food-box">

    <p class="arrow">&RightArrowBar;</p>

    <div class="day">
      <h4>Måndag</h4>
      <p><b>Huvudrätt:</b> Chili con Carne på svenskt nötkött med bönor serveras med ris</p>
      <p><b>Vegetarisk:</b> Chili sin Carne på bönor och paprika serveras med ris.</p>
    </div>

    <div class="day">
      <h4>Tisdag</h4>
      <p><b>Huvudrätt:</b> Chili con Carne på svenskt nötkött med bönor serveras med ris</p>
      <p><b>Vegetarisk:</b> Chili sin Carne på bönor och paprika serveras med ris.</p>
    </div>

    <div class="day">
      <h4>Onsdag</h4>
      <p><b>Huvudrätt:</b> Chili con Carne på svenskt nötkött med bönor serveras med ris</p>
      <p><b>Vegetarisk:</b> Chili sin Carne på bönor och paprika serveras med ris.</p>
    </div>

    <div class="day">
      <h4>Torsdag</h4>
      <p><b>Huvudrätt:</b> Chili con Carne på svenskt nötkött med bönor serveras med ris</p>
      <p><b>Vegetarisk:</b> Chili sin Carne på bönor och paprika serveras med ris.</p>
    </div>

    <div class="day">
      <h4>Fredag</h4>
      <p><b>Huvudrätt:</b> Chili con Carne på svenskt nötkött med bönor serveras med ris</p>
      <p><b>Vegetarisk:</b> Chili sin Carne på bönor och paprika serveras med ris.</p>
    </div>

  </div>


</section>

<section id="letter">
  <h3>Kårbrevet</h3>
</section>

 <script src="http://localhost:35729/livereload.js"></script>

<?php

get_footer();

 ?>
