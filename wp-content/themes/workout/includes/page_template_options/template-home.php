<?php
/*
 * template-home.php
 *
 * This file supports the template-home.php template
 * by creating the metabox fields necessary to render
 * the admin panel options
 *
 */
function home_page_meta_boxes($meta_boxes) {
  // homepage template options
  $homepage_metabox = new T2T_MetaBox(array(
      "id"            => "template-home",
      "post_type"     => T2T_Page::get_name(),
      "title"         => __("Home Template Options", "t2t"),
      "location"      => "normal",
      "priority"      => "low",
  ));

  $slider_field_group = new T2T_MetaBoxFieldGroup(array(
    "title" => __("Slider", "t2t")
  ));

  $slider_field_group->add_field(new T2T_SelectHelper(array(
    "id"          => "slider",
    "name"        => "slider",
    "label"       => __("Page Slider", "t2t"),
    "description" => __("Select which, if any, slider you'd like on this page", "t2t"),
    "options"     => array(
      "none"                        => "None",
      T2T_SlitSlider::get_name()    => T2T_SlitSlider::get_title(),
      T2T_ElasticSlider::get_name() => T2T_ElasticSlider::get_title(),
      T2T_FlexSlider::get_name()    => T2T_FlexSlider::get_title()
    ),
    "default"     => "none"
  )));

  $homepage_metabox->add_field_group($slider_field_group);

  /*
   * album fields
   */
  $album_field_group = new T2T_MetaBoxFieldGroup(array(
    "title" => sprintf(__('%1$s Carousel', 't2t'), T2T_Album::get_title())
  ));

  $album_field_group->add_field(new T2T_SelectHelper(array(
    "id"          => "show_albums",
    "name"        => "show_albums",
    "label"       => __("Enable Section", "t2t"),
    "description" => __("Select No to hide this section from the template.", "t2t"),
    "class"       => "enabled_field_group",
    "options" => array(
      "true"  => __("Yes", "t2t"),
      "false" => __("No", "t2t")
    ),
    "default"     => "true"
  )));

  // use the same options the shortcode uses
  $album_list_sc = new T2T_Shortcode_Highlighted_Gallery();
  foreach($album_list_sc->get_attributes("album") as $att) {
    $album_field_group->add_field($att);
  }

  $homepage_metabox->add_field_group($album_field_group);

  /*
   * testimonial fields
   */
  $testimonial_field_group = new T2T_MetaBoxFieldGroup(array(
    "title" => sprintf(__('%1$s Carousel', 't2t'), T2T_Testimonial::get_title())
  ));

  $testimonial_field_group->add_field(new T2T_SelectHelper(array(
    "id"          => "show_testimonials",
    "name"        => "show_testimonials",
    "label"       => __("Enable Section", "t2t"),
    "description" => __("Select No to hide this section from the template.", "t2t"),
    "class"       => "enabled_field_group",
    "options" => array(
      "true"  => __("Yes", "t2t"),
      "false" => __("No", "t2t")
    ),
    "default"     => "true"
  )));

  // use the same options the shortcode uses
  $testimonial_list_sc = new T2T_Shortcode_Highlighted_Testimonial_List();
  foreach($testimonial_list_sc->get_attributes("testimonials") as $att) {
    $testimonial_field_group->add_field($att);
  }

  $homepage_metabox->add_field_group($testimonial_field_group);

  /*
   * highlighted post fields
   */
  $post_field_group = new T2T_MetaBoxFieldGroup(array(
    "title" => sprintf(__('%1$s List', 't2t'), T2T_Post::get_title())
  ));

  $post_field_group->add_field(new T2T_SelectHelper(array(
    "id"          => "show_posts",
    "name"        => "show_posts",
    "label"       => __("Enable Section", "t2t"),
    "description" => __("Select No to hide this section from the template.", "t2t"),
    "class"       => "enabled_field_group",
    "options" => array(
      "true"  => __("Yes", "t2t"),
      "false" => __("No", "t2t")
    ),
    "default"     => "true"
  )));

  // use the same options the shortcode uses
  $post_list_sc = new T2T_Shortcode_Highlighted_Post_List();
  foreach($post_list_sc->get_attributes("posts") as $att) {
    $post_field_group->add_field($att);
  }

  $homepage_metabox->add_field_group($post_field_group);

  /*
   * program list fields
   */
  $program_field_group = new T2T_MetaBoxFieldGroup(array(
    "title" => sprintf(__('%1$s List', 't2t'), T2T_Service::get_title())
  ));

  $program_field_group->add_field(new T2T_SelectHelper(array(
    "id"          => "show_programs",
    "name"        => "show_programs",
    "label"       => __("Enable Section", "t2t"),
    "description" => __("Select No to hide this section from the template.", "t2t"),
    "class"       => "enabled_field_group",
    "options" => array(
      "true"  => __("Yes", "t2t"),
      "false" => __("No", "t2t")
    ),
    "default"     => "true"
  )));

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

  $program_field_group->add_field(new T2T_TextHelper(array(
    "id"          => "programs_title",
    "name"        => "programs_title",
    "label"       => __("Title", "t2t"),
    "description" => __("Leave blank to not display a title.", "t2t")
  )));
  $program_field_group->add_field(new T2T_SelectHelper(array(
    "id"          => "programs_posts_to_show",
    "name"        => "programs_posts_to_show",
    "label"       => sprintf(__('Number of %1$s', 't2t'), T2T_Toolkit::pluralize(T2T_Service::get_title())),
    "description" => sprintf(__('Choose how many %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Service::get_title()))),
    "options"     => $to_show_array,
    "default"     => "-1"
  )));
  $program_field_group->add_field(new T2T_SelectHelper(array(
    "id"          => "programs_posts_per_row",
    "name"        => "programs_posts_per_row",
    "label"       => sprintf(__('Number of %1$s Per Row', 't2t'), T2T_Toolkit::pluralize(T2T_Service::get_title())),
    "description" => sprintf(__('Choose how many %1$s you\'d like displayed on each row.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Service::get_title()))),
    "options"     => array(1 => 1, 2, 3), // specify first key to define index starting point of 1
    "default"     => (($service_result->found_posts < 3) ? $service_result->found_posts : 3)
  )));

  $program_field_group->add_field(new T2T_TextHelper(array(
    "id"          => "programs_description_length",
    "name"        => "programs_description_length",
    "label"       => sprintf(__('%1$s Description Length', 't2t'), T2T_Service::get_title()),
    "description" => __("How many characters should be displayed before truncating.", "t2t"),
    "default"     => "100"
  )));

  // reset to main query
  wp_reset_postdata();

  $homepage_metabox->add_field_group($program_field_group);

  /*
   * location fields
   */
  $location_field_group = new T2T_MetaBoxFieldGroup(array(
    "title" => __("Location", "t2t")
  ));

  $location_field_group->add_field(new T2T_SelectHelper(array(
    "id"          => "show_location",
    "name"        => "show_location",
    "label"       => __("Enable Section", "t2t"),
    "description" => __("Select No to hide this section from the template.", "t2t"),
    "class"       => "enabled_field_group",
    "options" => array(
      "true"  => __("Yes", "t2t"),
      "false" => __("No", "t2t")
    ),
    "default"     => "true"
  )));

  // use the same options the shortcode uses
  $location_list_sc = new T2T_Shortcode_Location();
  foreach($location_list_sc->get_attributes("location") as $att) {
    $location_field_group->add_field($att);
  }

  $homepage_metabox->add_field_group($location_field_group);

  array_push($meta_boxes, $homepage_metabox);

  return $meta_boxes;
}
add_filter("t2t_page_meta_boxes", "home_page_meta_boxes");
?>