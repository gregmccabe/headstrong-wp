<?php
if(!class_exists('T2T_PostType_Slider')) {
  /**
   * T2T_PostType_Slider
   *
   * @package T2T_PostType_Slider
   */
  class T2T_PostType_Slider extends T2T_PostType
  {
    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $options Options for the post type
     */
    public function __construct($options = array()) { 
      $singular = __("Slide", "t2t");
      $plural   = __("Slides", "t2t");

      $default_labels = array(
        "name"               => $plural,
        "singular_name"      => $singular,
        "menu_name"          => call_user_func(array($this, "get_title")),
        "all_items"          => sprintf(__('All %1$s', 't2t'), $plural),
        "add_new"            => sprintf(__('Add New %1$s', 't2t'), $singular),
        "add_new_item"       => sprintf(__('Add New %1$s', 't2t'), $singular),
        "edit_item"          => sprintf(__('Edit %1$s', 't2t'), $singular),
        "new_item"           => sprintf(__('New %1$s', 't2t'), $singular),
        "view_item"          => sprintf(__('View %1$s', 't2t'), $singular),
        "search_items"       => sprintf(__('Search %1$s', 't2t'), $plural),
        "not_found"          => sprintf(__('No %1$s found', 't2t'), strtolower($plural)),
        "not_found_in_trash" => sprintf(__('No %1$s found in Trash', 't2t'), strtolower($plural)), 
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
  }
}
?>