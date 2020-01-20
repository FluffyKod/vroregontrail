<?php

/**
 * Template Name: Front-Calendar
 */

get_header();

?>

<header id="single-page-header">

    <img src="<?php echo get_bloginfo('template_directory') . '/img/frontkalender.jpg'; ?>" alt="">
    <div class="img-overlay"></div>


  <svg class="single-page-logo" id="calendar-logo" width="665" height="101" viewBox="0 0 665 101" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path stroke="#fff" stroke-width="5" d="M54.6606 101L13.3326 55.208V101H0.228638V0.632004H13.3326V47.144L54.8046 0.632004H71.3646L25.8606 50.888L71.7966 101H54.6606Z"/>
  <path stroke="#fff" stroke-width="5" d="M145.76 78.68H101.984L93.9198 101H80.0958L116.384 1.208H131.504L167.648 101H153.824L145.76 78.68ZM142.016 68.024L123.872 17.336L105.728 68.024H142.016Z"/>
  <path stroke="#fff" stroke-width="5" d="M196.567 90.344H231.703V101H183.463V0.632004H196.567V90.344Z"/>
  <path stroke="#fff" stroke-width="5" d="M258.723 11.288V44.84H295.299V55.64H258.723V90.2H299.619V101H245.619V0.488007H299.619V11.288H258.723Z"/>
  <path stroke="#fff" stroke-width="5" d="M398.359 101H385.255L332.551 21.08V101H319.447V0.488007H332.551L385.255 80.264V0.488007H398.359V101Z"/>
  <path stroke="#fff" stroke-width="5" d="M451.945 0.632004C462.889 0.632004 472.345 2.696 480.313 6.824C488.377 10.856 494.521 16.664 498.745 24.248C503.065 31.832 505.225 40.76 505.225 51.032C505.225 61.304 503.065 70.232 498.745 77.816C494.521 85.304 488.377 91.064 480.313 95.096C472.345 99.032 462.889 101 451.945 101H420.697V0.632004H451.945ZM451.945 90.2C464.905 90.2 474.793 86.792 481.609 79.976C488.425 73.064 491.833 63.416 491.833 51.032C491.833 38.552 488.377 28.808 481.465 21.8C474.649 14.792 464.809 11.288 451.945 11.288H433.801V90.2H451.945Z"/>
  <path stroke="#fff" stroke-width="5" d="M535.614 11.288V44.84H572.19V55.64H535.614V90.2H576.51V101H522.51V0.488007H576.51V11.288H535.614Z"/>
  <path stroke="#fff" stroke-width="5" d="M649.186 101L625.282 59.96H609.442V101H596.338V0.632004H628.738C636.322 0.632004 642.706 1.928 647.89 4.52C653.17 7.11201 657.106 10.616 659.698 15.032C662.29 19.448 663.586 24.488 663.586 30.152C663.586 37.064 661.57 43.16 657.538 48.44C653.602 53.72 647.65 57.224 639.682 58.952L664.882 101H649.186ZM609.442 49.448H628.738C635.842 49.448 641.17 47.72 644.722 44.264C648.274 40.712 650.05 36.008 650.05 30.152C650.05 24.2 648.274 19.592 644.722 16.328C641.266 13.064 635.938 11.432 628.738 11.432H609.442V49.448Z"/>
  </svg>

  <hr id="logo-sepparator">

</header>

<section id="front-calendar">

  <h2>Kalender</h2>


  <div class="events_view">

    <!-- MODAL FOR CLICKED EVENTS -->
    <div class="modal" id="modal">
      <div class="modal-header">
        <div class="title">
          Example modal
        </div>
        <button data-close-button class="close-button" type="button" name="button">&times;</button>
      </div>
      <div class="modal-body">
        sdfjsldkjf
      </div>
    </div>
    <div id="overlay"></div>

    <div class="calendar_container">

      <div class="calendar_top">

        <button onclick="calendar_previous()">&#x02190;</button>
        <h3 id="monthAndYear">Month And Year</h3>
        <button onclick="calendar_next()" >&#x02192;</button>

      </div>

      <table id="calendar">

        <thead>
          <tr>
            <th class="week">v.</th>
            <th>Mån</th>
            <th>Tis</th>
            <th>Ons</th>
            <th>Tor</th>
            <th>Fre</th>
          </tr>
        </thead>

        <tbody id="calendar-body">

        </tbody>

      </table>

    </div>

  </div>

</section>

<?php

// Get all events
global $wpdb;

if (current_user_can('administrator') || current_user_can('elevkaren') ){
    // Get all events
    $all_events = $wpdb->get_results('SELECT * FROM vro_events');
} else {
  // Only get events that has been published
  $all_events = $wpdb->get_results('SELECT * FROM vro_events WHERE visibility="a"');
}

$event_type_array = array();
$all_event_types = $wpdb->get_results('SELECT * FROM vro_event_types');

foreach($all_event_types as $et){
  $event_type_array += array(
    $ét->id => array($et->bg_color, $et->fg_color)
  );
}

$json_events = json_encode($all_events);
$json_event_types = json_encode($all_event_types)

?>
<script type="text/javascript">
  var actionLink = "<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kalender.inc.php'); ?>";
  var allEvents = <?php echo $json_events; ?>;
  var allEventTypes = <?php echo $json_event_types; ?>;

</script>

<script src="<?php echo get_bloginfo('template_directory') ?>/js/forms.js" charset="utf-8"></script>
<script src="<?php echo get_bloginfo('template_directory') ?>/js/modal.js" charset="utf-8"></script>
<script src="<?php echo get_bloginfo('template_directory') ?>/js/calendar.js" charset="utf-8"></script>
<script src="<?php echo get_bloginfo('template_directory') ?>/js/admin.js" charset="utf-8"></script>
<script type="text/javascript">
  window.addEventListener('scroll', function() {
    fillNavigationBar('single-page-header');
  });
</script>

<?php

get_footer();

?>
