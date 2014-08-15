<?php
if(!class_exists('T2T_Shortcode_FlexSlider')) {
	/**
	 * T2T_Shortcode_FlexSlider
	 *
	 * @package T2T_Shortcode
	 */
	class T2T_Shortcode_FlexSlider extends T2T_Custom_Shortcode
	{
	  const SHORTCODE_ID    = "t2t_flexslider";
		const SHORTCODE_NAME  = "Flex Slider";

	  /**
	   * configure_attributes
	   *
	   * @since 1.0.0
	   */
	  public function configure_attributes() {
	  	// gather all the slides created
	    $slide_result = new WP_Query(array(
	      "post_type" => T2T_FlexSlider::get_name()
	    ));

			// -1 in WP_Query refers to all items
	    $to_show_array = array(-1 => __("All", "t2t"));

	    // list of slides for attribute
	    $slide_list = array();

	    // initialize the index and option counter
			$i = 0;

			// create a standard array to pass as options
	    while($slide_result->have_posts()) { 
	      $slide_result->the_post();

	      // increment index and option counter
	      $i++;
	      
	      // add the index as an option
	      $to_show_array[$i] = $i;
	    }

		  array_push($this->attributes, new T2T_SelectHelper(array(
		    "id"          => "posts_to_show",
		    "name"        => "posts_to_show",
		    "label"       => __("Number of Slides", "t2t"),
		    "description" => __("Choose how many slides you'd like displayed.", "t2t"),
		    "options"     => $to_show_array,
		    "default"     => "-1"
		  )));
		  array_push($this->attributes, new T2T_SelectHelper(array(
		    "id"          => "effect",
		    "name"        => "effect",
		    "label"       => __("Slide Effect", "t2t"),
		    "description" => __("Choose an effect to use for the slider.", "t2t"),
		    "options"     => array(
		    	"fade"  => __("Fade", "t2t"),
		    	"slide" => __("Slide", "t2t")
		    ),
		    "default"     => "fade"
		  )));
		  array_push($this->attributes, new T2T_SelectHelper(array(
		    "id"          => "width",
		    "name"        => "width",
		    "label"       => __("Slider Width", "t2t"),
		    "description" => __("Choose a width for the slider.", "t2t"),
		    "options"     => array(
		    	"full"  => __("Full Width", "t2t"),
		    	"fixed" => __("Fixed Width", "t2t")
		    ),
		    "default"     => "full"
		  )));
		  array_push($this->attributes, new T2T_TextHelper(array(
		    "id"          => "height",
		    "name"        => "height",
		    "label"       => __("Slider Height", "t2t"),
		    "description" => __("Specify a height for the slider (in pixels). Leave blank for auto height.", "t2t"),
		    "default"     => ""
		  )));
		  array_push($this->attributes, new T2T_CheckboxHelper(array(
		    "id"    => "autoplay",
		    "name"  => "autoplay",
		    "label" => __("Enable Auto Play?", "t2t"), 
		    "description" => "If checked, slides will play automatically.",
		    "checked" => false
		  )));
		  array_push($this->attributes, new T2T_SliderHelper(array(
		    "id"          => "interval",
		    "name"        => "interval",
		    "label"       => __("Autoplay Duration", "t2t"),
		    "description" => __("Duration between auto play (in seconds)", "t2t"),
		    "range"       => "1,30",
		    "step"        => "1",
		    "default"     => "5"
		  )));

			$terms = get_terms(strtolower(T2T_FlexSlider::get_name()) . "_categories");
      if(!empty($terms) && !array_key_exists("errors", $terms)) {
        $terms = array_unique($terms, SORT_REGULAR);

        $categories = array();

        foreach($terms as $term) {
          $categories[$term->term_id] = $term->name;
        }

        array_push($this->attributes, new T2T_SelectHelper(array(
          "id"          => "category",
          "name"        => "category",
          "label"       => __("Category", "t2t"),
          "description" => sprintf(__('Select a specific category to list %1$s for.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_FlexSlider::get_title()))),
          "options"     => $categories,
          "prompt"      => __("Select a Category", "t2t")
        )));
      }

      // reset to main query
      wp_reset_postdata();

	    $this->attributes = apply_filters("t2t_shortcode_flexslider_fields", $this->attributes);
	  }

	  /**
	   * handle_shortcode
	   *
	   * @since 1.0.0
	   *
	   * @param array $atts Version of the field to display
	   * @param string $content Main content of the shortcode
	   *
	   * @return HTML representing this shortcode
	   */
	  public function handle_shortcode($atts, $content = null) {
	  	$options = shortcode_atts($this->get_attributes_as_defaults(), $atts);

			// allow modification to the query arguments
			$filtered_options = apply_filters("t2t_shortcode_flexslider_display_options", $options);

			// query argument
			$query_args = array(
			  "post_type"      => T2T_FlexSlider::get_name(),
			  "posts_per_page" => $options["posts_to_show"]
			);

			if(isset($options["category"]) && trim($options["category"]) != "") {
			  $category_query = array(
			    "taxonomy" => strtolower(T2T_FlexSlider::get_name()) . "_categories",
			    "field"    => "id",
			    "terms"    => $options["category"]
			  );

			  if(isset($query_args["tax_query"])) {
			    // if the key already exists append to it
			    array_push($query_args["tax_query"], array($category_query));
			  }
			  else {
			    // otherwise add it
			    $query_args["tax_query"] = array($category_query);
			  }
			}

			// allow modification to the query arguments
			$filtered_query_args = apply_filters("t2t_shortcode_flexslider_query_args", $query_args, $filtered_options);

			// query WP for our the slides
			$slides_loop = new WP_Query($filtered_query_args);

			// initialize the counter that will help determine the last item in a column
			$i = 0;

			// initialize the output
			$output = "";

  		// initialize the output options
      $output_options = array_merge(array(
        "post_count" => $slides_loop->found_posts
      ), $filtered_options);

			// loop through each service
			while($slides_loop->have_posts() ) {
			  // wordpress scope, grab this post
			  $slides_loop->the_post();

			  // increment the current position
			  $i++;

			  $output_options = array_merge($output_options, array(
			  	"post_id"       => get_the_ID(),
			  	"loop_position" => $i
			  ));

			  // allow modifcation to the markup
			  $output .= apply_filters("t2t_shortcode_flexslider_output", $this->handle_output($output_options, $content), $output_options, $content);
			}

			// reset to main query
			wp_reset_postdata();

			return apply_filters("t2t_shortcode_flexslider_wrapper", $this->handle_wrapper($output, $output_options), $output_options);
	  }

	  /**
	   * handle_output
	   *
	   * @since 1.0.0
	   *
	   * @param array $options Options provided to the markup
	   * @param string $content Content of the shortcode
	   *
	   * @return HTML representing this shortcode
	   */
	  public function handle_output($options, $content = null) {
	    extract(shortcode_atts($this->get_attributes_as_defaults(), $options));

	    // retrieve the post
	    $post = get_post($options["post_id"]);

			$image           = wp_get_attachment_image(get_post_thumbnail_id(), "full");
			$image_src       = wp_get_attachment_image_src(get_post_thumbnail_id(), "full");

			if(isset($options["height"]) && $options["height"] != "") {
				$height = $options["height"];
			} else {
				$height = $image_src[2];
			}

			$output  = "<li data-image=\"". $image_src[0] ."\" style=\"height: ". $height ."px;\">";
			$output .= "<div class=\"slide-content\">";
			$output .= "	<span class=\"title\">" . get_the_title() . "</span>";
			$output .= "	<span class=\"caption\">" . get_the_content() . "</span>";
			$output .= "</div>";
			$output .= "</li>";

	    return $output;
	  }

		/**
     * handle_wrapper
     *
     * @since 1.0.0
     *
     * @param string $output Markup to wrap
     * @param array $options options selected by user for this shortcode
     *
     * @return HTML representing this shortcode
     */
	  public function handle_wrapper($output, $options) {
	  	if(isset($options["post_count"]) && $options["post_count"] > 0) {
	  		// default smooth height to true
	  		$smooth_height = "true";

	  		// if a height is provided, do not use smooth height
	  		if(isset($options["height"]) && $options["height"] != "") {
	  			$smooth_height = "false";
	  		}

		  	$wrapper  = "<div class=\"flexslider ". $options["width"] ."\" data-effect=\"". $options["effect"] ."\" data-autoplay=\"". $options["autoplay"] ."\" data-interval=\"". $options["interval"] ."\" data-smooth_height=\"$smooth_height\" style=\"height: ". $options["height"] ."px;\">";
		  	$wrapper .= "	<ul class=\"slides\">";
		  	$wrapper .=			$output;
		  	$wrapper .=	"	</ul>";
		  	$wrapper .=	"</div>";

		  	return $wrapper;
		  }
  	  else {
    		$post_type_obj = get_post_type_object(T2T_FlexSlider::get_name());

  	  	$empty_markup  = "<div class=\"no_records\">";

  			$shortcode = new T2T_Shortcode_Alert();
  			$empty_markup .= $shortcode->handle_shortcode(array(
  				"title"   => sprintf(__('No %1$s to display', 't2t'), $post_type_obj->labels->name),
  				"style"   => "white",
  				"icon"    => "fontawesome-info-sign",
  			), sprintf(__('This %1$s is currently empty.', 't2t'), T2T_FlexSlider::get_title()));

  	  	if(current_user_can("publish_posts")) {
  	  		$empty_markup .= apply_filters("t2t_shortcode_flexslider_empty_author_output", "");
  	  	}

  	  	$empty_markup .= "</div>";

  	  	return apply_filters("t2t_shortcode_flexslider_empty_output", $empty_markup);
  	  }
	  }
	}
}
?>