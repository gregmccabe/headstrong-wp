<?php
if(!class_exists('T2T_Service')) {
  /**
   * T2T_Service
   *
   * @package T2T_PostType
   */
  class T2T_Service extends T2T_PostType 
  {    
    const POST_TYPE_NAME  = "t2t_service";
    const POST_TYPE_TITLE = "Service";

    // custom post type icons
    public $page_icon = "services-page-icon";
    public $menu_icon = "services-menu-icon";

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_service_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_service_title", self::POST_TYPE_TITLE);
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
        "post_type" => T2T_Service::get_name(),
        "title"     => T2T_Service::get_title() . __(" Options", "t2t")
      ));

      $fields = array(
        new T2T_IconSelectHelper(array(
          "id"          => "service_icon",
          "name"        => "service_icon",
          "label"       => __("Icon", "t2t"),
          "description" => sprintf(__('Choose the icon to associate with this %1$s.', 't2t'), strtolower(T2T_Service::get_title()))
        )),
        new T2T_TextHelper(array(
          "id"          => "service_external_url",
          "name"        => "service_external_url",
          "label"       => __("External URL", "t2t"),
          "description" => sprintf(__('Link this to an external URL instead of the %1$s page.', 't2t'), strtolower(T2T_Service::get_title()))
        ))
      );

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_service_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      $meta_boxes = apply_filters("t2t_service_meta_boxes", $meta_boxes);

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
      array_push($shortcodes, "T2T_Shortcode_Service_List");
      array_push($shortcodes, "T2T_Shortcode_Service");
      
      return $shortcodes;
    }
  }
}
?>