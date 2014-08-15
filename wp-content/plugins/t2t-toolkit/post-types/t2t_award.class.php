<?php
if(!class_exists('T2T_Award')) {
  /**
   * T2T_Award
   *
   * @package T2T_PostType
   */
  class T2T_Award extends T2T_PostType 
  {    
    const POST_TYPE_NAME  = "t2t_award";
    const POST_TYPE_TITLE = "Award";

    // custom post type icons
    public $page_icon = "award-page-icon";
    public $menu_icon = "award-menu-icon";

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_award_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_award_title", self::POST_TYPE_TITLE);
    }

    /**
     * configure_meta_boxes
     *
     * @since 1.0.0
     */
    public function configure_meta_boxes() {
      $meta_boxes = array();
      $metabox = new T2T_MetaBox(array(
        "post_type" => T2T_Award::get_name(),
        "title"     => T2T_Award::get_title() . __(" Options", "t2t")
      ));

      $fields = array();

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_award_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      $meta_boxes = apply_filters("t2t_award_meta_boxes", $meta_boxes);

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
      // array_push($shortcodes, new T2T_Shortcode_Award_List());
      
      return $shortcodes;
    }
  }
}
?>