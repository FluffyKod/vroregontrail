<?php
    if (!is_user_logged_in()){
      wp_redirect( '/wp-login.php' );
    }

    $is_chairman = false;

?>

<div class="row">

  <article class="blog-post box white lg">

    <?php if ( metadata_exists('post', get_the_ID(), 'kommitte_name') ) : ?>
      <p class="blog-post-category"><?php echo get_post_meta( get_the_ID(), 'kommitte_name')[0]; ?></p>

      <?php
      // Check if current user is the chairman
      global $wpdb;

      $chairman = $wpdb->get_var('SELECT chairman FROM vro_kommiteer WHERE name = "' . get_post_meta( get_the_ID(), 'kommitte_name')[0] . '"');

      if ( $chairman == get_current_user_id() ){
        $is_chairman = true;
      }

      ?>
    <?php endif; ?>

    <?php if ( metadata_exists('post', get_the_ID(), 'month') ) : ?>
      <p class="blog-post-category"><?php echo get_post_meta( get_the_ID(), 'month' )[0]; ?></p>
    <?php endif; ?>

    <h3 class="blog-post-title"><?php the_title(); ?></h3>
    <p class="blog-post-date">Publicerades: <?php echo get_the_date(); ?></p>

    <p class="text-preview"><?php the_content() ?></p>

    <?php if ($edit) : ?>
    <?php if (current_user_can('administrator') || current_user_can('elevkaren') || $is_chairman ): ?>
    <div class="delete-button">
      <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_notification.inc.php'); ?>" method="post">
        <button name="archive_notification" value="<?php echo get_the_ID(); ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/archive.png"></button>
      </form>

      <form action="<?php echo (get_bloginfo('template_directory') . '/scripts/handle_notification.inc.php'); ?>" method="post">
        <button class="description" name="delete_notification" value="<?php echo get_the_ID(); ?>" type="submit">
          <span class="btn-description">Ta bort: </span>
          <img src="<?php echo get_bloginfo('template_directory') ?>/img/wrong.png">
        </button>
      </form>
    </div>

  <?php endif; ?>
<?php endif; ?>

  </article>

</div>
