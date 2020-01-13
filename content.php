<?php
    if (!is_user_logged_in()){
      wp_redirect( '/wp-login.php' );
    }

?>

<div class="row">

  <article class="blog-post box white lg">

    <?php if ( metadata_exists('post', get_the_ID(), 'kommitte_name') ) : ?>
      <p class="blog-post-category"><?php echo get_post_meta( get_the_ID(), 'kommitte_name')[0]; ?></p>
    <?php endif; ?>

    <h3 class="blog-post-title"><?php the_title(); ?></h3>
    <p class="blog-post-date"><?php the_date(); ?></p>

    <p class="text-preview"><?php the_content() ?></p>

    <div class="delete-button">
      <form class="" action="index.html" method="post">
        <button name="remove_notification" value="<?php echo get_the_ID(); ?>" type="submit"><img src="<?php echo get_bloginfo('template_directory') ?>/img/wrong.png"></button>
      </form>
    </div>

  </article>

</div>
