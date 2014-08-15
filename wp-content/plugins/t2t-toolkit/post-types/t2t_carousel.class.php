<?php
if(!class_exists('T2T_Carousel')) {
  /**
   * T2T_Carousel
   *
   * @package T2T_PostType
   */
  class T2T_Carousel extends T2T_PostType_Slider
  {    
    const POST_TYPE_NAME  = "t2t_carousel";
    const POST_TYPE_TITLE = "Carousel";

    // custom post type icons
    public $page_icon = "carousel-page-icon";
    public $menu_icon = "carousel-menu-icon";

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_carousel_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_carousel_title", self::POST_TYPE_TITLE);
    }

    /**
     * configure_meta_boxes
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function configure_meta_boxes() {
      $meta_boxes = array();
      $metabox = new T2T_MetaBox(array(
        "post_type" => T2T_Carousel::get_name(),
        "title"     => T2T_Carousel::get_title() . __(" Options", "t2t")
      ));

      $fields = array(
        new T2T_IconSelectHelper(array(
          "id"          => "service_icon",
          "name"        => "service_icon",
          "label"       => __("Icon", "t2t"),
          "description" => sprintf(__('Choose the icon to associate with this %1$s.', 't2t'), strtolower(T2T_Service::get_title()))
        )),
        new T2T_TextAreaHelper(array(
          "id"          => "content",
          "name"        => "content",
          "label"       => __("Content", "t2t"),
          "maxlength"   => 100,
          "description" => __("The text to display below the title.", "t2t")
        ))
     	);
      array_push($fields, new T2T_SelectHelper(array(
        "id"          => "button_post_id",
        "name"        => "button_post_id",
        "label"       => __("Post", "t2t"),
        "description" => __("Choose a post you'd like to link to.", "t2t"),
        "prompt"      => __("Select a Post", "t2t")
      )));

      // reset to main query
      wp_reset_postdata();

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_carousel_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      $meta_boxes = apply_filters("t2t_carousel_meta_boxes", $meta_boxes);

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
      return $shortcodes;
    }
  }
}
?>