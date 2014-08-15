<?php
if(!class_exists('T2T_Shortcode_Highlighted_Gallery')) {
	/**
	 * T2T_Shortcode_Highlighted_Gallery
	 *
	 * @package T2T_Shortcode
	 */
	class T2T_Shortcode_Highlighted_Gallery extends T2T_Shortcode
	{
	  const SHORTCODE_ID    = "t2t_highlighted_gallery";
		const SHORTCODE_NAME  = "Highlighted Gallery";

	  /**
	   * configure_attributes
	   *
	   * @since 1.0.0
	   */
	  public function configure_attributes() {
  		// gather all the albums created
  	  $album_result = new WP_Query(array(
        "posts_per_page" => -1,
  	    "post_type"      => T2T_Album::get_name()
  	  ));

  		// -1 in WP_Query refers to all items
      $to_show_array = array(-1 => __("All", "t2t"));

      // list of albums for attribute
      $album_list = array();

      // initialize the index and option counter
  		$i = 0;

  		// create a standard array to pass as options
      while($album_result->have_posts()) { 
        $album_result->the_post();

        // increment index and option counter
        $i++;
        
        // add the index as an option
        $to_show_array[$i] = $i;

        // append this album to the array
        $album_list[get_the_ID()] = get_the_title();
      }

      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "title",
        "name"        => "title",
        "label"       => __("Title", "t2t"),
        "description" => __("Leave blank to not display a title.", "t2t")
      )));
			array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "album_id",
        "name"        => "album_id",
        "label"       => sprintf(__('%1$s', 't2t'), T2T_Album::get_title()),
        "description" => sprintf(__('Choose the %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Album::get_title())),
        "options"     => $album_list
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "posts_to_show",
        "name"        => "posts_to_show",
        "label"       => __("Number of Images", "t2t"),
        "description" => __("Choose how many images you'd like displayed.", "t2t"),
        "options"     => $to_show_array,
        "default"     => "-1"
      )));

	    // reset to main query
      wp_reset_postdata();

	    $this->attributes = apply_filters("t2t_shortcode_highlighted_gallery_fields", $this->attributes);
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
			$filtered_options = apply_filters("t2t_shortcode_highlighted_gallery_options", $options);

			// query argument
			$images = T2T_Toolkit::get_gallery_images($options["album_id"], $options);

			// initialize the counter that will help determine the last item in a column
			$i = 0;

			// initialize the output
			$output = "";

	    // initialize the output options
	    $output_options = array();

			// loop through each album
			foreach($images as $image_id) {
			  // increment the current position
			  $i++;

			  $output_options = array_merge(array(
			  	"post_id"       => $image_id,
			  	"loop_position" => $i
			  ), $filtered_options);

			  // allow modifcation to the markup
			  $output .= apply_filters("t2t_shortcode_highlighted_gallery_output", $this->handle_output($output_options, $content), $output_options, $content);
			}

      // reset to main query
      wp_reset_postdata();

			return apply_filters("t2t_shortcode_highlighted_gallery_wrapper", $output, $output_options);
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

	    // image details
	    $image_file     = wp_get_attachment_image($options["post_id"], 'medium');
	    $large_image    = wp_get_attachment_image_src($options["post_id"], 'full');

	    // make sure the image is valid
	    if(empty($image_file)) {
	      return;
	    }

	    $output = "<li>";
	    $output .= "  <div class=\"wall_entry\">";
	    $output .= "    ". $image_file;
	    $output .= "    <span class=\"hover\"><span class=\"icons\">";
	    $output .= "      <a href=\"" . $large_image[0] . "\" class=\"entypo-search fancybox\" rel=\"album_". $options["album_id"] ."\"></a>";
	    // $output .= "      <a href=\"". get_attachment_link($options["post_id"]) ."\" class=\"entypo-link\"></a>";
	    $output .= "    </span></span>";
	    $output .= "  </div>";
	    $output .= "</li>";
	    
	    return $output;
	  }
	}
}
?>