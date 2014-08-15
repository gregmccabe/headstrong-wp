T2T Toolkit
===========

Core Functionality
------------------

- t2t_toolkit_enabled_post_types

Example:

```
function enable_t2t_post_types($post_types) {
  array_push($post_types, new T2T_Page());
  array_push($post_types, new T2T_Album());
  array_push($post_types, new T2T_Service(array(
    "args" => array(
      "supports" => array("title", "editor")
    )
  )));
  array_push($post_types, new T2T_Testimonial());

  return $post_types;
}

add_filter('t2t_toolkit_enabled_post_types', 'enable_t2t_post_types');

```

- t2t_toolkit_enabled_shortcodes

1. Create a class that defines the shortcode
```
/**
 * T2T_Shortcode_One_Seventh
 *
 * @package T2T_Shortcode
 */
class T2T_Shortcode_One_Seventh extends T2T_Shortcode
{
	const SHORTCODE_ID    = "one_seventh";
	const SHORTCODE_NAME  = "One Seventh (1/7)";

	/**
	 * configure_attributes
	 */
	public function configure_attributes() {
		array_push($this->attributes, new T2T_TextAreaHelper(array(
			"id"    => "content",
			"name"  => "content",
			"label" => __("Content", "t2t")
		)));
	}

	/**
	 * handle_shortcode
	 *
	 * @param array $options HTML representation of this shortcode
	 *
	 * @return HTML representing this shortcode
	 */
	public function handle_output($atts, $content = null) {
	  return "<div class=\"one_seventh\">" . do_shortcode($content) . "</div>";
	}
}
```

2. Include the file within functions.php
```
require_once(get_template_directory()  . '/includes/t2t_shortcode_one_seventh.class.php');
```

3. Instantiate the shortcode and add it to the filter
```
function add_theme_shortcodes($meta_boxes) {
	array_push($meta_boxes, new T2T_Shortcode_One_Seventh());

	return $meta_boxes;
}
add_filter("t2t_toolkit_enabled_shortcodes", "add_theme_shortcodes");
```

- t2t_post_type_album_name
- t2t_post_type_elasticslider_name
- t2t_post_type_service_name
- t2t_post_type_slitslider_name
- t2t_post_type_testimonial_name

Example:

```
function rename_album_name($current) {
	return "t2t_gallery";
}
add_filter("t2t_post_type_album_name", "rename_album_name");
```

- t2t_post_type_album_title
- t2t_post_type_elasticslider_title
- t2t_post_type_service_title
- t2t_post_type_slitslider_title
- t2t_post_type_testimonial_title

Example:

```
function rename_album_title($current) {
	return "Gallery";
}
add_filter("t2t_post_type_album_title", "rename_album_title");
```


Shortcodes
----------

- t2t_shortcode_testimonial_output
- t2t_shortcode_service_output
- t2t_shortcode_album_output
- t2t_shortcode_album_list_output
- t2t_shortcode_slitslider_output
- t2t_shortcode_elasticslider_output
- t2t_shortcode_post_list_output

Example: 

```
function testimonial_markup($output, $options) {
	// throw an exception if post_id is not provided
	if(!isset($options["post_id"])) {
		throw new InvalidArgumentException("A post_id is required to render a testimonial.");
	}

	// retrieve the post
	$post = get_post($options["post_id"]);

	// retrieve the testimonial image
	$image = wp_get_attachment_image(get_post_thumbnail_id($options["post_id"]), 'thumbnail');

	// retrieve the external_url provided by the user
	$external_url = T2T_Toolkit::get_post_meta($options["post_id"], 'testimonial_external_url', true, null);

	// generate the markup
	$output  = "<div class=\"" . join(" ", $options["classes"]) . "\">";    
	$output .= "  " . $image;
	$output .= "  <div class=\"content\">";

	if(empty($external_url)){
		$output .= "    <p>" . T2T_Toolkit::truncate_string(strip_tags($post->post_content), $options["description_length"]) . "</p>";
	}
	else {
		$output .= "    <p><a href=\"" . $external_url . "\" target=\"_blank\">" . T2T_Toolkit::truncate_string(strip_tags($post->post_content), $options["description_length"]) . "</a></p>";
	}

	$output .= "    <span class=\"author\">- " . $post->post_title . "</span>";
	$output .= "  </div>";
	$output .= "</div>";

	return $output;
}
add_filter("t2t_shortcode_testimonial_output", "testimonial_markup", null, 2);

```

- t2t_shortcode_service_list_query_args
- t2t_shortcode_testimonial_list_query_args
- t2t_shortcode_album_query_args
- t2t_shortcode_album_list_query_args
- t2t_shortcode_slitslider_query_args
- t2t_shortcode_elasticslider_query_args

Example:

```
// include example
```

- t2t_shortcode_service_wrapper
- t2t_shortcode_testimonial_wrapper
- t2t_shortcode_album_wrapper
- t2t_shortcode_album_list_wrapper
- t2t_shortcode_slitslider_wrapper
- t2t_shortcode_elasticslider_wrapper
- t2t_shortcode_post_list_wrapper

Example: 

```
function album_markup_wrapper($output) {
	return "<div class=\"albums\">" . $output . "</div>";
}
add_filter("t2t_shortcode_album_list_wrapper", "album_markup_wrapper");
```

- t2t_shortcode_service_list_display_options
- t2t_shortcode_testimonial_list_display_options
- t2t_shortcode_album_display_options
- t2t_shortcode_album_list_display_options
- t2t_shortcode_slitslider_display_options
- t2t_shortcode_elasticslider_display_options

Example:

```
// include example
```

- t2t_shortcode_service_list_fields
- t2t_shortcode_testimonial_list_fields
- t2t_shortcode_album_fields
- t2t_shortcode_album_list_fields
- t2t_shortcode_slitslider_fields
- t2t_shortcode_elasticslider_fields
- t2t_shortcode_post_list_fields

Example:

```
function album_list_shortcode_fields($fields) {
	array_push($fields, new T2T_SelectHelper(array(
    "id"          => "thumbnail_hover_style",
    "name"        => "thumbnail_hover_style",
    "label"       => __("Thumbnail Hover Style", "framework"),
    "description" => sprintf(__('Choose the hover style you\'d like to use for the %1$s thumbnails.', 't2t'), strtolower(T2T_Album::get_title())),
    "options"     => array(
      "default"            => __("Default", "framework"), 
      "caption_overlay"    => __("Caption Overlay", "framework"),
      "scroller"           => __("Thumbnail Scroller", "framework")),
    "default"     => "default"
  )));

  return $fields;
}
add_filter("t2t_shortcode_album_list_fields", "album_list_shortcode_fields");
```


Meta Boxes
----------------

- t2t_service_core_meta_box_fields
- t2t_testimonial_core_meta_box_fields
- t2t_album_core_meta_box_fields
- t2t_slitslider_core_meta_box_fields

Example:

```
function add_slitslider_meta_box_fields($fields) {
	// gather all the services created
  $album_result = new WP_Query(array(
	  "post_type" => T2T_Album::get_name(), 
	  "orderby"   => "title", 
	  "order"     => "asc"
  ));

  // instantiate an array for select options
  $album_list = array();

  // loop through each of the albums
  while ($album_result->have_posts()) {
    $album_result->the_post();

    // add to the checkboxes options array
    $album_list[get_the_id()] = get_the_title();
  }

  if(!empty($album_list)) {
    array_push($fields, new T2T_SelectHelper(array(
      "id"          => "album_id",
      "name"        => "album_id",
      "label"       => sprintf(__('%1$s', 't2t'), T2T_Album::get_title()),
      "description" => sprintf(__('Choose the %1$s you\'d like to link to.', 't2t'), strtolower(T2T_Album::get_title())),
      "options"     => $album_list,
      "prompt"      => "No " . T2T_Album::get_title()
    )));
  }

  return $fields;
}
add_filter("t2t_slitslider_core_meta_box_fields", "add_slitslider_meta_box_fields");
```


Widgets
-------------

- t2t_widget_service_list_fields
- t2t_widget_gallery_fields

Example: 

```
function add_service_list_widget_options($fields) {
	array_push($fields, new T2T_SelectHelper(array(
		"id"          => "show_icon",
		"name"        => "show_icon",
		"label"       => "Show Icon?",
		"description" => "Whether or not to show the icon associated with the service in the list.",
		"options"     => array(
			"false" => "No",
			"true" => "Yes"
		),
		"default"     => "1"
	)));

	return $fields;
}
add_filter("t2t_widget_service_list_fields", "add_service_list_widget_options");
```

- t2t_widget_service_list_output
- t2t_widget_gallery_output

Example:

```
function service_list_widget_output($current_markup, $instance) {
	$markup = array();

	array_push($markup, "<div class=\"services\">");
  array_push($markup, "<ul>");

  $services_loop = new WP_Query(array(
    "post_type"      => T2T_Service::get_name()
  ));

  while($services_loop->have_posts() ) {
    // wordpress scope, grab this post
    $services_loop->the_post();
    
    $external_url = T2T_Toolkit::get_post_meta(get_the_id(), 'service_external_url', true, get_permalink());

    if(get_permalink() != $external_url) {
      $target = "_blank";
    } 
    else {
      $target = "_self";      
    }
    
    array_push($markup, "<li>");
    array_push($markup, "<a href=\"" . T2T_Toolkit::get_post_meta(get_the_id(), 'service_external_url', true, get_permalink()) . "\" target=\"" . $target . "\">" . T2T_Toolkit::display_icon(get_post_meta(get_the_id(), 'service_icon', true)) . get_the_title() . "</a>");
    array_push($markup, "</li>");
  }
  
  array_push($markup, "</ul>");
  array_push($markup, "</div>");

  return join("\n", $markup);
}
add_filter("t2t_widget_service_list_output", "service_list_widget_output", null, 2);
```
