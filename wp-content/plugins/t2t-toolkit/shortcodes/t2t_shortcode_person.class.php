<?php
if(!class_exists('T2T_Shortcode_Person')) {
  /**
   * T2T_Shortcode_Person
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Person extends T2T_Custom_Shortcode
  {
    const SHORTCODE_ID    = "t2t_person";
  	const SHORTCODE_NAME  = "Person";

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $data Initial values for this attribute
     */
    public function __construct($data = array()) {
      $data["id"]   = T2T_Person::get_name();
      $data["name"] = T2T_Person::get_title();

      // call parent constructor
      parent::__construct($data);
    }

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
    	// gather all the people created
      $person_result = new WP_Query(array(
        "post_type" => T2T_Person::get_name()
      ));

  		// -1 in WP_Query refers to all items
      $to_show_array = array(-1 => __("All", "t2t"));

      // list of people for attribute
      $person_list = array();

      // initialize the index and option counter
  		$i = 0;

  		// create a standard array to pass as options
      while($person_result->have_posts()) { 
        $person_result->the_post();

        // increment index and option counter
        $i++;
        
        // add the index as an option
        $to_show_array[$i] = $i;

        // append this person to the array
        $person_list[get_the_ID()] = get_the_title();
      }

      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "person_id",
        "name"        => "person_id",
        "label"       => sprintf(__('%1$s', 't2t'), T2T_Person::get_title()),
        "description" => sprintf(__('Choose the %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Person::get_title())),
        "options"     => $person_list
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "description_length",
        "name"        => "description_length",
        "label"       => sprintf(__('%1$s Description Length', 't2t'), T2T_Person::get_title()),
        "description" => __("How many characters should be displayed before truncating.", "t2t"),
        "default"     => "100"
      )));

      // reset to main query
      wp_reset_postdata();

      $this->attributes = apply_filters("t2t_shortcode_person_fields", $this->attributes);
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
      $output = apply_filters("t2t_shortcode_person_output", $this->handle_output($options, $content), $options, $content);

      return apply_filters("t2t_shortcode_person_wrapper", $output, $options);
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
      $post = get_post($person_id);

      // retrieve the external_url provided by the user
      $person_url = T2T_Toolkit::get_post_meta($person_id, 'person_external_url', true, get_permalink($person_id));

      // if an external_url was provided, set the link to open in a new window
      if(get_permalink($person_id) != $person_url) {
        $target = "_blank";
      } else {
        $target = "_self";      
      }

      // generate the markup
      $output  = "<div id=\"person_". $person_id ."\" class=\"article full\">";    
      $output .= "  <div class=\"person_content\"><h5>";
      $output .= "    <a href=\"" . $person_url . "\" target=\"" . $target . "\" class=\"person_icon\">";
      $output .= "      " . T2T_Toolkit::display_icon(get_post_meta($person_id, 'person_icon', true));
      $output .= "    </a>";
      $output .= "    <a href=\"" . $person_url . "\" target=\"" . $target . "\" class=\"person_title\">" . $post->post_title . "</a>";
      $output .= "    </h5><p>" . T2T_Toolkit::truncate_string(strip_tags($post->post_content), $description_length) . "</p>";
      $output .= "  </div>";
      $output .= "</div>";

      return $output;
    }
  }
}
?>