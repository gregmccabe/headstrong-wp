<?php
/*
 * shortcodes.php
 *
 * This file exists as a place to take advantage
 * of the shortcode filters provided by the T2T_Toolkit plugin
 * that is required for this theme to function properly
 *
 */

/*
 * Gallery Shortcodes
 */
function highlighted_gallery_markup_wrapper($output, $options) {

	$html = "<section class=\"featured_gallery\">";
	$html .= "  <div class=\"container gallery\">";
    if(isset($options["title"]) && $options["title"] != "") {
        $shortcode = new T2T_Shortcode_Section_Title();
        $html .= $shortcode->handle_shortcode(array(
            "style" => "underline"
        ), $options["title"]);
    }
	$html .= "   <div class=\"jcarousel_wrapper\">";
	$html .= "    <div class=\"jcarousel\" data-columns=\"4\">";
	$html .= "      <ul>";
	$html .= 				$output;
	$html .= "      </ul>";
	$html .= "    </div>";
	$html .= "    <a class=\"jcarousel-prev jcarousel-nav\" href=\"javascript:;\"><span class=\"entypo-left-open-big\"></span></a>";
	$html .= "    <a class=\"jcarousel-next jcarousel-nav\" href=\"javascript:;\"><span class=\"entypo-right-open-big\"></span></a>";
	$html .= "   </div>";
	$html .= "  </div>";
	$html .= "</section>";

	return break_page_container($html, $options);
}
add_filter("t2t_shortcode_highlighted_gallery_wrapper", "highlighted_gallery_markup_wrapper", null, 2);

/*
 * Testimonial Shortcodes
 */
function highlighted_testimonial_list_markup_wrapper($output, $options) {

	$html = "<section class=\"featured_testimonials\">";
	$html .= "  <div class=\"container\">";
	$shortcode = new T2T_Shortcode_Section_Title();
	$html .= $shortcode->handle_shortcode(array(
		"style" => "underline"
	), $options["title"]);
	$html .= "    <div class=\"jcarousel\" data-columns=\"1\">";
	$html .= "      <ul>";
	$html .= 				$output;
	$html .= "      </ul>";
	$html .= "    </div>";
	$html .= "    <a class=\"jcarousel-prev jcarousel-nav\" href=\"javascript:;\"><span class=\"entypo-left-open-big\"></span></a>";
	$html .= "    <a class=\"jcarousel-next jcarousel-nav\" href=\"javascript:;\"><span class=\"entypo-right-open-big\"></span></a>";
	$html .= "  </div>";
	$html .= "</section>";

	return break_page_container($html, $options);

}
add_filter("t2t_shortcode_highlighted_testimonial_list_wrapper", "highlighted_testimonial_list_markup_wrapper", null, 2);

function testimonial_markup_wrapper($output, $options) {
	return "<div class=\"testimonials\"><ul>" . $output . "</ul></div>";
}
add_filter("t2t_shortcode_testimonial_wrapper", "testimonial_markup_wrapper", null, 2);

function testimonial_markup_output($output, $options) {
	// retrieve the post
	$post = get_post($options["post_id"]);

	// retrieve the testimonial image
	$image = wp_get_attachment_image(get_post_thumbnail_id($options["post_id"]), 'thumbnail');

	// retrieve the external_url provided by the user
	$url = T2T_Toolkit::get_post_meta($options["post_id"], 'external_url', true, null);
	if(!is_single()) {
		if(empty($url)){
			$url = get_permalink($options["post_id"]);
		}
	}

	$output  = "<li class=\"". join(" ", $options["classes"]) ."\">";
	$output .= "  <span class=\"testimonial\">";
	$output .= "    <span class=\"photo\">";
	if(has_post_thumbnail($options["post_id"])) {
		$output .= 				$image;
	} else {
		$output .= "      <span class=\"fontawesome-quote-left\"></span>";
	}
	$output .= "    </span>";
	$output .= "    <span class=\"content\">";
	$output .= T2T_Toolkit::truncate_string(strip_tags($post->post_content), $options["description_length"]);
	$output .= "    </span>";
	$output .= "    <span class=\"author\">";
	$output .= "    	<a href=\"" . $url . "\">" . $post->post_title . "</a>";
	$output .= "    </span>";
	$output .= "  </span>";
	$output .= "</li>";

	return $output;
}
add_filter("t2t_shortcode_testimonial_output", "testimonial_markup_output", null, 2);


/*
 * Post Shortcodes
 */
function post_list_fields($fields) {
	$post_formats = T2T_PostType::get_enabled_post_formats("T2T_Post");

	if(!empty($post_formats)) {
		array_push($fields, new T2T_SelectHelper(array(
			"id"          => "post_format",
			"name"        => "post_format",
			"label"       => __("Post Format", "t2t"),
			"description" => __("Select a specfic post format to display.", "t2t"),
			"options"     => $post_formats,
			"prompt"      => __("Select a Post Format", "t2t")
		)));
	}

	return $fields;
}
add_filter("t2t_shortcode_post_list_fields", "post_list_fields", null, 2);

function post_list_output($output, $options) {
    // retrieve the post
    $post = get_post($options["post_id"]);

	// retrieve the featured image for this portfolio

    if($options["posts_per_row"] == 1) {
    	$image = wp_get_attachment_image_src(get_post_thumbnail_id($options["post_id"]), 'large');
    } else {
    	$image = wp_get_attachment_image_src(get_post_thumbnail_id($options["post_id"]), 'medium');
    }

    // retrieve the external_url provided by the user
    $portfolio_url = get_permalink($options["post_id"]);

    $post_format = get_post_format($options["post_id"]);

    $post_class = join(" ", get_post_class('', $options["post_id"]));

    $post_title = "    <a href=\"" . get_permalink($options["post_id"]) . "\">" . $post->post_title . "</a>";

    $post_output = "";
    $thumbnail = "";

    // Quote
    if($post_format == "quote") {

    	$post_output .= "<article id=\"post-". $options["post_id"] ."\" class=\"". $post_class ."\">";
    	$post_output .= "	<div class=\"inner\">";
    	$post_output .= "		<span class=\"quote\">". get_the_content() ."</span>";
    	$post_output .= "		<span class=\"author\">". $post->post_title ."</span>";
    	$post_output .= "	</div>";
    	$post_output .= "</article>";

    // Aside
    } elseif($post_format == "aside") {

    	$wod_date = get_post_meta(get_the_ID(), "wod_date", true);
    	if(!isset($wod_date) || $wod_date == "") {
    		$wod_date = get_the_date();
    	}

    	$post_output .= "<div id=\"post-". $options["post_id"] ."\" class=\"". $post_class ."\">";
    	$post_output .= "  <div class=\"header\">";
    	$post_output .= "  	<span class=\"day\">". date("l", strtotime($wod_date)) ."</span>";
    	$post_output .= "    <span class=\"title\"><a href=\"" . get_permalink($options["post_id"]) . "\">". date(get_option("date_format"), strtotime($wod_date)) ."</a></span>";
    	$post_output .= "    <span class=\"subtitle\">". get_the_title() ."</span>";
    	$post_output .= "  </div>";
    	$post_output .= "  <div class=\"content\">";
    	$post_output .=      "	<p>" .  T2T_Toolkit::truncate_string(strip_tags($post->post_content), $options["description_length"]) . "</p>";
    	$post_output .= "  </div>";
    	$post_output .= "</div>";

    // Others
    } else {
    	$post_output .= "<article id=\"post-". $options["post_id"] ."\" class=\"". $post_class ."\">";
    		// Image
    		if($post_format == "image") {
    			if(has_post_thumbnail($options["post_id"])) {
  			    $thumbnail = "	<a href=\"" . get_permalink($options["post_id"]) . "\">";
  			    $thumbnail .= " 	<img src=\"" . $image[0] ."\" class=\"wp-post-image\" />";
  			    $thumbnail .= " </a>";
    			}
    		// Video
    	 	} elseif($post_format == "video") {
    	 		$thumbnail = "<div class=\"thumbnail_video_player\">";
    	 		if(get_post_meta(get_the_ID(), "video_url", true) != "") {
    	 			global $wp_embed;
    	 			$thumbnail .= $wp_embed->run_shortcode("[embed]". get_post_meta(get_the_ID(), "video_url", true) ."[/embed]");
    	 		} else {
    	 		  $thumbnail .= get_post_meta(get_the_ID(), "video_embed", true);
    	 		}
    	 		$thumbnail .= "</div>";
    	 	// Audio
    	 	} elseif($post_format == "audio") {
    	 		$thumbnail = "<div class=\"audio_player\">";
    	 		if(get_post_meta(get_the_ID(), "audio_url", true) != "") {
    	 			global $wp_embed;
    	 			$thumbnail .= $wp_embed->run_shortcode("[embed]". get_post_meta(get_the_ID(), "audio_url", true) ."[/embed]");
    	 		} else {
    	 			$thumbnail .= get_post_meta(get_the_ID(), "audio_embed", true);
    	 		}
    	 		$thumbnail .= "</div>";
    	 	} elseif($post_format == "gallery") {
    	 		// initialize options to send to t2t_get_gallery_images
    	 		$slider_options = array(
    	 		  "posts_to_show"  => -1,
    	 		  "posts_per_row"  => -1
    	 		);

    	 		// gather the images
    	 		$images = T2T_Toolkit::get_gallery_images(get_the_ID(), $slider_options);

    	 		if(!empty($images) && $images != "") {

  	 		    $thumbnail = "<div class=\"multi_image_thumbnail\">";
  	 		    $thumbnail .= "<div class=\"flexslider\" data-effect=\"". T2T_Toolkit::get_post_meta(get_the_ID(), "effect", true, "fade") ."\" data-autoplay=\"". T2T_Toolkit::get_post_meta(get_the_ID(), "autoplay", true, "true") ."\" data-interval=\"". T2T_Toolkit::get_post_meta(get_the_ID(), "interval", true, "5") ."\">";
  	 		    $thumbnail .= " <ul class=\"slides\">";
  	 		    foreach($images as $index => $image_id) {
  	 		      $image = wp_get_attachment_image($image_id, "medium");
  	 		      $thumbnail .= "<li>$image</li>";
  	 		    }
  	 		    $thumbnail .= " </ul>";
  	 		    $thumbnail .= "</div>";
  	 		    $thumbnail .= "</div>";
    	 		}
    	 	}

    	 	// Post
    	 	$post_output .= $thumbnail;

    	 	if(isset($thumbnail) && $thumbnail != "") {
	    	 	$post_output .= "<div class=\"callout_box_content\">";
    	 	} else {
    	 		$post_output  .= "<div class=\"callout_box_content no_image\">";
    	 	}

            if(filter_var($options['show_featured_images'], FILTER_VALIDATE_BOOLEAN)) {
                $post_output .= "     <img src=\"" . $image[0] ."\" class=\"wp-post-image\" />";
            }
    	 	$post_output .= "	<h3>$post_title</h3>";
    	 	$post_output .= "	<p>" .  T2T_Toolkit::truncate_string(strip_tags($post->post_content), $options["description_length"]) . "</p>";
    	 	$post_output .= "</div>";

    	$post_output .= "</article>";
    }

    $output = "<div class=\"callout_box with_post " . join(" ", $options["classes"]) . "\">";
    $output .= 	$post_output;
    $output .= "</div>";

    return $output;

}
add_filter("t2t_shortcode_post_list_output", "post_list_output", null, 2);

function highlighted_post_list_markup_wrapper($output, $options) {
	$shortcode = new T2T_Shortcode_Section_Title();
	$title = $shortcode->handle_shortcode(array(
		"style" => "underline"
	), $options["title"]);

	return "<div class=\"recent_blogs\">" . $title . $output . "</div>";
}
add_filter("t2t_shortcode_highlighted_post_list_wrapper", "highlighted_post_list_markup_wrapper", null, 2);

function post_list_markup_wrapper($output, $options) {
	return "<div class=\"post_list ". $options["layout"] ."\">" . $output . "</div>";
}
add_filter("t2t_shortcode_post_list_wrapper", "post_list_markup_wrapper", null, 2);


/*
 * Special Shortcodes
 */
function special_markup($output, $options) {
	// retrieve the post
	$post = get_post($options["special_id"]);

	$special_id = mt_rand(99, 999);

	// use featured image as background if supplied
	$background = "";
	if(has_post_thumbnail($options["special_id"])) {
		$image_id = get_post_thumbnail_id($options["special_id"]);
		$image_url = wp_get_attachment_image_src($image_id, 'large', true);
		$background = $image_url[0];
	}

	// retrieve the external_url provided by the user
	$special_url = T2T_Toolkit::get_post_meta($options["special_id"], 'special_external_url', true, get_permalink($options["special_id"]));

	// if an external_url was provided, set the link to open in a new window
	if(get_permalink($options["special_id"]) != $special_url) {
	  $target = "_blank";
	} else {
	  $target = "_self";
	}

	$content           = T2T_Toolkit::get_post_meta($options["special_id"], "content_excerpt", true, $post->post_content);
	$start_date        = get_post_meta($options["special_id"], "start_date", true);
	$end_date          = get_post_meta($options["special_id"], "end_date", true);
	$sash_text         = get_post_meta($options["special_id"], "sash_text", true);
	$promo_code        = get_post_meta($options["special_id"], "promo_code", true);
	$sash_color        = get_post_meta($options["special_id"], "sash_color", true);
	$button_text       = T2T_Toolkit::get_post_meta($options["special_id"], "button_text", true, sprintf(__('View %1$s', 't2t'), T2T_Special::get_title()));
	$button_color      = T2T_Toolkit::get_post_meta($options["special_id"], "button_color", true, "#e21b58");
	$button_text_color = T2T_Toolkit::get_post_meta($options["special_id"], "button_text_color", true, "#ffffff");

	$content_classes = array();

	$output  = "<div id=\"special-$special_id\" class=\"special backstretch\" data-background-image=\"". $background ."\">";

	if(isset($sash_text) && $sash_text != "") {
		$output .= "  <span class=\"sash\" style=\"background: $sash_color;\">";
		$output .= "  	<span class=\"inner\">";
		$output .= "  		" . $sash_text;
		$output .= "  	</span>";
		$output .= "  </span>";
	} else {
		$content_classes[] = "no_sash";
	}

	$output .= "  <span class=\"content ". join(" ", $content_classes) ."\">";

	$display_dates = array();
	$date_format = get_option("date_format");

	if(isset($start_date) && $start_date != "") {
		array_push($display_dates, date($date_format, strtotime($start_date)));
	}
	if(isset($end_date) && $end_date != "") {
		array_push($display_dates, date($date_format, strtotime($end_date)));
	}

	if(!empty($display_dates)) {
		$output .= "  	<span class=\"date\">" . join(" - ", $display_dates) . "</span>";
	}

	$output .= "  	<span class=\"excerpt\">" . T2T_Toolkit::truncate_string(strip_tags($content), $options["description_length"]) . "</span>";

	if(isset($promo_code) && $promo_code != "") {
		$output .= "  	<span class=\"code\">Code: <b>" . $promo_code . "</b></span>";
	}

	// only show the button if were not viewing the single special
	if(get_post_type() != T2T_Special::get_name()) {
        // retrieve the button_post_id provided by the user, default to the special (self)
        $special_post_id = T2T_Toolkit::get_post_meta($options["special_id"], 'button_post_id', true, $options["special_id"]);

        // get the permalink of th above specified id
        $special_url = get_permalink($special_post_id);

        // retrieve the external_url provided by the user, defaulting to the above defined
        $special_url = T2T_Toolkit::get_post_meta($options["special_id"], 'external_url', true, $special_url);

		$output .= "<a href=\"" . $special_url . "\" class=\"button three-dimensional medium\">" . $button_text . "</a>";
	}

	$output .= "  </span>";
	$output .= "  <span class=\"shade\"></span>";
	$output .= " </div>";

	$output .= "<style type=\"text/css\">";
	$output .= "#special-$special_id .button {";
	$output .= "	background: $button_color;";
	$output .= "	color: $button_text_color;";
	$output .= "}";
	$output .= "</style>";

	return $output;

}
add_filter("t2t_shortcode_special_output", "special_markup", null, 2);


/*
 * Album Shortcodes
 */
function album_markup($output, $options) {
	// throw an exception if post_id is not provided
	if(!isset($options["post_id"])) {
		throw new InvalidArgumentException(__("A post_id is required to render a album.", "t2t"));
	}

  // image details
  $large_image    = wp_get_attachment_image_src($options["post_id"], 'full');

  // make sure the image is valid
  if(empty($large_image)) {
  	return;
  }

  $post = get_post($options["post_id"]);

  $image_file = wp_get_attachment_image($options["post_id"], 'medium');
  if($options["posts_per_row"] == 1) {
  	$image_file = wp_get_attachment_image($options["post_id"], 'full');
  }

  $title = "";
  if($post->post_excerpt != "") {
  	$title .= "<h3>". $post->post_excerpt ."</h3>";
  }
  if($post->post_content != "") {
  	$title .= "<p>". $post->post_content ."</p>";
  }

    // override output completely rather than appending to it
    $output = "";

    $output .= "<div class=\"wall_entry " . join(" ", $options["classes"]) . "\">";
    $output .= "       ". $image_file;
    $output .= "       <span class=\"hover\"><span class=\"icons\">";
    $output .= "       	<a href=\"" . $large_image[0] . "\" class=\"entypo-search fancybox\" title=\"" . get_post($options["post_id"])->post_excerpt . "\" rel=\"album_". $options["album_id"] ."\"></a>";
    // $output .= "       	<a href=\"". get_attachment_link($options["post_id"]) ."\" class=\"entypo-link\"></a>";
    $output .= "			 </span></span>";
    $output .= "</div>";

  	return $output;

}
add_filter("t2t_shortcode_album_output", "album_markup", null, 2);

function album_markup_wrapper($output, $options) {
	$html = "<div class=\"gallery\">";
	$html .= $output;
	$html .= "</div>";

	return $html;
}
add_filter("t2t_shortcode_album_wrapper", "album_markup_wrapper", null, 2);

function album_list_markup($output, $options) {
	// retrieve the post
	$post = get_post($options["post_id"]);

	// retrieve the featured image for this album
	$image = wp_get_attachment_image_src(get_post_thumbnail_id($options["post_id"]), 'medium');

	// if not featured image is present
	if(empty($image)) {
	  // make sure there are images int he album
	  if(sizeof($options["image_ids"]) > 0) {
	    // retrieve a random image from the album
	    $random_key = array_rand($options["image_ids"], 1);
	    $image = wp_get_attachment_image_src($options["image_ids"][$random_key], 'medium');
	  }
	}

	// if the user has selected to display the filters
	if(filter_var($options["show_category_filter"], FILTER_VALIDATE_BOOLEAN)) {
		// gather the categories
		$terms = wp_get_post_terms($options["post_id"], strtolower(T2T_Album::get_name()) . "_categories");

		if(!empty($terms)) {
			// pull out just the slug
			$slugs = wp_list_pluck($terms, "slug");

			foreach($slugs as $slug) {
				// append the appropriate class to the classes array
				array_push($options["classes"], "term_" . $slug);
			}
		}
	}

	$output  = "<div class=\"element " . join(" ", $options["classes"]) . "\" data-album-id=\"album_" . $options["post_id"] . "\">";
	$output .= "	<a href=\"" . get_permalink($options["post_id"]) . "\">";
	$output .= "	  <img src=\"" . $image[0] ."\" />";
	$output .= "	</a>";
	$output .= "	<div class=\"caption\">";
	$output .= "		<div class=\"inner\">";
	$output .= "			<h5><a href=\"" . get_permalink($options["post_id"]) . "\" class=\"title\">" . $post->post_title . "</a></h5>";
	$output .= "			<p>" . T2T_Toolkit::truncate_string(strip_tags($post->post_content), $options["description_length"]) . "</p>";
	$output .= "		</div>";
	$output .= "	</div>";
	$output .= "</div>";

	return $output;
}
add_filter("t2t_shortcode_album_list_output", "album_list_markup", null, 2);

function album_list_markup_wrapper($output, $options) {
	$classes = array();

	if(isset($options["post_count"]) && $options["post_count"] > 0) {

		$before_output = "<div class=\"galleries\">\n";

		// if the user has selected to display the filters
		if(!isset($options["category"]) && filter_var($options["show_category_filter"], FILTER_VALIDATE_BOOLEAN)) {
			$terms = wp_get_object_terms(array_keys($options["all_image_ids"]), strtolower(T2T_Album::get_name()) . "_categories");

			if(!empty($terms)) {
				// remove duplicates
				$terms = array_unique($terms, SORT_REGULAR);

				$before_output .= "<ul class=\"filter_list\">\n";
				$before_output .= "<li><a href=\"javascript:;\" class=\"active\" data-filter=\"*\">". __('All', 'framework') ."</a><span class=\"separator\">/</span></li>";

				// create entry for each term
				foreach($terms as $term) {
	      	$before_output .= "<li><a href=\"javascript:;\" data-filter=\".term_" . $term->slug . "\">" . $term->name . "</a><span class=\"separator\">/</span></li>";
				}

				$before_output .= "</ul>\n";
				array_push($classes, 'with_filters');
			}
		} else {
			array_push($classes, "without_filters");
		}

		$output = $before_output . "<div class=\"filter_content ". join(' ', $classes) ."\">" . $output . "</div></div>";
	}

	return $output;
}
add_filter("t2t_shortcode_album_list_wrapper", "album_list_markup_wrapper", null, 2);

function album_shortcode_fields($fields) {

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

	$fields = array();

  array_push($fields, new T2T_SelectHelper(array(
    "id"          => "album_id",
    "name"        => "album_id",
    "label"       => sprintf(__('%1$s', 't2t'), T2T_Album::get_title()),
    "description" => sprintf(__('Choose the %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Album::get_title())),
    "options"     => $album_list
  )));
   array_push($fields, new T2T_SelectHelper(array(
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
  array_push($fields, new T2T_SelectHelper(array(
    "id"          => "posts_to_show",
    "name"        => "posts_to_show",
    "label"       => __("Number of Images", "t2t"),
    "description" => __("Choose how many images you'd like displayed.", "t2t"),
    "options"     => $to_show_array,
    "default"     => "-1"
  )));
  array_push($fields, new T2T_SelectHelper(array(
    "id"          => "posts_per_row",
    "name"        => "posts_per_row",
    "label"       => __("Number of Images Per Row", "t2t"),
    "description" => __("Choose how many images you'd like displayed on each row.", "t2t"),
    "options"     => array(2 => 2, 3, 4), // specify first key to define index starting point of 1
    "default"     => 2
  )));

	return $fields;

}
add_filter("t2t_shortcode_album_fields", "album_shortcode_fields");

function album_list_shortcode_fields($fields) {
  $terms = get_terms(strtolower(T2T_Album::get_name()) . "_categories");

	$default_show_filters = true;

	// only show the filter if there are 2 or more, otherwise what would you be filtering?
	if(!empty($terms) && sizeof($terms) > 1 && !array_key_exists("errors", $terms)) {
		$default_show_filters = false;
	}

	array_push($fields, new T2T_SelectHelper(array(
		"id"          => "show_category_filter",
		"name"        => "show_category_filter",
		"label"       => __("Show Category Filter?", "t2t"),
    "description" => sprintf(__('Whether or not to include a list of categories that will allow visitors to filter your %1$s.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Album::get_title()))),
		"options"     => array(
			"true"  => __("Yes", "t2t"),
			"false" => __("No", "t2t")
		),
		"default"     => $default_show_filters
	)));

  return $fields;
}
add_filter("t2t_shortcode_album_list_fields", "album_list_shortcode_fields");

/*
 * Program Shortcodes
 */
function program_list_shortcode_fields($fields) {
  $fields = array();

  $service_result = new WP_Query(array(
    "posts_per_page" => -1,
    "post_type"      => T2T_Service::get_name()
  ));

  $to_show_array = array(-1 => __("All", "t2t"));

  // initialize the index and option counter
	$i = 0;

	// create a standard array to pass as options
	while($service_result->have_posts()) {
		$service_result->the_post();

		// increment index and option counter
		$i++;

		// add the index as an option
		$to_show_array[$i] = $i;
	}

	// reset to main query
	wp_reset_postdata();

	array_push($fields, new T2T_SelectHelper(array(
    "id"          => "posts_to_show",
    "name"        => "posts_to_show",
    "label"       => sprintf(__('Number of %1$s', 't2t'), T2T_Toolkit::pluralize(T2T_Service::get_title())),
    "description" => sprintf(__('Choose how many %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Service::get_title()))),
    "options"     => $to_show_array,
    "default"     => "-1"
  )));
  array_push($fields, new T2T_SelectHelper(array(
    "id"          => "posts_per_row",
    "name"        => "posts_per_row",
    "label"       => sprintf(__('Number of %1$s Per Row', 't2t'), T2T_Toolkit::pluralize(T2T_Service::get_title())),
    "description" => sprintf(__('Choose how many %1$s you\'d like displayed on each row.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Service::get_title()))),
    "options"     => array(1 => 1, 2, 3), // specify first key to define index starting point of 1
    "default"     => (($service_result->found_posts < 3) ? $service_result->found_posts : 3)
  )));

  array_push($fields, new T2T_TextHelper(array(
    "id"          => "description_length",
    "name"        => "description_length",
    "label"       => sprintf(__('%1$s Description Length', 't2t'), T2T_Service::get_title()),
    "description" => __("How many characters should be displayed before truncating.", "t2t"),
    "default"     => "100"
  )));

  $terms = get_terms(strtolower(T2T_Service::get_name()) . "_categories");
  if(!empty($terms) && !array_key_exists("errors", $terms)) {
    $terms = array_unique($terms, SORT_REGULAR);

    $categories = array();

    foreach($terms as $term) {
      $categories[$term->term_id] = $term->name;
    }

    array_push($fields, new T2T_SelectHelper(array(
      "id"          => "category",
      "name"        => "category",
      "label"       => __("Category", "t2t"),
      "description" => sprintf(__('Select a specific category to list %1$s for.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Service::get_title()))),
      "options"     => $categories,
      "prompt"      => __("Select a Category", "t2t")
    )));
  }


  return $fields;

}
add_filter("t2t_shortcode_service_list_fields", "program_list_shortcode_fields");


function program_list_markup($output, $options) {
	// retrieve the post
	$post = get_post($options["post_id"]);

	$thumbnail = get_the_post_thumbnail(get_the_ID(), "thumbnail");

    // retrieve the external_url provided by the user
    $program_url = T2T_Toolkit::get_post_meta($options["post_id"], 'service_external_url', true, get_permalink($options["post_id"]));

	// generate the markup
	$output  = "<article id=\"service_". $options["post_id"] ."\" class=\"program " . join(" ", $options["classes"]) . "\">";
	if($thumbnail) {
		$output .= "<div class=\"thumbnail\">". get_the_post_thumbnail(get_the_ID(), "thumbnail") ."</div>";
	} else {
		$output .= "<div class=\"icon_thumbnail\"><span class=\"". get_post_meta(get_the_ID(), "service_icon", true) ."\"></span></div>";
	}

	$output .= "  <div class=\"inner\"><span class=\"program_title\">";
	$output .= "    <a href=\"" . get_permalink() . "\" class=\"service_title\">" . $post->post_title . "</a>";
	$output .= "    </span><p>" . T2T_Toolkit::truncate_string(strip_tags($post->post_content), $options["description_length"]) . "</p>";
	$output .= "  </div>";
	$output .= "	<div class=\"hover\">";
	$output .= "		<div class=\"buttons\">";
	$output .= "			<a href=\"". $program_url ."\" class=\"outlined_button\">". __("Learn More", "t2t") ."</a>";
	$output .= "		</div>";
	$output .= "	</div>";
	$output .= "</article>";

	return $output;

}
add_filter("t2t_shortcode_service_list_output", "program_list_markup", null, 2);

function program_list_wrapper($output, $options) {
	$title = get_post_meta(get_the_ID(), "programs_title", true);

	$shortcode = new T2T_Shortcode_Section_Title();
	$wrapper = $shortcode->handle_shortcode(array(
		"style" => "underline"
	), $title);

	return $wrapper . $output;
}
add_filter("t2t_shortcode_service_list_wrapper", "program_list_wrapper", null, 2);


/*
 * Location Shortcodes
 */
function location_wrapper($output, $options) {
	$html = "</div></section><section class=\"location\"><div class=\"container\">";

	$shortcode = new T2T_Shortcode_Section_Title();
	$wrapper = $shortcode->handle_shortcode(array(
		"style" => "underline"
	), $options["title"]);

	$html .= $wrapper . $output;

	return $html;


}
add_filter("t2t_shortcode_location_wrapper", "location_wrapper", null, 2);


/*
 * Coach Shortcodes
 */
function person_list_markup($output, $options) {

	$post = get_post($options["post_id"]);

	$image = wp_get_attachment_image(get_post_thumbnail_id($options["post_id"]), 'thumbnail');

	$title = get_post_meta($options["post_id"], "title", true);

	$social_links = array(
		"twitter"   => array(
			"rounded"  => "entypo-twitter-circled",
			"href"     => get_post_meta($options["post_id"], "twitter", true)
		),
		"facebook"  => array(
			"rounded"  => "entypo-facebook-circled",
			"href"     => get_post_meta($options["post_id"], "facebook", true)
		),
		"flickr"    => array(
			"rounded"  => "entypo-flickr-circled",
			"href"     => get_post_meta($options["post_id"], "flickr", true)
		),
		"vimeo"     => array(
			"rounded"  => "entypo-vimeo-circled",
			"href"     => get_post_meta($options["post_id"], "vimeo", true)
		),
		"pinterest" => array(
			"rounded"  => "entypo-pinterest-circled",
			"href"     => get_post_meta($options["post_id"], "pinterest", true)
		),
		"email"     => array(
			"rounded"  => "typicons-at",
			"href"     => "mailto:".get_post_meta($options["post_id"], "email", true)
		)
	);

	$output  = "<div id=\"person_". $options["post_id"] ."\" class=\"coach_box " . join(" ", $options["classes"]) . "\">";
	$output .= "	<div class=\"inner\">";
	$output .= "  <a href=\"" . get_permalink($options["post_id"]) ."\">" . $image . "</a>";
	$output .= " 	 	<span class=\"title\"><a href=\"" . get_permalink($options["post_id"]) ."\">" . $post->post_title . "</a></span>";
	if(isset($title) && $title != "") {
		$output .= "  	<span class=\"role\">$title</span>";
	}
	$output .= "    <p>" . T2T_Toolkit::truncate_string($post->post_content, $options["description_length"]) . "</p>";

	$social = "";
	foreach($social_links as $site => $settings) {
		// only include the link if a url was provided
		if(!empty($settings["href"]) && $settings["href"] != "" && $settings["href"] != "mailto:") {
			$social .= "<li><a href=\"" . $settings["href"] . "\" title=\"" . $site . "\" target=\"_blank\"><span class=\"" . $settings["rounded"] . "\"></span></a></li>";
		}
	}

	if(isset($social) && $social != "") {
		$output .= "<ul class=\"social square_round\">$social</ul>";
	}
	$output .= "</ul>";
	$output .= "	</div>";
	$output .= "</div>";

	return $output;
}
add_filter("t2t_shortcode_person_list_output", "person_list_markup", null, 2);


function person_list_wrapper($output, $options) {
	return "<div class=\"coach_list\">$output</div>";
}
add_filter("t2t_shortcode_person_list_wrapper", "person_list_wrapper", null, 2);


/*
 * Slit Slider Shortcodes
 */
function slit_slider_markup($output, $options, $content) {
	$slider_id = mt_rand(99, 999);

	$show_title         = get_post_meta($options["post_id"], 'show_title', true);
	$alignment          = get_post_meta($options["post_id"], 'alignment', true);
	$orientation        = get_post_meta($options["post_id"], 'orientation', true);
	$slice1_rotation    = get_post_meta($options["post_id"], 'slice_1_rotation', true);
	$slice1_scale       = get_post_meta($options["post_id"], 'slice_1_scale', true);
	$slice2_rotation    = get_post_meta($options["post_id"], 'slice_2_rotation', true);
	$slice2_scale       = get_post_meta($options["post_id"], 'slice_2_scale', true);
	$title_color        = get_post_meta($options["post_id"], 'title_color', true);
	$caption_color      = get_post_meta($options["post_id"], 'caption_color', true);
	$post_id            = get_post_meta($options["post_id"], 'button_post_id', true);
	$button_text        = get_post_meta($options["post_id"], 'button_text', true);
	$button_color       = get_post_meta($options["post_id"], 'button_color', true);
	$button_text_color  = get_post_meta($options["post_id"], 'button_text_color', true);
	$image              = wp_get_attachment_image_src(get_post_thumbnail_id(), "large");

  // override output completely rather than appending to it
  $html = "";

	$html .= "<div id=\"slit-slider-$slider_id\" class=\"sl-slide\" data-orientation=\"" . $orientation . "\" data-slice1-rotation=\"" . $slice1_rotation . "\" data-slice2-rotation=\"" . $slice2_rotation . "\" data-slice1-scale=\"" . $slice1_scale . "\" data-slice2-scale=\"" . $slice2_scale . "\">";
	$html .= "	<div class=\"sl-slide-inner\">";
	$html .= "		<div class=\"bg-img\" data-background=\"" . $image[0] . "\"></div>";
	$html .= "		<div class=\"slide-content\">";

	if(filter_var($show_title, FILTER_VALIDATE_BOOLEAN)) {
		$html .= "			<span class=\"title\">" . get_the_title() . "</span>";
	}

	$html .= "      <span class=\"caption\">" . get_the_content() . "</span>";
	$html .= "			" . get_slider_button_markup($post_id, $button_text);
	$html .= "		</div>";
	$html .= "	</div>";
	$html .= "</div>";

	$html .= "<style type=\"text/css\">";
	$html .= "#slit-slider-" . $slider_id." .title {";
	if(isset($title_color) && $title_color != "") { $html .= "  color: " . $title_color." !important;"; }
	if(isset($alignment) && $alignment != "") { $html .= "  text-align: " . $alignment." !important;"; }
	$html .= "}";
	$html .= "#slit-slider-" . $slider_id." .caption {";
	if(isset($caption_color) && $caption_color != "") { $html .= "  color: " . $caption_color." !important;"; }
	if(isset($alignment) && $alignment != "") { $html .= "  text-align: " . $alignment." !important;"; }
	$html .= "}";
	$html .= "#slit-slider-" . $slider_id . " .link {";
	if(isset($button_color) && $button_color != "") { $html .= "  background: " . $button_color . " !important;"; }
	if(isset($button_text_color) && $button_text_color != "") { $html .= "  color: " . $button_text_color . " !important;"; }
	if(isset($alignment) && $alignment != "") { $html .= "  float: " . $alignment . " !important;"; }
	$html .= "}";
	$html .= "</style>";

	return $html;
}
add_filter("t2t_shortcode_slitslider_output", "slit_slider_markup", null, 3);

// function slitslider_markup_wrapper($output, $options) {
// 	// if full width was selected we need to break the container
// 	if($options["width"] == "full" && $options["post_count"] > 0) {
// 		return break_page_container($output, $options);
// 	}
// 	else {
// 		return $output;
// 	}
// }
// add_filter("t2t_shortcode_slitslider_wrapper", "slitslider_markup_wrapper", null, 2);

function slit_slider_empty_author_markup($markup) {
	$markup .= get_empty_author_markup("T2T_SlitSlider", "http://docs.t2themes.com/crossfit/#slit-slider-2");

	return $markup;
}
add_filter("t2t_shortcode_slitslider_empty_author_output", "slit_slider_empty_author_markup");


/*
 * Elastic Slider Shortcodes
 */
function elasticslider_markup($output, $options, $content) {
	$album = get_post_meta($options["post_id"], 'album_id', true);
	$slider_id = mt_rand(99, 999);

	$image = wp_get_attachment_image_src(get_post_thumbnail_id(), "large");

	$show_title         = get_post_meta($options["post_id"], 'show_title', true);
	$alignment          = get_post_meta($options["post_id"], 'alignment', true);
	$title_color        = get_post_meta($options["post_id"], 'title_color', true);
	$caption_color      = get_post_meta($options["post_id"], 'caption_color', true);
	$controls_color     = get_post_meta($options["post_id"], 'controls_color', true);
	$post_id            = get_post_meta($options["post_id"], 'button_post_id', true);
	$button_text        = get_post_meta($options["post_id"], 'button_text', true);
	$button_color       = get_post_meta($options["post_id"], 'button_color', true);
	$button_text_color  = get_post_meta($options["post_id"], 'button_text_color', true);

  // override output completely rather than appending to it
  $html = "";

	$html .= "<li id=\"elastic-slider-$slider_id\" class=\"controls-$controls_color\">";
	$html .= "	<img src=\"" . $image[0] . "\" alt=\"" . get_the_title() . "\">";
	$html .= "	<div class=\"slide-content\">";

	if(filter_var($show_title, FILTER_VALIDATE_BOOLEAN)) {
		$html .= "	  <span class=\"title\">" . get_the_title() . "</span>";
	}

	$html .= "	  <span class=\"caption\">" . get_the_content() . "</span>";
	$html .= "		" . get_slider_button_markup($post_id, $button_text);
	$html .= "	</div>";
	$html .= "</li>";

	$html .= "<style type=\"text/css\">";
	$html .= "#elastic-slider-" . $slider_id." .title {";
	if(isset($title_color) && $title_color != "") { $html .= "  color: " . $title_color." !important;"; }
	if(isset($alignment) && $alignment != "") { $html .= "  text-align: " . $alignment." !important;"; }
	$html .= "}";
	$html .= "#elastic-slider-" . $slider_id." .caption {";
	if(isset($caption_color) && $caption_color != "") { $html .= "  color: " . $caption_color." !important;"; }
	if(isset($alignment) && $alignment != "") { $html .= "  text-align: " . $alignment." !important;"; }
	$html .= "}";
	$html .= "#elastic-slider-" . $slider_id . " .link {";
	if(isset($button_color) && $button_color != "") { $html .= "  background: " . $button_color . " !important;"; }
	if(isset($button_text_color) && $button_text_color != "") { $html .= "  color: " . $button_text_color . " !important;"; }
	if(isset($alignment) && $alignment != "") { $html .= "  float: " . $alignment . " !important;"; }
	$html .= "}";
	$html .= "</style>";

	return $html;
}
add_filter("t2t_shortcode_elasticslider_output", "elasticslider_markup", null, 3);

function elastic_slider_empty_author_markup($markup) {
	$markup .= get_empty_author_markup("T2T_SlitSlider", "http://docs.t2themes.com/crossfit/#elastic-slider-2");

	return $markup;
}
add_filter("t2t_shortcode_elasticslider_empty_author_output", "elastic_slider_empty_author_markup");

// function elasticslider_markup_wrapper($output, $options) {
// 	// if full width was selected we need to break the container
// 	if($options["width"] == "full") {
// 		return break_page_container($output, $options);
// 	}
// 	else {
// 		return $output;
// 	}
// }
// add_filter("t2t_shortcode_elasticslider_wrapper", "elasticslider_markup_wrapper", null, 2);

/*
 * Flex Slider Shortcodes
 */
function flexslider_markup_output($output, $options) {

	$slider_id = mt_rand(99, 999);

  // retrieve the post
  $post = get_post($options["post_id"]);
  $post_format = get_post_format($options["post_id"]);

	$image           = wp_get_attachment_image(get_post_thumbnail_id(), "large");
	$image_src       = wp_get_attachment_image_src(get_post_thumbnail_id(), "large");

	$show_title         = get_post_meta($options["post_id"], 'show_title', true);
	$alignment          = get_post_meta($options["post_id"], 'alignment', true);
	$title_color        = get_post_meta($options["post_id"], 'title_color', true);
	$caption_color      = get_post_meta($options["post_id"], 'caption_color', true);
	$controls_color     = get_post_meta($options["post_id"], 'controls_color', true);
	$post_id            = get_post_meta($options["post_id"], 'button_post_id', true);
	$button_text        = get_post_meta($options["post_id"], 'button_text', true);
	$button_color       = get_post_meta($options["post_id"], 'button_color', true);
	$button_text_color  = get_post_meta($options["post_id"], 'button_text_color', true);

	if(isset($options["height"]) && $options["height"] != "") {
		$height = $options["height"];
	} else {
		$height = $image_src[2];
	}

	if($post_format == "video") {
		$output  = "<li class=\"flexslider-$slider_id\">";
		if(get_post_meta(get_the_ID(), "video_url", true) != "") {
      global $wp_embed;
      $output .= $wp_embed->run_shortcode("[embed]". get_post_meta(get_the_ID(), "video_url", true) ."[/embed]");
		} else {
			$output .= get_post_meta(get_the_ID(), "video_embed", true);
		}
		$output .= "</li>";
	} else {
		$output  = "<li class=\"flexslider-$slider_id\" data-image=\"". $image_src[0] ."\" style=\"height: ". $height ."px;\">";
		$output .= "<div class=\"slide-content\">";
		if(filter_var($show_title, FILTER_VALIDATE_BOOLEAN)) {
			$output .= "	<span class=\"title\">" . get_the_title() . "</span>";
		}
		$output .= "	<span class=\"caption\">" . get_the_content() . "</span>";
		$output .= "	" . get_slider_button_markup($post_id, $button_text);
		$output .= "</div>";
		$output .= "</li>";
	}

	$output .= "<style type=\"text/css\">";
	$output .= ".flexslider-" . $slider_id." .title {";
	if(isset($title_color) && $title_color != "") { $output .= "  color: " . $title_color." !important;"; }
	if(isset($alignment) && $alignment != "") { $output .= "  text-align: " . $alignment." !important;"; }
	$output .= "}";
	$output .= ".flexslider-" . $slider_id." .caption {";
	if(isset($caption_color) && $caption_color != "") { $output .= "  color: " . $caption_color." !important;"; }
	if(isset($alignment) && $alignment != "") { $output .= "  text-align: " . $alignment." !important;"; }
	$output .= "}";
	$output .= ".flexslider-" . $slider_id . " .link {";
	if(isset($button_color) && $button_color != "") { $output .= "  background: " . $button_color . " !important;"; }
	if(isset($button_text_color) && $button_text_color != "") { $output .= "  color: " . $button_text_color . " !important;"; }
	if(isset($alignment) && $alignment != "") { $output .= "  float: " . $alignment . " !important;"; }
	$output .= "}";
	$output .= "</style>";

  return $output;

}
add_filter("t2t_shortcode_flexslider_output", "flexslider_markup_output", null, 2);

// function flexslider_markup_wrapper($output, $options) {
// 	// if full width was selected we need to break the container
// 	if($options["width"] == "full") {
// 		return break_page_container($output, $options);
// 	}
// 	else {
// 		return $output;
// 	}
// }
// add_filter("t2t_shortcode_flexslider_wrapper", "flexslider_markup_wrapper", null, 2);


/*
 * Callout banners
 */
function callout_banner_wrapper($output, $options) {
	return break_page_container($output, $options);
}
add_filter("t2t_shortcode_callout_banner_wrapper", "callout_banner_wrapper", null, 2);


/*
 * Page sections
 */
function page_section_wrapper($output, $options) {

	// Break page container
	$html = "</div></section>";

	$html .= "<section style=\"padding-left: 0; padding-right: 0;\">";
	$html .= 			$output;
	$html .= "</section>";

	// Reopen page container
	$html .= "<section><div class=\"container\">";

	return $html;

}
add_filter("t2t_shortcode_page_section_wrapper", "page_section_wrapper", null, 2);

function page_section_fields($fields) {

	$fields = array();

	array_push($fields, new T2T_TextAreaHelper(array(
	  "id"    => "content",
	  "name"  => "content",
	  "label" => __("Content", "t2t")
	)));
	array_push($fields, new T2T_UploadHelper(array(
	  "id"    => "background_image",
	  "name"  => "background_image",
	  "label" => __("Background Image", "t2t")
	)));
	array_push($fields, new T2T_TextHelper(array(
	  "id"          => "background_color",
	  "name"        => "background_color",
	  "class"       => "t2t-color-picker",
	  "label"       => __("Background Color", "t2t"),
	  "description" => __("Choose a solid color instead of an image.", "t2t"),
	  "default"     => "#444444"
	)));
	array_push($fields, new T2T_SelectHelper(array(
	  "id"      => "background_repeat",
	  "name"    => "background_repeat",
	  "label"   => __("Background Style", "t2t"),
	  "options" => array(
	    "no-repeat top left"       => __("No Repeat (Left Aligned)", "t2t"),
	    "no-repeat top center"     => __("No Repeat (Center Aligned)", "t2t"),
	    "no-repeat top right"      => __("No Repeat (Right Aligned)", "t2t"),
	    "repeat"                   => __("Tile", "t2t"),
	    "repeat-x"                 => __("Tile Horizontally", "t2t"),
	    "repeat-y"                 => __("Tile Vertically", "t2t")
	  ),
	  "default" => "repeat"
	)));
	array_push($fields, new T2T_TextHelper(array(
	  "id"          => "min_height",
	  "name"        => "min_height",
	  "label"       => __("Minimum Height (in pixels)", "t2t"),
	  "description" => __("Set the minimum height for this section.", "t2t"),
	  "default"     => "200"
	)));
	array_push($fields, new T2T_TextHelper(array(
	  "id"          => "padding_top",
	  "name"        => "padding_top",
	  "label"       => __("Top Padding (in pixels)", "t2t"),
	  "default"     => "35"
	)));
	array_push($fields, new T2T_TextHelper(array(
	  "id"          => "padding_bottom",
	  "name"        => "padding_Bottom",
	  "label"       => __("Bottom Padding (in pixels)", "t2t"),
	  "default"     => "35"
	)));

	return $fields;
}
add_filter("t2t_shortcode_page_section_fields", "page_section_fields");

/**
 * break_page_container
 *
 * @since 1.0.0
 *
 * @param string $output Markup generated by the shortcode
 * @param array $options options selected by user for this shortcode
 *
 * @return HTML representing a break in the markup
 */
function break_page_container($output, $options) {
	$wrapper  = "</div></section>";
	$wrapper .= $output;
	$wrapper .= "<section><div class=\"container\">";

	return $wrapper;
}

/**
 * get_slider_button_markup
 *
 * @since 1.1.0
 *
 * @param string $post_id Post to link the button to
 * @param string $button_text Text to appear on the button
 *
 * @return HTML representing a break in the markup
 */
function get_slider_button_markup($post_id, $button_text) {
	// can't do much without a link
	if($post_id > 0) {
		// get the permalink to the post provided
		$url = get_permalink($post_id);

		if($button_text == "") {
			// gather information for default button text
			$post_type        = get_post_type($post_id);
			$post_type_object = get_post_type_object($post_type);

			// make sure a post type was found
			if(isset($post_type_object)) {
				$button_text = sprintf(__('View %1$s', 't2t'), $post_type_object->labels->singular_name);
			}
			else {
				$button_text = __("View", "t2t");
			}
		}

		// return the button markup
		return "<a href=\"" . $url . "\" class=\"link\">" . $button_text . "</a>";
	}
	else {
		return "";
	}
}

/**
 * get_empty_author_markup
 *
 * @since 1.2.0
 *
 * @param string $class_name Class name used to get post type link
 * @param string $help_url URL to help docs
 *
 * @return HTML representing a break in the markup
 */
function get_empty_author_markup($class_name, $help_url = "") {
	$post_type_obj = get_post_type_object(call_user_func(array($class_name, "get_name")));

	$markup  = "  <div class=\"author_instructions\">";
	$markup .= "    <p>" . sprintf(__('You have not created a %1$s yet, in order to display correctly you\'ll need at least 1 %2$s.', 't2t'), $post_type_obj->labels->singular_name, $post_type_obj->labels->singular_name) . "</p>";

	if($help_url !== "") {
		$shortcode = new T2T_Shortcode_Button();
		$markup .= $shortcode->handle_shortcode(array(
			"size"             => "medium",
			"background_color" => "#85ca75",
			"icon"             => "fontawesome-question-sign",
			"style"            => "three-dimensional",
			"target"           => "_blank",
			"url"              => $help_url
		), __("Get Help", "t2t"));

		$markup .= " ";
	}

	$shortcode = new T2T_Shortcode_Button();
	$markup .= $shortcode->handle_shortcode(array(
		"size"             => "medium",
		"background_color" => "#21759b",
		"icon"             => "fontawesome-plus-sign",
		"style"            => "three-dimensional",
		"target"           => "_blank",
		"url"              => home_url(). "/wp-admin/post-new.php?post_type=" . call_user_func(array($class_name, "get_name"))
	), sprintf(__('%1$s &rarr;', 't2t'), $post_type_obj->labels->add_new));

	$markup .= "  </div>";

	return $markup;
}

?>