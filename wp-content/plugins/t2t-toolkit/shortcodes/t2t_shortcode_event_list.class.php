<?php
if(!class_exists('T2T_Shortcode_Event_List')) {
  /**
   * T2T_Shortcode_Event_List
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Event_List extends T2T_Custom_Shortcode
  {
    const SHORTCODE_ID    = "t2t_event_list";
  	const SHORTCODE_NAME  = "Event List";

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $data Initial values for this attribute
     */
    public function __construct($data = array()) {
      $data["id"]   = T2T_Event::get_name() . "_list";
      $data["name"] = T2T_Event::get_title() . __(" List", "t2t");

      // call parent constructor
      parent::__construct($data);
    }

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      // gather all the events created
      $event_result = new WP_Query(array(
        "post_type" => T2T_Event::get_name()
      ));

      // -1 in WP_Query refers to all items
      $to_show_array = array(-1 => __("All", "t2t"));

      // confirm posts exist
      if($event_result->found_posts > 0) {
        // in order to preserve the precious keys, manually construct
        // the rest of the options
        foreach(range(1, $event_result->found_posts) as $option) {
          $to_show_array[$option] = $option;
        }
      }

      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "posts_to_show",
        "name"        => "posts_to_show",
        "label"       => sprintf(__('Number of %1$s', 't2t'), T2T_Toolkit::pluralize(T2T_Event::get_title())),
        "description" => sprintf(__('Choose how many %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Event::get_title()))),
        "options"     => $to_show_array,
        "default"     => "-1"
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "posts_per_row",
        "name"        => "posts_per_row",
        "label"       => sprintf(__('Number of %1$s Per Row', 't2t'), T2T_Toolkit::pluralize(T2T_Event::get_title())),
        "description" => sprintf(__('Choose how many %1$s you\'d like displayed on each row.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Event::get_title()))),
        "options"     => array(1 => 1, 2, 3, 4), // specify first key to define index starting point of 1
        "default"     => (($event_result->found_posts < 4) ? $event_result->found_posts : 4)
      )));

      $terms = get_terms(strtolower(T2T_Event::get_name()) . "_categories");
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
          "description" => sprintf(__('Select a specific category to list %1$s for.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Event::get_title()))),
          "options"     => $categories,
          "prompt"      => __("Select a Category", "t2t")
        )));
      }

      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "description_length",
        "name"        => "description_length",
        "label"       => sprintf(__('%1$s Description Length', 't2t'), T2T_Event::get_title()),
        "description" => __("How many characters should be displayed before truncating.", "t2t"),
        "default"     => "100"
      )));

      // reset to main query
      wp_reset_postdata();

      $this->attributes = apply_filters("t2t_shortcode_event_list_fields", $this->attributes);
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

  		// allow modification to the query arguments
  		$filtered_options = apply_filters("t2t_shortcode_event_list_display_options", $options);

  		// query argument
  		$query_args = array(
  		  "post_type"      => T2T_Event::get_name(),
  		  "posts_per_page" => $options["posts_to_show"]
  		);

      if(isset($options["category"]) && trim($options["category"]) != "") {
        $category_query = array(
          "taxonomy" => strtolower(T2T_Event::get_name()) . "_categories",
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
  		$filtered_query_args = apply_filters("t2t_shortcode_event_list_query_args", $query_args, $filtered_options);

  		// query WP for our the events
  		$events_loop = new WP_Query($filtered_query_args);

  		// initialize the counter that will help determine the last item in a column
  		$i = 0;

  		// initialize the output
  		$output = "";

  		// initialize the output options
      $output_options = array_merge(array(
        "post_count" => $events_loop->found_posts
      ), $filtered_options);

      // loop through each event
  		while($events_loop->have_posts() ) {
  		  // wordpress scope, grab this post
  		  $events_loop->the_post();

  		  // increment the current position
  		  $i++;

  		  // determine classes for this position in the loop
  		  $classes = T2T_Toolkit::determine_loop_classes($events_loop->found_posts, $i, $filtered_options);

  		  $output_options = array_merge($output_options, array(
  		  	"classes"       => explode(" ", $classes),
  		  	"post_id"       => get_the_ID(),
  		  	"loop_position" => $i
  		  ));

  		  // allow modifcation to the markup
  		  $output .= apply_filters("t2t_shortcode_event_list_output", $this->handle_output($output_options, $content), $output_options, $content);
  		}

      // reset to main query
      wp_reset_postdata();

  		return apply_filters("t2t_shortcode_event_list_wrapper", $output, $output_options);
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

      // generate the markup
      $output  = "<div id=\"event_". $options["post_id"] ."\" class=\"article " . join(" ", $options["classes"]) . "\">";    
      $output .= "  <div class=\"event_content\"><h5>";
      $output .= "    " . $post->post_title;
      $output .= "    </h5><p>" . T2T_Toolkit::truncate_string(strip_tags($post->post_content), $description_length) . "</p>";
      $output .= "  </div>";
      $output .= "</div>";

      return $output;
    }
  }
}
?>