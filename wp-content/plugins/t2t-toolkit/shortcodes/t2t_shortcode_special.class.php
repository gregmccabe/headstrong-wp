<?php
if(!class_exists('T2T_Shortcode_Special')) {
  /**
   * T2T_Shortcode_Special
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Special extends T2T_Custom_Shortcode
  {
    const SHORTCODE_ID    = "t2t_special";
  	const SHORTCODE_NAME  = "Special";

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $data Initial values for this attribute
     */
    public function __construct($data = array()) {
      $data["id"]   = T2T_Special::get_name();
      $data["name"] = T2T_Special::get_title();

      // call parent constructor
      parent::__construct($data);
    }

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
    	// gather all the specials created
      $special_result = new WP_Query(array(
        "post_type" => T2T_Special::get_name()
      ));

  		// -1 in WP_Query refers to all items
      $to_show_array = array(-1 => __("All", "t2t"));

      // list of specials for attribute
      $special_list = array();

      // initialize the index and option counter
  		$i = 0;

  		// create a standard array to pass as options
      while($special_result->have_posts()) { 
        $special_result->the_post();

        // increment index and option counter
        $i++;
        
        // add the index as an option
        $to_show_array[$i] = $i;

        // append this special to the array
        $special_list[get_the_ID()] = get_the_title();
      }

      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "special_id",
        "name"        => "special_id",
        "label"       => sprintf(__('%1$s', 't2t'), T2T_Special::get_title()),
        "description" => sprintf(__('Choose the %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Special::get_title())),
        "options"     => $special_list
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "description_length",
        "name"        => "description_length",
        "label"       => sprintf(__('%1$s Description Length', 't2t'), T2T_Special::get_title()),
        "description" => __("How many characters should be displayed before truncating.", "t2t"),
        "default"     => "100"
      )));

      // reset to main query
      wp_reset_postdata();

      $this->attributes = apply_filters("t2t_shortcode_special_fields", $this->attributes);
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

      // allow modifcation to the markup
      $output = apply_filters("t2t_shortcode_special_output", $this->handle_output($options, $content), $options, $content);

      return apply_filters("t2t_shortcode_special_wrapper", $output, $options);
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
      $post = get_post($special_id);

      // retrieve the external_url provided by the user
      $special_url = T2T_Toolkit::get_post_meta($special_id, 'special_external_url', true, get_permalink($special_id));

      // if an external_url was provided, set the link to open in a new window
      if(get_permalink($special_id) != $special_url) {
        $target = "_blank";
      } else {
        $target = "_self";      
      }

      // generate the markup
      $output  = "<div id=\"special_". $special_id ."\" class=\"article full\">";    
      $output .= "  <div class=\"special_content\"><h5>";
      $output .= "    <a href=\"" . $special_url . "\" target=\"" . $target . "\" class=\"special_icon\">";
      $output .= "      " . T2T_Toolkit::display_icon(get_post_meta($special_id, 'special_icon', true));
      $output .= "    </a>";
      $output .= "    <a href=\"" . $special_url . "\" target=\"" . $target . "\" class=\"special_title\">" . $post->post_title . "</a>";
      $output .= "    </h5><p>" . T2T_Toolkit::truncate_string(strip_tags($post->post_excerpt), $description_length) . "</p>";
      $output .= "  </div>";
      $output .= "</div>";

      return $output;
    }
  }
}
?>