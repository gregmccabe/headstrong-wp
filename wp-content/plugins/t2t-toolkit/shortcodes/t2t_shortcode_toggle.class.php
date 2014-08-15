<?php
if(!class_exists('T2T_Shortcode_Toggle')) {
  /**
   * T2T_Shortcode_Toggle
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Toggle extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "toggle";
    const SHORTCODE_NAME  = "Toggle Box";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "title",
        "name"  => "title",
        "label" => __("Title", "t2t")
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"      => "opened",
        "name"    => "opened",
        "label"   => __("Opened?", "t2t"),
        "options" => array(
          "true"  => __("True", "t2t"),
          "false" => __("False", "t2t")
        ),
        "default" => "false"
      )));
      array_push($this->attributes, new T2T_TextAreaHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Content", "t2t")
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
      
      if($opened == "true") {
        $toggle_class = "opened";
      } 
      else {
        $toggle_class = "";
      }

      $output = "<div class=\"toggle_box $toggle_class\">";      
      $output .= "<div class=\"title\"><a href=\"javascript:;\">" . do_shortcode($title) . "</a> <a href=\"javascript:;\" class=\"toggle_link\" data-open_text=\"+\" data-close_text=\"-\"></a></div>";
      $output .= "<div class=\"content\">" . do_shortcode($content) . "</div>";
      $output .= "</div>";
      
      return $output;
    }
  }
}
?>