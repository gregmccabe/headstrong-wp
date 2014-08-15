<?php
if(!class_exists('T2T_MetaBox')) {
  /**
   * T2TMetaBox
   *
   * @package T2T_MetaBox
   */
  class T2T_MetaBox extends T2T_BaseClass
  {
    /**
     * Holds all fields (attributes) of the metabox.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $fields = array();

    /**
     * Holds all field groups (containing fields) of the metabox.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $field_groups = array();

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $data Initial values for this field
     */
    public function __construct($data = array()) {
      $defaults = array(
        "id"        => "t2t_metabox_" . strtolower(get_class($this)),
        "context"   => "normal",
        "priority"  => "default"
      );

      // merge defaults into the provided arguments
      $data = array_merge($defaults, $data);

      // call parent constructor
      parent::__construct($data);

      // every form element could contain the following
      if(isset($data['id'])) {
          $this->id = $data['id'];
      }
      if(isset($data['post_type'])) {
          $this->post_type = $data['post_type'];
      }
      if(isset($data['post_type_class'])) {
          $this->post_type_class = $data['post_type_class'];
          $this->post_type = call_user_func(array($data["post_type_class"], "get_name"));
      }
      if(isset($data['title'])) {
          $this->title = $data['title'];
      }
      if(isset($data['class'])) {
          $this->class = $data['class'];
      }
      if(isset($data['context'])) {
          $this->context = $data['context'];
      }
      if(isset($data['priority'])) {
          $this->priority = $data['priority'];
      }
      if(isset($data['fields'])) {
        foreach($data['fields'] as $field) {
          $this->add_field($field);
        }
      }

      $this->configure_fields();
    }

    /**
     * configure_fields
     *
     * @since 1.0.0
     */
    public function configure_fields() {}

    /**
     * add_field
     *
     * @since 1.0.0
     *
     * @param T2T_FormHelper $field
     */
    public function add_field($field) {
      // add the field to the private array of fields
      array_push($this->fields, $field);
    }

    /**
     * add_fields
     *
     * @since 1.0.0
     *
     * @param array $fields
     */
    public function add_fields($fields) {
      if(is_array($fields) && !empty($fields)) {
        foreach($fields as $field) {
          $this->add_field($field);
        }
      }
    }

    /**
     * get_fields
     *
     * @since 1.0.0
     *
     * @return array $fields
     */
    public function get_fields($with_groups = true) {
      // whether or not to include the field_groups' fields
      if($with_groups === true) {
        // initialize the result with just this metabox fields
        $fields = $this->fields;

        // loop through each field_group
        foreach($this->get_field_groups() as $field_group) {
          // add each field within the group the result
          foreach($field_group->get_fields() as $field) {
            array_push($fields, $field);
          }
        }

        return $fields;
      }
      else {
        // opted not to include the field_groups' fields
        return $this->fields;
      }
    }

    /**
     * add_field_group
     *
     * @since 1.0.0
     *
     * @param T2T_MetaBoxFieldGroup $field_group
     */
    public function add_field_group($field_group) {
      // confirm a type was provided
      if(isset($field_group->title)) {
        // add the field to the private array of fields
        array_push($this->field_groups, $field_group);
      }
    }

    /**
     * get_field_groups
     *
     * @since 1.0.0
     *
     * @return array $fields
     */
    public function get_field_groups() {
      return $this->field_groups;
    }

    /**
     * handle_output
     *
     * @since 1.0.0
     *
     * @param post $post An object containing the current post
     * @param metabox $metabox An array with metabox id, title, callback, and args elements.
     */
    public function handle_output($post, $metabox) {
      $nonce_field = new T2T_HiddenHelper(array(
        "id"    => "",
        "name"  => "post_format_meta_box_nonce",
        "value" => wp_create_nonce("T2T_Toolkit")
      ));

      // print the nonce field
      echo $nonce_field->toString();

      // print each field that is not a part of a field group
      foreach($this->get_fields(false) as $field) {
        $this->populate_field($field, $post);

        // print the field
        echo $this->print_field($field);
      }

      // print each field group
      foreach($this->field_groups as $fg) {
        echo "<div class=\"t2t_field_group\">";
        echo $fg->toString();

        foreach($fg->get_fields() as $field) {
          // populate the field based on values from the provided post
          $this->populate_field($field, $post);

          // print the field
          echo $this->print_field($field);
        }
        echo "</div>";
      }
    }

    /**
     * populate_field
     *
     * @since 2.0.0
     *
     * @param field $field Field to print
     * @param post $post Post this field is attached to
     */
    private function populate_field(&$field, $post) {
      // only attempt to set a value if a post was provided
      if(!empty($post)) {
        if(get_class($field) == "T2T_ButtonHelper") {
          return;
        }

        // retrieve current value from the database
        $existing_value = get_post_meta($post->ID, $field->name, false);

        if(strlen($field->name) > 4 && strrpos($field->name, "_ids", -4) !== false) {
          $existing_value = $existing_value;

          if(empty($existing_value)) {
            $existing_value = $field->default_value();
          }
        }
        else {
          $existing_value = (empty($existing_value) ? "" : $existing_value[0]);
        }

        // set the default if there is no existing value
        $field->value = (is_string($existing_value) && trim($existing_value) == "" ? $field->default_value() : $existing_value);
      }
    }

    /**
     * print_field
     *
     * @since 2.0.0
     *
     * @param field $field Field to print
     */
    private function print_field($field) {
      // print the metabox markup
      if($field->render) {
        return "<div class=\"t2t-post-option-row\">" . $field->toString() . "</div>\n";
      }
    }
  }

  /**
   * T2T_MetaBoxFieldGroup
   *
   * @package default
   */
  class T2T_MetaBoxFieldGroup extends T2T_BaseClass
  {
    protected $fields = array();

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $data Initial values for this field
     */
    public function __construct($data = array()) {
      // call parent constructor
      parent::__construct($data);

      if(isset($data['title'])) {
        $this->title = $data['title'];
      }
      if(isset($data['fields'])) {
        foreach($data['fields'] as $field) {
          $this->add_field($field);
        }
      }
    }

    /**
     * add_field
     *
     * @since 1.0.0
     *
     * @param T2T_FormHelper $field
     */
    public function add_field($field) {
      // add the field to the private array of fields
      array_push($this->fields, $field);
    }

    /**
     * get_fields
     *
     * @since 1.0.0
     *
     * @return array $fields
     */
    public function get_fields() {
      return $this->fields;
    }

    /**
     * toString
     *
     * @param string $version Version of the field to display
     *
     * @return HTML representing this field
     */
    public function toString($version = TOSTRING_FULL) {
      // determine which version of the object to dislay
      if($version == TOSTRING_FULL) {
        return "<h2>" . $this->title . "</h2>";
      }
    }
  }
}
?>