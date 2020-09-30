<div class="kommitee_member_img">
  <?php echo get_avatar( $member->ID ); ?>

  <?php if (current_user_can('administrator') || current_user_can('elevkaren') || $is_chairman ){ ?>
    <form autocomplete="off"  class="" action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_kommiteer.inc.php'); ?>" method="post">
      <input type="text" name="kommitte_id" value="<?php echo $k_id; ?>" hidden>
      <input type="text" name="student_id" value="<?php echo $member->ID; ?>" hidden>

      <button type="submit" name="leave_kommitte" class="add-btn extra-btn deny">-</button>
    </form>
  <?php } ?>

</div>
