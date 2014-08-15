<?php
if(!class_exists('T2T_Testimonial')) {
  /**
   * T2T_Testimonial
   *
   * @package T2T_PostType
   */
  class T2T_Testimonial extends T2T_PostType 
  {    
    const POST_TYPE_NAME  = "t2t_testimonial";
    const POST_TYPE_TITLE = "Testimonial";

    // custom post type icons
    public $page_icon = "testimonials-page-icon";
    public $menu_icon = "testimonials-menu-icon";

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_testimonial_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_testimonial_title", self::POST_TYPE_TITLE);
    }

    /**
     * configure_meta_boxes
     *
     * @since 1.0.0
     */
    public function configure_meta_boxes() {
      $meta_boxes = array();
      $metabox = new T2T_MetaBox(array(
        "post_type" => T2T_Testimonial::get_name(),
        "title"     => T2T_Testimonial::get_title() . __(" Options", "t2t")
      ));

      $fields = array(
  	    new T2T_TextHelper(array(
  	      "id"          => "external_url",
  	      "name"        => "external_url",
  	      "label"       => __("External URL", "t2t"),
          "description" => sprintf(__('Link this service to an external URL instead of it\'s %1$s page.', 't2t'), strtolower(T2T_Testimonial::get_title()))
  	    ))
     	);

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_testimonial_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      $meta_boxes = apply_filters("t2t_testimonial_meta_boxes", $meta_boxes);

      return $meta_boxes;
    }

    /**
     * configure_shortcodes
     *
     * @since 1.0.0
     *
     * @param array $shortcodes
     */
    public function configure_shortcodes($shortcodes) {
      array_push($shortcodes, "T2T_Shortcode_Testimonial_List");
      
      return $shortcodes;
    }
  }
}
?>