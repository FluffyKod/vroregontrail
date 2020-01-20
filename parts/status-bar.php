<!--
* Status View
--------------------------------------->
<?php

  // Include helpful functions
  // include_once('helpful_functions.php');

  $user = wp_get_current_user();

  global $wpdb;

?>

<section id="status">

  <div class="status-info">

    <a href="<?php echo wp_logout_url( '/' ); ?>" class="logout">
      <p><b>Logga ut</b></p>
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/logout.png" alt="">
    </a>

    <div class="profile">
      <div class="profile-img">
        <?php echo get_avatar( $user->ID ); ?>
        <button class="add-btn extra-btn">+</button>
      </div>

      <p><b><?php echo get_user_meta($user->ID,'nickname',true); ?></b></p>

      <?php
      // Get class name
      $display_class_name = '';

      // Check if a class has been set for this student
      if (metadata_exists('user', $user->ID, 'class_id')){
        // Get the class id
        $user_class_id = get_user_meta($user->ID, 'class_id', true);

        // Check if there is a class with that class id
        if ($user_class = $wpdb->get_row('SELECT * FROM vro_classes WHERE id='. $user_class_id)) {
          // if so, get the class name
          $display_class_name = $user_class->name;
        }

      }

      ?>
      <p><?php echo $display_class_name; ?></p>
    </div>

</div>

  <div class="upcoming">

    <div class="see-more">
      <h4>Kommande</h4>
      <div>
        <a href="/panel/kalender">Se alla events &#8594;</a>
      </div>
    </div>

    <form class="events_buttons" action="" method="post">
      <button name="day-event-btn" id="today-event-btn" value="today" >Idag</button>
      <button name="day-event-btn" id="week-event-btn" value="week" class="selected">Vecka</button>
      <button name="day-event-btn" id="month-event-btn" value="month">Månad</button>
    </form>

    <div class="events">

      <?php

      function updateEventBtnLinks($activeId) {
        ?>
        <script type="text/javascript">
          // Remove selected class from all links
          if ( document.getElementById('today-event-btn').classList.contains('selected') ) {
              document.getElementById('today-event-btn').classList.remove('selected');
          }
          if ( document.getElementById('week-event-btn').classList.contains('selected') ) {
              document.getElementById('week-event-btn').classList.remove('selected');
          }
          if ( document.getElementById('month-event-btn').classList.contains('selected') ) {
              document.getElementById('month-event-btn').classList.remove('selected');
          }

          // Set the correct one
          document.getElementById("<?php echo $activeId; ?>").classList = 'selected';
        </script>
        <?php
      }

      global $wpdb;
      // $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE start > DATE_SUB(NOW(), INTERVAL 1 MONTH) ORDER BY start DESC');
      $currentMonth = date('m');
      $currentYear = date('Y');
      $currentDay = date('d');
      $currentWeek = date('W');
      if ($currentWeek[0] == '0'){
        $currentWeek = $currentWeek[1];
      }

      // DEFAULT MONTH
      // Get all events for the current month
      // $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE MONTH(start) = ' . $currentMonth . ' AND YEAR(start) = ' . $currentYear . ' ORDER BY start ASC');
      //
      // if (isset($_POST['day-event-btn'])){
      //   if ($_POST['day-event-btn'] == 'today'){
      //     // Get all events for the current day
      //     $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE MONTH(start) = ' . $currentMonth . ' AND YEAR(start) = ' . $currentYear . ' AND DAY(start) = ' . $currentDay . ' ORDER BY start ASC');
      //
      //     updateEventBtnLinks('today-event-btn');
      //   }
      //   elseif ($_POST['day-event-btn'] == 'week'){
      //     // Get all events for the current day
      //     $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE YEAR(start) = ' . $currentYear . ' AND WEEK(start, 3) = ' . $currentWeek . ' ORDER BY start ASC');
      //
      //     updateEventBtnLinks('week-event-btn');
      //   }
      // }

      // DEFAULT DAY
      // Get all events for the current day
      // $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE MONTH(start) = ' . $currentMonth . ' AND YEAR(start) = ' . $currentYear . ' AND DAY(start) = ' . $currentDay . ' ORDER BY start ASC');
      //
      // if (isset($_POST['day-event-btn'])){
      //   if ($_POST['day-event-btn'] == 'month'){
      //     // Get all events for the current day
      //     $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE MONTH(start) = ' . $currentMonth . ' AND YEAR(start) = ' . $currentYear . ' ORDER BY start ASC');
      //
      //     updateEventBtnLinks('month-event-btn');
      //   }
      //   elseif ($_POST['day-event-btn'] == 'week'){
      //     // Get all events for the current day
      //     $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE YEAR(start) = ' . $currentYear . ' AND WEEK(start, 3) = ' . $currentWeek . ' ORDER BY start ASC');
      //
      //     updateEventBtnLinks('week-event-btn');
      //   }
      // }

      // DEFAULT WEEK
      // Get all events for the current day
      if (current_user_can('administrator') || current_user_can('elevkaren') ){
        $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE YEAR(start) = ' . $currentYear . ' AND WEEK(start, 3) = ' . $currentWeek . ' ORDER BY start ASC');
      } else {
        $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE YEAR(start) = ' . $currentYear . ' AND WEEK(start, 3) = ' . $currentWeek . ' AND visibility="a" ORDER BY start ASC');
      }

      if (isset($_POST['day-event-btn'])){
        if ($_POST['day-event-btn'] == 'month'){
          // Get all events for the current day
          if (current_user_can('administrator') || current_user_can('elevkaren') ){
            $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE MONTH(start) = ' . $currentMonth . ' AND YEAR(start) = ' . $currentYear . ' ORDER BY start ASC');
          } else {
            $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE MONTH(start) = ' . $currentMonth . ' AND YEAR(start) = ' . $currentYear . ' AND visibility="a" ORDER BY start ASC');
          }

          updateEventBtnLinks('month-event-btn');
        }
        elseif ($_POST['day-event-btn'] == 'today'){
          // Get all events for the current day

          if (current_user_can('administrator') || current_user_can('elevkaren') ){
            $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE MONTH(start) = ' . $currentMonth . ' AND YEAR(start) = ' . $currentYear . ' AND DAY(start) = ' . $currentDay . ' ORDER BY start ASC');
          } else {
            $upcoming_events = $wpdb->get_results('SELECT * FROM vro_events WHERE MONTH(start) = ' . $currentMonth . ' AND YEAR(start) = ' . $currentYear . ' AND DAY(start) = ' . $currentDay . ' AND visibility="a" ORDER BY start ASC');
          }

          updateEventBtnLinks('today-event-btn');
        }
      }

      $i = 0;
      foreach ($upcoming_events as $up_event) {

        $current_event_type = $wpdb->get_row('SELECT * FROM vro_event_types WHERE id=' . $up_event->type);
        $symbol = ($current_event_type) ? $current_event_type->symbol : '';

        if ($up_event->visibility == 'a') {
          echo '<div class="event">';
        } else {
          echo '<div class="event unpublished">';
        }
        ?>

          <div class="icon">
            <p><?php echo $symbol; ?></p>
          </div>



          <div class="info">

            <h5><?php echo $up_event->name; ?></h5>
            <?php
              // Check if the event is on one or mulitple days
              if (date('d M Y', strtotime($up_event->start)) != date('d M Y', strtotime($up_event->end)) ){
                ?>
                  <p><?php echo date('H:i', strtotime($up_event->start)); ?> - <?php echo date('d M Y, l', strtotime($up_event->start)); ?></p>
                  <p><?php echo date('H:i', strtotime($up_event->end)); ?> - <?php echo date('d M Y, l', strtotime($up_event->end)); ?></p>
                <?php
              } else {
                  ?>
                  <p><?php echo date('H:i', strtotime($up_event->start)); ?> - <?php echo date('H:i', strtotime($up_event->end)); ?></p>
                  <p><?php echo date('d M Y, l', strtotime($up_event->start)); ?></p>
                <?php } ?>
          </div>


        </div>
        <?php

        $i++;
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
