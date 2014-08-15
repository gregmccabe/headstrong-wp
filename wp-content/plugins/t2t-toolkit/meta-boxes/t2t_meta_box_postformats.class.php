<?php
if(!class_exists('T2T_MetaBox_PostFormats')) {
  /**
   * T2T_MetaBox_PostFormats
   *
   * @package T2T_MetaBox
   */
  class T2T_MetaBox_PostFormats extends T2T_MetaBox_Gallery
  {   
    public $post_formats = array();
    
    /**
     * __construct
     *
     * @since 1.1.0
     *
     * @param array $data Initial values for this field
     */
    public function __construct($data = array()) {
      $defaults = array(
        "id"        => "postformat_metabox",
        "title"     => __("Post Format Options", "t2t"),
        "context"   => "normal",
        "priority"  => "high"
      );

      // merge defaults into the provided arguments
      $data = array_merge($defaults, $data);

      if(isset($data["post_type_class"])) {
        $this->post_formats = T2T_PostType::get_enabled_post_formats($data["post_type_class"]);
      }

      // call parent constructor
      parent::__construct($data);
    }

    /**
     * configure_fields
     *
     * @since 1.1.0
     */
    public function configure_fields() {  
      if(isset($this->post_formats) && !empty($this->post_formats)) {
        array_push($this->fields, new T2T_SelectHelper(array(
          "id"            => "postformat-select",
          "name"          => "postformat_select",
          "label"         => __("Post Format"),
          "options"       => $this->post_formats,
          "default" => get_option('default_post_format')
        )));

        // retrieves all the declared classes
        foreach(get_declared_classes() as $class) {
          // looping through, if the current class is a subclass of T2T_Shortcode
          if(get_parent_class($class) == "T2T_PostFormat") {
            foreach(call_user_func(array($class, "get_fields")) as $format_field) {
              array_push($this->fields, $format_field);           
            }
          }
        }
      }
    }
  }
}
?>