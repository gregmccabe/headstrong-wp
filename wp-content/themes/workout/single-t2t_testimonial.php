<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section id="content">
	<div class="page_content container">
    <div class="testimonials">
      <ul>
        <?php 
          $markup = testimonial_markup_output("", array(
            "post_id" => get_the_ID(),
            "description_length" => 10000
          )); 

          echo $markup;
        ?>
      </ul>
    </div>
  </div>
</section>
<?php endwhile; endif; ?>

<?php get_footer(); ?>