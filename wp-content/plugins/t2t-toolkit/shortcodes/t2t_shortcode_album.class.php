<?php
if(!class_exists('T2T_Shortcode_Album')) {
  /**
   * T2T_Shortcode_Album
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Album extends T2T_Custom_Shortcode
  {
    const SHORTCODE_ID    = "t2t_album";
  	const SHORTCODE_NAME  = "Album";

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $data Initial values for this attribute
     */
    public function __construct($data = array()) {
      $data["id"]   = T2T_Album::get_name();
      $data["name"] = T2T_Album::get_title();

      // call parent constructor
      parent::__construct($data);
    }

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
    	// gather all the albums created
      $album_result = new WP_Query(array(
        "post_type" => T2T_Album::get_name()
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

      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "album_id",
        "name"        => "album_id",
        "label"       => sprintf(__('%1$s', 't2t'), T2T_Album::get_title()),
        "description" => sprintf(__('Choose the %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Album::get_title())),
        "options"     => $album_list
      )));
       array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "album_layout_style",
        "name"        => "album_layout_style",
        "label"       => __("Layout Style", "t2t"),
        "description" => __("Choose the style of layout in which these photos will be displayed.", "t2t"),
        "options"     => array(
          "grid"         => __("Grid", "t2t"), 
          "grid_full"    => __("Grid (Full Width)", "t2t"), 
          "masonry"      => __("Masonry", "t2t"),
          "masonry_full" => __("Masonry (Full Width)", "t2t")),
        "default"     => "grid"
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "masonry_style",
        "name"        => "masonry_style",
        "label"       => __("Masonry Style", "t2t"),
        "description" => __("Choose style of masonry you'd like the images displayed with.", "t2t"),
        "options"     => array(
          "natural" => __("Natural", "t2t"), 
          "forced"  => __("Forced", "t2t")), 
        "default"     => "forced"
      )));
  	  array_push($this->attributes, new T2T_SelectHelper(array(
  	    "id"          => "posts_to_show",
  	    "name"        => "posts_to_show",
  	    "label"       => __("Number of Images", "t2t"),
  	    "description" => __("Choose how many images you'd like displayed.", "t2t"),
  	    "options"     => $to_show_array,
  	    "default"     => "-1"
  	  )));
  	  array_push($this->attributes, new T2T_SelectHelper(array(
  	    "id"          => "posts_per_row",
  	    "name"        => "posts_per_row",
  	    "label"       => __("Number of Images Per Row", "t2t"),
  	    "description" => __("Choose how many images you'd like displayed on each row.", "t2t"),
  	    "options"     => array(1 => 1, 2, 3, 4), // specify first key to define index starting point of 1
  	    "default"     => (($album_result->found_posts < 4) ? $album_result->found_posts : 4)
  	  )));

      // reset to main query
      wp_reset_postdata();

      $this->attributes = apply_filters("t2t_shortcode_album_fields", $this->attributes);
    }

    /**
     * handle_shortcode
     *
     * @param array $atts Attributes of the shortcode
     * @param string $content Content of the shortcode
     *
     * @return HTML representing this shortcode
     */
    public function handle_shortcode($atts, $content = null) {
    	$options = shortcode_atts($this->get_attributes_as_defaults(), $atts);

  		// allow modification to the query arguments
  		$filtered_options = apply_filters("t2t_shortcode_album_display_options", $options);

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

  		  // determine classes for this position in the loop
  		  $classes = T2T_Toolkit::determine_loop_classes(sizeof($images), $i, $filtered_options);

  		  $output_options = array_merge(array(
  		  	"classes"       => explode(" ", $classes),
  		  	"post_id"       => $image_id,
  		  	"loop_position" => $i
  		  ), $filtered_options);

  		  // allow modifcation to the markup
  		  $output .= apply_filters("t2t_shortcode_album_output", $this->handle_output($output_options, $content), $output_options, $content);
  		}

  		return apply_filters("t2t_shortcode_album_wrapper", $output, $output_options);
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

      // make sure the image is valid
      if(empty($image_file)) {
        return;
      }

      $output  = "<div class=\"wall_entry " . join(" ", $options["classes"]) . "\">";
      $output .= "   <a href=\"" . get_attachment_link($options["post_id"]) . "\">";
      $output .= "       ". $image_file;
      $output .= "   </a>";
      $output .= "</div>";

      return $output;
    }
  }
}
?>