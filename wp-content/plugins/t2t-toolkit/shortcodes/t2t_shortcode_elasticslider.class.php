<?php
if(!class_exists('T2T_Shortcode_ElasticSlider')) {
	/**
	 * T2T_Shortcode_ElasticSlider
	 *
	 * @package T2T_Shortcode
	 */
	class T2T_Shortcode_ElasticSlider extends T2T_Custom_Shortcode
	{
	  const SHORTCODE_ID    = "t2t_elasticslider";
		const SHORTCODE_NAME  = "Elastic Slider";

	  /**
	   * configure_attributes
	   *
	   * @since 1.0.0
	   */
	  public function configure_attributes() {
	  	// gather all the slides created
	    $slide_result = new WP_Query(array(
	      "post_type" => T2T_ElasticSlider::get_name()
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
		    "id"          => "width",
		    "name"        => "width",
		    "label"       => __("Slider Width", "t2t"),
		    "description" => __("Choose a width for the slider.", "t2t"),
		    "options"     => array(
		    	"full"    => "Full Width",
		    	"fixed"   => "Fixed Width"
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
		  array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "controls_color",
        "name"        => "controls_color",
        "label"       => __("Controls Color", "t2t"),
        "description" => __("Color for the slider controls", "t2t"),
        "options"     => array(
          "light" => "Light",
          "dark"   => "Dark"
        ),
        "default"     => "dark"
      )));

			$terms = get_terms(strtolower(T2T_ElasticSlider::get_name()) . "_categories");
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
          "description" => sprintf(__('Select a specific category to list %1$s for.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_ElasticSlider::get_title()))),
          "options"     => $categories,
          "prompt"      => __("Select a Category", "t2t")
        )));
      }

      // reset to main query
      wp_reset_postdata();

	    $this->attributes = apply_filters("t2t_shortcode_elasticslider_fields", $this->attributes);
	  }

	  /**
	   * handle_shortcode
	   *
	   * @since 1.0.0
	   *
	   * @param array $atts Attributes of the shortcode
	   * @param string $content Content of the shortcode
	   *
	   * @return HTML representing this shortcode
	   */
	  public function handle_shortcode($atts, $content = null) {
	    $options = shortcode_atts($this->get_attributes_as_defaults(), $atts);

    	 wp_enqueue_style("eislideshow", 
        plugin_dir_url(dirname(__FILE__)) . "css/eislideshow.css", 
        array(), 
        "0.1", 
        "screen");

      wp_enqueue_script("eislideshow", 
        plugin_dir_url(dirname(__FILE__)) . "js/jquery.eislideshow.js", 
        array("jquery"), 
        true, true);

			// allow modification to the query arguments
			$filtered_options = apply_filters("t2t_shortcode_elasticslider_display_options", $options);

			// query argument
			$query_args = array(
			  "post_type"      => T2T_ElasticSlider::get_name(),
			  "posts_per_page" => $options["posts_to_show"]
			);

			if(isset($options["category"]) && trim($options["category"]) != "") {
			  $category_query = array(
			    "taxonomy" => strtolower(T2T_ElasticSlider::get_name()) . "_categories",
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
			$filtered_query_args = apply_filters("t2t_shortcode_elasticslider_query_args", $query_args);

			// query WP for our the slides
			$slides_loop = new WP_Query($filtered_query_args);

			// initialize the counter that will help determine the last item in a column
			$i = 0;

			// initialize the output
			$output = "";

			if($options["posts_to_show"] > 0) {
				$post_count = $options["posts_to_show"];
			}
			else {
				$post_count = $slides_loop->found_posts;
			}

      // initialize the output options
      $output_options = array_merge(array(
        "post_count" => $post_count
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
			  $output .= apply_filters("t2t_shortcode_elasticslider_output", $this->handle_output($output_options, $content), $output_options, $content);
			}

			// reset to main query
			wp_reset_postdata();

			$output_options["query_result"] = $slides_loop;
			
			return apply_filters("t2t_shortcode_elasticslider_wrapper", $this->handle_wrapper($output, $output_options), $output_options);
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

			$image = wp_get_attachment_image_src(get_post_thumbnail_id(), "large");

			$output  = "<li>";
			$output .= "	<img src=\"" . $image[0] . "\" alt=\"" . $post->post_title . "\">";
			$output .= "	<div class=\"ei-title\">";

			$show_title = get_post_meta($options["post_id"], "show_title", true);

			if(filter_var($show_title, FILTER_VALIDATE_BOOLEAN)) {
				$output .= "	  <h2>" . $post->post_title . "</h2>";
			}

			$output .= "	  <h3>" . $post->post_content . "</h3>";
			$output .= "	</div>";
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
				$wrapper  = "<div data-autoplay=\"". $options["autoplay"] ."\" data-interval=\"". $options["interval"] ."\" class=\"ei-slider controls-". $options["controls_color"] ."\" style=\"height: ". $options["height"] ."px;\">";
				$wrapper .= "  <ul class=\"ei-slider-large\">";
				$wrapper .= "    " . $output;
				$wrapper .= "  </ul>";

		  	// only show nav elements if there are more than one slides
				if(isset($options["post_count"]) && $options["post_count"] > 1) {
					$wrapper .= "  <ul class=\"ei-slider-thumbs\">";
					$wrapper .= "    <li class=\"ei-slider-element\">" . __("Current", "framework") . "</li>";

					// loop through the results of the query
					while($options["query_result"]->have_posts()) {
						$options["query_result"]->the_post();

						// thumbnail for this slide
						$image = wp_get_attachment_image_src(get_post_thumbnail_id(), "thumb");

						$wrapper .= "    <li>";
						$wrapper .= "      <a href=\"#\">" . get_the_title() . "</a>";
						$wrapper .= "	     <img src=\"" . $image[0] . "\" alt=\"" . get_the_title() . "\">";
						$wrapper .= "    </li>";
					}

					wp_reset_postdata();

					$wrapper .= "  </ul>";
				}

				$wrapper .= "</div>";

				return $wrapper;
			}
		  else {
	  		$post_type_obj = get_post_type_object(T2T_ElasticSlider::get_name());

		  	$empty_markup  = "<div class=\"no_records\">";

				$shortcode = new T2T_Shortcode_Alert();
				$empty_markup .= $shortcode->handle_shortcode(array(
					"title"   => sprintf(__('No %1$s to display', 't2t'), $post_type_obj->labels->name),
					"style"   => "white",
					"icon"    => "fontawesome-info-sign",
				), sprintf(__('This %1$s is currently empty.', 't2t'), T2T_ElasticSlider::get_title()));

		  	if(current_user_can("publish_posts")) {
		  		$empty_markup .= apply_filters("t2t_shortcode_elasticslider_empty_author_output", "");
		  	}

		  	$empty_markup .= "</div>";

		  	return apply_filters("t2t_shortcode_elasticslider_empty_output", $empty_markup);
		  }
	  }
	}
}
?>