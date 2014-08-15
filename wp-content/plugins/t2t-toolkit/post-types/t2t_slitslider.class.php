<?php
if(!class_exists('T2T_SlitSlider')) {
  /**
   * T2T_SlitSlider
   *
   * @package T2T_PostType
   */
  class T2T_SlitSlider extends T2T_PostType_Slider
  {    
    const POST_TYPE_NAME  = "t2t_slitslider";
    const POST_TYPE_TITLE = "Slit Slider";

    // custom post type icons
    public $page_icon = "slit-page-icon";
    public $menu_icon = "slit-menu-icon";

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_slitslider_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_slitslider_title", self::POST_TYPE_TITLE);
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
        "post_type" => T2T_SlitSlider::get_name(),
        "title"     => T2T_SlitSlider::get_title() . __(" Options", "t2t")
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
        new T2T_SelectHelper(array(
          "id"          => "orientation",
          "name"        => "orientation",
          "label"       => __("Orientation", "t2t"),
          "description" => __("Orientation of the slider slices", "t2t"),
          "options"     => array(
            "horizontal" => "Horizontal",
            "vertical"   => "Vertical"
          ),
          "default"     => "horizontal"
        )),
        new T2T_SliderHelper(array(
          "id"          => "slice_1_rotation",
          "name"        => "slice_1_rotation",
          "label"       => __("Slice 1 Rotation", "t2t"),
          "description" => __("First Slice (Top or Left depending on orientation) rotation", "t2t"),
          "range"       => "-90,90",
          "step"        => "10",
          "default"     => "-30"
        )),
        new T2T_SliderHelper(array(
          "id"          => "slice_1_scale",
          "name"        => "slice_1_scale",
          "label"       => __("Slice 1 Scale", "t2t"),
          "description" => __("First Slice (Top or Left depending on orientation) scale", "t2t"),
          "range"       => "1,5",
          "step"        => "1",
          "default"     => "2"
        )),
        new T2T_SliderHelper(array(
          "id"          => "slice_2_rotation",
          "name"        => "slice_2_rotation",
          "label"       => __("Slice 2 Rotation", "t2t"),
          "description" => __("Second Slice (Bottom or Right depending on orientation) rotation", "t2t"),
          "range"       => "-90,90",
          "step"        => "10",
          "default"     => "30"
        )),
        new T2T_SliderHelper(array(
          "id"          => "slice_2_scale",
          "name"        => "slice_2_scale",
          "label"       => __("Slice 2 Scale", "t2t"),
          "description" => __("Second Slice (Bottom or Right depending on orientation) scale", "t2t"),
          "range"       => "1,5",
          "step"        => "1",
          "default"     => "2"
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
        apply_filters("t2t_slitslider_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      $meta_boxes = apply_filters("t2t_slitslider_meta_boxes", $meta_boxes);

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
      array_push($shortcodes, "T2T_Shortcode_SlitSlider");
      
      return $shortcodes;
    }
  }
}
?>