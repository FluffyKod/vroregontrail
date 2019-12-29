<!--
* Status View
--------------------------------------->
<?php

  // Include helpful functions
  // include_once('helpful_functions.php');

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

    <form class="events_buttons">
      <button>Idag</button>
      <button >Vecka</button>
      <button class="selected">Månad</button>
    </form>

    <div class="events">

      <?php

      global $wpdb;
      // $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE start > DATE_SUB(NOW(), INTERVAL 1 MONTH) ORDER BY start DESC');
      $currentMonth = date('m');
      $currentYear = date('Y');

      // Get all events for the current month
      $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE MONTH(start) = ' . $currentMonth . ' AND YEAR(start) = ' . $currentYear . ' ORDER BY start ASC');

      foreach ($upcoming_events as $up_event) {

        $current_event_type = $wpdb->get_row('SELECT * FROM vro_event_types WHERE id=' . $up_event->type);
        $symbol = ($current_event_type) ? $current_event_type->symbol : '';

        ?>
        <div class="event">
          <div class="icon">
            <p><?php echo $symbol; ?></p>
          </div>

          <div class="info">
            <h5><?php echo $up_event->name; ?></h5>
            <p><?php echo date('H:i', strtotime($up_event->start)); ?> - <?php echo date('H:i', strtotime($up_event->end)); ?></p>
            <p><?php echo date('d M Y, l', strtotime($up_event->start)); ?></p>
          </div>

        </div>
        <?php
      }

      ?>

    <!-- <div class="event">
      <div class="icon">
        <p>$</p>
      </div>

      <div class="info">
        <h5>Försäljning Catchergames</h5>
        <p>12:10 - 13:00</p>
        <p>14 Jan 2019, Fredag</p>
      </div>

    </div> -->

  </div>

  </div>

</section>
