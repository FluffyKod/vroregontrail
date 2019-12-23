<?php

/**
 * Template Name: Visselpipan
 */

?>

<?php

// Show this page only to admin
if (! is_user_logged_in() || ! current_user_can('administrator') ){
  wp_redirect( '/' );
} else {
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
      <?php
        require_once(get_template_directory() . "/parts/navigation-bar.php");
      ?>

      <!--
      * Dashboard
      --------------------------------------->
      <section id="dashboard">

        <div class="top-bar">
          <h2>Visselpipan</h2>
          <p><?php echo current_time('d M Y, D'); ?></p>
        </div>

        <div class="banner">
          <h3>4 nya förslag!</h3>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatright.png" alt="" class="chatright">
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/chatleft.png" alt="" class="chatleft">
        </div>

        <div class="row">

          <div class="box white lg">
            <div class="see-more">
              <h4>Fler återvinningsplatser för plast!</h4>
              <div>
                <a href="#">Svara &#8594;</a>
              </div>
            </div>

            <p>Hej! Jag tycker att man bör skapa fler återvinningsplatser för plast då det endast finns en i hela skolan! Det är många som slänger sina plastsaker i brännbart för att de inte orkar gå till denna enda, eller så vet de inte helt enkelt att det finns någon återvinning för plast.</p>
          </div>

        </div>

      </section>

      <!--
      * Status View
      --------------------------------------->
      <?php
        require_once(get_template_directory() . "/parts/status-bar.php");
      ?>

    </div>

    <script src="<?php echo get_bloginfo('template_directory') ?>/scripts/admin.js" charset="utf-8"></script>
    <script type="text/javascript">
      window.onload = highlightLink('link-visselpipan');
    </script>

    <?php
    // End if admin
    }
    ?>

  </body>
</html>
