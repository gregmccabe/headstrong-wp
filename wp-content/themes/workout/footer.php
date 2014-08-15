  <?php 
    $copyright = get_theme_mod('t2t_customizer_copyright');
    if(empty($copyright)) {
      // default
      $copyright = "&copy; " . __("Copyright", "framework") . " " . get_the_date("Y") . " " . get_bloginfo('name');
    }
  ?>

  <?php 
  // legacy support for whether or not to display the carousel
  // the initial version of the theme used this variable instead of
  // enable_carousel, and we are checking this instead of using a
  // migration script
  $footer_style    = get_post_meta(get_queried_object_id(), "footer_style", true);

  // whether or not to display the carousel on this page, defaulting
  // to footer style being set to carousel previously
  $enable_carousel = get_post_meta(get_queried_object_id(), "enable_carousel", true);

  // defaulting $enable_carousel
  if($enable_carousel == "") {
    $enable_carousel = ($footer_style == T2T_Carousel::get_name());
  }

  // ensure its a boolean
  $enable_carousel = filter_var($enable_carousel, FILTER_VALIDATE_BOOLEAN);

  // gather slides if we need to display the carousel
  if(class_exists("T2T_Toolkit") && $enable_carousel) { 
    $slides = new WP_Query(array(
      "post_type"      => T2T_Carousel::get_name(),
      "posts_per_page" => -1
    ));
  }

  if(isset($slides) && $slides->have_posts()) {
  ?>
  <footer id="carousel" class="bottom">
    <div class="jcarousel_wrapper">

      <div class="jcarousel">

        <ul>
          <?php
          while ($slides->have_posts()) {
            $slides->the_post();

            $html = "<li>";
            $html .= "  <div class=\"widget icon_box\">";

            // get the post id this slide should link to
            $post_id = get_post_meta(get_the_ID(), "button_post_id", true);

            // wrap the icon and title in a link if a post id was provided
            if($post_id != "") {
              $html .= "    <a href=\"" . get_permalink($post_id) . "\"><span class=\"". get_post_meta(get_the_ID(), "service_icon", true) ."\"></span></a>";
              $html .= "    <h4><a href=\"" . get_permalink($post_id) . "\">". get_the_title() ."</a></h4>";
            }
            else {
              $html .= "    <span class=\"". get_post_meta(get_the_ID(), "service_icon", true) ."\"></span>";
              $html .= "    <h4>". get_the_title() ."</a></h4>";
            }

            $html .= "    <p>". get_post_meta(get_the_ID(), "content", true) ."</p>";
            $html .= "  </div>";
            $html .= "</li>";

            echo $html;
          }
          ?>
        </ul>

      </div>

      <a class="jcarousel-prev jcarousel-nav" href="javascript:;"><span class="entypo-left-open-mini"></span></a>
      <a class="jcarousel-next jcarousel-nav" href="javascript:;"><span class="entypo-right-open-mini"></span></a>
    </div>

  </footer>
  <?php 
    // reset to main query
    wp_reset_postdata();
  } ?>
  <footer id="standard">
    <?php
    // initialize footer column count
    $footer_columns = 0;
    for($i = 1; $i <= 4; $i++) {
      // if this footer is active
      if(is_active_sidebar("footer-widget-" . $i)) {
        // increment the number of columns
        $footer_columns++;
      }
    }
    if($footer_columns > 0) {

      echo "<div id=\"footer-sidebar\"><div class=\"container\">";

      for($i = 1; $i <= $footer_columns; $i++) {
        // initialize classes value
        $classes = "one_fourth";

        if($i == $footer_columns) {
          $classes .= " column_last";
        }

        echo "<div id=\"footer-sidebar-$i\" class=\"widgets $classes\">";

        if(is_active_sidebar("footer-widget-" . $i)) {
          dynamic_sidebar("footer-widget-" . $i);
        }

        echo "</div>";
      }
      
      echo "</div></div>";
    }
    ?>

    <div class="copyright container">
      <p><?php echo $copyright; ?></p>
      <?php t2t_social_links(); ?>
    </div>
  </footer>

  <?php if(get_theme_mod("t2t_customizer_header_background") != "") { ?>
    <?php if(get_theme_mod("t2t_customizer_header_background_repeat") == "stretch") { ?>
      <div class="background backstretch" data-background-image="<?php echo get_theme_mod("t2t_customizer_header_background"); ?>"></div>
    <?php } ?>
    <div class="shade"></div>
  <?php } ?>

  <!-- Start Wordpress Footer Hook -->
  <?php wp_footer(); ?>
  <!-- End Wordpress Footer Hook -->
</body>
</html>