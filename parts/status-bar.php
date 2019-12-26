<!--
* Status View
--------------------------------------->
<?php

  $user = wp_get_current_user();

?>

<section id="status">

  <div class="status-info">

    <a href="<?php echo wp_logout_url( '/' ); ?>" class="logout">
      <p><b>Logga ut</b></p>
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/logout.png" alt="">
    </a>

    <div class="profile">
      <div class="profile-img">
        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80" alt="">
        <button class="add-btn extra-btn">+</button>
      </div>

      <p><b><?php echo $user->user_nicename; ?></b></p>
      <p>Na21d</p>
    </div>

</div>

  <div class="upcoming">

    <div class="see-more">
      <h4>Kommande</h4>
      <div>
        <a href="#">Se alla events &#8594;</a>
      </div>
    </div>

    <div class="events">

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

  </div>

</section>
