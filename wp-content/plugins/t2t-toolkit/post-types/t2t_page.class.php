<?php
if(!class_exists('T2T_Page')) {
  /**
   * T2T_Page
   *
   * This class exists solely to provide additional functionality to the 
   * WordPress post type 'page'
   *
   * @package T2T_PostType
   */
  class T2T_Page extends T2T_PostType 
  {    
    const POST_TYPE_NAME  = "page";
    const POST_TYPE_TITLE = "Page";

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $options Options for the post type
     */
    public function __construct($options = array()) {
    	// configurations not set because we don't call the 
    	// parent constructor (by design)
			$this->name            = self::get_name();
			$this->title           = self::get_title();
			$this->show_shortcodes = true;

      $post_formats = get_theme_support("post-formats");

      // only if post formats have been defined
      if (!empty($post_formats[0]) && is_array($post_formats[0])) {
        $post_formats = $post_formats[0];
      }
      else {
        $post_formats = array();
      }

      $this->enabled_post_formats = apply_filters($this->name . "_post_formats", $post_formats);

    	// actions
      add_action("add_meta_boxes_" . $this->name, array($this, "add_meta_boxes"));
			add_action("save_post", array($this, "save"));

      // filters
      // add_filter("configure_meta_boxes", array($this, "configure_meta_boxes"));
      $this->meta_boxes = $this->configure_meta_boxes();
    }

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      return self::POST_TYPE_NAME;
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      return self::POST_TYPE_TITLE;
    }

    /**
     * configure_meta_boxes
     *
     * @since 1.0.0
     */
    public function configure_meta_boxes() {
      $meta_boxes = array();
      $metabox = new T2T_MetaBox(array(
        "id"        => T2T_Page::get_name(),
        "post_type" => T2T_Page::get_name(),
        "title"     => T2T_Page::get_title() . __(" Options", "t2t")
      ));

      $fields = array(
        new T2T_SelectHelper(array(
          "id"          => "layout",
          "name"        => "layout",
          "label"       => __("Page Layout", "t2t"),
          "description" => __("Choose a layout for this page.", "t2t"),
          "options"     => array(
            "full_width"    => "No Sidebar",
            "sidebar_left"  => "Left Sidebar",
            "sidebar_right" => "Right Sidebar"
          ),
          "default"     => "full_width"
        ))        
     	);

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_page_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      $meta_boxes = apply_filters("t2t_page_meta_boxes", $meta_boxes);

      return $meta_boxes;
    }
  }
}
?>