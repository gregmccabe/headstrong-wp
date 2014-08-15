<?php
/*
 * template-coaches.php
 *
 * This file supports the template-home.php template
 * by creating the metabox fields necessary to render
 * the admin panel options
 *
 */
function coaches_page_meta_boxes($meta_boxes) {
  // homepage template options
  $coaches_metabox = new T2T_MetaBox(array(
      "id"            => "template-coaches",
      "post_type"     => "page",
      "title"         => __("Coach Template Options", "t2t"),
      "location"      => "normal",
      "priority"      => "low",
  ));

  // use the same options the shortcode uses
  $program_list_sc = new T2T_Shortcode_Person_List();
  foreach($program_list_sc->get_attributes() as $att) {
    $coaches_metabox->add_field($att);
  }

  array_push($meta_boxes, $coaches_metabox);

  return $meta_boxes;
}
add_filter("t2t_page_meta_boxes", "coaches_page_meta_boxes");
?>