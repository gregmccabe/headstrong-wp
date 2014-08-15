<?php
if(!class_exists('T2T_Album')) {
  /**
   * T2T_Album
   *
   * @package T2T_PostType
   */
  class T2T_Album extends T2T_PostType 
  {
    const POST_TYPE_NAME  = "t2t_album";
    const POST_TYPE_TITLE = "Album";

    // custom post type icons
    public $page_icon = "albums-page-icon";
    public $menu_icon = "albums-menu-icon";

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_album_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_album_title", self::POST_TYPE_TITLE);
    }

    /**
     * configure_meta_boxes
     *
     * @since 1.0.0
     */
    public function configure_meta_boxes() {
      $meta_boxes = array();
      $metabox = new T2T_MetaBox(array(
        "post_type" => T2T_Album::get_name(),
        "title"     => T2T_Album::get_title() . __(" Options", "t2t")
      ));

      $fields = array(
        new T2T_SelectHelper(array(
          "id"          => "album_layout_style",
          "name"        => "album_layout_style",
          "label"       => __("Layout Style", "t2t"),
          "description" => __("Choose the style of layout in which these photos will be displayed.", "t2t"),
          "options"     => array(
            "grid"         => __("Grid", "t2t"), 
            "grid_full"    => __("Grid (Full Width)", "t2t"), 
            "masonry"      => __("Masonry", "t2t"),
            "masonry_full" => __("Masonry (Full Width)", "t2t")),
          "default"     => "grid"
        )),
        new T2T_SelectHelper(array(
          "id"          => "masonry_style",
          "name"        => "masonry_style",
          "label"       => __("Masonry Style", "t2t"),
          "description" => __("Choose style of masonry you'd like the images displayed with.", "t2t"),
          "options"     => array(
            "natural" => __("Natural", "t2t"), 
            "forced"  => __("Forced", "t2t")), 
          "default"     => "forced"
        )),
        new T2T_SelectHelper(array(
          "id"          => "album_photos_per_row",
          "name"        => "album_photos_per_row",
          "label"       => __("Number of Photos Per Row", "t2t"),
          "description" => sprintf(__('Choose how many photos you\'d like displayed on each row of this %1$s.', 't2t'), strtolower(T2T_Album::get_title())),
          "options"     => array(1 => 1, 2, 3, 4), // specify first key to define index starting point of 1
          "default"     => 4
        )),
        new T2T_SelectHelper(array(
          "id"          => "allow_comments",
          "name"        => "allow_comments",
          "label"       => __("Allow Comments", "t2t"),
          "description" => sprintf(__('Allow comments to be posted on photos in this %1$s.', 't2t'), strtolower(T2T_Album::get_title())),
          "options"     => array(
            "true"  => __("Yes", "t2t"), 
            "false" => __("No", "t2t")),
          "default"     => "false"
        )));

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_album_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      // add gallery metabox
      array_push($meta_boxes, new T2T_MetaBox_Gallery(array(
        "post_type_class" => "T2T_Album"
      )));

      $meta_boxes = apply_filters("t2t_album_meta_boxes", $meta_boxes);

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
      array_push($shortcodes, "T2T_Shortcode_Album_List");
      array_push($shortcodes, "T2T_Shortcode_Album");

      return $shortcodes;
    }
  }
}
?>