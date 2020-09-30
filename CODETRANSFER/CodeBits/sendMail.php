<div class="box green md">

  <h4>Skicka mail till elever</h4>

  <form class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/send_mail.inc.php'); ?>" method="post">

    <input type="text" name="subject" value="" placeholder="Ämne...">
    <textarea name="message" placeholder="Meddelande..."></textarea>

    <input type="radio" name="mail-to" value="all" checked> <label>Hela skolan</label><br>
    <input type="radio" name="mail-to" value="3"> <label>Årskurs 3</label><br>
    <input type="radio" name="mail-to" value="2"> <label>Årskurs 2</label><br>
    <input type="radio" name="mail-to" value="1"> <label>Årskurs 1</label><br>

    <button name="send_message_school" class="btn lg">Skicka</button>

  </form>

</div>

<!-- Send message box -->
<div class="box green md">

  <h4>Skicka mail till elever</h4>


  <textarea name="name" placeholder="Meddelande..."></textarea>

    <input type="radio" name="mail-to" value="" checked> <label>Hela skolan</label><br>
    <input type="radio" name="mail-to" value=""> <label>Årskurs 3</label><br>
    <input type="radio" name="mail-to" value=""> <label>Årskurs 2</label><br>
    <input type="radio" name="mail-to" value=""> <label>Årskurs 1</label><br>

    <a href="#" class="btn lg">Skicka</a>

</div>
