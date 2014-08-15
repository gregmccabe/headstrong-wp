<?php
if(!class_exists('T2T_Shortcode_Before_After')) {
  /**
   * T2T_Shortcode_Before_After
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Before_After extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "before_after";
    const SHORTCODE_NAME  = "Before & After";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"    => "before",
        "name"  => "before",
        "label" => __("Before Photo", "t2t")
      )));
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"    => "after",
        "name"  => "after",
        "label" => __("After Photo", "t2t")
      )));
      array_push($this->attributes, new T2T_SliderHelper(array(
        "id"          => "offset",
        "name"        => "offset",
        "label"       => __("Offset", "t2t"),
        "description" => __("How far from the left the slider should be by default", "t2t"),
        "range"       => "0.1,1",
        "step"        => "0.1",
        "default"     => "0.5"
      )));
    }

    /**
     * handle_output
     *
     * @since 1.0.0
     *
     * @param array $options Options provided to the markup
     * @param string $content Content of the shortcode
     *
     * @return HTML representing this shortcode
     */
    public function handle_output($options, $content = null) {
      extract(shortcode_atts($this->get_attributes_as_defaults(), $options));

      wp_enqueue_style("twentytwenty", 
        plugin_dir_url(dirname(__FILE__)) . "css/twentytwenty.css", 
        array(), 
        "0.1", 
        "screen");

      wp_enqueue_script("twentytwenty", 
        plugin_dir_url(dirname(__FILE__)) . "js/jquery.twentytwenty.js", 
        array("jquery"), 
        true, true);
      
      return "<div class=\"before_after twentytwenty-container\" data-default_offset_pct=\"$offset\">" .
        "<img src=\"$before\">" .
        "<img src=\"$after\">" .
        "</div>";
    }
  }
}
?>