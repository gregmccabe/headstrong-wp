<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section id="content">
  <div class="page_content container">

    <?php if(post_password_required(get_the_id())) { ?>
    
    <div class="page_content password_form">
      <?php echo get_the_password_form(); ?>
    </div>
      
    <?php } else { ?>

    <?php if(!empty($post->post_content)) { ?>
      <?php the_content(); ?>
    <?php } ?>
      
    <div class="gallery">
      <?php
      $post_id = get_the_id();

      if(class_exists("T2T_Toolkit")) {
        $shortcode = new T2T_Shortcode_Album();
        echo $shortcode->handle_shortcode(array(
          "album_id"      => $post_id,
          "posts_to_show" => -1,
          "posts_per_row" => T2T_Toolkit::get_post_meta($post_id, "album_photos_per_row", true, 3)
        ));
      }
      ?>
    </div>
    
    <?php } ?>

    <div class="clear"></div>

  </div>
</section>
<?php endwhile; endif; ?>

<?php get_footer(); ?>