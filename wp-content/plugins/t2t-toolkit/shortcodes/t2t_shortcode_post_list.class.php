<?php
if(!class_exists('T2T_Shortcode_Post_List')) {
	/**
	 * T2T_Shortcode_Post_List
	 *
	 * @package T2T_Shortcode
	 */
	class T2T_Shortcode_Post_List extends T2T_Shortcode
	{
	  const SHORTCODE_ID    = "t2t_post_list";
		const SHORTCODE_NAME  = "Post List";

	  /**
	   * configure_attributes
	   *
	   * @since 1.0.0
	   */
	  public function configure_attributes() {
	  	// gather all the posts created
	    $post_result = new WP_Query(array(
	      "post_type" => "post"
	    ));

			// -1 in WP_Query refers to all items
	    $to_show_array = array(-1 => __("All", "t2t"));

      // confirm posts exist
      if($post_result->found_posts > 0) {
		    // in order to preserve the precious keys, manually construct
		    // the rest of the options
		    foreach(range(1, $post_result->found_posts) as $option) {
		      $to_show_array[$option] = $option;
		    }
		  }

	    array_push($this->attributes, new T2T_SelectHelper(array(
	      "id"          => "layout",
	      "name"        => "layout",
	      "label"       => __("Layout", "t2t"),
	      "description" => __("Choose how to display these posts.", "t2t"),
	      "options"     => array(
	      	"grid"      => __("Grid", "t2t"),
	      	"masonry"   => __("Masonry", "t2t"),
	      ),
	      "default"     => "grid"
	    )));
	    array_push($this->attributes, new T2T_SelectHelper(array(
	      "id"          => "show_featured_images",
	      "name"        => "show_featured_images",
	      "label"       => __("Show Featured Images?", "t2t"),
	      "description" => "Whether or not to show the featured image of each post.",
	      "options"     => array(
	      	"true"    => "Yes",
	      	"false"   => "No",
	      	"inherit" => "Value From Post"
	      ),
	      "default"     => "true"
	    )));
		  array_push($this->attributes, new T2T_SelectHelper(array(
		    "id"          => "posts_to_show",
		    "name"        => "posts_to_show",
		    "label"       => __("Number of Posts", "t2t"),
		    "description" => __("Choose how many posts you'd like displayed.", "t2t"),
		    "options"     => $to_show_array,
		    "default"     => "-1"
		  )));
		  array_push($this->attributes, new T2T_SelectHelper(array(
		    "id"          => "posts_per_row",
		    "name"        => "posts_per_row",
		    "label"       => __("Number of Posts Per Row", "t2t"),
		    "description" => __("Choose how many posts you'd like displayed on each row.", "t2t"),
		    "options"     => array(1 => 1, 2, 3, 4), // specify first key to define index starting point of 1
		    "default"     => (($post_result->found_posts < 4) ? $post_result->found_posts : 4)
		  )));
		  array_push($this->attributes, new T2T_TextHelper(array(
		    "id"          => "description_length",
		    "name"        => "description_length",
		    "label"       => __("Post Description Length", "t2t"),
		    "description" => __("How many characters should be displayed before truncating.", "t2t"),
		    "default"     => "100"
		  )));

		  $terms = get_terms("category");
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
		      "description" => sprintf(__('Select a specific category to list %1$s for.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Post::get_title()))),
		      "options"     => $categories,
		      "prompt"      => __("Select a Category", "t2t")
		    )));
		  }

		  // reset to main query
		  wp_reset_postdata();

	    $this->attributes = apply_filters("t2t_shortcode_post_list_fields", $this->attributes);
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
			$filtered_options = apply_filters("t2t_shortcode_post_list_display_options", $options);

			// query argument
			$query_args = array(
			  "post_type"      => "post",
			  "posts_per_page" => $options["posts_to_show"],
				"order"          => "DESC",
				"orderby"        => "date"
			);

			if(isset($options["category"]) && trim($options["category"]) != "") {
			  $category_query = array(
			    "taxonomy" => "category",
			    "field"    => "id",
			    "terms"    => $options["category"]
			  );

			  if(isset($query_args["tax_query"])) {
			    // if the key already exists append to it
			    array_push($query_args["tax_query"], $category_query);
			  }
			  else {
			    // otherwise add it
			    $query_args["tax_query"] = array($category_query);
			  }
			}

			if(isset($options["post_format"]) && trim($options["post_format"]) != "") {
			  $post_format_query = array(
			    "taxonomy" => "post_format",
			    "field"    => "slug",
			    "terms"    => "post-format-" . $options["post_format"]
			  );

			  if(isset($query_args["tax_query"])) {
			    // if the key already exists append to it
			    array_push($query_args["tax_query"], $post_format_query);
			  }
			  else {
			    // otherwise add it
			    $query_args["tax_query"] = array($post_format_query);
			  }
			}

			// allow modification to the query arguments
			$filtered_query_args = apply_filters("t2t_shortcode_post_list_query_args", $query_args, $filtered_options);

			// query WP for our the posts
			$posts_loop = new WP_Query($filtered_query_args);

			// initialize the counter that will help determine the last item in a column
			$i = 0;

			// initialize the output
			$output = "";

	    if($options["posts_to_show"] > 0) {
        $post_count = $options["posts_to_show"];
      }
      else {
        $post_count = $posts_loop->found_posts;
      }

  		// initialize the output options
      $output_options = array_merge(array(
        "post_count" => $post_count
      ), $filtered_options);

			// loop through each post
			while($posts_loop->have_posts()) {
			  // wordpress scope, grab this post
			  $posts_loop->the_post();

			  // increment the current position
			  $i++;

			  $classes = T2T_Toolkit::determine_loop_classes($posts_loop->found_posts, $i, $filtered_options);

  		  $output_options = array_merge($output_options, array(
  		  	"classes"       => explode(" ", $classes),
  		  	"post_id"       => get_the_ID(),
  		  	"loop_position" => $i
  		  ));

			  // allow modifcation to the markup
			  $output .= apply_filters("t2t_shortcode_post_list_output", $this->handle_output($output_options, $content), $output_options, $content);
			}

			// reset to main query
			wp_reset_postdata();

			return apply_filters("t2t_shortcode_post_list_wrapper", $output, $output_options);
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

			// initialize array to hold classes
			$classes = array();

			$html = "<div class=\"callout_box with_post " . join(" ", $options["classes"]) . "\">";

			// featured image (thumbnail) logic
			$thumbnail  = wp_get_attachment_image_src(get_post_thumbnail_id($options["post_id"]),'full');
			if(isset($thumbnail[0]) && $thumbnail[0] != "") {
				$alt_text   = get_post_meta(get_post_thumbnail_id($options["post_id"]), '_wp_attachment_image_alt', true);
				$image_html = "<img src=\"$thumbnail[0]\" class=\"callout_box_image\" alt=\"$alt_text\">";

				if(filter_var($show_featured_images, FILTER_VALIDATE_BOOLEAN)) {
				  $html .= "  " . $image_html;
				}
				else {
					if($show_featured_images == "inherit") {
						$show_featured_images = T2T_Toolkit::get_post_meta($options["post_id"], "show_featured_images", true, "true");

						if($show_featured_images == "true") {
						  $html .= "  " . $image_html;
						}
						else {
						  array_push($classes, "no_image");
						}
					}

				  array_push($classes, "no_image");
				}
			} else {
				array_push($classes, "no_image");
			}

			$html .= "  <div class=\"callout_box_content " . join(" ", $classes) . "\">";

			$title = "    <a href=\"" . get_permalink($options["post_id"]) . "\">" . $post->post_title . "</a>";

			if($options["posts_per_row"] == 1) {
				$html .= "    <h3>$title</h3>";
				$html .= "    <span class=\"date\">". get_the_time('F j, Y', $options["post_id"]) ."</span>";
			}
			elseif($options["posts_per_row"] == 2) {
				$html .= "    <h4>$title</h4>";
			}
			else {
				$html .= "    <h5>$title</h5>";
			}

			$html .= "    <p>" .  T2T_Toolkit::truncate_string(strip_tags($post->post_content), $options["description_length"]) . "</p>";
			$html .= "      <span class=\"author\">";
			$html .= "      <a href=\"" . get_author_posts_url($post->post_author) . "\">";
			$html .= "        <span class=\"typicons-pencil\"></span>";
			$html .= "        " . get_the_author_meta("display_name", $post->post_author);
			$html .= "      </a>";
			$html .= "    </span>";
			$html .= "    <span class=\"comments\">";
			$html .= "      <a href=\"" . get_comments_link($options["post_id"]) . "\">";
			$html .= "        <span class=\"typicons-messages\"></span>";
			$html .= "        " . get_comments_number($options["post_id"]);
			$html .= "      </a>";
			$html .= "    </span>";
			$html .= "  </div>";
			$html .= "</div>";

			return $html;
	  }
	}
}
?>