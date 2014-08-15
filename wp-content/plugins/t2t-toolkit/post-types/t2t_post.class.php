<?php
if(!class_exists('T2T_Post')) {
  /**
   * T2T_Post
   *
   * This class exists solely to provide additional functionality to the 
   * WordPress post type 'post'
   *
   * @package T2T_PostType
   */
  class T2T_Post extends T2T_PostType 
  {    
    const POST_TYPE_NAME  = "post";
    const POST_TYPE_TITLE = "Post";

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
        "post_type" => T2T_Post::POST_TYPE_NAME,
        "title"     => T2T_Post::POST_TYPE_TITLE . __(" Options", "t2t")
      ));

      $fields = array(
        new T2T_SelectHelper(array(
          "id"          => "show_featured_image",
          "name"        => "show_featured_image",
          "label"       => __("Show Featured Image?", "t2t"),
          "description" => __("Whether or not to show the featured image.", "t2t"),
          "options"     => array(
            "true"  => "Yes",
            "false" => "No"
          ),
          "default"     => "true"
        ))        
     	);

      // provide the core fields to the filter
      $metabox->add_fields(
        apply_filters("t2t_post_core_meta_box_fields", $fields));

      // append this meta_box to the array
      array_push($meta_boxes, $metabox);

      if(isset($this->enabled_post_formats) && !empty($this->enabled_post_formats)) {
        // append this meta_box to the array
        array_push($meta_boxes, new T2T_MetaBox_PostFormats(array(
          "post_type_class" => "T2T_Post"
        )));        
      }

      $meta_boxes = apply_filters("t2t_post_meta_boxes", $meta_boxes);

      return $meta_boxes;
    }
  }
}
?>