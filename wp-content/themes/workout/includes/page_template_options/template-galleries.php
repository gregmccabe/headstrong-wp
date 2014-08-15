<?php
/*
 * template-galleries.php
 *
 * This file supports the template-home.php template
 * by creating the metabox fields necessary to render
 * the admin panel options
 *
 */
function galleries_page_meta_boxes($meta_boxes) {
  // homepage template options
  $galleries_metabox = new T2T_MetaBox(array(
      "id"            => "template-galleries",
      "post_type"     => "page",
      "title"         => __("Galleries Template Options", "t2t"),
      "location"      => "normal",
      "priority"      => "low",
  ));

  // use the same options the shortcode uses
  $program_list_sc = new T2T_Shortcode_Album_List();
  foreach($program_list_sc->get_attributes() as $att) {
    $galleries_metabox->add_field($att);
  }

  array_push($meta_boxes, $galleries_metabox);

  return $meta_boxes;
}
add_filter("t2t_page_meta_boxes", "galleries_page_meta_boxes");
?>