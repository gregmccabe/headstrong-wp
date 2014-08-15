<?php
if(!class_exists('T2T_Special')) {
  /**
   * T2T_Special
   *
   * @package T2T_PostType
   */
  class T2T_Special extends T2T_PostType 
  {    
    const POST_TYPE_NAME  = "t2t_special";
    const POST_TYPE_TITLE = "Special";

    // custom post type icons
    public $page_icon = "specials-page-icon";
    public $menu_icon = "specials-menu-icon";

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_special_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_special_title", self::POST_TYPE_TITLE);
    }

    /**
     * configure_meta_boxes
     *
     * @since 1.0.0
     */
    public function configure_meta_boxes() {
      $meta_boxes = array();
      $metabox = new T2T_MetaBox(array(
        "post_type" => T2T_Special::get_name(),
        "title"     => T2T_Special::get_title() . __(" Options", "t2t")
      ));

      $fields = array(
        new T2T_TextAreaHelper(array(
          "id"          => "content_excerpt",
          "name"        => "content_excerpt",
          "label"       => __("Excerpt"),
          "description" => __("A shorter, text only version of the special to display in smaller places on your site.", "t2t"),
          "maxlength"  => 100
        )),
        new T2T_DatePickerHelper(array(
          "id"          => "start_date",
          "name"        => "start_date",
          "label"       => __("Start Date", "t2t"),
          "description" => sprintf(__('The date this %1$s starts.', 't2t'), strtolower(T2T_Special::get_title())),
          "disabled"    => true
        )),
        new T2T_DatePickerHelper(array(
          "id"          => "end_date",
          "name"        => "end_date",
          "label"       => __("End Date", "t2t"),
          "description" => sprintf(__('The date this %1$s ends.', 't2t'), strtolower(T2T_Special::get_title())),
          "disabled"    => true
        )),
        new T2T_TextHelper(array(
          "id"          => "sash_text",
          "name"        => "sash_text",
          "label"       => __("Sash Text", "t2t"),
          "description" => sprintf(__('Text to appear within the sash over the corner of this %1$s.', 't2t'), strtolower(T2T_Special::get_title()))
        )),
        new T2T_TextHelper(array(
          "id"          => "promo_code",
          "name"        => "promo_code",
          "label"       => __("Promo Code", "t2t"),
          "description" => sprintf(__('Promo code to associate with this %1$s.', 't2t'), strtolower(T2T_Special::get_title()))
        )),
        new T2T_TextHelper(array(
          "id"          => "sash_color",
          "name"        => "sash_color",
          "label"       => __("Sash Color", "t2t"),
          "description" => sprintf(__('Color to associate with this %1$s.', 't2t'), strtolower(T2T_Special::get_title())),
          "class"       => "t2t-color-picker"
        )),
        new T2T_SelectHelper(array(
          "id"          => "button_post_id",
          "name"        => "button_post_id",
          "label"       => __("Button Post", "t2t"),
          "description" => __("Choose a post you'd like to link to", "t2t"),
          "prompt"      => __("Select a Post", "t2t")
        )),
        new T2T_TextHelper(array(
          "id"          => "button_text",
          "name"        => "button_text",
          "label"       => __("Button Text", "t2t"),
          "description" => __("Text to display on the button.", "t2t")
        )),
        new T2T_TextHelper(array(
          "id"          => "button_color",
          "name"        => "button_color",
          "label"       => __("Button Color", "t2t"),
          "description" => __("Background color of the button", "t2t"),
          "class"       => "t2t-color-picker"
        )),
        new T2T_TextHelper(array(
          "id"          => "button_text_color",
          "name"        => "button_text_color",
          "label"       => __("Button Text Color", "t2t"),
          "description" => __("Text color of the button", "t2t"),
          "class"       => "t2t-color-picker",
          "default"     => "#ffffff"
        )),
        new T2T_TextHelper(array(
          "id"          => "external_url",
          "name"        => "external_url",
          "label"       => __("External URL", "t2t"),
          "description" => sprintf(__('Link to an external URL instead of the %1$s page.', 't2t'), strtolower(T2T_Special::get_title()))
        ))
      );

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_special_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      $meta_boxes = apply_filters("t2t_special_meta_boxes", $meta_boxes);

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
      array_push($shortcodes, new T2T_Shortcode_Special());
      
      return $shortcodes;
    }
  }
}
?>