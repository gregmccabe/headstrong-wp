<?php get_header(); ?>
<section id="content">
	<div class="<?php echo get_post_meta(get_queried_object_id(), 'layout', true); ?> container">
    <?php while (have_posts()) : the_post(); ?>
      <div class="page_content">

      <article id="photo" class="post">
        <?php
          $image = wp_get_attachment_image(get_post_thumbnail_id(), 'large', null, array("class" => "the_photo"));
          echo $image;
        ?>

        <div class="inner"> 

          <?php the_content(); ?>

          <!-- AddThis Button BEGIN -->
          <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
          <a class="addthis_button_preferred_1"></a>
          <a class="addthis_button_preferred_2"></a>
          <a class="addthis_button_preferred_3"></a>
          <a class="addthis_button_preferred_4"></a>
          <a class="addthis_button_compact"></a>
          <a class="addthis_counter addthis_bubble_style"></a>
          </div>
          <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52201ac3444196d2"></script>
          <!-- AddThis Button END -->

         <div class="clear"></div>
       </div>


      </article>

      </div>

  	<?php endwhile; ?>

    <?php if(get_post_meta(get_queried_object_id(), 'layout', true) == "sidebar_right" || get_post_meta(get_queried_object_id(), 'layout', true) == "sidebar_left") { ?>
     <?php get_sidebar(); ?>
    <?php } ?>

  	<div class="clear"></div>
  </div>
</section>
<?php get_footer(); ?>