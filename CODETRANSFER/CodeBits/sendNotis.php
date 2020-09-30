<div class="box green" id="send_message">

  <h4>Skicka Notis</h4>

  <!-- SEND MAIL -->
  <!-- <form autocomplete="off"  autocomplete="off" class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/send_mail.inc.php'); ?>" method="post">

    <input type="text" name="subject" value="" placeholder="Ämne...">
    <textarea name="message" placeholder="Meddelande..."></textarea>
    <input type="text" name="k_id" value="<?php echo $k_id; ?>" hidden>

    <?php if (current_user_can('administrator') || current_user_can('elevkaren' ) ) { ?>
      <input type="radio" name="mail-to" value="all_members" checked> <label>Hela kommitéen</label><br>
      <input type="radio" name="mail-to" value="only_chairman"> <label>Endast ordförande</label><br>
    <?php } ?>

    <button name="send_message_kommitte" class="btn lg">Skicka</button>

  </form> -->

  <!-- SEND NOTIFICATION -->
  <form autocomplete="off"  autocomplete="off" class="notis-form" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_notification.inc.php'); ?>" method="post">

    <input type="text" name="title" value="" placeholder="Titel..">
    <textarea name="content" placeholder="Meddelande..."></textarea>

    <div class="datetime-picker">

      <p><b>Datum då notisen går ut:</b></p>

      <div class="date-picker" id="start-datepicker">
        <div class="selected-date"></div>
        <input type="hidden" name="expire-date" value="" id="start_hidden_input"/>

        <div class="dates">
          <div class="month">
            <div class="arrows prev-mth">&lt;</div>
            <div class="mth"></div>
            <div class="arrows next-mth">&gt;</div>
          </div>

          <div class="days">

          </div>

        </div>
      </div>

    </div>

    <input type="text" name="k_id" value="<?php echo $k_id; ?>" hidden>

    <button name="send_notification_kommitte" value="" class="btn lg">Skicka</button>

  </form>

</div>
