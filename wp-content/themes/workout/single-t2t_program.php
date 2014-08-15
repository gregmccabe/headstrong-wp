<?php get_header(); ?>
<section id="content">
	<div class="<?php echo get_post_meta(get_queried_object_id(), 'layout', true); ?> container">
    <?php while (have_posts()) : the_post(); ?>
        
    <div id="single_schedule" class="page_content">

      <?php the_content(); ?>

      <?php
      if(filter_var(get_post_meta(get_the_ID(), "show_schedule", true), FILTER_VALIDATE_BOOLEAN)) {
        if(class_exists("T2T_Toolkit")) {
          $shortcode = new T2T_Shortcode_Schedule();
          echo $shortcode->handle_shortcode(array(
            "program_id" => get_queried_object_id()
          ));
        }
      }
      ?>
       
    </div>

    <?php endwhile; ?>
  	<div class="clear"></div>
  </div>
	
  <?php if(get_post_meta(get_queried_object_id(), 'layout', true) == "sidebar_right" || get_post_meta(get_queried_object_id(), 'layout', true) == "sidebar_left") { ?>
	 <?php get_sidebar(); ?>
  <?php } ?>
</section>
<?php get_footer(); ?>