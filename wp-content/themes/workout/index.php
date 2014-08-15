<?php get_header(); ?>
<section id="content">
  <div class="<?php if(is_active_sidebar('blog-sidebar')) { echo "sidebar_right"; } ?> container">
		<div class="page_content">
    <?php while (have_posts()) : the_post(); ?>

    	<?php if(has_post_format("quote")) { ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="inner">
                <span class="quote"><?php echo get_the_content(); ?></span>
                <?php if(!is_single()) : ?>
                <span class="author"><?php echo get_the_title(); ?></span>
                <?php endif; ?>
            </div>
        </article>
        <?php comments_template(); ?>
      <?php
      }
      elseif(has_post_format("aside")) { ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <div class="header">
            <?php
            $date = get_post_meta(get_the_ID(), "wod_date", true);
            if(!isset($date) || $date == "") {
              $date = get_the_date();
            }
            ?>
            <span class="day"><?php echo date("l", strtotime($date)); ?></span>
            <span class="title"><a href="<?php echo the_permalink(); ?>"><?php echo date(get_option("date_format"), strtotime($date)); ?></a></span>
            <span class="subtitle">'<?php echo get_the_title(); ?>'</span>
          </div>
          <div class="content">
            <?php the_content(); ?>
          </div>
        </div>
        <?php comments_template(); ?>
    	<?php
      }
      else { ?>
    	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    		<?php if(has_post_format("image")) { ?>
    			<?php the_post_thumbnail('large'); ?>
    		<?php } elseif(has_post_format("video")) { ?>
  					<div class="video_player">
  					<?php
  						if(get_post_meta(get_the_ID(), "video_url", true) != "") {
  			        global $wp_embed;
  			        echo $wp_embed->run_shortcode("[embed]". get_post_meta(get_the_ID(), "video_url", true) ."[/embed]");
  						} else {
  							echo get_post_meta(get_the_ID(), "video_embed", true);
  						}
  					?>
  					</div>
    		<?php } elseif(class_exists("T2T_Toolkit") && has_post_format("gallery")) { ?>
	    		<div class="multi_image">

		    		<div class="flexslider" data-effect="<?php echo T2T_Toolkit::get_post_meta(get_the_ID(), "effect", true, "fade"); ?>" data-autoplay="<?php echo T2T_Toolkit::get_post_meta(get_the_ID(), "autoplay", true, "true"); ?>" data-interval="<?php echo T2T_Toolkit::get_post_meta(get_the_ID(), "interval", true, "5"); ?>">
			    		<ul class="slides">
				    		<?php
				    			// initialize options to send to t2t_get_gallery_images
				    			$options = array(
				    			  "posts_to_show"  => -1,
				    			  "posts_per_row"  => -1
				    			);

				    			// gather the images
				    			$images = T2T_Toolkit::get_gallery_images(get_the_ID(), $options);

				    			foreach($images as $index => $image_id) {
				    			  $image = wp_get_attachment_image($image_id, "large");

				    			  echo "<li>$image</li>";

				    			}
				    		?>
			    		</ul>
		    		</div>

	    		</div>
    		<?php } ?>
        <?php the_post_thumbnail('large'); ?>
	    	<div class="inner">
          <?php if(!is_single()) : ?>
          <span class="date"><?php the_date(); ?></span>
	    		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	    		<hr/>
        <?php endif; ?>
	    		<div class="post_content">
	    			<?php if(has_post_format("audio")) { ?>
	    				<div class="audio_player">
	    				<?php
	    					if(get_post_meta(get_the_ID(), "audio_url", true) != "") {
	    						global $wp_embed;
	    						echo $wp_embed->run_shortcode("[embed]". get_post_meta(get_the_ID(), "audio_url", true) ."[/embed]");
	    					} else {
	    						echo get_post_meta(get_the_ID(), "audio_embed", true);
	    					}
	    				?>
	    				</div>
	    			<?php } ?>

	    			<?php the_content(); ?>

	    			<?php
	    			  wp_link_pages(array(
	    			    "before" => "<div class=\"post_pagination\">",
	    			    "after"  => "</div>",
	    			    "link_before" => "<span>",
	    			    "link_after" => "</span>"
	    			  ));
	    			?>

            <div class="meta">
              <span class="author">
                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                    <span class="typicons-pencil"></span>
                    <?php the_author(); ?>
                </a>
              </span>
              <span class="comments">
                <a href="<?php comments_link(); ?>">
                    <span class="typicons-messages"></span>
                    <?php comments_number(); ?>
                </a>
              </span>
              <?php if(has_tag()) { ?>
              <span class="tags">
                <span class="typicons-tags"></span>
                <?php the_tags(""); ?>
              </span>
              <?php } ?>
            </div>
	    		</div>

	    		<div class="clear"></div>
	    	</div>

    	</article>

			<?php comments_template(); ?>

    	<?php } ?>

  	<?php endwhile; ?>

  		<div class="pagination">
	  	  <?php previous_posts_link('&larr; Previous') ?>
	  	  <?php next_posts_link('Next &rarr;') ?>
  		</div>
  	</div>

    <?php get_sidebar('blog'); ?>

  	<div class="clear"></div>
  </div>
</section>
<?php get_footer(); ?>