<?php
if(!class_exists('T2T_PostType')) {
  /**
   * T2T_PostType
   *
   * @package T2T_PostType
   */
  class T2T_PostType extends T2T_BaseClass
  {
    /**
     * Labels argument for the register_post_type method.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $labels     = array();

    /**
     * Args argument for the register_post_type method.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $args       = array();

    /**
     * Holds all metaboxes of this post type.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $meta_boxes = array();

    /**
     * Holds all enabled post formats of this post type.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $enabled_post_formats = array();

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $options Options for the post type
     */
    public function __construct($options = array()) {
      $this->name  = call_user_func(array($this, "get_name"));
      $this->title = call_user_func(array($this, "get_title"));

      if(isset($options["show_shortcodes"])) {
        $this->show_shortcodes = $options["show_shortcodes"];
      }
      else {
        $this->show_shortcodes = true;
      }
      if(isset($options["show_taxonomy"])) {
        $this->show_taxonomy = $options["show_taxonomy"];
      }
      else {
        $this->show_taxonomy = true;
      }
      if(isset($options["labels"])) {
        $this->labels = $options["labels"];
      }
      if(isset($options["args"])) {
        $this->args = $options["args"];
      }

      $post_formats = get_theme_support("post-formats");

      // only if post formats have been defined
      if (!empty($post_formats[0]) && is_array($post_formats[0])) {
        $post_formats = $post_formats[0];
      }
      else {
        $post_formats = array();
      }

      $this->enabled_post_formats = apply_filters($this->name . "_post_formats", $post_formats);

      if(!post_type_exists(call_user_func(array($this, "get_name")))) {
        // actions
        add_action("save_post", array($this, "save"));
        add_action("add_meta_boxes_" . $this->name, array($this, "add_meta_boxes"));
        add_action("admin_head", array($this, "configure_icon"));

        $this->register_post_type();

        if($this->show_taxonomy) {
          $this->register_taxonomies();
        }

        // filters
        if(is_admin()) {
          // add_filter("configure_meta_boxes", array($this, "configure_meta_boxes"));
          $this->meta_boxes = $this->configure_meta_boxes();
        }

        add_filter("t2t_toolkit_enabled_shortcodes", array($this, "configure_shortcodes"));
      }
    }

    /**
     * get_name
     *
     * @since 1.0.0
     *
     * @return string Name of this post type
     */
    public static function get_name() {
      // static::POST_TYPE_NAME;
      call_user_func(array($this, POST_TYPE_NAME));
    }

    /**
     * get_title
     *
     * @since 1.0.0
     *
     * @return string Title of this post type
     */
    public static function get_title() {
      // static::POST_TYPE_TITLE;
      call_user_func(array($this, POST_TYPE_TITLE));
    }

    /**
     * register_post_type
     *
     * @since 1.0.0
     */
    public function register_post_type() {
      // prepare naming for registration with wp
      $plural   = T2T_Toolkit::pluralize(ucwords(str_replace("_", " ", call_user_func(array($this, "get_title")))));
      $singular = ucwords(str_replace("_", " ", call_user_func(array($this, "get_title"))));

      // set default values
      $default_labels = array(
        "name"               => $plural,
        "singular_name"      => $singular,
        "menu_name"          => $plural,
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
      if(isset($this->labels) && !empty($this->labels)) {
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
        "supports"          => array("title", "editor", "thumbnail"),
        "menu_position"     => 31,
        "rewrite"           => array(
          "slug" => T2T_Toolkit::pluralize(strtolower(
            str_replace("&", "and",
              str_replace(" ", "-",
                call_user_func(array($this, "get_title"))))))
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
      register_post_type(call_user_func(array($this, "get_name")), $this->args);
    }

    /**
     * register_taxonomies
     *
     * @since 1.0.0
     */
    public function register_taxonomies() {
      new T2T_Taxonomy(array(
        "name"      => strtolower(call_user_func(array($this, "get_name"))) . "_categories",
        "label"     => __("Category"),
        "post_type" => strtolower(call_user_func(array($this, "get_name")))
      ));
    }

    /**
     * configure_meta_boxes
     *
     * @since 1.0.0
     */
    public function configure_meta_boxes() {
      $meta_boxes = array();
      return array();
    }

    /**
     * configure_shortcodes
     *
     * @since 1.0.0
     *
     * @param array $shortcodes
     */
    public function configure_shortcodes($shortcodes) {
      return $shortcodes;
    }

    /**
     * configure_icon
     *
     * @since 2.0.0
     *
     * @param array $shortcodes
     */
    public function configure_icon() {
      // if both icons are provided, render a style tag to use them
      if(isset($this->menu_icon) && $this->menu_icon != "") {
        $css  = "<style type=\"text/css\">";
        $css .= "#menu-posts-" . $this->name . " .wp-menu-image {";
        $css .= "    background: url('" . plugin_dir_url(dirname(__FILE__)) . "images/" . $this->menu_icon . ".png') no-repeat 6px 6px !important;";
        $css .= "}";
        $css .= "#menu-posts-" . $this->name . " .wp-menu-image img {";
        $css .= "    display: none;";
        $css .= "}";
        $css .= "#menu-posts-" . $this->name . " .icon16.icon-post:before,";
        $css .= "#menu-posts-" . $this->name . " .menu-icon-post div.wp-menu-image:before {";
        $css .= "    content: none;";
        $css .= "}";
        $css .= "#menu-posts-" . $this->name . ":hover .wp-menu-image, #menu-posts-" . $this->name . ".wp-has-current-submenu .wp-menu-image {";
        $css .= "    background-position: 6px -26px !important;";
        $css .= "}";
        $css .= ".icon32-posts-" . $this->name . " {";
        $css .= "    background: url('" . plugin_dir_url(dirname(__FILE__)) . "images/" . $this->page_icon . ".png') no-repeat left top !important;";
        $css .= "}";
        $css .= "@media ";
        $css .= "only screen and (-webkit-min-device-pixel-ratio: 1.5),";
        $css .= "only screen and (   min--moz-device-pixel-ratio: 1.5),";
        $css .= "only screen and (     -o-min-device-pixel-ratio: 3/2),";
        $css .= "only screen and (        min-device-pixel-ratio: 1.5),";
        $css .= "only screen and (                min-resolution: 1.5dppx) {";
        $css .= "    #menu-posts-" . $this->name . " .wp-menu-image {";
        $css .= "        background-image: url('" . plugin_dir_url(dirname(__FILE__)) . "images/" . $this->menu_icon . "@2x.png') !important;";
        $css .= "        -webkit-background-size: 16px 48px !important;";
        $css .= "        -moz-background-size: 16px 48px !important;";
        $css .= "        background-size: 16px 48px !important;";
        $css .= "    } ";
        $css .= "     ";
        $css .= "    .icon32-posts-" . $this->name . " {";
        $css .= "        background-image: url('" . plugin_dir_url(dirname(__FILE__)) . "images/" . $this->page_icon . "@2x.png') !important;";
        $css .= "        -webkit-background-size: 32px 32px !important;";
        $css .= "        -moz-background-size: 32px 32px !important;";
        $css .= "        background-size: 32px 32px !important;";
        $css .= "    }   ";
        $css .= "}";
        $css .= "</style>";

        echo $css;
      }
    }

    /**
     * save
     *
     * @since 1.0.0
     *
     * @param integer $post_id The ID of the post being saved
     *
     * @return void on error
     */
    public function save($post_id) {
      $is_valid_nonce = isset($_POST["post_format_meta_box_nonce"]) && wp_verify_nonce($_POST["post_format_meta_box_nonce"], "T2T_Toolkit");
      $is_revision    = wp_is_post_revision($post_id);
      $is_autosave    = wp_is_post_autosave($post_id);

      if($is_revision || $is_autosave || !$is_valid_nonce) {
        return;
      }

      // loop through each metabox
      foreach($this->meta_boxes as $metabox) {
        if(isset($_POST["page_template"])) {
          // ignore this metabox unless its specific to this template
          if($metabox->post_type == T2T_Page::get_name() &&
            basename($_POST["page_template"], ".php") != $metabox->id && $metabox->id != T2T_Page::get_name()) {

            continue;
          }
        }

        if($_POST['post_type'] == $metabox->post_type && current_user_can('edit_post', $post_id)) {
          foreach ($metabox->get_fields() as $field) {
            // only save this field if it is marked as such
            // if(filter_var($field->render, FILTER_VALIDATE_BOOLEAN) === false) {
            //   continue;
            // }

            // check for current value before save
            $current_data = get_post_meta($post_id, $field->name, true);

            // if the field was supplied on this form load
            if(isset($_POST[$field->name])) {
              $new_data = $_POST[$field->name];
            }

            if(is_array($new_data)) {
              // remove all data with this key
              delete_post_meta($post_id, $field->name);

              // re-add only the ones provided
              foreach($new_data as $item) {
                add_post_meta(
                  $post_id,
                  $field->name,
                  $item);
              }
            }
            else {
              // if a value already existed
              if(isset($current_data)) {
                if(trim($new_data) == "") {
                  // the field was submitted, but the value was empty
                  delete_post_meta($post_id, $field->name);
                }
                elseif($new_data != $current_data) {
                  // the field was submitted, and is a different value
                  update_post_meta($post_id, $field->name, $new_data);
                }
              }
              elseif(isset($new_data) && !trim($new_data) != "") {
                // no data existed but a new value was provided
                add_post_meta(
                  $post_id,
                  $field->name,
                  $new_data, true);
              }
            }

            unset($new_data);
          }
        }
      }
    }

    /**
     * add_meta_boxes
     *
     * @since 1.0.0
     *
     * @param t2t_meta_box $meta_box The meta_box to add
     */
    public function add_meta_boxes($post) {
      foreach($this->meta_boxes as $meta_box) {
        // if(sizeof($meta_box->get_fields(true)) > 0 && $meta_box->post_type == call_user_func(array($this, "get_name"))) {
        if(sizeof($meta_box->get_fields(true)) > 0 && isset($meta_box->post_type)) {
          array_push($this->meta_boxes, $meta_box);
          // wordpress call to add the metabox
          add_meta_box(
            $meta_box->id,
            $meta_box->title,
            array($meta_box, "handle_output"),
            $meta_box->post_type,
            $meta_box->context,
            $meta_box->priority,
            $meta_box->get_fields());
        }
      }
    }

    /**
     * get_enabled_post_formats
     *
     * @since 2.0.0
     *
     * @param String $post_type_class The class name of the post type to get post formats for
     *
     * @return An array representing the enabled post formats
     */
    public static function get_enabled_post_formats($post_type_class) {
      $formats_to_return = array();

      // filter post formats for a specific post type
      $enabled_post_formats = apply_filters(call_user_func(array($post_type_class, "get_name")) . "_post_formats", array());

      // custom post format names
      if(isset($enabled_post_formats) && !empty($enabled_post_formats)) {
        // temp storage for formatted key value pairs
        $formatted_post_formats = array();

        // interate through each user provided post format
        foreach($enabled_post_formats as $key => $value) {
          if(is_numeric($key)) {
            // default post format provided
            $format = $value;
            $title  = ucwords($value);
          }
          else {
            // custom post format title provided
            $format = $key;
            $title  = $value;

            /**
             * NOTE: if selecting a custom post format title
             * be aware that you will also need to provide
             * an icon with class matching the structure of
             * 'post-format-[your title lower cased]' for the
             * dropdown to display properly
             */
          }

          $formatted_post_formats[$format] = $title;
        }

        $enabled_post_formats = $formatted_post_formats;

        $post_formats = get_theme_support("post-formats");

        // only if post formats have been defined
        if (!empty($post_formats[0]) && is_array($post_formats[0])) {
          foreach($post_formats[0] as $format) {
            if(empty($enabled_post_formats)) {
              $formats_to_return[$format] = ucwords($format);
            }
            else {
              if(in_array($format, array_keys($enabled_post_formats))) {
                $formats_to_return[$format] = $enabled_post_formats[$format];
              }
            }
          }

          // standard post format
          if(empty($enabled_post_formats)) {
            array_unshift($formats_to_return, __("Standard"));
          }
          elseif(in_array("standard", array_keys($enabled_post_formats))) {
            array_unshift($formats_to_return, $enabled_post_formats["standard"]);
          }
        }
      }

      return $formats_to_return;
    }
  }
}
?>