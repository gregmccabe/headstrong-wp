<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section id="content">
	<article class="container">
    <div class="inner">
  		<?php 
  		if (has_post_thumbnail()) {
  	    $image = wp_get_attachment_image(get_post_thumbnail_id(), 'thumbnail');
  		?>
  		<div class="coach_photo">
  			<?php echo $image; ?>
  		</div>
  		<?php } ?>
      
  		<div class="coach_info">
        <h2><?php echo get_post_meta(get_the_ID(), "title", true); ?></h2>
  			<?php echo the_content(); ?>
        <ul class="social square_round">
        <?php 

        $social_links = array(
          "twitter"   => array(
            "rounded"  => "entypo-twitter-circled",
            "href"     => get_post_meta(get_the_ID(), "twitter", true)
          ),
          "facebook"  => array(
            "rounded"  => "entypo-facebook-circled",
            "href"     => get_post_meta(get_the_ID(), "facebook", true)
          ),
          "flickr"    => array(
            "rounded"  => "entypo-flickr-circled",
            "href"     => get_post_meta(get_the_ID(), "flickr", true)
          ),
          "vimeo"     => array(
            "rounded"  => "entypo-vimeo-circled",
            "href"     => get_post_meta(get_the_ID(), "vimeo", true)
          ),
          "pinterest" => array(
            "rounded"  => "entypo-pinterest-circled",
            "href"     => get_post_meta(get_the_ID(), "pinterest", true)
          ),
          "email"     => array(
            "rounded"  => "typicons-at",
            "href"     => "mailto:".get_post_meta(get_the_ID(), "email", true)
          )
        );
        
        foreach($social_links as $site => $settings) {
          // only include the link if a url was provided
          if(!empty($settings["href"]) && $settings["href"] != "" && $settings["href"] != "mailto:") {
            echo "<li><a href=\"" . $settings["href"] . "\" title=\"" . $site . "\" target=\"_blank\"><span class=\"" . $settings["rounded"] . "\"></span></a></li>";
          }
        }
        ?>
        </ul>
  		</div>
    </div>
	</article>
</section>
<?php endwhile; endif; ?>

<?php get_footer(); ?>