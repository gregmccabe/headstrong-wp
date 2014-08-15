<?php
if(!class_exists('T2T_Person')) {
  /**
   * T2T_Person
   *
   * @package T2T_PostType
   */
  class T2T_Person extends T2T_PostType 
  {    
    const POST_TYPE_NAME  = "t2t_person";
    const POST_TYPE_TITLE = "Person";

    // custom post type icons
    public $page_icon = "people-page-icon";
    public $menu_icon = "people-menu-icon";

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_person_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_person_title", self::POST_TYPE_TITLE);
    }

    /**
     * configure_meta_boxes
     *
     * @since 1.0.0
     */
    public function configure_meta_boxes() {
      $meta_boxes = array();
      $metabox = new T2T_MetaBox(array(
        "post_type" => T2T_Person::get_name(),
        "title"     => T2T_Person::get_title() . __(" Options", "t2t")
      ));

      $fields = array(
        new T2T_TextHelper(array(
          "id"          => "title",
          "name"        => "title",
          "label"       => __("Title", "t2t"),
          "description" => sprintf(__('The current job title or position of this %1$s.', 't2t'), strtolower(T2T_Person::get_title()))
        )),
        new T2T_TextHelper(array(
          "id"          => "email",
          "name"        => "email",
          "label"       => __("Email Address", "t2t")
        )),
        new T2T_TextHelper(array(
          "id"          => "twitter",
          "name"        => "twitter",
          "label"       => __("Twitter URL", "t2t")
        )),
        new T2T_TextHelper(array(
          "id"          => "facebook",
          "name"        => "facebook",
          "label"       => __("Facebook URL", "t2t")
        )),
        new T2T_TextHelper(array(
          "id"          => "vimeo",
          "name"        => "vimeo",
          "label"       => __("Vimeo URL", "t2t")
        )),
        new T2T_TextHelper(array(
          "id"          => "flickr",
          "name"        => "flickr",
          "label"       => __("Flickr URL", "t2t")
        )),
        new T2T_TextHelper(array(
          "id"          => "pinterest",
          "name"        => "pinterest",
          "label"       => __("Pinterest URL", "t2t")
        ))
      );

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_person_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      $meta_boxes = apply_filters("t2t_person_meta_boxes", $meta_boxes);

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
      array_push($shortcodes, new T2T_Shortcode_Person_List());
      
      return $shortcodes;
    }
  }
}
?>