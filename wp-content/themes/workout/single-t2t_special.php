<?php get_header(); ?>
<section id="content">
  <div class="<?php echo get_post_meta(get_queried_object_id(), 'layout', true); ?> container">
    <?php while (have_posts()) : the_post(); ?>
      <div class="page_content">

        <?php
         if(class_exists("T2T_Toolkit")) {

           $shortcode = new T2T_Shortcode_Special();
           echo $shortcode->handle_shortcode(array(
            "special_id"      => get_the_ID(),
            "show_button"     => false
           ));

         }
        ?>
        <br/>
        
        <?php the_content(); ?>
      </div>

    <?php endwhile; ?>

    <?php if(get_post_meta(get_queried_object_id(), 'layout', true) == "sidebar_right" || get_post_meta(get_queried_object_id(), 'layout', true) == "sidebar_left") { ?>
     <?php get_sidebar(); ?>
    <?php } ?>

    <div class="clear"></div>
  </div>
</section>
<?php get_footer(); ?>