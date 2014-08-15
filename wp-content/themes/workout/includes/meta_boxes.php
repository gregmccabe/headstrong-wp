<?php
/*
 * Post MetaBox Fields
 */
function aside_post_format_fields($fields) {
  array_push($fields, new T2T_DatePickerHelper(array(
      "id"          => "wod_date",
      "name"        => "wod_date",
      "label"       => __("Date", "t2t"),
      "description" => __("Date this WOD will be programmed.", "t2t"),
      "class"       => "post-format-aside"
    )));

  return $fields;
}
add_filter("t2t_post_format_aside_fields", "aside_post_format_fields");


/*
 * Album MetaBox Fields
 */
function album_meta_box_fields($fields) {
  $fields = array(
    new T2T_SelectHelper(array(
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
    )),
    new T2T_SelectHelper(array(
      "id"          => "album_photos_per_row",
      "name"        => "album_photos_per_row",
      "label"       => __("Number of Photos Per Row", "t2t"),
      "description" => sprintf(__('Choose how many photos you\'d like displayed on each row of this %1$s.', 't2t'), strtolower(T2T_Album::get_title())),
      "options"     => array(2 => 2, 3, 4), // specify first key to define index starting point of 1
      "default"     => 3
    )),
    new T2T_SelectHelper(array(
      "id"          => "allow_comments",
      "name"        => "allow_comments",
      "label"       => __("Allow Comments", "t2t"),
      "description" => sprintf(__('Allow comments to be posted on photos in this %1$s.', 't2t'), strtolower(T2T_Album::get_title())),
      "options"     => array(
        "true"  => __("Yes", "t2t"), 
        "false" => __("No", "t2t")),
      "default"     => "false"
    )));


  $fields = array_merge(get_subtitle_fields(), $fields);

  return $fields;
}
add_filter("t2t_album_core_meta_box_fields", "album_meta_box_fields");


/*
 * Page MetaBox Fields
 */
function page_meta_box_fields($fields) {
  $fields = array_merge(get_subtitle_fields(), $fields);

  array_push($fields, new T2T_SelectHelper(array(
    "id"          => "enable_carousel",
    "name"        => "enable_carousel",
    "label"       => __("Enable Carousel", "t2t"),
    "description" => __("Enable floating carousel for this page.", "t2t"),
    "options"     => array(
      "true"  => __("Yes", "t2t"), 
      "false" => __("No", "t2t")),
    "default"     => "false"
  )));

  return $fields;
}
add_filter("t2t_page_core_meta_box_fields", "page_meta_box_fields");


/*
 * Program MetaBox Fields
 */
function program_meta_box_fields($fields) {
  $fields = array_merge(get_subtitle_fields(), $fields);

  array_push($fields, new T2T_SelectHelper(array(
    "id"          => "show_schedule",
    "name"        => "show_schedule",
    "label"       => __("Show Schedule", "t2t"),
    "description" => sprintf(__('Whether or not to show the schedule for this %1$s.', 't2t'), strtolower(T2T_Service::get_title())),
    "options"     => array(
      "true"  => __("Yes", "t2t"), 
      "false" => __("No", "t2t")),
    "default"     => "true"
  )));
  array_push($fields, new T2T_TextHelper(array(
    "id"          => "accent_color",
    "name"        => "accent_color",
    "class"       => "t2t-color-picker",
    "label"       => __("Accent Color", "t2t"),
    "description" => sprintf(__('Color to use for displaying this %1$s.', 't2t'), strtolower(T2T_Service::get_title())),
    "default"     => "#444444"
  )));

  return $fields;
}
add_filter("t2t_service_core_meta_box_fields", "program_meta_box_fields");

function service_meta_boxes($meta_boxes) {
  array_push($meta_boxes, new T2T_MetaBox_Schedule(array(
    "post_type" => T2T_Service::get_name()
  )));

  return $meta_boxes;
}
add_filter("t2t_service_meta_boxes", "service_meta_boxes");


/*
 * SlitSlider MetaBox Fields
 */
function slitslider_meta_box_fields($fields) {
  $fields = array_merge($fields, get_slider_button_fields());

  return $fields;
}
add_filter("t2t_slitslider_core_meta_box_fields", "slitslider_meta_box_fields");

/*
 * ElasticSlider MetaBox Fields
 */
function elasticslider_meta_box_fields($fields) {
  $fields = array_merge($fields, get_slider_button_fields());

  return $fields;
}
add_filter("t2t_elasticslider_core_meta_box_fields", "elasticslider_meta_box_fields");

/*
 * Flexlider MetaBox Fields
 */
function flexslider_meta_box_fields($fields) {
  $fields = array_merge($fields, get_slider_button_fields());

  return $fields;
}
add_filter("t2t_flexslider_core_meta_box_fields", "flexslider_meta_box_fields");


/**
 * get_slider_button_fields
 *
 * @since 1.1.0
 *
 * @return Array of fields
 */
function get_slider_button_fields() {

  $fields = array(
    new T2T_SelectHelper(array(
      "id"          => "button_post_id",
      "name"        => "button_post_id",
      "label"       => __("Button Post", "t2t"),
      "description" => __("Choose a post you'd like to link to", "t2t"),
      "prompt"      => __("Select a Post", "t2t")
    )),
    new T2T_TextHelper(array(
      "id"          => "button_text",
      "name"        => "button_text",
      "label"       => __("Button Text", "t2t"),
      "description" => __("Text to display on the button. <b>Default: </b> \"View _PostType_\"", "t2t")
    )),
    new T2T_TextHelper(array(
      "id"          => "button_color",
      "name"        => "button_color",
      "label"       => __("Button Color", "t2t"),
      "description" => __("Background color of the button", "t2t"),
      "class"       => "t2t-color-picker",
      "default"     => get_theme_mod("t2t_customizer_accent_color", "#e21b58")
    )),
    new T2T_TextHelper(array(
      "id"          => "button_text_color",
      "name"        => "button_text_color",
      "label"       => __("Button Text Color", "t2t"),
      "description" => __("Text color of the button", "t2t"),
      "class"       => "t2t-color-picker",
      "default"     => "#ffffff"
    ))
  );

  return $fields;
}


/**
 * get_subtitle_fields
 *
 * @since 2.0.0
 *
 * @return Array of fields
 */
function get_subtitle_fields() {
  $fields = array(
    new T2T_TextHelper(array(
      "id"          => "subtitle",
      "name"        => "subtitle",
      "label"       => __("Subtitle", "t2t"),
      "description" => __("Text to display under the title.", "t2t")
    ))
  );

  return $fields;
}
?>