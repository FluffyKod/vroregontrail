// Game in progress, show work in progress screen
if (!is_student_admin() )  { ?>

    <div id="work-in-progress">
      <div class="box">
        <h1>Spelet är just nu under konstruktion! Kapitel 2 släpps senare idag.</h1>
      </div>
    </div>

<?php
  exit();
}
