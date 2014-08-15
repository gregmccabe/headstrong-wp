<?php
if(!class_exists('T2T_Portfolio')) {
  /**
   * T2T_Portfolio
   *
   * @package T2T_PostType
   */
  class T2T_Portfolio extends T2T_PostType 
  {
    const POST_TYPE_NAME  = "t2t_portfolio";
    const POST_TYPE_TITLE = "Portfolio";

    // custom post type icons
    public $page_icon = "portfolio-page-icon";
    public $menu_icon = "portfolio-menu-icon";

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $options Options for the post type
     */
    public function __construct($options = array()) { 
      $singular = __("Item");
      $plural   = __("Items");

      $default_labels = array(
        "name"               => $plural,
        "singular_name"      => $singular,
        "menu_name"          => call_user_func(array($this, "get_title")),
        "all_items"          => sprintf(__('All %1$s'), $plural),
        "add_new"            => sprintf(__('Add New %1$s'), $singular),
        "add_new_item"       => sprintf(__('Add New %1$s'), $singular),
        "edit_item"          => sprintf(__('Edit %1$s'), $singular),
        "new_item"           => sprintf(__('New %1$s'), $singular),
        "view_item"          => sprintf(__('View %1$s'), $singular),
        "search_items"       => sprintf(__('Search %1$s'), $plural),
        "not_found"          => sprintf(__('No %1$s found'), strtolower($plural)),
        "not_found_in_trash" => sprintf(__('No %1$s found in Trash'), strtolower($plural)), 
        "parent_item_colon"  => ""
      );

      // if labels have been set, merge them into the defaults
      if(isset($options["labels"])) {
        $this->labels = array_merge($default_labels, $this->labels);
      }
      else {
        $this->labels = $default_labels;
      }

      parent::__construct($options);
    }

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return apply_filters("t2t_post_type_portfolio_name", self::POST_TYPE_NAME);
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return apply_filters("t2t_post_type_portfolio_title", self::POST_TYPE_TITLE);
    }

    /**
     * configure_meta_boxes
     *
     * @since 1.0.0
     */
    public function configure_meta_boxes() {
      $meta_boxes = array();
      $metabox = new T2T_MetaBox(array(
        "post_type" => T2T_Portfolio::get_name(),
        "title"     => T2T_Portfolio::get_title() . __(" Options", "t2t")
      ));

      $fields = array(
        new T2T_TextHelper(array(
          "id"          => "external_url",
          "name"        => "external_url",
          "label"       => __("External URL", "t2t"),
          "description" => sprintf(__('Link to an external URL instead of the %1$s page.', 't2t'), strtolower(T2T_Portfolio::get_title()))
        )),
        new T2T_SelectHelper(array(
          "id"          => "allow_comments",
          "name"        => "allow_comments",
          "label"       => __("Allow Comments", "t2t"),
          "description" => sprintf(__('Allow comments to be posted on items in this %1$s.', 't2t'), strtolower(T2T_Portfolio::get_title())),
          "options"     => array(
            "true"  => __("Yes", "t2t"), 
            "false" => __("No", "t2t")),
          "default"     => "false"
        ))
      );

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_portfolio_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);
          
      // append this meta_box to the array
      array_push($meta_boxes, new T2T_MetaBox_PostFormats(array(
        "post_type_class" => "T2T_Portfolio"
      )));

      $meta_boxes = apply_filters("t2t_portfolio_meta_boxes", $meta_boxes);

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
      array_push($shortcodes, "T2T_Shortcode_Portfolio");

      return $shortcodes;
    }
  }
}
?>