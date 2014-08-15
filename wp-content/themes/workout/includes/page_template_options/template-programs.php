<?php
/*
 * template-programs.php
 *
 * This file supports the template-home.php template
 * by creating the metabox fields necessary to render
 * the admin panel options
 *
 */
function programs_page_meta_boxes($meta_boxes) {
  // homepage template options
  $programs_metabox = new T2T_MetaBox(array(
      "id"            => "template-programs",
      "post_type"     => "page",
      "title"         => __("Progam Template Options", "t2t"),
      "location"      => "normal",
      "priority"      => "low",
  ));

  // use the same options the shortcode uses
  $program_list_sc = new T2T_Shortcode_Service_List();
  foreach($program_list_sc->get_attributes() as $att) {
    $programs_metabox->add_field($att);
  }

  array_push($meta_boxes, $programs_metabox);

  return $meta_boxes;
}
add_filter("t2t_page_meta_boxes", "programs_page_meta_boxes");
?>