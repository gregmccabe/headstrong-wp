<?php
if(!class_exists('T2T_FlexSlider')) {
  /**
   * T2T_FlexSlider
   *
   * @package T2T_PostType
   */
  class T2T_FlexSlider extends T2T_PostType_Slider
  {    
    const POST_TYPE_NAME  = "t2t_flexslider";
    const POST_TYPE_TITLE = "Flex Slider";

    // custom post type icons
    public $page_icon = "flex-page-icon";
    public $menu_icon = "flex-menu-icon";

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_flexslider_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_flexslider_title", self::POST_TYPE_TITLE);
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
        "post_type" => T2T_FlexSlider::get_name(),
        "title"     => T2T_FlexSlider::get_title() . __(" Options", "t2t")
      ));

      $fields = array(
        new T2T_SelectHelper(array(
          "id"          => "show_title",
          "name"        => "show_title",
          "label"       => __("Show Title?", "t2t"),
          "description" => __("Whether or not you'd like the title displayed on the slide or not", "t2t"),
          "options"     => array(
            "true"  => __("Yes"),
            "false" => __("No")
          ),
          "default"     => "true"
        )),
        new T2T_SelectHelper(array(
          "id"          => "alignment",
          "name"        => "alignment",
          "label"       => __("Slide Alignment", "t2t"),
          "description" => __("How would you like the content of this slide aligned?", "t2t"),
          "options"     => array(
            "right"  => __("Right"),
            "left"   => __("Left"),
            "center" => __("Center")
          ),
          "default"     => "center"
        )),
        new T2T_TextHelper(array(
          "id"          => "title_color",
          "name"        => "title_color",
          "label"       => __("Title Color", "t2t"),
          "description" => __("Font color for the slide title", "t2t"),
          "class"       => "t2t-color-picker",
          "default"     => "#ffffff"
        )),
        new T2T_TextHelper(array(
          "id"          => "caption_color",
          "name"        => "caption_color",
          "label"       => __("Caption Color", "t2t"),
          "description" => __("Font color for the slide caption", "t2t"),
          "class"       => "t2t-color-picker",
          "default"     => "#ffffff"
        ))
      );

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_flexslider_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      // append this meta_box to the array
      array_push($meta_boxes, new T2T_MetaBox_PostFormats(array(
        "post_type_class" => "T2T_FlexSlider"
      )));

      $meta_boxes = apply_filters("t2t_flexslider_meta_boxes", $meta_boxes);

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
      array_push($shortcodes, "T2T_Shortcode_FlexSlider");
      
      return $shortcodes;
    }
  }
}
?>