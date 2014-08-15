<?php
if(!class_exists('T2T_MetaBox_Shortcodes')) {
  /**
   * T2T_MetaBox_Shortcodes
   *
   * @package T2T_MetaBox
   */
  class T2T_MetaBox_Shortcodes extends T2T_MetaBox
  {   
    public $shortcodes = array();
    
    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $data Initial values for this field
     */
    public function __construct($data = array()) {
      $defaults = array(
        "id"        => "shortcode_metabox",
        "title"     => __("Shortcode Options", "t2t"),
        "context"   => "side",
        "priority"  => "high"
      );

      if(isset($data["shortcodes"])) {
        $this->shortcodes = $data["shortcodes"];
      }

      // merge defaults into the provided arguments
      $data = array_merge($defaults, $data);

      // call parent constructor
      parent::__construct($data);
    }

    /**
     * configure_fields
     *
     * @since 1.0.0
     */
    public function configure_fields() {
      // sort the shortcode list in alpha order
      usort($this->shortcodes, array("T2T_Shortcode", "compare"));

      // empty option (default) for shortcode select element
      $shortcode_list = array();
    
      // loop through the shorcode array to create the select
      foreach($this->shortcodes as $shortcode) {
        if(sizeof($shortcode->get_attributes()) > 0) {
          $shortcode_list[$shortcode->id] = $shortcode->name;
        }
      }
    
      array_push($this->fields, new T2T_SelectHelper(array(
        "id"            => "shortcode-select",
        "name"          => "shortcode_select",
        "label"         => "",
        "description"   => __("Select a shortcode from the list below, then add your options and click \"Generate Shortcode\".", "t2t"),
        "options"       => $shortcode_list,
        "include_blank" => true,
        "prompt"        => "Choose a Shortcode"
      )));
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

      // loop through each field in the metabox 
      foreach($metabox["args"] as $field) {
        // print the metabox markup
        echo "<div class=\"t2t-shortcode-row\">" . $field->toString() . "</div>\n";
      }

      // loop through each shortcode
      foreach($this->shortcodes as $shortcode) {
        // print the shortcode
        echo $shortcode->toString(TOSTRING_FULL);
      }
    }
  }
}
?>