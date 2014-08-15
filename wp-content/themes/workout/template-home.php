<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>

  <div id="slider_container" class="container">
    <?php
    if(class_exists("T2T_Toolkit")) {

      // retrieve the slider to use, if any
      $slider = T2T_Toolkit::get_post_meta(get_the_ID(), "slider", true, "none");

      // check to make sure the slider option is supported
      if(in_array($slider, array(
        T2T_SlitSlider::get_name(), T2T_ElasticSlider::get_name(), T2T_FlexSlider::get_name()))) {

        if($slider == T2T_ElasticSlider::get_name()) {
          // create the shortcode
          $shortcode = new T2T_Shortcode_ElasticSlider();

          // render the shortcode
          echo $shortcode->handle_shortcode(array(
            "posts_to_show"  => -1,
            "width"          => "full",
            "controls_color" => "light"
          ));
        }
        elseif($slider == T2T_SlitSlider::get_name()) {
          // create the shortcode
          $shortcode = new T2T_Shortcode_SlitSlider();

          // render the shortcode
          echo $shortcode->handle_shortcode(array(
            "posts_to_show"  => -1,
            "width"          => "full",
            "controls_color" => "light"
          ));
        }
        elseif($slider == T2T_FlexSlider::get_name()) {
          // create the shortcode
          $shortcode = new T2T_Shortcode_FlexSlider();

          // render the shortcode
          echo $shortcode->handle_shortcode(array(
            "posts_to_show"  => -1,
            "width"          => "fixed",
            "controls_color" => "light"
          ));
        }
      }
      else {
        echo "<div class=\"splash\">";
        echo "  <span class=\"slide-content\">";
        echo "    <span class=\"title\">" . get_bloginfo("name") . "</span>";
        echo "    <span class=\"caption\">" . get_bloginfo("description") . "</span>";
        echo "  </span>";
        echo "</div>";
      }

    }
    ?>
  </div>

  <?php while (have_posts()) : the_post(); ?>
  <section id="content">
    <div class="container">
      <?php the_content(); ?>

      <?php
      if(class_exists("T2T_Toolkit")) {

        $show_albums = T2T_Toolkit::get_post_meta(get_the_ID(), "show_albums", true, true);
        if(filter_var($show_albums, FILTER_VALIDATE_BOOLEAN)) {
          $posts_to_show = T2T_Toolkit::get_post_meta(get_the_ID(), "album_posts_to_show", true, 0);
          if($posts_to_show == -1 || $posts_to_show > 0) {
            $shortcode = new T2T_Shortcode_Highlighted_Gallery();
            echo $shortcode->handle_shortcode(array(
              "title"         => T2T_Toolkit::get_post_meta(get_the_ID(), "album_title", true, ""),
              "album_id"      => T2T_Toolkit::get_post_meta(get_the_ID(), "album_album_id", true, ""),
              "posts_to_show" => $posts_to_show
            ));
          }
        }

        $show_posts = T2T_Toolkit::get_post_meta(get_the_ID(), "show_posts", true, true);
        if(filter_var($show_posts, FILTER_VALIDATE_BOOLEAN)) {
          $posts_to_show = T2T_Toolkit::get_post_meta(get_the_ID(), "posts_posts_to_show", true, 0);
          $shortcode = new T2T_Shortcode_Highlighted_Post_List();
          echo $shortcode->handle_shortcode(array(
            "title"              => T2T_Toolkit::get_post_meta(get_the_ID(), "posts_title", true, ""),
            "posts_to_show"      => $posts_to_show,
            "highlighted_description_length" => T2T_Toolkit::get_post_meta(get_the_ID(), "posts_highlighted_description_length", true, 300),
            "description_length" => T2T_Toolkit::get_post_meta(get_the_ID(), "posts_description_length", true, 100),
            "category"           => T2T_Toolkit::get_post_meta(get_the_ID(), "posts_category", true, null)
          ));
        }

        $show_testimonials = T2T_Toolkit::get_post_meta(get_the_ID(), "show_testimonials", true, true);
        if(filter_var($show_testimonials, FILTER_VALIDATE_BOOLEAN)) {
          $testimonials_to_show = T2T_Toolkit::get_post_meta(get_the_ID(), "testimonials_posts_to_show", true, 0);
          if($testimonials_to_show == -1 || $testimonials_to_show > 0) {
            $shortcode = new T2T_Shortcode_Highlighted_Testimonial_List();
            echo $shortcode->handle_shortcode(array(
              "title"             => T2T_Toolkit::get_post_meta(get_the_ID(), "testimonials_title", true, ""),
              "posts_to_show"      => $testimonials_to_show,
              "description_length" => T2T_Toolkit::get_post_meta(get_the_ID(), "testimonials_description_length", true, 100),
              "category"           => T2T_Toolkit::get_post_meta(get_the_ID(), "testimonials_category", true, null)
            ));
          }
        }

        $show_programs = T2T_Toolkit::get_post_meta(get_the_ID(), "show_programs", true, true);
        if(filter_var($show_programs, FILTER_VALIDATE_BOOLEAN)) {
          $programs_to_show = T2T_Toolkit::get_post_meta(get_the_ID(), "programs_posts_to_show", true, 0);
          if($programs_to_show == -1 || $programs_to_show > 0) {
            $shortcode = new T2T_Shortcode_Service_List();
            echo $shortcode->handle_shortcode(array(
              "title"              => T2T_Toolkit::get_post_meta(get_the_ID(), "programs_title", true, ""),
              "posts_to_show"      => $programs_to_show,
              "posts_per_row"      => T2T_Toolkit::get_post_meta(get_the_ID(), "programs_posts_per_row", true, 4),
              "description_length" => T2T_Toolkit::get_post_meta(get_the_ID(), "programs_description_length", true, 100),
              "category"           => T2T_Toolkit::get_post_meta(get_the_ID(), "programs_category", true, null)
            ));
          }
        }

        $show_location = T2T_Toolkit::get_post_meta(get_the_ID(), "show_location", true, true);
        if(filter_var($show_location, FILTER_VALIDATE_BOOLEAN)) {
          $shortcode = new T2T_Shortcode_Location();
          echo $shortcode->handle_shortcode(array(
            "title"           => T2T_Toolkit::get_post_meta(get_the_ID(), "location_title", true, ""),
            "name"            => get_post_meta(get_the_ID(), "location_name", true),
            "address"         => get_post_meta(get_the_ID(), "location_address", true),
            "address_details" => get_post_meta(get_the_ID(), "location_address_details", true),
            "city"            => get_post_meta(get_the_ID(), "location_city", true),
            "state"           => get_post_meta(get_the_ID(), "location_state", true),
            "postal_code"     => get_post_meta(get_the_ID(), "location_postal_code", true),
            "country"         => get_post_meta(get_the_ID(), "location_country", true),
            "phone"           => get_post_meta(get_the_ID(), "location_phone", true),
            "latitude"        => get_post_meta(get_the_ID(), "location_latitude", true),
            "longitude"       => get_post_meta(get_the_ID(), "location_longitude", true)
          ));
        }
      }
      ?>
    </div>
  </section>
  <?php endwhile; ?>

<?php get_footer(); ?>