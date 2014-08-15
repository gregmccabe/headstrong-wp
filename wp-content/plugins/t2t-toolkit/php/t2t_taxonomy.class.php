<?php
if(!class_exists('T2T_Taxonomy')) {
  /**
   * T2T_Taxonomy
   *
   * @package T2T_Taxonomy
   */
  class T2T_Taxonomy extends T2T_BaseClass
  {
    /**
     * Labels argument for the register_taxonomy method.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $labels = array();

    /**
     * Args argument for the register_taxonomy method.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $args   = array();

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $options Options for the post type
     */
    public function __construct($options = array()) { 
      if(isset($options["name"])) {
        $this->name = $options["name"];
      }
      if(isset($options["label"])) {
        $this->label = $options["label"];
      }
      if(isset($options["post_type"])) {
        $this->post_type = $options["post_type"];
      }
      if(isset($options["labels"])) {
        $this->labels = $options["labels"];
      }
      if(isset($options["args"])) {
        $this->args = $options["args"];
      }

      if(!taxonomy_exists($this->name)) {
        // actions
        $this->register_taxonomy();
      }
    }

    /**
     * register_taxonomy
     *
     * @since 1.0.0
     */
    public function register_taxonomy() {
      // prepare naming for registration with wp
      $plural   = T2T_Toolkit::pluralize(ucwords(str_replace("_", " ", $this->label)));
      $singular = ucwords(str_replace("_", " ", $this->label));

      // set default values
      $default_labels = array(
        "add_new"            => sprintf(__('Add New %1$s'), $singular),
        "add_new_item"       => sprintf(__('Add New %1$s'), $singular),
        "edit_item"          => sprintf(__('Edit %1$s'), $singular),
        "new_item"           => sprintf(__('New %1$s'), $singular),
        "all_items"          => sprintf(__('All %1$s'), $plural),
        "view_item"          => sprintf(__('View %1$s'), $singular),
        "search_items"       => sprintf(__('Search %1$s'), $plural),
        "not_found"          => sprintf(__('No %1$s found'), strtolower($plural)),
        "not_found_in_trash" => sprintf(__('No %1$s found in Trash'), strtolower($plural)), 
        "parent_item_colon"  => "",
        "menu_name"          => $plural
      );

      // if labels have been set, merge them into the defaults
      if(isset($this->labels) && !empty($this->lables)) {
        $this->labels = array_merge($default_labels, $this->labels);
      }
      else {
        $this->labels = $default_labels;
      }

      // set default value
      $default_args = array(
        "label"             => $plural,
        "labels"            => $this->labels,
        "public"            => true,
        "hierarchical"      => true, 
        "query_var"         => true,
        "rewrite"           => array(
          "slug" => T2T_Toolkit::pluralize(strtolower(str_replace(" ", "-", $this->label)))
        )
      );

      // if args have been set, merge them into the defaults
      if(isset($this->args) && !empty($this->args)) {
        $this->args = array_merge($default_args, $this->args);
      }
      else {
        $this->args = $default_args;
      }

      // register the post type with wp
      register_taxonomy($this->name, $this->post_type, $this->args);

      register_taxonomy_for_object_type($this->name, $this->post_type);
    }
  }
}
?>